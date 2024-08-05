<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobApplicationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $jobPost;
    public $application;
    public $resumeLink;
    public $resumePath;

    public function __construct($user, $jobPost, $application)
    {
        $this->user = $user;
        $this->jobPost = $jobPost;
        $this->application = $application;
        $this->resumeLink = $application->resume; // Full public URL for the email link

        // Generate the storage path by replacing the URL part before 'storage/' with 'public/'
        $this->resumePath = str_replace(url('/storage'), 'public', $this->resumeLink);
    }

    public function build()
    {
        $email = $this->subject('New Job Application Received')
            ->view('emails.job-application-notification')
            ->with(['resumeLink' => $this->resumeLink]);

        // Attach the resume if it exists and is valid
        if (Storage::exists($this->resumePath)) {
            $email->attachFromStorage($this->resumePath);
        }

        return $email;
    }
}
