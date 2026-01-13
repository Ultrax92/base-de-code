<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log; // <--- Indispensable

class LogRequestMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $userAgent = $request->header('User-Agent');

        Log::info('Nouvelle requête reçue. Navigateur : ' . $userAgent);

        return $next($request);
    }
}
