<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralController;
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

Route::view('file-upload', 'components.upload_form');
Route::post('/file-upload', [GeneralController::class, 'store']);
Route::get('/view-uploads', [GeneralController::class, 'viewUploads']);
Route::get('/view-uploads/delete/{url}', [GeneralController::class, 'deleteImage']);
