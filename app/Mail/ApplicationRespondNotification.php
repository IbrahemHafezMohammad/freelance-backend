<?php

namespace App\Mail;

use App\Constants\JobApplicationConstants;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationRespondNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $seeker;
    public $employer;
    public $jobPost;
    public $application;

    /**
     * Create a new message instance.
     */
    public function __construct($seeker, $employer, $jobPost, $application)
    {
        $this->seeker = $seeker;
        $this->employer = $employer;
        $this->jobPost = $jobPost;
        $this->application = $application;
    }

    public function build()
    {
        if ($this->application->status == JobApplicationConstants::STATUS_ACCEPTED) {
            $email = $this->subject('You Got Accepted!')
            ->view('emails.accepted-notification');
        } else {
            $email = $this->subject('Application Respond Notification')
            ->view('emails.rejected-notification');
        }

        return $email;
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Application Respond Notification',
    //     );
    // }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    // public function attachments(): array
    // {
    //     return [];
    // }
}
