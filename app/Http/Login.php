<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        
             if(isset(Auth::user()->User_type) && Auth::user()->User_type=="c")
               {
                    
               }
               else
               {    
                   return redirect('/login');
                   die(); 
               }
                 return $next($request);
    }
            
}
