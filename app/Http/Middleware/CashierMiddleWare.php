<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Account_Role;
use Illuminte\Support\Facades\Auth;
class CashierMiddleWare
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

        if($role == "cashier"){
            
        }
        else {
            abort(403);
        }

        return $next($request);
    }
}
