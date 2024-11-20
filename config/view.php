<?php

return [
    'paths' => [
        __DIR__ . '/../app/Infrastructure/PDF/templates',
    ],

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views')),
    ),
];
