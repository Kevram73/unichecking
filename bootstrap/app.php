<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


use App\Http\Middleware\UserLoggedIn;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
		
		
		api: __DIR__.'/../routes/api.php',
		apiPrefix: 'api',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
		$middleware->convertEmptyStringsToNull(except: [
        fn ($request) => $request->path() ,
		]);
		$middleware->web(append:[
		UserLoggedIn::class
		]/*,
		except: [
        fn ($request) => route('user.pg_login') ,
		]
		*/);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
