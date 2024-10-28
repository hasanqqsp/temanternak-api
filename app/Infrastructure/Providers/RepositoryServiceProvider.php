<?php

namespace App\Infrastructure\Providers;

use App\Domain\Invitations\InvitationRepository;
use App\Domain\UserFiles\UserFileRepository;
use App\Domain\Users\UserRepository;
use App\Infrastructure\Repository\Eloquent\InvitationRepositoryEloquent;
use App\Infrastructure\Repository\Eloquent\UserFileRepositoryEloquent;
use App\Infrastructure\Repository\Eloquent\UserRepositoryEloquent;
use App\Infrastructure\Repository\Storage\S3Compatible\S3FileRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind interfaces to implementations here
        $this->app->singleton(UserRepository::class, UserRepositoryEloquent::class);
        $this->app->singleton(UserFileRepository::class, UserFileRepositoryEloquent::class);
        $this->app->singleton(InvitationRepository::class, InvitationRepositoryEloquent::class);
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
