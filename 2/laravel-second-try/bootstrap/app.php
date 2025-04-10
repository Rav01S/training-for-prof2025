<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Session\SessionServiceProvider;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->removeFromGroup('api', [
            SessionServiceProvider::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class
        ]);

        $middleware->redirectGuestsTo('/admin/login');

        $middleware->prependToGroup('api', [\App\Http\Middleware\ForceJsonResponse::class]);

        $middleware->alias(['isAdmin', \App\Http\Middleware\IsAdmin::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $error, Request $request) {
            if (isApiRoute($request)) {
                return response()->json([
                    'message' => 'Not found'
                ], 404);
            }
            return null;
        });

        $exceptions->render(function (ValidationException $error, Request $request) {
            if (isApiRoute($request)) {
                return response()->json([
                    'message' => 'Invalid data',
                    'errors' => $error->errors()
                ], 422);
            }
            return null;
        });

        $exceptions->render(function (AuthenticationException $error, Request $request) {
            if (isApiRoute($request)) {
                return response()->json([
                    'message' => 'Forbidden for you'
                ], 403);
            }
            return null;
        });

        $exceptions->render(function (UnauthorizedException $error, Request $request) {
            if (isApiRoute($request)) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 403);
            }
            return null;
        });
    })->create();

function isApiRoute(Request $request): bool
{
    return str_starts_with($request->path(), 'api');
}
