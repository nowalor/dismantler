<?php

namespace App\Console\Commands\Ebay;

use App\Models\NewCarPart;
use App\Services\EbayApiService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class UploadPartsCommand extends Command
{
    protected $signature = 'ebay:upload';

    private EbayApiService $service;

    public function __construct()
    {
        $this->service = new EbayApiService();

        parent::__construct();
    }

    public function handle(): int
    {
        $parts = $this->parts();

        $this->service->addPartsToXml($parts);

        return Command::SUCCESS;
    }

    private function parts(): Collection
    {
        $parts = NewCarPart::where('dismantle_company_name', 'BO')
            ->where(function ( $query ) {
                $query->where('fuel', 'like', '%disel%');
                $query->orWhere('fuel', 'like', '%bensin%');
            })
            ->take(10)
            ->get();

        return $parts;
    }
}
