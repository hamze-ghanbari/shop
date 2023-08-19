<?php

namespace Modules\Auth\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Auth\Events\UserRegistered;
use Modules\Auth\Http\Services\AuthService;

class SendEmailRegistered implements ShouldQueue
{
    public $afterCommit = true;

    public $queue = 'EmailRegistered';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        public AuthService $authService
    )
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $this->authService->sendEmail($event->otpCode, $event->userName);
    }
}
