<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'Moderator',
            'email' => 'moderator@moderator.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('moderator');
    }

}
