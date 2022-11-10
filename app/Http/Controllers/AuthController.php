<?php

namespace App\Http\Controllers;

use App\Http\Resources\TokenResource;
use App\Libraries\ApiResponse;
use App\Libraries\ApiToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $user = User::where('email', $request->post('email'))->first();
            if ($user->isTokenExpired()) {
                $token = new ApiToken(config('token.random_length'));
                $user->token = $token->generate($user->email, time());
                $user->token_expiration = Carbon::now()->addSecond(config('token.expiration_time'))->toDateTimeString();
                $user->save();
            }
            $response = new ApiResponse(200, new TokenResource($user), 'Usuario logeado');

            return $response->successResponse();
        } catch (\Throwable $e) {
            report($e);
            $response = new ApiResponse(500, null, $e->getMessage());

            return $response->errorResponse();
        }
    }

    public function refresh(Request $request)
    {
        try {
            $user = User::where('token', $request->header('X-Token'))->first();
            $token = new ApiToken(config('token.random_length'));
            $user->token = $token->generate($user->email, time());
            $user->token_expiration = Carbon::now()->addSecond(config('token.expiration_time'))->toDateTimeString();
            $user->save();

            $response = new ApiResponse(200, new TokenResource($user), 'Token refrescado');

            return $response->successResponse();
        } catch (\Throwable $e) {
            report($e);
            $response = new ApiResponse(500, null, $e->getMessage());

            return $response->errorResponse();
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = User::where('token', $request->header('X-Token'))->first();
            $user->token = null;
            $user->token_expiration = null;
            $user->save();

            $response = new ApiResponse(200, null, 'Sesión cerrada');

            return $response->successResponse();
        } catch (\Throwable $e) {
            report($e);
            $response = new ApiResponse(500, null, $e->getMessage());

            return $response->errorResponse();
        }
    }
}
