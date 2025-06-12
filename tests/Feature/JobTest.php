<?php

use App\Models\Establishment;
use App\Models\JobOffer;
use App\Models\Organization;
use App\Models\User;

it('allows an associated user to create a JobOffer offer for an establishment', function () {
    // Arrange
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $establishment = Establishment::factory()->create(['organization_id' => $organization->id]);
    $user->organizations()->attach($organization);

    $data = [
        'title' => 'Educateur spécialisé',
        'description' => 'Accompagnement des enfants...',
        'contract_type' => 'CDI',
        'start_date' => '2025-09-01',
        'end_date' => null,
        'working_hours' => 'Temps plein',
        'salary' => '2300€/mois',
        'status' => 'draft',
    ];

    $user->refresh();
    // Act + Assert
    $this->actingAs($user)
        ->post("/organizations/{$organization->id}/establishments/{$establishment->id}/jobs", $data)
        ->assertRedirect();

    $this->assertDatabaseHas('Job_offers', [
        'title' => 'Educateur spécialisé',
        'establishment_id' => $establishment->id,
    ]);
});

it('allows an associated user to view a job offer of their establishment', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $establishment = Establishment::factory()->create(['organization_id' => $organization->id]);
    $user->organizations()->attach($organization);

    $jobOffer = JobOffer::factory()->create([
        'establishment_id' => $establishment->id,
    ]);

    $user->refresh();

    $this->actingAs($user)
        ->get("/organizations/{$organization->id}/establishments/{$establishment->id}/jobs/{$jobOffer->id}")
        ->assertOk()
        ->assertSee($jobOffer->title);
});

it('allows an associated user to update a job offer', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $establishment = Establishment::factory()->create(['organization_id' => $organization->id]);
    $user->organizations()->attach($organization);

    $jobOffer = JobOffer::factory()->create(['establishment_id' => $establishment->id]);

    $user->refresh();

    $this->actingAs($user)
        ->put("/organizations/{$organization->id}/establishments/{$establishment->id}/jobs/{$jobOffer->id}", [
            'title' => 'Updated title',
            'description' => 'Updated desc',
            'contract_type' => 'CDD',
            'start_date' => '2025-07-01',
            'end_date' => '2025-12-31',
            'working_hours' => '35h',
            'salary' => '3000',
            'status' => 'draft',

        ])
        ->assertRedirect();

    $this->assertDatabaseHas('job_offers', ['title' => 'Updated title']);
});

it('allows an associated user to delete a job offer', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $establishment = Establishment::factory()->create(['organization_id' => $organization->id]);
    $user->organizations()->attach($organization);

    $jobOffer = JobOffer::factory()->create(['establishment_id' => $establishment->id]);

    $user->refresh();

    $this->actingAs($user)
        ->delete("/organizations/{$organization->id}/establishments/{$establishment->id}/jobs/{$jobOffer->id}")
        ->assertRedirect();

    $this->assertDatabaseMissing('jobs', ['id' => $jobOffer->id]);
});

it('forbids a non-associated user to create a job', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $establishment = Establishment::factory()->create(['organization_id' => $organization->id]);

    $data = [
        'title' => 'Non autorisé',
        'description' => 'Tentative de création...',
        'contract_type' => 'CDD',
        'start_date' => '2025-09-01',
        'working_hours' => 'Temps partiel',
        'status' => 'draft',
    ];

    $user->refresh();

    $this->actingAs($user)
        ->post("/organizations/{$organization->id}/establishments/{$establishment->id}/jobs", $data)
        ->assertForbidden();
});

it('forbids a non-associated user to view a job', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $establishment = Establishment::factory()->create(['organization_id' => $organization->id]);
    $jobOffer = JobOffer::factory()->create(['establishment_id' => $establishment->id]);

    $user->refresh();

    $this->actingAs($user)
        ->get("/organizations/{$organization->id}/establishments/{$establishment->id}/jobs/{$jobOffer->id}")
        ->assertForbidden();
});

it('forbids a non-associated user to update a job', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $establishment = Establishment::factory()->create(['organization_id' => $organization->id]);
    $jobOffer = JobOffer::factory()->create(['establishment_id' => $establishment->id]);

    $user->refresh();

    $this->actingAs($user)
        ->put("/organizations/{$organization->id}/establishments/{$establishment->id}/jobs/{$jobOffer->id}", [
            'title' => 'Tentative non autorisée',
            'description' => 'Should not be saved',
            'contract_type' => 'CDD',
            'start_date' => '2025-07-01',
            'end_date' => '2025-12-31',
            'working_hours' => '35h',
            'salary' => '2500',
            'status' => 'draft',
        ])
        ->assertForbidden();
});

it('forbids a non-associated user to delete a job', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $establishment = Establishment::factory()->create(['organization_id' => $organization->id]);
    $jobOffer = JobOffer::factory()->create(['establishment_id' => $establishment->id]);

    $user->refresh();

    $this->actingAs($user)
        ->delete("/organizations/{$organization->id}/establishments/{$establishment->id}/jobs/{$jobOffer->id}")
        ->assertForbidden();
});
