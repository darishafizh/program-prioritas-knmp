<?php

namespace Database\Seeders;

use App\Models\Knmp;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VillageUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates one user for each KNMP (village) location.
     */
    public function run(): void
    {
        $knmps = Knmp::all();
        $enumeratorRole = Role::where('name', 'enumerator')->first();

        foreach ($knmps as $knmp) {
            // Get village name from relation or use knmp nama
            $villageName = $knmp->village ? $knmp->village->name : $knmp->nama;

            // Generate username: lowercase, no spaces, no punctuation
            $username = $this->generateUsername($villageName);

            // Check if user already exists for this KNMP
            $existingUser = User::where('knmp_id', $knmp->id)->first();
            if ($existingUser) {
                $this->command->info("User for KNMP '{$knmp->nama}' already exists. Skipping.");
                continue;
            }

            // Also check if username already exists
            $usernameExists = User::where('username', $username)->first();
            if ($usernameExists) {
                // Append knmp id to make it unique
                $username = $username . $knmp->id;
            }

            $user = User::create([
                'name' => $villageName,
                'username' => $username,
                'email' => $username . '@knmp.local',
                'password' => Hash::make('P@ssw0rd'),
                'knmp_id' => $knmp->id,
            ]);

            // Assign enumerator role
            if ($enumeratorRole) {
                $user->roles()->attach($enumeratorRole->id);
            }

            $this->command->info("Created user: {$username} for KNMP: {$knmp->nama}");
        }

        $this->command->info('Village user seeding completed!');
    }

    /**
     * Generate username from village name.
     * Lowercase, no spaces, no punctuation.
     */
    private function generateUsername(string $name): string
    {
        // Convert to lowercase
        $username = strtolower($name);

        // Remove all characters except letters and numbers
        $username = preg_replace('/[^a-z0-9]/', '', $username);

        return $username;
    }
}
