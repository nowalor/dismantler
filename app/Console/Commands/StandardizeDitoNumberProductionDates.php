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

        $input = strtolower(trim($input));
        $input = str_replace(['–', '—'], '-', $input);

        // Clean corrupted year values (e.g., 20013)
        $input = preg_replace_callback('/\d{5}/', function ($match) {
            return substr($match[0], 0, 4); // trim to 4-digit year
        }, $input);

        // Handle: YY-mon or YYYY-mon ➝ e.g. 05-nov, 2005-nov
        if (preg_match('/^(\d{2,4})-(jan|feb|mar|apr|maj|jun|jul|aug|sep|okt|nov|dec)$/', $input, $matches)) {
            $year = $this->normalizeYear($matches[1]);
            return "{$year}>";
        }

        // Fix mixed formats like: 97>02, 97-02>, etc.
        if (preg_match('/^(\d{2,4})[->]+(\d{2,4})$/', $input, $matches)) {
            $start = $this->normalizeYear($matches[1]);
            $end = $this->normalizeYear($matches[2]);
            return "{$start}-{$end}";
        }

        // Month cleanup (after we've handled valid ones above)
        $months = ['jan','feb','mar','apr','maj','jun','jul','aug','sep','okt','nov','dec'];
        $input = str_replace($months, '', $input);
        $input = preg_replace('/[^0-9><-]/', '', $input);

        // Year range
        if (preg_match('/^(\d{2,4})-(\d{2,4})$/', $input, $matches)) {
            $start = $this->normalizeYear($matches[1]);
            $end = $this->normalizeYear($matches[2]);
            return "{$start}-{$end}";
        }

        // Single year with >
        if (preg_match('/^(\d{2,4})>$/', $input, $matches)) {
            return $this->normalizeYear($matches[1]) . '>';
        }

        // Single year
        if (preg_match('/^(\d{2,4})$/', $input, $matches)) {
            return $this->normalizeYear($matches[1]) . '>';
        }

        return null; // anything we couldn't handle
    }

    protected function normalizeYear($year)
    {
        $year = (int) $year;
        if ($year < 100) {
            return $year > 30 ? 1900 + $year : 2000 + $year;
        }
        return $year;
    }

}
