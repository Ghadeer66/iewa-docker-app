<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class BusinessRoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define and create permissions
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

        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $businessRole = Role::firstOrCreate(['name' => 'business', 'guard_name' => 'web']);
        $clientRole = Role::firstOrCreate(['name' => 'client', 'guard_name' => 'web']);

        // Add extra admin permissions
        $adminPermissions = array_merge($permissions, [
            'manage all users',
            'manage all businesses',
            'manage all clients',
            'access admin panel',
            'view system analytics',
            'manage system settings'
        ]);

        foreach ([
            'manage all users', 'manage all businesses', 'manage all clients',
            'access admin panel', 'view system analytics', 'manage system settings'
        ] as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        $adminRole->syncPermissions($adminPermissions);
        $businessRole->syncPermissions($permissions);

        // Create users
        $this->createSampleAdminUser($adminRole);
        $businessUsers = $this->createSampleBusinessUsers($businessRole);
        $this->createSampleClientUsers($clientRole, $businessUsers);

        $this->command->info('Roles, permissions, and users created successfully.');
    }

    private function createSampleAdminUser($adminRole)
    {
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'محسن مهدوی',
                'phone' => '1234567890',
                'personal_code' => 'ADMIN001',
                'position' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );

        $adminUser->assignRole($adminRole);
    }

    private function createSampleBusinessUsers(Role $businessRole)
    {
        $businessUsersData = [
            [
                'name' => 'رضا کریمی',
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
                'name' => 'مینا احمدی',
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
                'name' => 'ناصر موسوی',
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

        $createdBusinesses = [];

        foreach ($businessUsersData as $data) {
            $user = User::firstOrCreate(['email' => $data['email']], $data);
            $user->assignRole($businessRole);
            $createdBusinesses[] = $user;
        }

        return $createdBusinesses;
    }

    private function createSampleClientUsers(Role $clientRole, array $businessUsers)
    {
        $clientUsersData = [
            [
                'name' => 'سارا محمدی',
                'email' => 'client@example.com',
                'phone' => '09130000001',
                'personal_code' => 'PD0001',
                'position' => 'client',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'احمد رضایی',
                'email' => 'client2@example.com',
                'phone' => '09130000002',
                'personal_code' => 'PD0002',
                'position' => 'client',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'لیلا موسوی',
                'email' => 'client3@example.com',
                'phone' => '09130000003',
                'personal_code' => 'PD0003',
                'position' => 'client',
                'password' => Hash::make('password'),
            ],
        ];

        // Assign each client to a business via belongs_to
        foreach ($clientUsersData as $index => $data) {
            $belongsTo = $businessUsers[$index % count($businessUsers)]->id;

            $user = User::firstOrCreate(
                ['email' => $data['email']],
                array_merge($data, ['belongs_to' => $belongsTo])
            );

            $user->assignRole($clientRole);
        }
    }
}
