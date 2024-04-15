<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $companies = Company::all();

        foreach ($companies as $company) {
            for ($i = 0; $i < 2; $i++) {
                $user = User::create([
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'password' => bcrypt('password'),  // Default password for all users
                ]);

                // Attach the user to the current company
                $user->companies()->attach($company->id);
            }
        }
    }

}
