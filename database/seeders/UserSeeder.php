<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure roles exist first
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'super_admin'],
            [
                'display_name' => 'Super Admin',
                'description' => 'Super Administrator dengan kontrol penuh ke semua fitur dan dapat menginput semua KNMP'
            ]
        );

        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            [
                'display_name' => 'Admin',
                'description' => 'Administrator yang dapat memantau dan melihat semua data (read-only)'
            ]
        );

        $enumeratorRole = Role::firstOrCreate(
            ['name' => 'enumerator'],
            [
                'display_name' => 'Enumerator',
                'description' => 'Dapat mengisi survey dan mengedit data responden'
            ]
        );

        // Create Super Admin user
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@kkp.go.id'],
            [
                'name' => 'Super Admin',
                'username' => 'SuperAdmin',
                'password' => Hash::make('MonevKKP65'),
            ]
        );
        if (!$superAdmin->hasRole('super_admin')) {
            $superAdmin->assignRole('super_admin');
        }
        $this->command->info("Created Super Admin user: SuperAdmin (MonevKKP65)");

        // Create Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@kkp.go.id'],
            [
                'name' => 'Admin',
                'username' => 'Admin',
                'password' => Hash::make('MonevKKP65'),
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
        $this->command->info("Created Admin user: Admin (MonevKKP65)");

        // Create Enumerator 1
        $enum1 = User::firstOrCreate(
            ['email' => 'enumerator1@kkp.go.id'],
            [
                'name' => 'Enumerator 1',
                'username' => 'Enumerator1',
                'password' => Hash::make('EnumPertama'),
            ]
        );
        if (!$enum1->hasRole('enumerator')) {
            $enum1->assignRole('enumerator');
        }
        $this->command->info("Created Enumerator user: Enumerator1 (EnumPertama)");

        // Create Enumerator 2
        $enum2 = User::firstOrCreate(
            ['email' => 'enumerator2@kkp.go.id'],
            [
                'name' => 'Enumerator 2',
                'username' => 'Enumerator2',
                'password' => Hash::make('EnumKedua'),
            ]
        );
        if (!$enum2->hasRole('enumerator')) {
            $enum2->assignRole('enumerator');
        }
        $this->command->info("Created Enumerator user: Enumerator2 (EnumKedua)");

        // Create Enumerator 3
        $enum3 = User::firstOrCreate(
            ['email' => 'enumerator3@kkp.go.id'],
            [
                'name' => 'Enumerator 3',
                'username' => 'Enumerator3',
                'password' => Hash::make('EnumKetiga'),
            ]
        );
        if (!$enum3->hasRole('enumerator')) {
            $enum3->assignRole('enumerator');
        }
        $this->command->info("Created Enumerator user: Enumerator3 (EnumKetiga)");

        $this->command->info('');
        $this->command->info('Users seeded successfully!');
        $this->command->info('=============================================');
        $this->command->info('| Username     | Password     | Role        |');
        $this->command->info('|--------------|--------------|-------------|');
        $this->command->info('| SuperAdmin   | MonevKKP65   | Super Admin |');
        $this->command->info('| Admin        | MonevKKP65   | Admin       |');
        $this->command->info('| Enumerator1  | EnumPertama  | Enumerator  |');
        $this->command->info('| Enumerator2  | EnumKedua    | Enumerator  |');
        $this->command->info('| Enumerator3  | EnumKetiga   | Enumerator  |');
        $this->command->info('=============================================');
    }
}
