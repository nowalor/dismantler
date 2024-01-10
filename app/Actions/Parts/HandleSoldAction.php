<?php

namespace App\Actions\Parts;

use App\Helpers\Constants\SellerPlatform;
use App\Models\NewCarPart;
use App\Models\Reservation;
use App\Services\FenixApiService;
use App\Services\SlackNotificationService;

class HandleSoldAction
{
    private SlackNotificationService $notificationService;
    private FenixApiService $fenixApiService;

    public function __construct()
    {
        $this->notificationService = new SlackNotificationService();
        $this->fenixApiService = new FenixApiService();
    }

    public function execute(array $parts, string $platform): void
    {
        foreach($parts as $part) {
            $dbPart = NewCarPart::where('article_nr', $part['article_nr'])->first();

            // Return if part sold_at is not null
            if($dbPart->sold_at) {
                continue;
            }

            if($dbPart->dismantle_company_name === 'BO') {
                $part->is_live = false;
                $part->sold_at = now();
                $part->sold_on_platform = $platform;

                $part->save();

                $this->notificationService->notifyOrderSuccess(
                    partData: $part,
                    reservationId: null,
                    reservationUuid: null,
                );

                continue;
            }

            $reservation = $this->fenixApiService->createReservation($dbPart, $platform);

            if($reservation instanceof Reservation) {
                $this->notificationService->notifyOrderSuccess(
                    partData: $part,
                    reservationId: $reservation->reservation_id,
                    reservationUuid: $reservation->uuid,
                );
            }
        }
    }

    /*
     * TODO resolving the information into the same format for ebay and autoteile
     */
    private function resolveInformation()
    {

    }
}
