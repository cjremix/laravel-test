<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnyFileEnlistRequest;
use App\Http\Resources\AnyFileResource;
use App\Jobs\DownloadAnyFile;
use App\Models\AnyFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DownloaderController extends Controller
{
    public function enlistFile(AnyFileEnlistRequest $request)
    {
        $file = new AnyFile();
        $file->url = $request->get('url');
        $file->save();

        DownloadAnyFile::dispatch($file);

        return new AnyFileResource($file->fresh());
    }
}
