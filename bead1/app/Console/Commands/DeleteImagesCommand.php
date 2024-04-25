<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete the public/images directory';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $imagePath = 'public/images';
        $b=Storage::deleteDirectory($imagePath);
        $answer = $b ? 'true' : 'false';

        $this->info($answer);
        
        return 0; // Return 0 to indicate success
    }
}
