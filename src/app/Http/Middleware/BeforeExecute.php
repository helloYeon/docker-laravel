<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BeforeExecute
{
    public function handle(Request $request, Closure $next)
    {

        // set X-PID
        app('Common')->setPid($request->header('X-PID') ?? '');

        // set api req infos
        log_info(
            sprintf(config('message.I0002'), 'api request'),
            [
                'url'       => $request->getUri(),
                'method'    => $request->getMethod(),
                'header'    => $request->headers->all(),
                'parameter' => $request->json()->all(),
            ]
        );

        return $next($request);
    }
}
