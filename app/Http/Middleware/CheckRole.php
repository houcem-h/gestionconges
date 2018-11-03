<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
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
        if(!auth()->user())        
            return $next($request);
        if(auth()->user()->role == 0)
            return redirect('employee/home');
        if(auth()->user()->role == 1)
            return redirect('superviseur/home');
        if(auth()->user()->role == 2)
            return redirect('resprh/home');
    }
}
