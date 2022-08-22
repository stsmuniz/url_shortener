<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\QrCodeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/qrcode', [QrCodeController::class, 'index']);

Route::get('/{shortened_url}', [LinkController::class, 'redirect']);

Route::get('/qrcode/{shortened_url}', [LinkController::class, 'generateQrCode']);
