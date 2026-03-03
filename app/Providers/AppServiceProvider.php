<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            \Laravel\Passport\ClientRepository::class,
            \App\Repositories\CustomClientRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Spatie Permission Team support is enabled in config/permission.php
        // The team ID should be set dynamically based on the system being accessed.

        Passport::tokensCan([
            'view-basic-profile' => 'View basic profile information (Name, Email).',
            'read-medical-records' => 'Read medical records and history.',
            'write-appointments' => 'Create and manage medical appointments.',
        ]);

        Passport::useClientModel(\App\Models\OAuthClient::class);

        Passport::authorizationView(function () {
            return response('Authorization View Not Configured', 500);
        });
    }
}
