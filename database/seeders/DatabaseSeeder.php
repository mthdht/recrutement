<?php

namespace Database\Seeders;

use App\Models\Establishment;
use App\Models\Organization;
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
            ->has(Organization::factory(4)
                ->has(Establishment::factory(6)))
            ->create([
                'name' => 'mth',
                'email' => 'mthdht@gmail.com',
            ]);

        $matt2 = User::factory()
            ->has(Organization::factory(4)
                ->has(Establishment::factory(6)))
            ->create([
                'name' => 'mth2',
                'email' => 'mthdht2@gmail.com',
            ]);


        // $max = User::factory()->create([
        //     'name' => 'max',
        //     'email' => 'max@example.com',
        // ]);

        // $eric = User::factory()->create([
        //     'name' => 'eric',
        //     'email' => 'eric@example.com',
        // ]);

        
        // Role::create(['name' => 'admin']);
        // Role::create(['name' => 'manager']);
        // Role::create(['name' => 'recruiter']);
        // Role::create(['name' => 'candidate']);

        // $matt->assignRole('admin');
        // $max->assignRole('recruiter');
        // $eric->assignRole('candidate');
    }
}
