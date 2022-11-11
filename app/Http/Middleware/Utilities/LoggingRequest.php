<?php

namespace App\Http\Middleware\Utilities;

use Illuminate\Support\Facades\Log;

class LoggingRequest
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
        $index = $request->ip().' - Entry: '.$request->fullUrl();
        $data = $request->all();
        Log::channel('requestLog')->info($index, $data);

        $response = $next($request);

        // Post-Middleware Action

        return $response;
    }

    public function terminate($request, $response)
    {
        print_r($response);
        if (config('app.env') !== 'prod') {
            $index = $request->ip().' - Output: '.$request->fullUrl();

            Log::channel('requestLog')->info($index, ['response' => $response]);
        }
    }
}
