<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(Request $request, \Illuminate\Http\Response $response): void
    {
        Request::macro('fields', function ($guarded = ['id'], $attributes = []) use ($request) {
            $except = ['_token', '_method'];
            array_push($except, ...$guarded);
            $result = $request->except($except);
            if(!empty($attributes)){
              $result =  array_merge($request->except($except), $attributes);
            }
            return $result;
        });

        Response::macro('postSuccess', function (string $url, string $message = 'success', array $additional = []) use ($response) {
            $response = [
                'hasError' => false,
                'url' => $url,
                'message' => $message,
                'status' => $response->status()
            ];
            foreach ($additional as $key => $value) {
                $response[$key] = $value;
            }
            return response()->json($response);
        });

        Response::macro('postError', function (string $url, string $message = 'error', array $additional = []) use ($response) {
            $response = [
                'hasError' => true,
                'url' => $url,
                'message' => $message,
                'status' => $response->status()
            ];
            foreach ($additional as $key => $value) {
                $response[$key] = $value;
            }
            return response()->json($response);
        });
    }
}
