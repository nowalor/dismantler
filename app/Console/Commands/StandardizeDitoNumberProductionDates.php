<?php

namespace App\Console\Commands;

use App\Models\DitoNumber;
use Illuminate\Console\Command;

class StandardizeDitoNumberProductionDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dito-numbers:standardize-production-dates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle()
    {
        $this->info('Starting to normalize production dates...');

        DitoNumber::chunk(500, function ($ditoNumbers) {
            foreach ($ditoNumbers as $dito) {
                $normalized = $this->normalize($dito->production_date);

                if ($normalized) {
                    $dito->standardized_production_date = $normalized;
                    $dito->save();
                    $this->info("Updated DitoNumber ID {$dito->id} ➔ {$normalized}");
                }
            }
        });

        $this->info('Done normalizing production dates!');
    }

    protected function normalize(?string $input)
    {
        if (empty($input)) {
            return null;
        }

        $input = str_replace(['–', '—'], '-', strtolower(trim($input)));

        // Trash values
        if (preg_match('/[^0-9><\-]/', $input) && !preg_match('/(jan|feb|mar|apr|maj|jun|jul|aug|sep|okt|nov|dec)/', $input)) {
            return null;
        }

        // Fix common typos
        $input = str_replace(['20015', '20014', '1017'], ['2015', '2014', '2017'], $input);

        // Months just drop (keep the year part only)
        $months = ['jan','feb','mar','apr','maj','jun','jul','aug','sep','okt','nov','dec'];
        foreach ($months as $month) {
            $input = str_replace($month, '', $input);
        }

        $input = preg_replace('/[^0-9><-]/', '', $input); // Strip any remaining unwanted chars

        // Now parse
        if (preg_match('/^(\d{2,4})-(\d{2,4})$/', $input, $matches)) {
            $start = $this->normalizeYear($matches[1]);
            $end = $this->normalizeYear($matches[2]);
            return "{$start}-{$end}";
        }

        if (preg_match('/^(\d{2,4})>$/', $input, $matches)) {
            $start = $this->normalizeYear($matches[1]);
            return "{$start}>";
        }

        if (preg_match('/^(\d{2,4})$/', $input, $matches)) {
            $start = $this->normalizeYear($matches[1]);
            return "{$start}>";
        }

        return null;
    }

    protected function normalizeYear($year)
    {
        if (strlen($year) == 2) {
            if (intval($year) > 30) { // e.g. 89 -> 1989
                return '19' . $year;
            } else {
                return '20' . $year;
            }
        }
        return $year;
    }
}
