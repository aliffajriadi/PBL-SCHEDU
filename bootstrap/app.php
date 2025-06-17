<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\MiddlewareAdmin;
use App\Http\Middleware\MiddlewareIntance;
use App\Http\Middleware\ParticipantMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use \App\Http\Middleware\AdminMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'web' => ParticipantMiddleware::class,
            'admin' => MiddlewareAdmin::class, 
            'staff' => MiddlewareIntance::class, 
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
