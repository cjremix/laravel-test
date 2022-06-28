<?php

namespace Tests\Feature;

use App\Jobs\DownloadAnyFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class EnlistFileTest extends TestCase
{
    use RefreshDatabase;

    public function test_enlist_file()
    {
        $url = url('/') . '/test_file.png';
        $response = $this->followingRedirects()
            ->post('/enlist-file', [
                'url' => $url
            ]);

        $response->assertSee($url);
    }

    public function test_not_valid_url()
    {
        $url = 'h' . url('/') . '/test_file.png';
        $response = $this->followingRedirects()
            ->post('/enlist-file', [
                'url' => $url
            ]);

        $response->assertSee("The url must be a valid URL.");
    }

    function test_jobs()
    {
        Queue::fake();
        $this->test_enlist_file();
        Queue::assertPushed(DownloadAnyFile::class);
    }
}
