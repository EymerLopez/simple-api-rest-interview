<?php

namespace App\Http\Middleware;

use App\Libraries\ApiResponse;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, \Closure $next, $guard = null)
    {
        $response = new ApiResponse(401, null, 'Inautorizado');
        if ($this->auth->guard($guard)->guest()) {
            return $response->unauthorizedResponse();
        } else {
            $user = $request->user();

            if ($user->isTokenExpired()) {
                $response->setMessage('Token Expirado. Por favor renuévelo.');

                return $response->unauthorizedResponse();
            }
        }

        return $next($request);
    }
}
