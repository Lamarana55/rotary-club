<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
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

        if(Auth::user()->isDelete) {
            //Loggout
            Auth::logout();
            return redirect('/login')->with('msg', "Votre compte a un problème, merci de contacter l'administrateur.");
        }

        if(!Auth::user()->isvalide) {
            //Loggout
            Auth::logout();
            return redirect('/login')->with('msg', "Votre compte n'est pas encore validé.");
        }

        return $next($request);
    }
}
