<?php

namespace App\Listeners;

use App\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCustomEmailVerificationNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(Registered $event)
    {
        $event->user->notify(new VerifyEmail());
    }
}
