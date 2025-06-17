<?php

namespace Database\Factories;

use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::class,
            'job_offer_id' => JobOffer::class,
            'cv' => 'storage/cv/jane.pdf',
            'cover_letter' => 'Je suis motivée...',
            'status' => 'pending',
        ];
    }
}
