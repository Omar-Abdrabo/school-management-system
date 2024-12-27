<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    
    /**
     * Handle the incoming request and set the application locale based on the
     * 'locale' parameter in the route.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->route('locale');
        App::setLocale($locale);

        return $next($request);
    }
}
