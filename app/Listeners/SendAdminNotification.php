<?php

namespace App\Listeners;

// use App\Models\Parish;
use App\Events\ParishRegistered;
use App\Mail\NewParishNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendAdminNotification
{
    /**
     * Create the event listener.
     */

    /**
     * Handle the event.
     */
    public function handle(ParishRegistered $event): void
    {
        //
        Mail::to('iconuwemfrank@gmail.com')->send(New NewParishNotification($event->parish));
    }
}
