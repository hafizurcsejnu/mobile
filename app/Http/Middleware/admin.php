<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class admin
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
        if(session('user.user_type') == 'Admin' || session('user.user_type') == 'Manager'){  
            
        }
        else{
            return redirect('/login');
        }
        return $next($request);
    }
}
