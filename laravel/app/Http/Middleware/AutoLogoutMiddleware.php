<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AutoLogoutMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user) {
            $lastActivity = session('lastActivityTime');
            if (!$lastActivity) {
                session(['lastActivityTime' => time()]);
                return $next($request);
            }

            if ((time() - $lastActivity) > 86400) {
                Auth::logout();
                return redirect('/login')->with('message', 'You have been automatically logged out due to inactivity.');
            }
            session(['lastActivityTime' => time()]);
        }

        return $next($request);
    }
}
