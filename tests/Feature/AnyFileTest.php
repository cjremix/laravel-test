<?php

namespace Tests\Feature;

use App\Models\AnyFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AnyFileTest extends TestCase
{
    public function test_anyfile_download()
    {
        $test_file_name = 'test_file.png';

        $exampleFile = new File(resource_path($test_file_name));

        Storage::putFileAs('/', $exampleFile, $test_file_name);

        $file = new AnyFile();
        $file->url = url('/') . $test_file_name;
        $file->filename = $test_file_name;
        $file->save();

        $response = $this->get(url('/') . $file->getDownloadLink());
        $response->assertOk();
        $response->assertHeader('Content-Type', 'image/png');

        Storage::assertExists($test_file_name);
        Storage::delete($test_file_name);
        Storage::assertMissing($test_file_name);
    }
}
