<?php

namespace App\Console\Commands\Egluit;

use App\Models\NewCarPart;
use App\Models\NewCarPartImage;
use Illuminate\Console\Command;

class WipeEgluitPartsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
         /*NewCarpartImage::where('original_url', 'like', '%egluit%')
            ->chunk(20000, function($images) {
                foreach ($images as $image) {
                    $image->delete();
                }
            }); */

        NewCarPart::where('country', 'DK')->chunk(5000,  function($parts){
            foreach($parts as $part){
                $part->delete();
            }
        });

        return Command::SUCCESS;
    }
}
