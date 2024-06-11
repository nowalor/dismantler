<?php

/*
 * Here we check if a part by us is sold on an outside platform
 * If a part is sold we should reserve it in the data provider
 * For example if a part we uploaded from the fenix API is sold on autoteile-markt.de
 * We then need to send a API request to fenix after getting the information from the autoteile-markt FTP
 * This can work differently depending on the platform and provider
 */

namespace App\Console\Commands;

use App\Console\Commands\Base\FenixApiBaseCommand;
use App\Helpers\Constants\SellerPlatform;
use App\Mail\ReservationMail;
use App\Models\NewCarPart;
use App\Models\Reservation;
use App\Services\FenixApiService;
use App\Services\SlackNotificationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

/*
 * TODO: replace a lot of this called with shared actions / services for ebay
 * This was all written when the only sales platform was autoteile
 * now it should also work for ebay
 */

class ResolvePartsSoldByUsCommand extends FenixApiBaseCommand
{
    protected $signature = 'parts-we-sold:resolve';

    private SlackNotificationService $notificationService;
    private FenixApiService $fenixApiService;

    public function __construct()
    {
        $this->notificationService = new SlackNotificationService();
        $this->fenixApiService = new FenixApiService();

        parent::__construct();
    }

    public function handle(): int
    {
        $parts = $this->getSoldParts();

        if (count($parts)) {
            $this->handleSoldParts($parts);
        }

        return Command::SUCCESS;
    }

    /*
     * Go through all the sold parts
     * Let the dismantler know via email
     * Update the part in the database
     */

    private function getSoldParts(): array
    {
        $files = Storage::disk('ftp')->files();

        $xmlFiles = array_filter($files, function ($file) {
            return strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'xml';
        });

        if (empty($xmlFiles)) {
            return [];
        }

        $parts = [];

        foreach ($xmlFiles as $xmlFile) {
            $file = Storage::disk('ftp')->get($xmlFile);

            $xml = simplexml_load_string($file);

            if (!$xml) {
                continue;
            }

            foreach ($xml->item as $item) {
                $articleNr = (string)$item->number;

                // Extract billing address details
                $billingAddress = $xml->head->billingadress;
                $billingInformation = $this->extractInformation($billingAddress);

                // Extract shipping address details
                $shippingAddress = $xml->head->shippingadress;
                $shippingInformation = $this->extractInformation($shippingAddress);

                $soldPart = [
                    'article_nr' => $articleNr,
                    'billing_information' => $billingInformation,
                    'shipping_information' => $shippingInformation,
                ];

                $parts[] = $soldPart;

            }
        }

        return $parts;
    }

    private function extractInformation(SimpleXMLElement $item): array
    {
        $data = [
            'firstname' => (string)$item->firstname,
            'surname' => (string)$item->surname,
            'street' => (string)$item->street,
            'zip' => (string)$item->zip,
            'city' => (string)$item->city,
            'country' => (string)$item->country,
            'phone' => (string)$item->phone,
        ];

        if ($item->email) {
            $data['email'] = (string)$item->email;
        }

        return $data;
    }

    public function handleSoldParts(array $parts)
    {
        foreach ($parts as $part) {
            $dbPart = NewCarPart::where('article_nr', $part['article_nr'])->first();

            if(!$dbPart) {
                logger("Couldn't find {$part['article_nr']}");
                
                continue;
            }

            // Return if part sold_at is not null
            if ($dbPart->sold_at) {
                continue;
            }

//            Mail::send(
//                new ReservationMail(
//                    dismantleCompanyCode: $dbPart->dismantle_company_name,
//                    dismantleId: $dbPart->article_nr_at_dismantler
//                )
//            );

            $dbPart->is_live = false;
            $dbPart->sold_at = now();
            $dbPart->sold_on_platform = SellerPlatform::AUTOTEILE_MARKT;

            $dbPart->save();

            $this->notificationService->notifyOrderSuccess(
                partData: $part,
                reservationId: null,
                reservationUuid: null,
            );

// Currently we don't reserve right away since it's to hard for the dismantlers to remove the reservations sometimes
//            $reservation = $this->fenixApiService->createReservation(
//                $dbPart,
//                SellerPlatform::AUTOTEILE_MARKT
//            );

//            if($reservation instanceof Reservation) {
//                $this->notificationService->notifyOrderSuccess(
//                    partData: $part,
//                    reservationId: $reservation->reservation_id,
//                    reservationUuid: $reservation->uuid,
//                );
//            }
        }
    }
}
