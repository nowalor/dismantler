<?php

namespace App\Console\Commands;

use App\Models\EngineAlias;
use App\Models\EngineType;
use Illuminate\Console\Command;

class ConnectEngineAliasToEngineTypeCommand extends Command
{
    protected $signature = 'engine-alias_engine-type:connect';

    public function handle(): int
    {
        $engineAliases = EngineAlias::where('name', 'like', '%(%')->get();

        // Copy existing engine types to engine aliases table
//        foreach($engineTypes as $engineType ) {
//            EngineAlias::create([
//                'name' => $engineType->name,
//            ]);
//        }

        foreach($engineAliases as $engineAlias) {
            $name = strstr($engineAlias->name, '(', true); // Get everything before the first '('

            $engineType = EngineType::where('name', $name)->first();

            if(!$engineType) {
                $engineType = EngineType::create([
                    'name' => $name,
                    'is_new_format' => true,
                ]);
            }

            $engineType->is_new_format = true;
            $engineType->save();

            $matchingEngineAliases = EngineAlias::where('name', 'like', $name . '%')
                ->where('name', 'like', '%(%')
                ->get();

            $engineType->engineAliases()->syncWithoutDetaching($matchingEngineAliases->pluck('id'));
        }

        return Command::SUCCESS;
    }
}
