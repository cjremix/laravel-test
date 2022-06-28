<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AnyFileController;
use App\Http\Controllers\Api\v1\DownloaderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/files', [AnyFileController::class, 'index']);

Route::post('/enlist-file', [DownloaderController::class, 'enlistFile'])->name('enlist-file');
