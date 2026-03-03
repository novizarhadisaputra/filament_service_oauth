<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateClient
{
    use ApiResponse;

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $clientId = $request->header('X-Client-Id');
        $clientSecret = $request->header('X-Client-Secret');

        if (! $clientId || ! $clientSecret) {
            return $this->errorResponse('Missing internal credentials', 401);
        }

        $client = DB::table('oauth_clients')
            ->where('id', $clientId)
            ->first();

        if (! $client || ! password_verify($clientSecret, $client->client_secret)) {
            return $this->errorResponse('Invalid internal credentials', 401);
        }

        return $next($request);
    }
}
