<?php

namespace App\Http\Controllers;

use App\Models\AnyFile;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index()
    {
        $files = AnyFile::all();

        return view('index', compact('files'));
    }
}
