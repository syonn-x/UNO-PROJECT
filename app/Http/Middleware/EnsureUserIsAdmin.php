<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * Ensures that only authenticated users with the 'admin' role can access the route.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthenticated.',
                ], 401);
            }

            return redirect()->guest(route('login'))->with('error', 'Silakan masuk terlebih dahulu untuk mengakses Admin Panel.');
        }

        if (! Auth::user()->isAdmin()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Forbidden. Halaman Admin Panel hanya dapat diakses oleh Administrator.',
                ], 403);
            }

            return redirect()->route('landing')->with('error', 'Akses ditolak! Halaman Admin Panel hanya dapat diakses oleh Administrator.');
        }

        return $next($request);
    }
}
