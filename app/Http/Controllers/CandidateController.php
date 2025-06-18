<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateRequest;
use App\Models\Establishment;
use App\Models\JobOffer;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Organization $organization, Establishment $establishment, JobOffer $jobOffer)
    {
        Gate::authorize('create', [JobOffer::class, $establishment]);
        
        return Inertia::render('candidates/Create', [
            'organization' => $organization,
            'establishment' => $establishment,
            'jobOffer' => $jobOffer,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CandidateRequest $request, Organization $organization, Establishment $establishment, JobOffer $jobOffer)
    {
        Gate::authorize('create', [JobOffer::class, $establishment]);

        $user = User::create([
            'name' => "$request->last_name $request->first_name",
            'email' => $request->email,
            'password' => Hash::make('password') 
        ]);

        $path= '';
        if ($request->hasFile('cv')) {
            $path = $request->file('cv')->store('cv', 'public');
        }

        $user->profile()->create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'cv' => $path,
            'phone' => $request->phone,
            'bio' => $request->bio,
        ]);

        return redirect()->route('organizations.establishments.jobs.show', [$organization, $establishment, $jobOffer]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Candidate $candidat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Candidate $candidat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CandidateRequest $request, Candidate $candidat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidate $candidat)
    {
        //
    }
}
