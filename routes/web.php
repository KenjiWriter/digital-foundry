<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('analytics/track', [\App\Http\Controllers\DashboardController::class, 'track'])
    ->name('analytics.track');

Route::get('language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'pl', 'es', 'ru'])) {
        session()->put('locale', $locale);
    }
    return back();
});

Route::controller(\App\Http\Controllers\CaseStudyController::class)->group(function () {
    Route::get('/case-studies', 'index')->name('case-studies.index');
    Route::get('/case-studies/{caseStudy}', 'show')->name('case-studies.show');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('case-studies', \App\Http\Controllers\Admin\CaseStudyController::class);
    Route::resource('leads', \App\Http\Controllers\Admin\LeadController::class);
});

Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

require __DIR__ . '/settings.php';
