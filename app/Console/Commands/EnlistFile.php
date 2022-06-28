<?php

namespace App\Console\Commands;

use App\Jobs\DownloadAnyFile;
use App\Models\AnyFile;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class EnlistFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'anyfile:enlist {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enlist new file to queue';

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
        $validator = Validator::make([
            'url' => $this->argument('url'),
        ],
        [
            'url' => 'required|url'
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                printf($error . "\n");
            }

            return 0;
        }

        $file = new AnyFile();
        $file->url = $this->argument('url');
        $file->save();

        DownloadAnyFile::dispatch($file);

        printf("OK");

        return 1;
    }
}
