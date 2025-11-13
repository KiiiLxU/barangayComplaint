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
        // Create kagawad users (admin role) - one for each purok
        for ($i = 1; $i <= 7; $i++) {
            User::factory()->create([
                'name' => 'Kagawad ' . $i,
                'email' => 'kagawad' . $i . '@example.com',
                'role' => 'kagawad',
            ]);
        }

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

        // Create barangay officials
        \App\Models\BrgyOfficial::create([
            'name' => 'Juan Dela Cruz',
            'position' => 'Kapitan',
            'contact_no' => '09123456789',
            'purok_assigned' => null,
        ]);

        \App\Models\BrgyOfficial::create([
            'name' => 'Maria Santos',
            'position' => 'Treasurer',
            'contact_no' => '09123456790',
            'purok_assigned' => null,
        ]);

        \App\Models\BrgyOfficial::create([
            'name' => 'Pedro Reyes',
            'position' => 'Secretary',
            'contact_no' => '09123456791',
            'purok_assigned' => null,
        ]);

        // Create 7 Kagawads
        for ($i = 1; $i <= 7; $i++) {
            \App\Models\BrgyOfficial::create([
                'name' => 'Kagawad ' . $i,
                'position' => 'Kagawad',
                'contact_no' => '0912345679' . $i,
                'purok_assigned' => $i,
            ]);
        }

        // Create additional test users
        User::factory(5)->create();
    }
}
