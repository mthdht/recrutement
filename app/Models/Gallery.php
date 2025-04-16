<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    /** @use HasFactory<\Database\Factories\GalleryFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'address',
    ];

    // 🔗 Le gérant (user)
    public function manager()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 🔗 Les enseignes de cette galerie
    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
