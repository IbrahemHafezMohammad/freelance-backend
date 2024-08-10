<!DOCTYPE html>
<html>
<head>
    <title>Application Respond Notification</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa; padding: 20px;">
    <div class="container">
        <div class="text-center mb-4">
            <img src="https://static.vecteezy.com/system/resources/previews/011/401/355/original/job-finder-logo-vector.jpg" alt="Website Logo" style="width: 150px; height: auto;">
        </div>
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h2>Application Respond Notification</h2>
            </div>
            <div class="card-body">
                <h4>Dear {{ $seeker->user->name }},</h4>

                <p>Thank you for applying for the position of <strong>{{ $jobPost->title }}</strong> with {{ $employer->user->name }}. After careful consideration, we regret to inform you that your application has not been successful at this time.</p>

                <p>We appreciate the time and effort you invested in your application, and we encourage you to apply for future opportunities that may align with your skills and experience.</p>

                <p>If you have any questions or would like feedback on your application, please do not hesitate to reach out.</p>

                <p>We wish you all the best in your job search.</p>

                <p>Best regards,</p>
                <p>{{ $employer->user->name }}</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (Optional if you plan to include any JS functionality in your emails) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
