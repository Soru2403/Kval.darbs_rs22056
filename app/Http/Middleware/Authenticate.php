<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Apstrādā ienākošo pieprasījumu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pārbauda, vai lietotājs ir autorizēts
        if (!Auth::check()) {
            // Ja lietotājs nav autorizēts, novirza uz pieteikšanās lapu
            return redirect()->route('login'); // Novirzīt uz pieteikšanās lapu
        }

        // Ja lietotājs ir autorizēts, turpinām pieprasījuma apstrādi
        return $next($request); // Turpinām ar nākamo middleware vai kontrolieri
    }
}

