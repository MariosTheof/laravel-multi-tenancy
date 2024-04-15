<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();
        $faker = Faker::create();

        $admin = User::create(['name' => 'Admin ',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');

        foreach ($companies as $company)
        {
            $user = User::create(['name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('password'),
                ]);
                $user->assignRole('moderator');
            $user->companies()->attach($company->id);
        }
    }

}
