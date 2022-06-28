<?php

namespace App\Jobs;

use App\Models\AnyFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DownloadAnyFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AnyFile $file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->file->status = 'downloading';
        $this->file->save();

        try {
            $contents = file_get_contents($this->file->url);
            if ($contents) {
                $name = uniqid() . "_" .substr($this->file->url, strrpos($this->file->url, '/') + 1);
                Storage::disk('local')->put($name, $contents);

                $this->file->filename = $name;
                $this->file->status = 'complete';
            } else {
                $this->file->status = 'error';
            }
        } catch (\Exception $e) {
            $this->file->status = 'error';
        }

        $this->file->save();
    }
}
