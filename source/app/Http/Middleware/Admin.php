<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class Admin
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
        if(\Auth::check() && \Auth::user()->user_role==User::USER_TYPE_ADMIN){
            return $next($request);
        }else{
            \Auth::logout();
            \Session::flash('error','Restricted area for this user.');
            return redirect()->to('admin');
        }
    }
}
