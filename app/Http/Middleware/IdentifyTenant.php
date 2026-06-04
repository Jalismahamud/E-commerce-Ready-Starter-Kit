<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $subdomain = explode('.', $host)[0];

        $tenant = Tenant::where('subdomain', $subdomain)->first();

        if (!$tenant) {
            return response()->json(['status' => false, 'message' => 'Tenant not found'], 404);
        }

        app()->instance('tenant', $tenant);
        app()->instance('tenant_id', $tenant->id);

        config(['database.connections.tenant.database' => $tenant->database]);

        return $next($request);
    }
}
