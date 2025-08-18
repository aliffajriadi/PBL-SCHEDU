<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\MiddlewareAdmin;
use \App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\MiddlewareInstance;
use App\Http\Middleware\ParticipantMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'web' => ParticipantMiddleware::class,
            'admin' => MiddlewareAdmin::class, 
            'staff' => MiddlewareInstance::class, 
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
