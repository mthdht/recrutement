<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Http\Requests\StoreOrganizationRequest;
use App\Http\Requests\UpdateOrganizationRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('organizations/Index', ['organizations' => Auth::user()->organizations]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('organizations/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganizationRequest $request)
    {   
        $organization = Organization::create($request->all());

        // Associer l'utilisateur à cette organisation
        Auth::user()->organizations()->attach($organization);

        return redirect()->route('organizations.show', [$organization])->with('success', 'Organisation créée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization)
    {
        return Inertia::render('organizations/Show', [
            'organization' => $organization,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization)
    {
        return Inertia::render('organizations/Edit', [
            'organization' => $organization,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        $organization->update($request->all());

        return redirect()->route('organizations.show', [$organization])->with('success', 'Organisation modifier avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        //
    }
}
