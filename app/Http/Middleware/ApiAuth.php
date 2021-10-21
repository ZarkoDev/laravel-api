<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuth
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
        //return $request->bearerToken();
        if (empty($request->bearerToken())) {
            return response('Not authorized', 401);
        }

        $user = User::firstWhere('token', $request->bearerToken());

        if (!$user) {
            return response('Not authorized', 401);
        }

        Auth::login($user);

        return $next($request);
    }
}
