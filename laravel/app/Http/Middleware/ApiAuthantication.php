<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Closure;

class ApiAuthantication
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
        $auth=$request->header('Auth');
        $authDB=DB::table('auth')->where('id','1')->value('auth');
        if(Hash::check($auth,$authDB)){
            return $next($request);
        }else{
            $this->reply = ['status' => 'fail', 'msg' => 'Authentication Failed.', 'data' => []];
            return response()->json($this->reply);
        }
    }
}
