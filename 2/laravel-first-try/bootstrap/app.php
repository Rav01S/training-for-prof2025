<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo('/admin/login');

        $middleware->removeFromGroup('api', [
            \Illuminate\Session\SessionServiceProvider::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class
        ]);

        $middleware->prependToGroup('api', \App\Http\Middleware\ForceJsonResponse::class);

        $middleware->alias([
            'isAdmin' => \App\Http\Middleware\isAdmin::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $error, Request $request) {
            if (isApiRoute($request)) {
                return response()->json([
                    'message' => 'Not Found'
                ], 404);
            } else {
                return null;
            }
        });

        $exceptions->render(function (UnauthorizedException $error, Request $request) {
            if (isApiRoute($request)) {
                return response()->json([
                    'message' => 'Forbidden for you'
                ], 403);
            } else {
                return null;
            }
        });

        $exceptions->render(function (AuthenticationException $error, Request $request) {
            if (isApiRoute($request)) {
                return response()->json([
                    'message' => 'Forbidden for you'
                ], 403);
            } else {
                return null;
            }
        });

        $exceptions->render(function (ValidationException $error, Request $request) {
            if (isApiRoute($request)) {
                return response()->json([
                    'message' => 'Invalid fields',
                    'errors' => $error->errors()
                ], 422);
            } else {
                return null;
            }
        });
    })->create();

function isApiRoute(Request $request): bool
{
    return str_starts_with($request->path(), 'api');
}
