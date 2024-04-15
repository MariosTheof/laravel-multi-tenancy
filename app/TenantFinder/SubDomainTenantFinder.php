<?php

namespace App\TenantFinder;

use App\Models\CustomTenant;
use Illuminate\Http\Request;
use Spatie\Multitenancy\Models\Concerns\UsesTenantModel;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\TenantFinder\DomainTenantFinder;

class SubDomainTenantFinder extends DomainTenantFinder
{
    use UsesTenantModel;

    public function findForRequest(Request $request): ?Tenant
    {
        $host = $request->getHost();

        $host = explode('.', $host);
        if (!$this->getTenantModel()::whereDomain($host[0])->exists()) {
            abort(404, 'Tenant not found');
        }


        return $this->getTenantModel()::whereDomain($host[0])->first();
    }
}
