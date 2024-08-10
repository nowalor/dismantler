<?php

namespace App\Console\Commands\Hood;

use App\Models\NewCarPart;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use App\Actions\Hood\CreateXmlAction as HoodCreateXmlAction;

class ExportPartsCommand extends Command
{
    protected $signature = 'hood:export';

    private Client $client;
    private string | null $apiUrl;

    public function __construct()
    {
        parent::__construct();

        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF-8',
                'Accept' => 'text/xml; charset=UTF-8',
            ],
        ]);

        $this->apiUrl = config('services.hood.api_url');
    }

    public function handle(): int
    {
        $parts = $this->parts();

        $partsXml = (new HoodCreateXmlAction())->execute('itemInsert', $parts);
        //$this->info($partsXml);

        try {
            $response = $this->client->post(
                $this->apiUrl,
                [
                    'body' => $partsXml,
                ]
            );

            if($response->getStatusCode() !== 200) {
                logger($response->getStatusCode());
                logger($response->getBody());
                return Command::FAILURE;
            }

            logger($response->getBody());

            foreach($parts as $part) {
                $part->update(['is_live_on_hood' => true]);
            }

            $hasMoreParts = $this->partsCount();

            if($hasMoreParts) {
                return \Artisan::call('hood:export');
            }

            return Command::SUCCESS;
        } catch(\Exception $ex) {
            logger($ex->getMessage());

            $this->info('in catch..');
            return Command::FAILURE;
        }
    }

    private function parts(): Collection
    {
        return NewCarPart::
        whereNotNull('engine_code')
            ->whereNotNull('new_name')
            ->whereNotNull('article_nr')
            ->whereHas("carPartImages", function ($query) {
                $query->whereNotNull('new_logo_german');
            })
            ->where('engine_code', '!=', '')
            ->whereNull('sold_at')
            ->whereNotNull('car_part_type_id')
            ->where('is_live_on_hood', false)
            ->where(function ($query) {
                $query
                    ->where('dismantle_company_name', '!=', 'F')
                    ->orWhere(function ($subQuery) {
                        $subQuery
                            ->where('dismantle_company_name', 'F')
                            ->whereIn('car_part_type_id', [6, 7]);
                    });
            })
            ->take(40)
            ->get();
    }

    private function partsCount(): int
    {
        return NewCarPart::whereNotNull('engine_code')
            ->whereNotNull('new_name')
            ->whereNotNull('article_nr')
            ->whereHas("carPartImages", function ($query) {
                $query->whereNotNull('new_logo_german');
            })
            ->where('engine_code', '!=', '')
            ->whereNull('sold_at')
            ->whereNotNull('car_part_type_id')
            ->where('is_live_on_hood', false)
            ->where(function ($query) {
                $query
                    ->where('dismantle_company_name', '!=', 'F')
                    ->orWhere(function ($subQuery) {
                        $subQuery
                            ->where('dismantle_company_name', 'F')
                            ->whereIn('car_part_type_id', [6, 7]);
                    });
            })
            ->count();
    }
}
