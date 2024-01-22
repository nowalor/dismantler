<?php

namespace App\Console\Commands\Ebay;

use App\Models\NewCarPart;
use App\Services\EbayApiService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class CreateXmlCommand extends Command
{
    protected $signature = 'ebay:create-xml';

    private EbayApiService $service;

    public function __construct()
    {
        $this->service = new EbayApiService();

        parent::__construct();
    }

    public function handle(): string
    {
        $parts = $this->parts();

        $this->service->addPartsToXml($parts);

        return Command::SUCCESS;
    }

    private function parts(): Collection
    {
        $parts = NewCarPart::with("carPartImages")
            ->where("sbr_car_name", "like", "%audi%")
            ->whereHas("carPartImages", function ($q) {
                $q->whereNotNull("image_name_blank_logo");
            })
            ->whereHas("germanDismantlers.kTypes")
            ->with("germanDismantlers", function ($q) {
                $q->whereHas("kTypes")->with("kTypes");
            })
            ->take(1)
            ->get();

        return $parts;
    }
}
