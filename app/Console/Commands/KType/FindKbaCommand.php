<?php

namespace App\Console\Commands\KType;

use App\Models\GermanDismantler;
use App\Models\KType;
use Illuminate\Console\Command;

/*
 * Purpose: Take in the kba_string which comes in a format of 2055|462<>2142|307<>2142|371
 * and sync it to our existing 'kbas' in the database so we can later find the k-type through the kba
 * the k-type is needed before uploading to ebay
 */
class FindKbaCommand extends Command
{
    protected $signature = 'k-type:find-kba';

    public function handle(): int
    {
        $kTypes = KType::select(['id', 'kba_string'])->get();

        foreach ($kTypes as $kType) {
            // About 50% of the kba is empty
            // Might need another way to sync them up in the future...
            if(!$kType->kba_string) {
                continue;
            }

            $kbaArr = $this->kbaStringToArr($kType->kba_string);

            $kbaIds = [];
            foreach ($kbaArr as $kba) {
                $kbaInDb = GermanDismantler::select(['id'])
                    ->where('hsn', $kba['hsn'])
                    ->where('tsn', $kba['tsn'])
                    ->first();

            if(!$kbaInDb) {
                logger()->info("Could not find kba where hsn: {$kba['hsn']} tsn: {$kba['tsn']} in k-type: $kType->id");

                continue;
            }

                $kbaIds[] = $kbaInDb->id;
            }

            $kType->germanDismantlers()->syncWithoutDetaching($kbaIds);
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
        $kbaPairs = explode('<>', $kba);

        foreach ($kbaPairs as $kbaPair) {
            // Split each pair into "hsn" and "tsn" using '|'
            [$hsn, $tsn] = explode('|', $kbaPair);

            // Add the pair to the result array
            $result[] = ["hsn" => $hsn, "tsn" => $tsn];
        }

        return $result;
    }
}
