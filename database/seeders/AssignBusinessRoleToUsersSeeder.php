<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AssignBusinessRoleToUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the business role
        $businessRole = Role::where('name', 'business')->first();

        if (!$businessRole) {
            $this->command->error('Business role not found! Please run BusinessRoleSeeder first.');
            return;
        }

        // Assign business role to users who have business-related data
        $businessUsers = User::whereNotNull('business_name')
                            ->orWhereNotNull('business_type')
                            ->get();

        foreach ($businessUsers as $user) {
            if (!$user->hasRole('business')) {
                $user->assignRole($businessRole);
                $this->command->info("Assigned business role to: {$user->email}");
            }
        }

        $this->command->info("Business role assigned to {$businessUsers->count()} users.");
    }
}
