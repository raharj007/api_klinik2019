<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class PasienMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('api')->check()) {
            $role = Auth::guard('api')->user();

            if ($role->getUserRole() == 'pasien') {
                return $next($request);
            }

            return response()->json(['error' => 'Anda tidak memiliki akses sebagai pasien'], 405);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
