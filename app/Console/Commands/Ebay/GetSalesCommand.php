<?php

namespace App\Console\Commands\Ebay;

use App\Actions\Parts\HandleSoldAction;
use App\Helpers\Constants\SellerPlatform;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GetSalesCommand extends Command
{
    protected $signature = 'ebay:orders';

    public function handle(): int
    {
        $disk = Storage::disk('ebay_sftp');

        $file = $disk->get('/store/order/output/order-latest');
        dd($file);

        $file = file_get_contents(base_path('public/poc/order-latest.xml'));

        $xml = new \SimpleXMLElement($file);

        $parts = [];

        // Might need to loop through some other elements from the XML response
        foreach($xml->children() as $order) {
            $parts[] = $this->formatOrder($order);
        }

        if(count($parts) === 0) {
            return Command::SUCCESS;
        }

        (new HandleSoldAction())->execute(
            $parts,
            SellerPlatform::EBAY,
        );

        return Command::SUCCESS;
    }

    private function formatOrder($order): array
    {
        // Maybe needs to be done conditinally depending on if it's in pendingOrderFulfillment?
        $order = $order->order;
        return [
            'article_nr' => $order->lineItem->listing->SKU,
            'sold_on_platform' => 'EBAY',
            'firstname' => $order->buyer->lastName,
            'surname' => $order->buyer->firstName,
            'email' => $order->buyer->email,
            'city' => $order->logisticsPlan->shipping->shipToAddress->city,
            'zip_code' => $order->logisticsPlan->shipping->shipToAddress->postalCode,
            'country' => $order->logisticsPlan->shipping->shipToAddress->country,
            'phone' => $order->logisticsPlan->shipping->shipToAddress->phone,
            'street' =>$order->logisticsPlan->shipping->shipToAddress->addressLine1,
        ];
    }
}
