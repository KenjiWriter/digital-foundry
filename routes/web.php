<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', [\App\Http\Controllers\WelcomeController::class, 'index'])->name('home');

Route::get('/process', function () {
    return Inertia::render('Process');
})->name('process');

Route::get('/privacy-policy', function () {
    $locale = session('locale', 'en');
    $path = resource_path("markdown/legal/{$locale}/privacy.md");

    if (!file_exists($path)) {
        $path = resource_path("markdown/legal/en/privacy.md");
    }

    $content = \Illuminate\Support\Str::markdown(file_get_contents($path));

    return Inertia::render('Legal/PrivacyPolicy', [
        'content' => $content
    ]);
})->name('privacy.policy');

Route::get('/terms-of-service', function () {
    $locale = session('locale', 'en');
    $path = resource_path("markdown/legal/{$locale}/terms.md");

    if (!file_exists($path)) {
        $path = resource_path("markdown/legal/en/terms.md");
    }

    $content = \Illuminate\Support\Str::markdown(file_get_contents($path));

    return Inertia::render('Legal/TermsOfService', [
        'content' => $content
    ]);
})->name('terms.service');

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
    Route::resource('sectors', \App\Http\Controllers\Admin\SectorController::class);
});

Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

require __DIR__ . '/settings.php';
