<?php

namespace App\Console\Commands\Hood;

use App\Models\NewCarPart;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use SimpleXMLElement;

class DeletePartsCommand extends Command
{
    protected $signature = 'hood:delete';

    private string | null $username;
    private string | null $apiPassword;

    public function __construct()
    {
        parent::__construct();

        $this->username = config('services.hood.username');
        $this->apiPassword = config('services.hood.api_password');
    }

    public function handle(): int
    {
        $parts = NewCarPart::where('is_live_on_hood', true)->get();



        return Command::SUCCESS;
    }

    private function xml(Collection $parts): string
    {
        $xml = new SimpleXMLElement(
            "<?xml version='1.0' encoding='UTF-8'?>
            <api
                user='$this->username'
                type='public'
                version='2.0'
                password='$this->apiPassword'
            ></api>"
        );
        $items = $xml->addChild('items');

        foreach($parts as $part) {

        }
    }
}
