<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributes = [
            [
                'name' => 'Admin',
                'email' => 'adminadmin@sineboxd.com',
                'password' => bcrypt('password'),
                'role_id' => 1,
            ],
            [
                'name' => 'User',
                'email' => 'TestUser@sineboxd,com',
                'password' => bcrypt('password'),
                'role_id' => 2,
            ],
        ];

        foreach ($attributes as $attribute) {
            User::factory()->create($attribute);
        }
    }
}
