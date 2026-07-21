<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin 01',
            'email' => 'admin01@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'Admin 02',
            'email' => 'admin02@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $this->call([
            CategorySeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
