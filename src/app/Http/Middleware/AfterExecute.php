<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AfterExecute
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        log_info(sprintf(config('message.I0003'), 'api request'), [
            'response_data' => $response->content(),
        ]);

        return $response;
    }
}
