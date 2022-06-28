<?php

namespace Tests\Feature;

use App\Jobs\DownloadAnyFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CliEnlistFileTest extends TestCase
{
    use RefreshDatabase;

    public function test_cli_enlist_file()
    {
        $url = url('/') . '/test_file.png';
        $this->artisan('anyfile:enlist ' . $url)
            ->assertExitCode(1);
    }

    public function test_cli_not_valid_url()
    {
        $url = 'h' . url('/') . '/test_file.png';
        $this->artisan('anyfile:enlist ' . $url)
            ->assertExitCode(0);
    }

    function test_cli_jobs()
    {
        Queue::fake();
        $this->test_cli_enlist_file();
        Queue::assertPushed(DownloadAnyFile::class);
    }
}
