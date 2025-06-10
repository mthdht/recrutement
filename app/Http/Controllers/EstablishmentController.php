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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstablishmentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Establishment $establishment)
    {
        //
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
