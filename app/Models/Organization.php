<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class Organization extends Model
{
    /** @use HasFactory<\Database\Factories\OrganizationFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'address',
        'street',
        'postcode',
        'country',
        'city',
        'phone',
        'logo',
        'website'
    ];

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function establishments()
    {
        return $this->hasMany(Establishment::class);
    }

    public function deleteLogoFile(): void
    {
        if ($this->logo && Storage::disk('public')->exists($this->logo)) {
            Storage::disk('public')->delete($this->logo);
        }
    }
}
