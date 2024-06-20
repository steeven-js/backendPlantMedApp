<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApi
{
    public $API_TOKEN = "aH3KCew1YsWhWqW0tqNU3ndzHb3RdblI";

    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if ($token === $this->API_TOKEN) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
