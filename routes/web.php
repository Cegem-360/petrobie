<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileProcessController;



Route::post('/upload', [FileProcessController::class, 'upload'])->name('upload');

Route::redirect('/', '/admin');
