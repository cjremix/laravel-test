<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnyFileResource;
use App\Models\AnyFile;
use Illuminate\Http\Request;

class AnyFileController extends Controller
{
    public function index (Request $request)
    {
        return AnyFileResource::collection(AnyFile::all());
    }
}
