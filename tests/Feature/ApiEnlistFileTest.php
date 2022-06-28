<?php

namespace Tests\Feature;

use App\Jobs\DownloadAnyFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ApiEnlistFileTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_enlist_file()
    {
        $url = url('/') . '/test_file.png';
        $response = $this->json('POST', '/api/v1/enlist-file', ['url' => $url]);

        $response
            ->assertJson([
                'data' => [
                    'url' => $url,
                ],
            ]);
    }

    public function test_api_not_valid_url()
    {
        $url = 'h' . url('/') . '/test_file.png';
        $response = $this->json('POST', '/api/v1/enlist-file', ['url' => $url]);

        $response
            ->assertJson([
                    'url' => ["The url must be a valid URL."]
            ]);
    }

    function test_api_jobs()
    {
        Queue::fake();
        $this->test_api_enlist_file();
        Queue::assertPushed(DownloadAnyFile::class);
    }
}
