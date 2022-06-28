<?php

namespace App\Http\Controllers;

use App\Jobs\DownloadAnyFile;
use App\Models\AnyFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloaderController extends Controller
{
    public function enlistFile(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $file = new AnyFile();
        $file->url = $request->get('url');
        $file->save();

        DownloadAnyFile::dispatch($file);

        return redirect()->route('index');
    }

    public function download (Request $request)
    {
        $file_id = $request->route('file_id');

        $file = AnyFile::select('filename')
                ->where('id', $file_id)
                ->first();

        if ($file) {
            return Storage::download($file->filename);
        } else {
            return redirect()->route('index')->withErrors('ERROR: No file to download');
        }
    }
}
