<?php

use App\Http\Controllers\CVController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/cv/{cv}', [CVController::class, 'show'])->name('cv.show');
    Route::get('/cv/{cv}/pdf', [CVController::class, 'downloadPdf'])->name('cv.pdf');
});
