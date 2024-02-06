<?php

namespace App\Console\Commands\Ebay;

use App\Models\NewCarPart;
use App\Services\EbayApiService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class CreateXmlCommand extends Command
{
    protected $signature = 'ebay:upload';

    private EbayApiService $service;

    public function __construct()
    {
        $this->service = new EbayApiService();

        parent::__construct();
    }

    public function handle(): string
    {
        $parts = $this->parts();

        if (count($parts) === 0) {
            return 0;
        }

        $this->service->handlePartUpload($parts);

        return Command::SUCCESS;
    }

    private function parts(): Collection
    {
        $parts = NewCarPart::with("carPartImages")
            ->where("sbr_car_name", "like", "%audi%")
            ->where('is_live_on_ebay', false)
            ->where('car_part_type_id', 1)
            ->where(function ($q) {
                $q->where('fuel', 'Diesel');
                $q->orWhere('fuel', 'Bensin');
            })
            ->whereHas("carPartImages", function ($q) {
                $q->whereNotNull("image_name_blank_logo");
            })
            ->whereHas("germanDismantlers.kTypes")
            ->with("germanDismantlers", function ($q) {
                $q->whereHas("kTypes")->with("kTypes");
            })
            ->take(25)
            ->get();

        return $parts;
    }
}
