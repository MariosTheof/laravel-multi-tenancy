<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Spatie\Multitenancy\Models\Tenant;

class CustomTenant extends Tenant
{
    use UsesLandlordConnection;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'name', 'domain', 'database'];
    protected $table = 'tenants';

    protected static function booted()
    {
        static::creating(function (CustomTenant $model) {
            $model->createDatabase();
        });
    }

    public function createDatabase()
    {
        if (empty($this->id)) {
            $this->id = (string) Str::ulid()->toBase32();
        }

        try {
            $landlordConnection = config('multitenancy.landlord_database_connection_name');
            DB::connection($landlordConnection)->statement("CREATE DATABASE IF NOT EXISTS `$this->database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        } catch (Exception $e) {
            throw new Exception("Failed to create tenant database: {$e->getMessage()}");
        }
    }

}
