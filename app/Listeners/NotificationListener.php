<?php

namespace App\Listeners;

use App\Events\SendNotification;
use App\Services\MockyService;

class NotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        private MockyService $service,
    ) {}

    /**
     * Handle the event.
     *
     * @param  \App\Events\ExampleEvent  $event
     * @return void
     */
    public function handle(SendNotification $event)
    {
        $this->service->notifyUser($event->transaction->wallet->user->id);
    }
}
