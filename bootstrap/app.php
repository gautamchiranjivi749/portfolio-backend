<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
   ->withExceptions(function (Exceptions $exceptions) {

    // Model not found
    $exceptions->render(function (ModelNotFoundException $e, $request) {

        if ($request->is('api/*')) {
            $model = class_basename($e->getModel());

            return response()->json([
                'success' => false,
                'message' => "{$model} not found.",
            ], 404);
        }

    });

    // Route not found
    $exceptions->render(function (NotFoundHttpException $e, $request) {

        if ($request->is('api/*')) {

            return response()->json([
                'success' => false,
                'message' => 'Resource not found.',
            ], 404);

        }

    });

    // Unauthenticated
    $exceptions->render(function (AuthenticationException $e, $request) {

        if ($request->is('api/*')) {

            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], Response::HTTP_UNAUTHORIZED);

        }

    });
})
->create();