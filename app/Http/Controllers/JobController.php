<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobController extends Controller
{
    public function index()
    {
        return Inertia::render('jobs/Index', ['jobOffers' => JobOffer::all()]);
    }
}
