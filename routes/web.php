<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\OrganizationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function (Request $request) {
    if ($request->user()->role === 'candidate') {
        return Inertia::render('dashboards/CandidateDashboard', [
            // 'organizations' => Auth::user()->organizations
        ]);
    }
    return Inertia::render('dashboards/RecruiterDashboard', [
        // 'organizations' => Auth::user()->organizations
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::delete('organizations/{organization}/delete-logo', [OrganizationController::class, 'deleteLogo'])->name('organizations.deleteLogo');
    Route::delete('organizations/{organization}/establishments/{establishment}/delete-logo', [EstablishmentController::class, 'deleteLogo'])->name('organizations.establishments.deleteLogo');
    Route::resource('organizations', OrganizationController::class);
    Route::resource('organizations.establishments', EstablishmentController::class);
    Route::resource('organizations.establishments.jobs', JobOfferController::class)->parameters([
        'jobs' => 'jobOffer'
    ]);
    Route::resource('organizations.establishments.jobs.applications', JobOfferController::class)->parameters([
        'jobs' => 'jobOffer'
    ]);
    Route::resource('organizations.establishments.jobs.candidates', CandidateController::class)->parameters([
        'jobs' => 'jobOffer'
    ]);
    // Route::get('jobs', [JobController::class, 'index'])->name('jobs.index');
    // Route::get('jobs/{jobOffer}', [JobController::class, 'show'])->name('jobs.indexshow');
    Route::get('applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
    Route::get('applications/{application}/edit', [ApplicationController::class, 'edit'])->name('applications.edit');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
