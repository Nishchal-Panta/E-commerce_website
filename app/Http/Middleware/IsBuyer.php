<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsBuyer
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        if (!auth()->user()->isBuyer()) {
            abort(403, 'Unauthorized. Buyer access required.');
        }

        if (auth()->user()->isBlocked()) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Your account has been blocked. Please contact support.');
        }

        return $next($request);
    }
}
