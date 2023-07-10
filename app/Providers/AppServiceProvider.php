<?php

namespace App\Providers;

use App\Http\Services\Message\Email\EmailService;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    public function boot(Request $request, \Illuminate\Http\Response $response): void
    {
        if ($this->app->environment('local')) {
            Mail::alwaysTo('ghanbarih243@gmail.com');
        }

        Paginator::defaultView('vendor.pagination.custom');



//        Blade::directive('messageBag', function (string $field) {
//          return view('error-messages.error', compact('field'));
//        });

    }


}
