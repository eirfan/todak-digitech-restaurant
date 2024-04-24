<?php

namespace App\Http\Middleware;

use App\Http\Resources\ErrorResource;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()) {
            $user = Auth::user();
                if(!$user->hasRole('manager')) {
                    return response()->json([
                        'error' => 'Forbidden',
                        'message' => 'Access Denied: You do not have permission to access this resource, required manager access',
                    ], 403);
                }
            }
            return $next($request);
        }
}
