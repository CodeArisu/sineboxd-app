<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $roles = [
            0 => 'admin',
            1 => 'user'
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert([
                'role' => $role,
                'created_at' => now()
            ]);
        }
    }
}
