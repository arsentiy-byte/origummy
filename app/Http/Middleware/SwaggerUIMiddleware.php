<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\SessionServiceProvider;

final class SwaggerUIMiddleware
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
        abort_if((bool) app()->environment('production'), 403);

        if (is_null(app()->getProvider(SessionServiceProvider::class))) {
            app()->register(SessionServiceProvider::class);
        }

        return $next($request);
    }
}
