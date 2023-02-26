<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Alert;

class pj
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
        if(auth()->user()->status == 1){
            return $next($request);
        }
        Alert::toast('Anda tidak dapat mengakses halaman ini', 'error');
        return redirect()->back();
    }
}
