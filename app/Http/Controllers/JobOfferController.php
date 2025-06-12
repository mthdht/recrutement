<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Establishment;
use App\Models\Organization;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class JobOfferController extends Controller
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
    public function create(Organization $organization, Establishment $establishment)
    {
        Gate::authorize('create', [JobOffer::class, $establishment]);

        return Inertia::render('Jobs/Create', [
            'organization' => $organization,
            'establishment' => $establishment,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobRequest $request, Organization $organization, Establishment $establishment)
    {
        Gate::authorize('create', [JobOffer::class, $establishment]);

        $data = $request->validated();

        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        $jobOffer = $establishment->jobOffers()->create($data);

        return redirect()->route('organizations.establishments.jobs.show', [$organization, $establishment, $jobOffer])
            ->with('success', 'Offre créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization, Establishment $establishment, JobOffer $jobOffer)
    {
        Gate::authorize('act', $jobOffer);

        return Inertia::render('Jobs/Show', [
            'organization' => $organization,
            'establishment' => $establishment,
            'jobOffer' => $jobOffer,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization, Establishment $establishment, JobOffer $jobOffer)
    {
        Gate::authorize('act', $jobOffer);

        return Inertia::render('Jobs/Edit', [
            'organization' => $organization,
            'establishment' => $establishment,
            'jobOffer' => $jobOffer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobRequest $request, Organization $organization, Establishment $establishment, JobOffer $jobOffer)
    {
        Gate::authorize('act', $jobOffer);

        $data = $request->validated();

        if ($data['status'] === 'published' && !$jobOffer->published_at) {
            $data['published_at'] = now();
        }
        
        $jobOffer->update($data);

        return redirect()->route('organizations.establishments.jobs.show', [$organization, $establishment, $jobOffer])
            ->with('success', 'Offre mise à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization, Establishment $establishment, JobOffer $jobOffer)
    {
        Gate::authorize('act', $jobOffer);

        $jobOffer->delete();

        return redirect()->route('organizations.establishments.show', [$organization, $establishment])
            ->with('success', 'Offre supprimée.');
    }
}
