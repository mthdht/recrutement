<?php

use App\Models\User;
use App\Models\Organization;
use App\Models\Establishment;
use App\Models\JobOffer;

it('allows a recruiter to create a candidate and assign them to a job offer', function () {
    // Arrange
    $recruiter = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $establishment = Establishment::factory()->create(['organization_id' => $organization->id]);
    $jobOffer = JobOffer::factory()->create(['establishment_id' => $establishment->id]);

    $recruiter->organizations()->attach($organization);

    $data = [
        'first_name' => 'Alice',
        'last_name' => 'Dupont',
        'email' => 'alice.dupont@example.com',
        'phone' => '0601020304',
        'cv' => 'cv/alice-dupont.pdf',
        'cover_letter' => 'Profil intéressant pour ce poste.',
    ];

    $recruiter->refresh();
    
    // Act
    $this->actingAs($recruiter)
        ->post("/organizations/{$organization->id}/establishments/{$establishment->id}/jobs/{$jobOffer->id}/candidates", $data)
        ->assertRedirect();

    // Assert
    $this->assertDatabaseHas('users', [
        'email' => 'alice.dupont@example.com',
        'role' => 'candidate',
    ]);

    $this->assertDatabaseHas('profiles', [
        'first_name' => 'Alice',
        'last_name' => 'Dupont',
        'phone' => '0601020304',
    ]);

    $this->assertDatabaseHas('applications', [
        'cover_letter' => 'Profil intéressant pour ce poste.',
        'cv' => 'cv/alice-dupont.pdf',
        'job_offer_id' => $jobOffer->id,
    ]);
});

