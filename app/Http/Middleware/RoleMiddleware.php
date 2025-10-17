<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // kalau belum login, lempar ke login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // dukung banyak role: role:admin atau role:admin,karyawan
        if (!in_array(auth()->user()->role, $roles, true)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
