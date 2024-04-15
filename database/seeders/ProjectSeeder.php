<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Company;
use App\Models\User;
use Faker\Factory as Faker;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $companies = Company::all();
        $users = User::all();

        // Generate multiple projects
        foreach ($companies as $company) {
            for ($i = 0; $i < 3; $i++) {  // 3 projects per company
                Project::create([
                    'name' => $faker->company,
                    'description' => $faker->paragraph,
                    'creator_id' => $users->random()->id,
                    'company_id' => $company->id,
                ]);
            }
        }
    }
}
