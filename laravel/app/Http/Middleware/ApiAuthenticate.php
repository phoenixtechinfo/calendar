<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\DB;

use Closure;

class ApiAuthenticate
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
        $authDB=DB::table('users')->where('id',$request->user_id)->value('remember_token'); 
        if($auth == $authDB && $request->user_id != ''){
                return $next($request);
        }else{
            $this->reply = ['status' => FALSE, 'msg' => 'Authentication Failed.', 'data' => new \stdClass()];
            return response()->json($this->reply);
        }
    }
}
