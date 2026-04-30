<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
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

        // Assign admin role to first user if exists
        $firstUser = User::first();
        if ($firstUser && !$firstUser->hasRole('admin')) {
            $firstUser->assignRole('admin');
            $this->command->info("Assigned admin role to user: {$firstUser->email}");
        }

        $this->command->info('Roles seeded successfully!');
        $this->command->info('- Super Admin: Full control over all features and can input all KNMP');
        $this->command->info('- Admin: Can monitor and view all data (read-only)');
        $this->command->info('- Enumerator: Can fill surveys and edit respondent data');
    }
}
