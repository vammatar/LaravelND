<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuaugusiemsMiddleware
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
        if ($request->user()==null){
            return redirect()->route('login');
        }
        if ($request->user()->age<18){
            return redirect()->route('students.index');
        }
        return $next($request);
    }
}
