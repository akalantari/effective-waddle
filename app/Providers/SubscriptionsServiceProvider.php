<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \Illuminate\Contracts\Support\DeferrableProvider;

use App\Services\AppleSubscriptionService;
use App\Services\GoogleSubscriptionService;

class SubscriptionsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GoogleSubscriptionService::class, function() {
            return new GoogleSubscriptionService();
        });

        $this->app->bind(AppleSubscriptionService::class, function() {
            return new AppleSubscriptionService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [AppleSubscriptionService::class, GoogleSubscriptionService::class];
    }
}
