<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $matt = User::factory()
            ->hasGalleries(3)
            ->create([
                'name' => 'matt',
                'email' => 'matt@example.com',
            ]);

        $max = User::factory()->create([
            'name' => 'max',
            'email' => 'max@example.com',
        ]);

        $eric = User::factory()->create([
            'name' => 'eric',
            'email' => 'eric@example.com',
        ]);

        
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'manager']);
        Role::create(['name' => 'recruiter']);
        Role::create(['name' => 'candidate']);

        $matt->assignRole('admin');
        $max->assignRole('recruiter');
        $eric->assignRole('candidate');
    }
}
