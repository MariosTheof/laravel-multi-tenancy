<?php

namespace Database\Seeders;

use App\Models\CustomTenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CustomTenant::create([
            'id'  =>  '1',
            'name' => 'Tenant1',
            'domain' => 'tenant1',
            'database' => 'tenant1_db',
        ]);

        CustomTenant::create([
            'id'  =>  '2',
            'name' => 'Tenant2',
            'domain' => 'tenant2',
            'database' => 'tenant2_db',
        ]);
    }
}
