<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use Faker\Factory as Faker;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 3; $i++) {
            Company::create([
                'title' => $faker->company,
                'info' => $faker->catchPhrase,
                'address' => $faker->address
            ]);
        }
    }
}
