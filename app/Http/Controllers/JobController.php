<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('candidate/jobs/Index', ['jobOffers' => JobOffer::all()]);
    }

    /**
     * Display the specified resource.
     */
    public function show(JobOffer $jobOffer)
    {
        return Inertia::render('candidate/jobs/Show', [
            'jobOffer' => $jobOffer
        ]);
    }
}
