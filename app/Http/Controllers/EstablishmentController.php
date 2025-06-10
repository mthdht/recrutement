<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Http\Requests\StoreEstablishmentRequest;
use App\Http\Requests\UpdateEstablishmentRequest;
use App\Models\Organization;
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
    public function create()
    {
        return Inertia::render('establishments/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstablishmentRequest $request, Organization $organization)
    {
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

        return redirect()->route('organizations.establishments.show', [$organization, $establishment])->with('success', 'Organisation créée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization, Establishment $establishment)
    {
        return Inertia::render('establishments/Show', [
            'organization' => $organization,
            'establishment' => $establishment
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Establishment $establishment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstablishmentRequest $request, Establishment $establishment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Establishment $establishment)
    {
        //
    }
}
