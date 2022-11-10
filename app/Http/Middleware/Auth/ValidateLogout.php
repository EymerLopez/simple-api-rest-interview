<?php

namespace App\Http\Middleware\Auth;

use App\Libraries\ApiResponse;
use App\Models\User;

class ValidateLogout
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        // Pre-Middleware Action

        $token = $request->header('X-Token');
        if (!$token) {
            $response = new ApiResponse(422, ['token' => 'Token no definido']);

            return $response->invalidResponse();
        }

        $user = User::where('token', $token)->first();
        if (!$user) {
            $response = new ApiResponse(404, null, 'Usuario no encontrado');

            return $response->notFoundResponse();
        }

        $response = $next($request);

        // Post-Middleware Action

        return $response;
    }
}
