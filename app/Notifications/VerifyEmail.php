<?php

namespace App\Notifications;

use App\Mail\VerifyEmailToken;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;

class VerifyEmail extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $token = Crypt::encrypt($notifiable->email . '|' . now()->timestamp);
        Log::info('Encrypted verification token: ' . $token);

        // Send the custom mailable
        return (new VerifyEmailToken($token))
            ->to($notifiable->email);
    }
}
