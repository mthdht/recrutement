<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('applications/Index', ['applications' => Application::all()]);
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
    public function store(StoreApplicationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        return Inertia::render('applications/Show', ['application' => $application]);
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
