<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create kagawad user (admin role)
        User::factory()->create([
            'name' => 'Kagawad User',
            'email' => 'kagawad@example.com',
            'role' => 'kagawad',
        ]);

        // Create kapitan user (super admin)
        User::factory()->create([
            'name' => 'Kapitan User',
            'email' => 'kapitan@example.com',
            'role' => 'kapitan',
        ]);

        // Create regular resident user
        User::factory()->create([
            'name' => 'Resident User',
            'email' => 'resident@example.com',
            'role' => 'resident',
        ]);

        // Create additional test users
        User::factory(5)->create();
    }
}
