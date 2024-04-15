<?php

use App\Models\CustomTenant;
use Illuminate\Support\Facades\DB;


//it('ensures that a tenant database is created on tenant creation', function () {
//    $tenant = CustomTenant::factory()->create();
//
//    $databaseName = $tenant->database;
//    $result = DB::connection('landlord_test')->select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", [$databaseName]);
//
//    expect($result)->not->toBeEmpty();
//});
