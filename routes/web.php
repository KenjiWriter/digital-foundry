<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(\App\Http\Controllers\CaseStudyController::class)->group(function () {
    Route::get('/case-studies', 'index')->name('case-studies.index');
    Route::get('/case-studies/{caseStudy}', 'show')->name('case-studies.show');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('case-studies', \App\Http\Controllers\Admin\CaseStudyController::class);
});

require __DIR__ . '/settings.php';
