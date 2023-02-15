<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@shayna.com',
                'password' => bcrypt('secret'),
                'role' => User::ROLE_ADMIN
            ],
            [
                'name' => 'User',
                'email' => 'user@shayna.com',
                'password' => bcrypt('secret'),
                'role' => User::ROLE_USER
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
