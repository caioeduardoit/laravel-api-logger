<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Log;

class LogApiRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // registra todos os logs quando a API é invocada
        if ($request->is('api/*')) {
            Log::create([
                'ip' => $request->ip(),
                'method' => $request->method(),
                'route' => $request->path(),
                'payload' => $request->all(),
                'response_status' => $response->getStatusCode(),
            ]);
        }

        return $response;
    }
}
