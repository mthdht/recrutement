<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    /** @use HasFactory<\Database\Factories\JobFactory> */
    use HasFactory;

    protected $fillable = [
        'establishment_id',
        'title',
        'description',
        'contract_type',
        'start_date',
        'end_date',
        'working_hours',
        'salary',
        'status',
        'published_at',
    ];

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    public function candidates() 
    {
        return $this->belongsToMany(User::class, 'applications')->using(Application::class);
    }
}
