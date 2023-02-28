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
                'role' => User::ROLE_ADMIN,
                'phone_number' => '03787598038',
                'address' => 'Gg. Tambun No. 210'
            ],
            [
                'name' => 'User',
                'email' => 'user@shayna.com',
                'password' => bcrypt('secret'),
                'role' => User::ROLE_USER,
                'phone_number' => '095314066907',
                'address' => 'Gg. Basoka Raya No. 848'
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
