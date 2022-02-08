<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminte\Support\Facades\Auth;
use App\Models\Account_Role;


class AdminMiddleWare
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
        $user = Auth()->user()->id;
        $account = Account_Role::where('user_id', $user)->first();
        $role = $account->role;

        if($role == "admin"){
            
        }
        else {

           return response()->json(['message'=>'Unauthorized access'],403);
         
        }

        return $next($request);
    }
}
