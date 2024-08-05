<!DOCTYPE html>
<html>
<head>
    <title>New Job Application Received</title>
</head>
<body>
    <img src="https://static.vecteezy.com/system/resources/previews/011/401/355/original/job-finder-logo-vector.jpg" alt="Website Logo" style="width: 150px; height: auto;">

    <h1>New Job Application</h1>
    <p>Dear {{ $jobPost->employer->user->name }},</p>
    <p>You have received a new application for the job post titled "<strong>{{ $jobPost->title }}</strong>" from {{ $user->name }}.</p>

    <p><strong>Seeker Details:</strong></p>
    <p>Name: {{ $user->name }}</p>
    <p>Email: {{ $user->email }}</p>

    <p><strong>Application Message:</strong></p>
    <p>{{ $application->message ?? 'No message provided.' }}</p>

    @if($resumeLink)
    <p><strong>Resume:</strong></p>
    <p>
        <a href="{{ $resumeLink }}" target="_blank" style="background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">View Resume</a>
    </p>
    @endif

    <p>You can view and manage this application in your employer dashboard.</p>

    <p>Best regards,</p>
    <p>Job Finder</p>
</body>
</html>
