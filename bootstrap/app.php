<?php

if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL'])) {
    $_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';
    if (!is_dir('/tmp/views')) {
        mkdir('/tmp/views', 0755, true);
    }
}

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
