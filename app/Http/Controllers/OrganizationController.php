<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Http\Requests\StoreOrganizationRequest;
use App\Http\Requests\UpdateOrganizationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        $path= '';
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
        }

        $organization = Organization::create([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            "street" => $request->street,
            "postcode" => $request->postcode,
            "city" => $request->city,
            "country" => "France",
            "logo" => $path,
            "phone" => $request->phone,
            "website" => $request->website
        ]);

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
            'establishments' => $organization->establishments
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
        $path = $organization->logo;

        if ($request->hasFile('logo')) {
            $organization->deleteLogoFile();
            $path = $request->file('logo')->store('logos', 'public');
        }

        $organization->update([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            "street" => $request->street,
            "postcode" => $request->postcode,
            "city" => $request->city,
            "country" => "France",
            "logo" => $path,
            "phone" => $request->phone,
            "website" => $request->website
        ]);

        return redirect()->route('organizations.show', [$organization])->with('success', 'Organisation modifier avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        $organization->deleteLogoFile();
        $organization->delete();

        return redirect()->route('organizations.index')->with('success', 'Organisation supprimée avec succès');
    }

    public function deleteLogo(Organization $organization)
    {
        $organization->deleteLogoFile();
        $organization->update([
            'logo' => ''
        ]);

        return Inertia::location(route('organizations.edit', [$organization]));
    }
}
