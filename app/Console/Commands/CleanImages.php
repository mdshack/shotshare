<?php

namespace App\Console\Commands;

use App\Models\Shot;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shotshare:clean-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup all images';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Cleanup Database Records
        Shot::query()->truncate();

        // Cleanup Filesystem
        Storage::deleteDirectory('uploads');
    }
}
