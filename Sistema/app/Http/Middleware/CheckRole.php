<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Verifica si el usuario está autenticado y si su rol coincide con el requerido
        if ($request->user() && $request->user()->role === $role) {
            return $next($request);
        }

        // Si no, retorna una respuesta de acceso denegado
        return response()->json(['message' => 'Acceso denegado.'], 403);
    }
}
