<?php

namespace App\Console\Commands;

use App\Models\AnyFile;
use Illuminate\Console\Command;

class GetFileList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'anyfile:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting enlisted files list with statuse and donwload link';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $format = "%100.255s | %11.11s | %-20.20s\n";
        printf($format, "Url", "Status", "Download link");
        foreach (AnyFile::all() as $file) {
            printf($format, $file->url, $file->status, $file->getDownloadLink());
        }
        return 0;
    }
}
