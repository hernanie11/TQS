<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminte\Support\Facades\Auth;
use App\Models\Account_Role;
use Illuminate\Support\Facades\DB;

class AccessPermission
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
         $rectoken = $request->token;
         $token = $request->bearerToken();

        if($token == $rectoken){
            return response([
                'isLoggedIn' => true
            ], 200);
        }
        else{
            return response([
                'isLoggedIn' => false
            ],200);
        
        }

        return $next($request);
    }


 
}
