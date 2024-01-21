<?php

namespace App\Console\Commands;

use App\Models\Shot;
use App\Models\ShotReaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shotshare:clean-images {--only-missing : Only clean up files that don\'t have corresponding database records}';

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
        if ($this->option('only-missing')) {
            $existingPaths = Shot::select('path')->get()->pluck('path')->toArray();

            foreach (Storage::allFiles('uploads') as $uploadedFile) {
                if (! in_array($uploadedFile, $existingPaths)) {
                    Storage::delete($uploadedFile);
                }
            }
        } else {
            // Cleanup Database Records
            ShotReaction::where('id', '>=', 0)->delete();
            Shot::where('id', '>=', 0)->delete();

            // Cleanup Filesystem
            Storage::deleteDirectory('uploads');
        }
    }
}
