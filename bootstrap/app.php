<?php

use App\Http\Middleware\AsprakMiddleware;
use App\Http\Middleware\LaboranMiddleware;
use App\Http\Middleware\DosenMiddleware;
use App\Http\Middleware\PraktikanMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'asprakMiddleware'     => AsprakMiddleware::class,
            'laboranMiddleware'    => LaboranMiddleware::class,
            'dosenMiddleware'    => DosenMiddleware::class,
            'praktikanMiddleware'=> PraktikanMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
