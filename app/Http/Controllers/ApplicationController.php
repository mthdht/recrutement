<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Models\JobOffer;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('candidate/applications/Index', ['applications' => Auth::user()->applications]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(JobOffer $jobOffer)
    {
        return Inertia::render('candidate/applications/Create', ['jobOffer' => $jobOffer]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApplicationRequest $request, JobOffer $jobOffer)
    {
        $path = '';
        if ($request->hasFile('cv')) {
            $path = $request->file('cv')->store('cv');
        }

        $application = $jobOffer->applications()->create([
            'cv' => $path,
            'cover_letter' => $request->cover_letter,
            'applied_at' => now(),
            'status' => 'pending',
            'user_id' => Auth::id()
        ]);
       

        return redirect()->route('applications.show', [$application]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        return Inertia::render('candidate/applications/Show', ['application' => $application]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        //
    }
}
