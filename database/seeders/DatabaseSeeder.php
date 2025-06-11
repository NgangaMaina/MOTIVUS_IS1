<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles first as they are required for users
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            VehicleSeeder::class,
        ]);

        // User::factory(10)->create();

        // Note: Uncomment and modify the following after updating UserFactory
        // to include role_id field
        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role_id' => 1, // Assuming renter role has ID 1
        ]);
        */
    }
}
