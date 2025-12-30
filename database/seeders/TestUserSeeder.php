<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if user already exists to avoid duplicates
        if (!User::where('email', 'ujicoba@example.com')->exists()) {
            User::create([
                'name' => 'Uji Coba',
                'email' => 'ujicoba@example.com',
                'password' => 'password', // The 'hashed' cast in User model should handle hashing, but let's verify. 
                // Actually, to be safe and consistent with UserFactory which uses Hash::make despite the cast, let's use Hash::make OR just string if we trust the cast.
                // Given User.php has 'password' => 'hashed', passing a plain string will be hashed.
                // passing Hash::make('password') will be hashed AGAIN presumably? 
                // Let's look at Laravel docs. "The attribute will automatically be hashed when it is set on the model."
                // So plain string is correct.
            ]);
        }
    }
}
