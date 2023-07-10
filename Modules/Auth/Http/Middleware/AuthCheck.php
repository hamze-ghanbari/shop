<?php

namespace Modules\Auth\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;

class AuthCheck
{

    public function handle(Request $request, Closure $next)
    {
        return auth()->check()
            ? (redirect()->to("profile/". $request->user()->id))
            : $next($request);
    }
}
