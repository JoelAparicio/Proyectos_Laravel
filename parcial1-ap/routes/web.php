<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PdfController::class, 'showUploadForm']);
Route::post('/upload', [PdfController::class, 'uploadPdf']);
Route::get('/status/{taskId}', [PdfController::class, 'checkStatus']);
Route::get('/download/{taskId}', [PdfController::class, 'downloadPdf']);
Route::get('/download-page/{taskId}', [PdfController::class, 'downloadPage']);
