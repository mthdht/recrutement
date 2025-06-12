<?php

namespace Database\Factories;

use App\Models\Establishment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobOfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'establishment_id' => Establishment::factory(),
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraphs(3, true),
            'contract_type' => $this->faker->randomElement(['CDI', 'CDD', 'Stage', 'Alternance']),
            'start_date' => $this->faker->optional()->date(),
            'end_date' => $this->faker->optional()->date(),
            'working_hours' => $this->faker->randomElement(['Temps plein', 'Temps partiel', 'Horaires flexibles']),
            'salary' => $this->faker->optional()->regexify('[2-4][0-9]{2,3}€/mois'),
            'status' => $this->faker->randomElement(['draft', 'published', 'archived']),
            'published_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
