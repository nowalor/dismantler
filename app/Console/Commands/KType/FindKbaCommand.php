<?php

namespace App\Console\Commands\KType;

use App\Models\GermanDismantler;
use App\Models\KType;
use Illuminate\Console\Command;

class FindKbaCommand extends Command
{
    protected $signature = 'k-type:find-kba';

    public function handle(): int
    {
        $kTypes = KType::select(['id', 'kba_string'])->all();

        foreach ($kTypes as $kType) {
            $kbaArr = $this->kbaStringToArr($kType->kba_string);

            $kbaIds = [];
            foreach ($kbaArr as $kba) {
                $kbaId = GermanDismantler::select(['idw'])
                    ->where('hsn', $kba['hsn'])
                    ->where('tsn', $kba['tsn'])
                    ->id;

                $kbaIds[] = $kbaId;
            }
        }

        return Command::SUCCESS;
    }

    /*
     * Input: 2055|462<>2142|307<>2142|371
     * Output: [["hsn" => "2055, "tsn => "462"], ["hsn" => "2142", "tsn" => "307" ...]
     */
    private function kbaStringToArr(string $kba): array
    {
        $result = [];

        // Split the input string into pairs using '<>' as the separator
        $pairs = explode('<>', $kba);

        foreach ($pairs as $pair) {
            // Split each pair into "hsn" and "tsn" using '|'
            [$hsn, $tsn] = explode('|', $pair);

            // Add the pair to the result array
            $result[] = ["hsn" => $hsn, "tsn" => $tsn];
        }

        return $result;
    }
}
