<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Auth;
use Closure;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
    public function handle($request, Closure $next, ... $roles)
    {
        if (\Request::is('api*')) {
            $api = Auth::guard('api')->user();
            if ($api) {
                return $next($request);
            }
            $response = [];
            $response['error'] = 'Unauthorized';
            return response()->json($response, 200);
        } else {
            if (!Auth::check()) {
            return redirect(route('login'));
            }

            $user = Auth::user();
            if(!$roles) {
                return $next($request);
            }
            foreach($roles as $role) {
                // Check if user has the role This check will depend on how your roles are set up
                if($user->role == $role) {
                    return $next($request);
                }
                    
            }
            return redirect(route('home'));
        }
        
    }
}
