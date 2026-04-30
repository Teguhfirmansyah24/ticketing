<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (auth()->user()->role !== $role) {
            // Redirect ke halaman sesuai role masing-masing
            if (auth()->user()->isAdmin()) {
                return redirect('/admin/dashboard');
            }

            return redirect('/home');
        }

        return $next($request);
    }
}
