<?php

namespace App\Http\Middleware\Auth;

use App\Libraries\ApiResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ValidateLogin
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
        $data = $request->only(['email', 'password']);
        $validator = Validator::make($data, [
            'email' => 'required|email|exists:App\Models\User,email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            $response = new ApiResponse(422, $validator->errors(), 'Datos inválidos');

            return $response->invalidResponse();
        }

        $user = User::where('email', $data['email'])->first();

        if (!Hash::check($data['password'], $user->password)) {
            $response = new ApiResponse(422, null, 'Las credenciales del usuarios son incorrectas.');

            return $response->invalidResponse();
        }

        $response = $next($request);

        // Post-Middleware Action

        return $response;
    }
}
