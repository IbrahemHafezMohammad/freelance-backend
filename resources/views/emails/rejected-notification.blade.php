<!DOCTYPE html>
<html>
<head>
    <title>Application Respond Notification</title>
</head>
<body>
    <h1>Dear {{ $seeker->user->name }},</h1>

    <p>Thank you for applying for the position of <strong>{{ $jobPost->title }}</strong> with {{ $employer->user->name }}. After careful consideration, we regret to inform you that your application has not been successful at this time.</p>

    <p>We appreciate the time and effort you invested in your application, and we encourage you to apply for future opportunities that may align with your skills and experience.</p>

    <p>If you have any questions or would like feedback on your application, please do not hesitate to reach out.</p>

    <p>We wish you all the best in your job search.</p>

    <p>Best regards,</p>
    <p>{{ $employer->user->name }}</p>
</body>
</html>
