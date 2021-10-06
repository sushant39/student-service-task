<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $AUTH_USER = 'user';
        $AUTH_PASS = 'password';

        $has_supplied_credentials = !(empty($request->server('PHP_AUTH_USER')) && empty($request->server('PHP_AUTH_PW')));

        $is_not_authenticated = (
            !$has_supplied_credentials ||
            $request->server('PHP_AUTH_USER') != $AUTH_USER ||
            $request->server('PHP_AUTH_PW') != $AUTH_PASS
        );
        if ($is_not_authenticated) {
            $response['message'] = 'Invalid Username Or Password';
            $http_code = 401;
            return response()->json($response, $http_code);
        }
        return $next($request);
    }
}
