<?php

use App\Models\Establishment;
use App\Models\Organization;
use App\Models\User;

it('allows an associated user to create a job offer for an establishment', function () {
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

    $this->assertDatabaseHas('jobs', [
        'title' => 'Educateur spécialisé',
        'establishment_id' => $establishment->id,
    ]);
});

it('allows an associated user to view a job offer of their establishment', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $establishment = Establishment::factory()->create(['organization_id' => $organization->id]);
    $user->organizations()->attach($organization);

    $offer = Job::factory()->create([
        'establishment_id' => $establishment->id,
    ]);

    $user->refresh();

    $this->actingAs($user)
        ->get("/organizations/{$organization->id}/establishments/{$establishment->id}/job-offers/{$offer->id}")
        ->assertOk()
        ->assertSee($offer->title);
});

it('allows an associated user to update a job offer', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $establishment = Establishment::factory()->create(['organization_id' => $organization->id]);
    $user->organizations()->attach($organization);

    $offer = Job::factory()->create(['establishment_id' => $establishment->id]);

    $user->refresh();

    $this->actingAs($user)
        ->put("/organizations/{$organization->id}/establishments/{$establishment->id}/jobs/{$offer->id}", [
            'title' => 'Updated title',
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('jobs', ['title' => 'Updated title']);
});

it('allows an associated user to delete a job offer', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $establishment = Establishment::factory()->create(['organization_id' => $organization->id]);
    $user->organizations()->attach($organization);

    $offer = Job::factory()->create(['establishment_id' => $establishment->id]);

    $user->refresh();

    $this->actingAs($user)
        ->delete("/organizations/{$organization->id}/establishments/{$establishment->id}/jobs/{$offer->id}")
        ->assertRedirect();

    $this->assertDatabaseMissing('jobs', ['id' => $offer->id]);
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
    $job = Job::factory()->create(['establishment_id' => $establishment->id]);

    $user->refresh();

    $this->actingAs($user)
        ->get("/organizations/{$organization->id}/establishments/{$establishment->id}/jobs/{$job->id}")
        ->assertForbidden();
});

it('forbids a non-associated user to update a job', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $establishment = Establishment::factory()->create(['organization_id' => $organization->id]);
    $job = Job::factory()->create(['establishment_id' => $establishment->id]);

    $user->refresh();

    $this->actingAs($user)
        ->put("/organizations/{$organization->id}/establishments/{$establishment->id}/jobs/{$job->id}", [
            'title' => 'Tentative non autorisée',
        ])
        ->assertForbidden();
});

it('forbids a non-associated user to delete a job', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $establishment = Establishment::factory()->create(['organization_id' => $organization->id]);
    $job = Job::factory()->create(['establishment_id' => $establishment->id]);

    $user->refresh();

    $this->actingAs($user)
        ->delete("/organizations/{$organization->id}/establishments/{$establishment->id}/jobs/{$job->id}")
        ->assertForbidden();
});
