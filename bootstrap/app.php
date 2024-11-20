<?php

use App\Commons\Exceptions\ClientException;
use App\Commons\Exceptions\UserInputException;
use App\Infrastructure\Middleware\ForceJsonResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../app/Interfaces/Http/Routes/api.php',
        commands: __DIR__ . '/../app/Interfaces/Http/Routes/console.php',
        apiPrefix: ""
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            ForceJsonResponse::class
        ]);
        $middleware->alias([
            'abilities' => CheckAbilities::class,
            'ability' => CheckForAnyAbility::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // handling all client exceptions here
        $exceptions->render(function (UserInputException $exception) {
            return response()->json([
                "status" => "fail",
                "message" => $exception->getMessage(),
                "errors" => $exception->getErrors(),
            ]);
        }, 400);
        $exceptions->render(function (ClientException $exception) {
            return response()->json([
                "status" => "fail",
                "message" => $exception->getMessage(),

            ], 400);
        });
        $exceptions->render(function (ValidationException $exception) {
            return response()->json([
                "status" => "fail",
                "message" => $exception->getMessage(),
                "errors" => $exception->errors()
            ], 400);
        });
        $exceptions->render(function (AuthenticationException $exception) {
            return response()->json([
                "status" => "fail",
                "message" => $exception->getMessage(),
            ], 401);
        });
        $exceptions->render(function (AccessDeniedHttpException $exception) {
            return response()->json([
                "status" => "fail",
                "message" => "Unauthorized. Access Denied",
            ], 403);
        });
        $exceptions->render(function (NotFoundHttpException $exception) {
            return response()->json([
                "status" => "fail",
                "message" => "Resource not found",
            ], 404);
        });
        $exceptions->render(function (MethodNotAllowedHttpException $exception) {
            return response()->json([
                "status" => "fail",
                "message" => "Method not allowed",
            ], 404);
        });

        $exceptions->shouldRenderJsonWhen(
            fn() => true
        );
    })

    ->create();
