<?php

use App\Models\Organization;
use App\Models\User;

it('allows an associated user to create an establishment for an organization', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $user->organizations()->attach($organization);

    $data = [
        'name' => 'Test Establishment',
        'description' => 'A new site',
        'address' => '45 avenue des Champs',
        'street' => 'avenue des Champs',
        'postcode' => '75008',
        'city' => 'Paris',
        'phone' => '0102030405',
        'website' => 'https://site.com',
    ];

    $this->actingAs($user)
        ->post("/organizations/{$organization->id}/establishments", $data)
        ->assertRedirect();

    $this->assertDatabaseHas('establishments', [
        'name' => 'Test Establishment',
        'organization_id' => $organization->id,
    ]);
});

it('allows an associated user to view an establishment of an organization', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $user->organizations()->attach($organization);

    $establishment = \App\Models\Establishment::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($user)
        ->get("/organizations/{$organization->id}/establishments/{$establishment->id}")
        ->assertOk()
        ->assertSee($establishment->name);
});

it('allows an associated user to update an establishment of an organization', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $user->organizations()->attach($organization);

    $establishment = \App\Models\Establishment::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $updateData = [
        'name' => 'Updated Name',
        'description' => 'Updated Description',
        'address' => 'Updated Address',
        'street' => 'Updated Street',
        'postcode' => '75001',
        'city' => 'Paris',
        'phone' => '0101010101',
        'website' => 'https://updated.com',
    ];

    $this->actingAs($user)
        ->put("/organizations/{$organization->id}/establishments/{$establishment->id}", $updateData)
        ->assertRedirect();

    $this->assertDatabaseHas('establishments', ['name' => 'Updated Name']);
});

it('allows an associated user to delete an establishment of an organization', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $user->organizations()->attach($organization);

    $establishment = \App\Models\Establishment::factory()->create([
        'organization_id' => $organization->id,
    ]);

    $this->actingAs($user)
        ->delete("/organizations/{$organization->id}/establishments/{$establishment->id}")
        ->assertRedirect();

    $this->assertDatabaseMissing('establishments', ['id' => $establishment->id]);
});

it('forbids a non-associated user from viewing an establishment', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $establishment = \App\Models\Establishment::factory()->create(['organization_id' => $organization->id]);

    $this->actingAs($user)
        ->get("/organizations/{$organization->id}/establishments/{$establishment->id}")
        ->assertForbidden();
});

it('forbids a non-associated user from updating an establishment', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $establishment = \App\Models\Establishment::factory()->create(['organization_id' => $organization->id]);

    $this->actingAs($user)
        ->put("/organizations/{$organization->id}/establishments/{$establishment->id}", [
            'name' => 'Should not update',
        ])
        ->assertForbidden();
});

it('forbids a non-associated user from deleting an establishment', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();
    $establishment = \App\Models\Establishment::factory()->create(['organization_id' => $organization->id]);

    $this->actingAs($user)
        ->delete("/organizations/{$organization->id}/establishments/{$establishment->id}")
        ->assertForbidden();
});
