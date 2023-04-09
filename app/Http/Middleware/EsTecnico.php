<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

//Definición de middelware para controlar el acceso de un usuario autentificado a secciones restringidas para perfil de acceso es_tecnico
class EsTecnico
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!auth()->user()->es_tecnico) {
            abort(403, 'Acceso no permitido');
        }

        return $next($request);
    }
}
