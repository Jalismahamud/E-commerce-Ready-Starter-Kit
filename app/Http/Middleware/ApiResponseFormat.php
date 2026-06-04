<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseFormat
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response->getStatusCode() === 401) {
            return response()->json([
                'status'  => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        if ($response->getStatusCode() === 403) {
            return response()->json([
                'status'  => false,
                'message' => 'Forbidden',
            ], 403);
        }

        if ($response->getStatusCode() === 404) {
            return response()->json([
                'status'  => false,
                'message' => 'Not found',
            ], 404);
        }

        return $response;
    }
}
