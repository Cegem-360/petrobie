<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileProcessController;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/upload', [FileProcessController::class,'upload'])->name('upload');
