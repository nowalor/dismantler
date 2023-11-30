<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EngineTypesEscapeNameCommand extends Command
{
    protected $signature = 'engine-types:escape';

    public function handle(): int
    {
        $engineTypes = \App\Models\EngineType::all();

        foreach($engineTypes as $engineType) {
            $engineType->update([
                'escaped_name' => str_replace([' ', '-'], '', $engineType->name)
            ]);
        }

        return Command::SUCCESS;
    }
}
