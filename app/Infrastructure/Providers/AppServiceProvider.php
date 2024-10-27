<?php

namespace App\Infrastructure\Providers;

use App\Infrastructure\Tokenizer\PersonalAccessTokenMongo;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $loader = AliasLoader::getInstance();
        $loader->alias(\Laravel\Sanctum\PersonalAccessToken::class, PersonalAccessTokenMongo::class);
    }
}
