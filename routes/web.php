<?php

use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard', [
        'organizations' => Auth::user()->organizations
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::delete('organizations/{organization}/delete-logo', [OrganizationController::class, 'deleteLogo'])->name('organizations.deleteLogo');
    Route::resource('organizations', OrganizationController::class);
    Route::resource('organizations.establishments', EstablishmentController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
