<?php

namespace App\Http\Middleware;

use App\Exceptions\MissingPermissionException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionVerify
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
            throw new MissingPermissionException('User not found', 404);
        }

        info($request->route()->getName());
        if (!auth()->user()->rolePermissions->contains('route_name', $request->route()->getName())) {
            throw new MissingPermissionException('User not found', 404);
        }

        return $next($request);
    }
}
