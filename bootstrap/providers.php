<?php

use App\Infrastructure\Providers\AppServiceProvider;
use App\Infrastructure\Providers\HashServiceProvider;
use App\Infrastructure\Providers\RepositoryServiceProvider;
use HPWebdeveloper\LaravelPayPocket\LaravelPayPocketServiceProvider;

return [
    AppServiceProvider::class,
    RepositoryServiceProvider::class,
    HashServiceProvider::class,
    LaravelPayPocketServiceProvider::class,
    \Barryvdh\DomPDF\ServiceProvider::class,
    \Torann\GeoIP\GeoIPServiceProvider::class
];
