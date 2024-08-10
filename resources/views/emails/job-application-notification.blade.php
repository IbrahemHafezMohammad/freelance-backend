<!DOCTYPE html>
<html>
<head>
    <title>New Job Application Received</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa; padding: 20px;">
    <div class="container">
        <div class="text-center mb-4">
            <img src="https://static.vecteezy.com/system/resources/previews/011/401/355/original/job-finder-logo-vector.jpg" alt="Website Logo" style="width: 150px; height: auto;">
        </div>
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2>New Job Application</h2>
            </div>
            <div class="card-body">
                <p>Dear {{ $jobPost->employer->user->name }},</p>
                <p>You have received a new application for the job post titled "<strong>{{ $jobPost->title }}</strong>" from {{ $user->name }}.</p>

                <p><strong>Seeker Details:</strong></p>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>

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
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (Optional if you plan to include any JS functionality in your emails) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
