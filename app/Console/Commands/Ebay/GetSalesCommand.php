<?php

namespace App\Console\Commands\Ebay;

use App\Actions\Parts\HandleSoldAction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GetSalesCommand extends Command
{
    protected $signature = 'ebay:orders';

    public function handle(): int
    {
        $disk = Storage::disk('ebay_sftp');

        $file = $disk->get('/store/order/output/order-latest');

        $xml = new \SimpleXMLElement($file);

        $parts = [];

        // Might need to loop through some other elements from the XML response
        foreach($xml->children() as $order) {
            // Push to parts here
        }

        if(count($parts) === 0) {
            return Command::SUCCESS;
        }

        (new HandleSoldAction())->execute($parts);

        return Command::SUCCESS;
    }

}
