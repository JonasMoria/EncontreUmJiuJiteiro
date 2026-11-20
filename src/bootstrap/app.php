<?php

use App\Http\Enums\HttpStatusCode;
use App\Http\Exceptions\FormRequestException;
use App\Http\Traits\HttpResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->render(function (
            FormRequestException $exception,
            Request $request,
        ) {
            return HttpResponse::makeResponse(
                $exception->getMessage(),
                HttpStatusCode::from($exception->getCode())
            );
        });

        $exceptions->render(function (
            RouteNotFoundException $exception,
            Request $request
        ) {
            return HttpResponse::makeResponse(
                'USER.UNAUTHENTICATED',
                HttpStatusCode::UNAUTHORIZED
            );
        });
    })->create();
