<?php
use App\Models\User;
use App\Models\Organization;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


it('allows a recruiter to create an organization', function () {
    $data = [
        'name' => 'Test Org',
        'description' => 'Description',
        'address' => '123 rue',
        'street' => 'rue X',
        'postcode' => '75000',
        'city' => 'Paris',
        'phone' => '0101010101',
        'website' => 'https://example.com',
        'logo' => UploadedFile::fake()->image('logo.png'),
    ];

    Storage::fake('public');

    $user = User::factory()->create(['role' => 'recruiter']);
    $response =$this->actingAs($user)->post('/organizations', $data);

    $response->assertRedirect();
    $this->assertDatabaseHas('organizations', ['name' => 'Test Org']);
    Storage::disk('public')->assertExists(Organization::first()->logo);
});

it('allows an associated user to view an organization', function () {
    $user = User::factory()->create();
    $organization = Organization::factory()->create();
    $user->organizations()->attach($organization);

    $response = $this->actingAs($user)->get("/organizations/{$organization->id}");

    $response->assertOk();
});

it('allows an associated user to update an organization', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $organization = Organization::factory()->create(['name' => 'Old Name']);
    $user->organizations()->attach($organization);

    $user->refresh();

    $newLogo = UploadedFile::fake()->image('new-logo.png');

    $response = $this->actingAs($user)->put("/organizations/{$organization->id}", [
        'name' => 'New Name',
        'description' => 'Updated desc',
        'address' => '456 rue',
        'street' => 'new street',
        'postcode' => '69000',
        'city' => 'Lyon',
        'phone' => '0202020202',
        'website' => 'https://new-example.com',
        'logo' => $newLogo,
    ]);

    $response->assertRedirect();
    expect(Organization::find($organization->id)->name)->toBe('New Name');
    Storage::disk('public')->assertExists(Organization::find($organization->id)->logo);
});

it('allows an associated user to delete an organization', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $organization = Organization::factory()->create();
    $user->organizations()->attach($organization);

    $user->refresh();
    // Ajouter un faux logo
    $organization->update([
        'logo' => UploadedFile::fake()->image('logo.png')->store('logos', 'public'),
    ]);

    $response = $this->actingAs($user)->delete("/organizations/{$organization->id}");

    $response->assertRedirect();
    expect(Organization::find($organization->id))->toBeNull();
});

it('forbids a non-associated user from viewing an organization', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();

    $this->actingAs($user)
        ->get("/organizations/{$organization->id}")
        ->assertForbidden();
});

it('forbids a non-associated user from updating an organization', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();

    $this->actingAs($user)
        ->put("/organizations/{$organization->id}", [
            'name' => 'Hacked Name',
        ])
        ->assertForbidden();
});

it('forbids a non-associated user from deleting an organization', function () {
    $user = User::factory()->create(['role' => 'recruiter']);
    $organization = Organization::factory()->create();

    $this->actingAs($user)
        ->delete("/organizations/{$organization->id}")
        ->assertForbidden();
});



