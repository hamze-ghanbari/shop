<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Modules\Auth\Events\UserRegistered;
use Modules\Auth\Http\Services\AuthService;
use Modules\Auth\Listeners\SendEmailRegistered;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserRegistered::class => [
            SendEmailRegistered::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
//        $this->app->bind(SendEmailRegistered::class, function ($app, $arguments) {
//            return new AuthService(...$arguments);
//        });


//        $this->app->bindMethod([SendEmailRegistered::class, 'handle'], function (SendEmailRegistered $sendEmailRegistered, $app) {
//            return $sendEmailRegistered->handle($app->make(AuthService::class));
//        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
