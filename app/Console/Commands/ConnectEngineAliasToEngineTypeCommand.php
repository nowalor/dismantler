<?php

namespace App\Console\Commands;

use App\Models\EngineType;
use Illuminate\Console\Command;

class ConnectEngineAliasToEngineTypeCommand extends Command
{
    protected $signature = 'engine-alias_engine-type:connect';

    public function handle(): int
    {
        $engineTypes = EngineType::where('name', 'like', '%(%')->get();

        return $engineTypes->count();

        return Command::SUCCESS;
    }
}
