<?php

namespace App\Console\Commands\Ebay;

use App\Actions\Ebay\CreateDeleteXmlAction;
use App\Actions\Ebay\FtpFileUploadAction;
use App\Models\NewCarPart;
use Illuminate\Console\Command;

class DeleteProductCommand extends Command
{
    protected $signature = 'ebay:delete-parts';

    public function handle()
    {
        $parts = $this->partQuery();

        $xmlName = (new CreateDeleteXmlAction())->execute(parts: $parts);

        (new FtpFileUploadAction())->execute(
            to: 'store/deleteInventory',
            location: base_path("public/exports/$xmlName.xml"),
            fileName: "$xmlName.xml",
        );

        NewCarPart::where('is_live_on_ebay', true)->update(['is_live_on_ebay' => false]);

        return Command::SUCCESS;
    }

    private function partQuery(): array
    {
        return NewCarPart::where('is_live_on_ebay', true)->get()->toArray();
    }
}