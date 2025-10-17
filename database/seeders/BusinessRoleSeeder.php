<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class BusinessRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions to avoid stale guard mismatches
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create business permissions (explicit guard_name to 'web')
        $permissions = [
            'access business dashboard',
            'manage business profile',
            'view business analytics',
            'manage business menu',
            'view business orders',
            'manage business settings',
            'view business reports',
            'manage business employees'
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);
        }

        // Create roles (explicit guard_name to 'web')
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);
        $businessRole = Role::firstOrCreate([
            'name' => 'business',
            'guard_name' => 'web',
        ]);
        $clientRole = Role::firstOrCreate([
            'name' => 'client',
            'guard_name' => 'web',
        ]);

        // Admin gets all permissions plus admin-specific ones
        $adminPermissions = array_merge($permissions, [
            'manage all users',
            'manage all businesses',
            'manage all clients',
            'access admin panel',
            'view system analytics',
            'manage system settings'
        ]);

        // Create admin permissions
        foreach (['manage all users', 'manage all businesses', 'manage all clients', 'access admin panel', 'view system analytics', 'manage system settings'] as $permissionName) {
            Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);
        }

        $adminRole->syncPermissions($adminPermissions);
        $businessRole->syncPermissions($permissions);

        // Create sample admin user
        $this->createSampleAdminUser($adminRole);

        // Create sample business users
        $this->createSampleBusinessUsers($businessRole);

        $this->command->info('Roles and permissions created successfully!');
        $this->command->info('Sample admin user created:');
        $this->command->info('Email: admin@example.com | Password: password');
        $this->command->info('Sample business users created:');
        $this->command->info('Email: business1@example.com | Password: password');
        $this->command->info('Email: business2@example.com | Password: password');
        $this->command->info('Email: restaurant@example.com | Password: password');
    }

    private function createSampleAdminUser($adminRole)
    {
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'System Administrator',
                'phone' => '1234567890',
                'personal_code' => 'ADMIN001',
                'position' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );

        if (!$adminUser->hasRole('admin')) {
            $adminUser->assignRole($adminRole);
        }
    }

    /**
     * Create sample business users
     */
    private function createSampleBusinessUsers(Role $businessRole): void
    {
        $businessUsers = [
            [
                'name' => 'کسب‌وکار نمونه یک',
                'email' => 'business1@example.com',
                'phone' => '09120000001',
                'personal_code' => 'PC0001',
                'position' => 'manager',
                'business_name' => 'رستوران شایان',
                'business_type' => 'restaurant',
                'business_phone' => '021-12345678',
                'business_address' => 'تهران، خیابان ولیعصر، پلاک ۱۲۳',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'کسب‌وکار نمونه دو',
                'email' => 'business2@example.com',
                'phone' => '09120000002',
                'personal_code' => 'PC0002',
                'position' => 'manager',
                'business_name' => 'کافی‌شاپ آرامش',
                'business_type' => 'cafe',
                'business_phone' => '021-87654321',
                'business_address' => 'تهران، میدان ونک، خیابان ملاصدرا',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'رستوران بهشت',
                'email' => 'restaurant@example.com',
                'phone' => '09120000003',
                'personal_code' => 'PC0003',
                'position' => 'manager',
                'business_name' => 'رستوران بهشت',
                'business_type' => 'restaurant',
                'business_phone' => '021-11112222',
                'business_address' => 'تهران، شهرک غرب، خیابان ایران زمین',
                'password' => Hash::make('password'),
            ]
        ];

        foreach ($businessUsers as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );

            // Assign business role to user
            if (!$user->hasRole('business')) {
                $user->assignRole($businessRole);
            }
        }
    }
}
