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
//        return NewCarPart::whereIn('article_nr', ['BO490467', 'BO518045', 'BO521829', 'BO471957', 'BO438695', 'BO474518', 'BO532585', 'BO525169', 'BO471955', 'BO516139', 'BO533010', 'BO543899', 'BO426791', 'BO522962', 'BO522962', 'BO477354', 'BO455633', 'BO535678', 'BO455631', 'BO545008', 'BO521845', 'BO437213', 'BO453042', 'BO551578', 'BO542433', 'BO517408'])->get()->toArray();
        return NewCarPart::
//            where('is_live_on_ebay', true)
            /*whereIn('car_part_type_id', [1, 3,4])*/
            whereIn('car_part_type_id', [14])
            ->get()
            ->toArray();
    }
}
