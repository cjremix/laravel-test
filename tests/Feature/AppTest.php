<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AppTest extends TestCase
{
    public function test_home_page_status()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
