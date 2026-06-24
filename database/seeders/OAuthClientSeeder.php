<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OAuthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\OAuthClient::updateOrCreate(
            ['id' => '019ca721-0712-7001-a8a3-221b1dbba00f'],
            [
                'name' => 'Frontend SPA Web',
                'client_id' => 'S1xravlqOjXCXnUa85F7nWdqpzc4XvAuCmAn2QQe',
                'secret' => 'zrEpbv6LjTEwIEEU78t6i16AOfzaQWkFDoVbxxBs',
                'provider' => null,
                'redirect' => env('FRONTEND_REDIRECT_URI', env('FRONTEND_URL', 'http://localhost:3000') . '/api/auth/callback/laravel-passport'),
                'personal_access_client' => false,
                'password_client' => false,
                'revoked' => false,
            ]
        );

        \App\Models\OAuthClient::updateOrCreate(
            ['id' => '019ca721-0712-7001-a8a3-221b1dbba010'],
            [
                'name' => 'Backend API Gateway',
                'client_id' => 'client_8KCbozt4Ff6BgocEeftboEHVa54IAeuA',
                'secret' => 'client_secret_jNwfwHZ9FwUM6nVlohFuzrtJebC2ggaI',
                'provider' => null,
                'redirect' => env('BACKEND_REDIRECT_URI', 'http://localhost:8002/api/v1/user/auth/sso/callback'),
                'personal_access_client' => false,
                'password_client' => false,
                'revoked' => false,
            ]
        );
    }
}
