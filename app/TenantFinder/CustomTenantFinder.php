<?php
namespace App\TenantFinder;
use Illuminate\Http\Request;
use Spatie\Multitenancy\Contracts\IsTenant;
use Spatie\Multitenancy\TenantFinder\TenantFinder;


class CustomTenantFinder extends TenantFinder
{
    public function findForRequest(Request $request): ?IsTenant
    {
        $host = $request->getHost();
        $parts = explode('.', $host);
        if (count($parts) < 3) {
            return null; // Not a valid tenant subdomain
        }   
        $tenantDomain = implode('.', array_slice($parts, 0, -2)); // Get the subdomain part
        $tenantDomain = strtolower($tenantDomain); // Normalize to lowercase
        return app(IsTenant::class)::whereDomain($tenantDomain)->first();
    }
}