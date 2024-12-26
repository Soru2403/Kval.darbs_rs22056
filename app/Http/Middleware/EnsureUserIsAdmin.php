<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    /**
     * Izpildīt middleware pieprasījumam.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Pārbaudām, vai lietotājs ir autentificēts un vai viņam ir administrātora loma
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Ja lietotājs ir administrators, turpinām pieprasījumu
        }

        // Ja lietotājs nav administrators, novirzām uz mājas lapu ar kļūdas ziņojumu
        return redirect()->route('home')->with('error', 'Tev nav administratora piekļuves.');
    }
}

