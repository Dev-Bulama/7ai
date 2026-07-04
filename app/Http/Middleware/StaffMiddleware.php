<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $user = $request->user();

        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('login')->withErrors(['email' => 'Your account has been deactivated.']);
        }

        $staffRoles = ['super-admin', 'admin', 'front-desk-staff', 'lunch-staff'];
        $allowed = array_merge($staffRoles, $roles);

        if (!$user->hasAnyRole($allowed)) {
            abort(403, 'Access denied. You do not have a staff role.');
        }

        return $next($request);
    }
}
