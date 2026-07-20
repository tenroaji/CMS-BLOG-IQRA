<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PenulisMiddleware
{

    public function handle(Request $request, Closure $next)
    {


        if (!auth()->check()) {

            return redirect()
                ->route('login');
        }



        if (auth()->user()->role !== 'penulis') {


            abort(
                403,
                'Halaman ini hanya untuk penulis'
            );
        }



        return $next($request);
    }
}