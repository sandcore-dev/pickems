<?php

namespace App\Http\Middleware;

use Closure;

use Carbon\Carbon;

class UserLocale
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
		if( auth()->check() )
		{
			$locale = auth()->user()->locale;
			
			app()->setLocale( $locale );
			
			setlocale( LC_TIME, config("app.time_locales.$locale") );
		}
		
        return $next($request);
    }
}
