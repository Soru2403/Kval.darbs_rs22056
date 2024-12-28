<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Pārbaudām, vai lietotājs ir autorizējies un vai viņa loma ir 'admin'
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);  // Ja lietotājs ir administrators, turpinām pieprasījumu
        }

        // Ja lietotājs nav administrators, novirzam viņu uz galveno lapu ar kļūdu ziņojumu
        return redirect()->route('home')->with('error', 'Jums nav tiesību piekļūt šai lapai.');
    }
}

