<?php

namespace App\Console\Commands;

use App\Models\NewCarPart;
use Illuminate\Console\Command;

class ResolveEngineTypeFromOriginalNumberCommand extends Command
{
    protected $signature = 'resolve-engine-types';

    public function handle(): int
    {
        $this->resolveField('engine_code');
//        $this->resolveField('engine_type');

        return Command::SUCCESS;
    }

    public function resolveField(string $field)
    {
        $carParts = NewCarPart::whereNull($field)
            ->orWhere($field, '')
            ->get();

        foreach($carParts as $carPart) {
            $carPartWithEngineType = NewCarPart::where('original_number', $carPart->original_number)
                ->whereNotNull($field)
                ->where($field, '!=', '')
                ->first();

            if(!$carPartWithEngineType) {
                continue;
            }

            $matchingParts = NewCarPart::where('original_number', $carPart->original_number)
                ->where(function($query) use($field) {
                    $query->whereNull($field)
                        ->orWhere($field, '');
                });

            if($matchingParts->count() === 0) {
                continue;
            }

            $matchingParts->update([
                $field => $carPartWithEngineType->getAttribute($field)
            ]);
        }
    }
}
