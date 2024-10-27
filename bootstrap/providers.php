<?php

use App\Infrastructure\Providers\AppServiceProvider;
use App\Infrastructure\Providers\HashServiceProvider;
use App\Infrastructure\Providers\RepositoryServiceProvider;

return [
    AppServiceProvider::class,
    RepositoryServiceProvider::class,
    HashServiceProvider::class,
];
