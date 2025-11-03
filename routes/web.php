<?php

use App\Http\Controllers\CVController;
use App\Http\Controllers\PublicCVController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::get('/cv/public/{slug}', [PublicCVController::class, 'show'])->name('cv.public.show');
Route::get('/cv/public/{slug}/view', [PublicCVController::class, 'viewPdf'])->name('cv.public.view');
Route::get('/cv/public/{slug}/pdf', [PublicCVController::class, 'downloadPdf'])->name('cv.public.pdf');

Route::middleware('auth')->group(function () {
    Route::get('/cv/{cv}', [CVController::class, 'show'])->name('cv.show');
    Route::get('/cv/{cv}/pdf', [CVController::class, 'downloadPdf'])->name('cv.pdf');
});
