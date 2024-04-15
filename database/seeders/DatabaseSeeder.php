<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Multitenancy\Models\Tenant;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Tenant::checkCurrent()
            ? $this->runTenantSpecificSeeders()
            : $this->runLandlordSpecificSeeders();

    }

    private function runTenantSpecificSeeders()
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(ProjectSeeder::class);
    }

    private function runLandlordSpecificSeeders()
    {
//        $this->call(TenantsSeeder::class);
    }
}
