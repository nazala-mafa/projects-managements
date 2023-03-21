<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => password_hash('1234', PASSWORD_BCRYPT),
            'role' => 'admin'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'user1',
            'email' => 'user1@example.com',
            'password' => password_hash('1234', PASSWORD_BCRYPT),
            'role' => 'user'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'user2',
            'email' => 'user2@example.com',
            'password' => password_hash('1234', PASSWORD_BCRYPT),
            'role' => 'user'
        ]);

        $this->call(ProjectSeeder::class);
        $this->call(TaskSeeder::class);
    }
}