<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiClient;

class ApiTokenMiddleware
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
        $token = $request->header('Authorization');

        // Token esperado no formato bearer: <token aqui>
        if (!$token || !str_starts_with($token, 'Bearer ')) {
            return response()->json([
                'error' => 'Token inválido!'
            ], 401);
        }

        $hashedToken = hash('sha256', trim(str_replace('Bearer ', '', $token)));

        $client = ApiClient::where('api_token', $hashedToken)->first();

        if (!$client) {
            return response()->json([
                'error' => 'Token não autorizado!'
            ], 401);
        }

        // Se chegou aqui, tudo deu certo, token válido e existente, passa adiante com o cliente autenticado
        // opcional: $request->merge([...]);
        return $next($request);
    }
}
