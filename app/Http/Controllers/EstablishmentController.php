<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Http\Requests\StoreEstablishmentRequest;
use App\Http\Requests\UpdateEstablishmentRequest;
use App\Models\Organization;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class EstablishmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Organization $organization)
    {
        $establishments = $organization->establishments()->get();

        return Inertia::render('Establishments/Index', [
            'organization' => $organization,
            'establishments' => $establishments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Organization $organization)
    {
        Gate::authorize('create', [Establishment::class, $organization]);
        
        return Inertia::render('establishments/Create', [
            'organization' => $organization,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstablishmentRequest $request, Organization $organization)
    {
        Gate::authorize('create', [Establishment::class, $organization]);

        $path= '';
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
        }

        $establishment = $organization->establishments()->create([
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

        return redirect()->route('organizations.establishments.show', [$organization, $establishment])->with('success', 'Etablissement crée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization, Establishment $establishment)
    {
        Gate::authorize('act', $establishment);

        return Inertia::render('establishments/Show', [
            'organization' => $organization,
            'establishment' => $establishment,
            'jobOffers' => $establishment->jobOffers
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization, Establishment $establishment)
    {
        Gate::authorize('act', $establishment);

        return Inertia::render('establishments/Edit', [
            'organization' => $organization,
            'establishment' => $establishment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstablishmentRequest $request, Organization $organization, Establishment $establishment)
    {
        Gate::authorize('act', $establishment);

        $path = $establishment->logo;

        if ($request->hasFile('logo')) {
            $organization->deleteLogoFile();
            $path = $request->file('logo')->store('logos', 'public');
        }

        $establishment->update([
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

        return redirect()->route('organizations.establishments.show', [$organization, $establishment])->with('success', 'Organisation modifier avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization, Establishment $establishment)
    {
        Gate::authorize('act', $establishment);

        $establishment->deleteLogoFile();
        $establishment->delete();

        return redirect()->route('organizations.show', [$organization])->with('success', 'Organisation supprimée avec succès');
    }

    public function deleteLogo(Organization $organization, Establishment $establishment)
    {
        Gate::authorize('act', $establishment);

        $establishment->deleteLogoFile();
        $establishment->update([
            'logo' => ''
        ]);

        return Inertia::location(route('organizations.establishments.edit', [$organization, $establishment]));
    }
}
