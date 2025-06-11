<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'renter',
                'description' => 'Users who can rent vehicles from the platform',
            ],
            [
                'name' => 'owner',
                'description' => 'Users who own vehicles and list them for rental',
            ],
            [
                'name' => 'driver',
                'description' => 'Users who deliver vehicles to renters',
            ],
            [
                'name' => 'admin',
                'description' => 'System administrators with full access',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                ['description' => $role['description']]
            );
        }
    }
}
