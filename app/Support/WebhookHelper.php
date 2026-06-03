<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use App\Models\OAuthClient;

class WebhookHelper
{
    /**
     * Notify all backend systems to invalidate/clear their permission cache.
     */
    public static function notifyBackendCacheInvalidation(): void
    {
        // 1. Get all non-revoked clients
        $clients = OAuthClient::where('revoked', false)->get();

        foreach ($clients as $client) {
            // 2. Retrieve and decode redirect URIs
            $redirectUris = $client->redirect_uris;
            if (empty($redirectUris)) {
                continue;
            }

            // Ensure redirect_uris is an array
            if (is_string($redirectUris)) {
                $redirectUris = json_decode($redirectUris, true) ?: [$redirectUris];
            }

            foreach ($redirectUris as $uri) {
                // We target http/https endpoints
                if (!str_starts_with($uri, 'http')) {
                    continue;
                }

                // Skip frontend Next.js applications since they don't have Spatie cache to clear
                if (str_contains($uri, 'localhost:3000') || str_contains($uri, '127.0.0.1:3000')) {
                    continue;
                }

                try {
                    $urlParts = parse_url($uri);
                    $scheme = $urlParts['scheme'] ?? 'http';
                    $host = $urlParts['host'] ?? 'localhost';
                    $port = isset($urlParts['port']) ? ':' . $urlParts['port'] : '';
                    
                    // Base URL of the client service
                    $baseUrl = "{$scheme}://{$host}{$port}";

                    // The cache invalidation webhook endpoint
                    $webhookUrl = "{$baseUrl}/api/v1/webhook/permissions/clear-cache";

                    // Decrypt client secret
                    $secret = Crypt::decryptString($client->encrypted_secret);

                    // Send asynchronous/short-timeout POST request
                    // We log the outcome. We use a short timeout of 2 seconds so it doesn't block.
                    $response = Http::withHeaders([
                        'X-Client-Id' => $client->client_id,
                        'X-Client-Secret' => $secret,
                        'Accept' => 'application/json',
                    ])->timeout(2)->post($webhookUrl);

                    if ($response->successful()) {
                        Log::info("Successfully sent permission cache invalidation webhook to client {$client->name} at {$webhookUrl}");
                    } else {
                        Log::warning("Failed to clear permission cache for client {$client->name} at {$webhookUrl}. Status: {$response->status()}", [
                            'response' => $response->body()
                        ]);
                    }
                } catch (\Exception $e) {
                    // Log but do not interrupt the main request
                    Log::warning("Failed to send cache invalidation webhook to client: {$client->name}. Error: " . $e->getMessage());
                }
            }
        }
    }
}
