<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class FormLimiter
{

    public function handle(Request $request, Closure $next): Response
    {
        $key = 'otp:' . url()->current() . $request->ip();
        $executed = RateLimiter::attempt(
            $key,
            Config::get('auth_module.rate_limit'),
            function () {}
        );
        if (!$executed) {
            $time = ((Carbon::now())->addSeconds(RateLimiter::availableIn($key))->timestamp - Carbon::now()->timestamp) * 1000;
            $url = url()->current();

            if ($request->ajax()) {
                return response()->json([
                    'url' => $url,
                    'time' => $time
                ], 429);
            }
            return redirect()->to($url)->with([
                'time' => $time,
            ]);
        }

        return $next($request);

    }
}
