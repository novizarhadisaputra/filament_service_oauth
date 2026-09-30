<?php

namespace App\Providers;

use App\Models\OAuthClient;
use App\Repositories\CustomClientRepository;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            ClientRepository::class,
            CustomClientRepository::class
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


        Passport::useClientModel(OAuthClient::class);

        Passport::authorizationView(function () {
            return response('Authorization View Not Configured', 500);
        });

        // Register Webhook notification trigger on Role/Permission changes (e.g. user-role assignments)
        \Illuminate\Support\Facades\Event::listen([
            \Spatie\Permission\Events\RoleAttached::class,
            \Spatie\Permission\Events\RoleDetached::class,
            \Spatie\Permission\Events\PermissionAttached::class,
            \Spatie\Permission\Events\PermissionDetached::class,
        ], function ($event = null) {
            // Role permission changes are handled by App\Observers\RoleObserver via touch()
            if ($event && isset($event->model) && $event->model instanceof \App\Models\Role) {
                return;
            }

            \Illuminate\Support\Facades\DB::afterCommit(function () {
                \App\Support\WebhookHelper::notifyBackendCacheInvalidation();
            });
        });

        // Role saved/deleted events are handled by App\Observers\RoleObserver

        \App\Models\Permission::deleted(function () {
            \Illuminate\Support\Facades\DB::afterCommit(function () {
                \App\Support\WebhookHelper::notifyBackendCacheInvalidation();
            });
        });

        // Register Filament Shield custom permissions & key composition
        \App\Support\ShieldCustomPermissionsLoader::register();
    }
}
