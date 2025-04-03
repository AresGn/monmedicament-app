<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PharmacyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->user_type !== 'PHARMACY') {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized. Pharmacy access required.'], 403);
            }
            
            return redirect()->route('login')->with('error', 'Cette section est réservée aux pharmacies.');
        }

        return $next($request);
    }
} 