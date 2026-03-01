<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Éviter de tracker les requêtes AJAX, API et admin
        if ($request->ajax() || 
            $request->is('api/*') || 
            $request->is('admin/*') ||
            $request->is('_debugbar/*')) {
            return $next($request);
        }

        try {
            // Tracker le visiteur
            Visitor::trackVisitor($request);
        } catch (\Exception $e) {
            // En cas d'erreur, on continue sans bloquer l'application
            \Log::error('Erreur tracking visiteur: ' . $e->getMessage());
        }

        return $next($request);
    }
}
