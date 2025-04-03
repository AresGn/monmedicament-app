<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsPharmacy
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
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->user_type !== 'PHARMACY') {
            return redirect('/')->with('error', 'Access denied. You must be a pharmacy to access this page.');
        }

        // Check if the pharmacy profile exists
        if (!Auth::user()->pharmacy) {
            return redirect('/')->with('error', 'Your pharmacy profile is not set up. Please contact an administrator.');
        }

        return $next($request);
    }
} 