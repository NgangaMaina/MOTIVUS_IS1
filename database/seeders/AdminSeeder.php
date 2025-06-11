<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin role
        $adminRole = Role::where('name', 'admin')->first();

        if (!$adminRole) {
            $this->command->error('Admin role not found. Please run RoleSeeder first.');
            return;
        }

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@motivus.com'],
            [
                'name' => 'MOTIVUS Administrator',
                'email' => 'admin@motivus.com',
                'phone' => '+254700000001',
                'role_id' => $adminRole->id,
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@motivus.com');
        $this->command->info('Password: admin123');
    }
}
