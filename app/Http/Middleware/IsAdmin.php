<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }
        
        // Prevent admin panel access when viewing as customer
        if (session('view_as_customer', false)) {
            return redirect()->route('home')->with('error', 'Exit customer view to access admin panel.');
        }

        return $next($request);
    }
}
