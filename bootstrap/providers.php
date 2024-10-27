<?php

use App\Infrastructure\Providers\AppServiceProvider;
use App\Infrastructure\Providers\HashServiceProvider;
use App\Infrastructure\Providers\RepositoryServiceProvider;
use App\Services\Hash\HashingServiceInterface;

return [
    AppServiceProvider::class,
    RepositoryServiceProvider::class,
    HashServiceProvider::class,
];
