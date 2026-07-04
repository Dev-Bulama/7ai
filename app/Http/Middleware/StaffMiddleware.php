<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        $user = $request->user();

        if (!$user) {
            if ($request->wantsJson() || $request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated. Please log in again.'], 401);
            }
            return redirect()->route('login');
        }

        if ($user->is_active === false || $user->is_active === 0) {
            auth()->logout();
            if ($request->wantsJson() || $request->expectsJson()) {
                return response()->json(['error' => 'Your account has been deactivated.'], 403);
            }
            return redirect()->route('login')->withErrors(['email' => 'Your account has been deactivated.']);
        }

        $staffRoles = ['super-admin', 'admin', 'front-desk-staff', 'lunch-staff'];
        $allowed    = array_merge($staffRoles, $roles);

        if (!$user->hasAnyRole($allowed)) {
            if ($request->wantsJson() || $request->expectsJson()) {
                return response()->json(['error' => 'Access denied. Insufficient role.'], 403);
            }
            return redirect()->route('login')->withErrors(['email' => 'You do not have access to this portal.']);
        }

        return $next($request);
    }
}
