<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            SiteSettingSeeder::class,
        ]);

        // Create a default admin for testing
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'user_type' => 'admin',
            'password' => bcrypt('password'),
            'phone' => '987-654-3210',
        ]);
        // Create a default regular user for testing
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'user_type' => 'user',
            'password' => bcrypt('password'),
            'phone' => '123-456-7890',
        ]);
    }
}
