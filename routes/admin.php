<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ConferenceController;
use App\Http\Controllers\Admin\SpeakerController;
use App\Http\Controllers\Admin\SponsorController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\ExhibitorController;
use App\Http\Controllers\Admin\AgendaDayController;
use App\Http\Controllers\Admin\AgendaSessionController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ParticipantController;
use App\Http\Controllers\Admin\ExhibitionBoothController;
use App\Http\Controllers\Admin\BoothBookingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Conferences
    Route::resource('conferences', ConferenceController::class);
    Route::post('conferences/{conference}/activate', [ConferenceController::class, 'activate'])->name('conferences.activate');

    // Speakers
    Route::resource('speakers', SpeakerController::class);

    // Sponsors
    Route::resource('sponsors', SponsorController::class);

    // Statistics
    Route::resource('statistics', StatisticController::class);

    // Exhibitors
    Route::resource('exhibitors', ExhibitorController::class);

    // Agenda Days
    Route::resource('agenda-days', AgendaDayController::class);

    // Agenda Sessions
    Route::resource('agenda-sessions', AgendaSessionController::class);

    // Gallery
    Route::resource('galleries', GalleryController::class);

    // FAQs
    Route::resource('faqs', FaqController::class);
    Route::post('faqs/{faq}/duplicate', [FaqController::class, 'duplicate'])
        ->name('faqs.duplicate');

    // Participants
    Route::resource('participants', ParticipantController::class);
    Route::post('participants/{id}/approve', [ParticipantController::class, 'approve'])
        ->name('participants.approve');
    Route::post('participants/{id}/reject', [ParticipantController::class, 'reject'])
        ->name('participants.reject');

    // Exhibition Booths
    Route::resource('exhibition-booths', ExhibitionBoothController::class);
    Route::post('exhibition-booths/{exhibitionBooth}/duplicate', [ExhibitionBoothController::class, 'duplicate'])
        ->name('exhibition-booths.duplicate');

    // Booth Bookings
    Route::resource('booth-bookings', BoothBookingController::class)->only(['index', 'show', 'update']);

    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
});

