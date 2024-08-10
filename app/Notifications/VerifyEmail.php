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
        $token = Crypt::encryptString($notifiable->email . '|' . now()->timestamp);
        $base64Token = base64_encode($token);
        Log::info('Encrypted verification token: ' . $base64Token);

        // Send the custom mailable
        return (new VerifyEmailToken($base64Token))
            ->to($notifiable->email);
    }
}
