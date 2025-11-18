<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\SpeakerController;
use App\Http\Controllers\Frontend\SponsorController;
use App\Http\Controllers\Frontend\ExhibitorController;
use App\Http\Controllers\Frontend\AgendaController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\RegistrationController;
use App\Http\Controllers\Frontend\PreviousEditionController;
use App\Http\Controllers\Frontend\BoothController;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lang/{locale}', [HomeController::class, 'switchLanguage'])->name('lang.switch');

Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/speakers', [SpeakerController::class, 'index'])->name('speakers');
Route::get('/speakers/{speaker}', [SpeakerController::class, 'show'])->name('speakers.show');
Route::get('/sponsors', [SponsorController::class, 'index'])->name('sponsors');
Route::get('/exhibitors', [ExhibitorController::class, 'index'])->name('exhibitors');
Route::get('/exhibitors/{exhibitor}', [ExhibitorController::class, 'show'])->name('exhibitors.show');
Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda');
Route::get('/agenda/{day}', [AgendaController::class, 'show'])->name('agenda.show');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

Route::get('/registration', [RegistrationController::class, 'index'])->name('registration');
Route::post('/registration', [RegistrationController::class, 'store'])->name('registration.store');

Route::get('/previous-editions', [PreviousEditionController::class, 'index'])->name('previous-editions');
Route::get('/previous-editions/{id}', [PreviousEditionController::class, 'show'])->name('previous-editions.show');

Route::get('/booths', [BoothController::class, 'index'])->name('booths');
Route::get('/booths/{booth}', [BoothController::class, 'show'])->name('booths.show');
Route::post('/booths/{booth}/book', [BoothController::class, 'book'])->name('booths.book');

// Auth Routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
