<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class VerifyAdminUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:verify-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically verify email addresses for all admin users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Verifying admin user emails...');

        $adminUsers = User::whereHas('role', function ($query) {
            $query->where('name', 'admin');
        })->whereNull('email_verified_at')->get();

        if ($adminUsers->isEmpty()) {
            $this->info('No unverified admin users found.');
            return;
        }

        foreach ($adminUsers as $admin) {
            $admin->markEmailAsVerified();
            $this->info("✓ Verified: {$admin->email}");
        }

        $this->info("Successfully verified {$adminUsers->count()} admin user(s).");
    }
}
