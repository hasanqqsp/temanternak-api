<?php

namespace App\Infrastructure\Providers;

use App\Infrastructure\Hasher\BcryptHasher;
use App\Services\Hash\HashingServiceInterface;

use Illuminate\Support\ServiceProvider;

class HashServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind interfaces to implementations here
        $this->app->bind(HashingServiceInterface::class, BcryptHasher::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
