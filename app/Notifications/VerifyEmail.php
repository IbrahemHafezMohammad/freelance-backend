<?php

namespace App\Notifications;

use App\Mail\VerifyEmailToken;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notification;

class VerifyEmail extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $token = $notifiable->getEmailForVerification();
        Log::info('getEmailForVerification: ' . $token);
        $token = sha1($token);

        // Send the custom mailable
        return (new VerifyEmailToken($token))
            ->to($notifiable->email);
    }
}
