<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create owner role
        $ownerRole = Role::where('name', 'owner')->first();
        $renterRole = Role::where('name', 'renter')->first();

        if (!$ownerRole || !$renterRole) {
            $this->command->error('Roles not found. Please run RoleSeeder first.');
            return;
        }

        // Create test owners
        $owners = [
            [
                'name' => 'John Kamau',
                'email' => 'john.kamau@example.com',
                'phone' => '+254700123456',
                'role_id' => $ownerRole->id,
            ],
            [
                'name' => 'Mary Wanjiku',
                'email' => 'mary.wanjiku@example.com',
                'phone' => '+254700234567',
                'role_id' => $ownerRole->id,
            ],
            [
                'name' => 'David Ochieng',
                'email' => 'david.ochieng@example.com',
                'phone' => '+254700345678',
                'role_id' => $ownerRole->id,
            ],
        ];

        foreach ($owners as $ownerData) {
            $owner = User::firstOrCreate(
                ['email' => $ownerData['email']],
                array_merge($ownerData, [
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ])
            );

            // Create vehicles for each owner
            $this->createVehiclesForOwner($owner);
        }

        // Create a test renter
        User::firstOrCreate(
            ['email' => 'renter@example.com'],
            [
                'name' => 'Test Renter',
                'email' => 'renter@example.com',
                'phone' => '+254700456789',
                'role_id' => $renterRole->id,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Vehicle test data created successfully!');
    }

    private function createVehiclesForOwner(User $owner): void
    {
        $vehicles = [
            [
                'make' => 'Toyota',
                'model' => 'Corolla',
                'year' => 2020,
                'location' => 'Westlands, Nairobi',
                'price_per_day' => 3500.00,
                'availability' => true,
                'image_url' => null,
            ],
            [
                'make' => 'Nissan',
                'model' => 'X-Trail',
                'year' => 2019,
                'location' => 'Karen, Nairobi',
                'price_per_day' => 5500.00,
                'availability' => true,
                'image_url' => null,
            ],
            [
                'make' => 'Honda',
                'model' => 'Civic',
                'year' => 2021,
                'location' => 'CBD, Nairobi',
                'price_per_day' => 4000.00,
                'availability' => true,
                'image_url' => null,
            ],
            [
                'make' => 'Mazda',
                'model' => 'CX-5',
                'year' => 2018,
                'location' => 'Kilimani, Nairobi',
                'price_per_day' => 4800.00,
                'availability' => true,
                'image_url' => null,
            ],
            [
                'make' => 'Subaru',
                'model' => 'Forester',
                'year' => 2020,
                'location' => 'Parklands, Nairobi',
                'price_per_day' => 5200.00,
                'availability' => true,
                'image_url' => null,
            ],
        ];

        // Create 1-2 vehicles per owner
        $vehicleCount = rand(1, 2);
        $selectedVehicles = array_slice($vehicles, 0, $vehicleCount);

        foreach ($selectedVehicles as $vehicleData) {
            Vehicle::create(array_merge($vehicleData, [
                'owner_id' => $owner->id,
            ]));
        }
    }
}
