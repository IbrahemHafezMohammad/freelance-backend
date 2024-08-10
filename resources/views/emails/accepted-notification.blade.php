<!DOCTYPE html>
<html>
<head>
    <title>You Got Accepted!</title>
</head>
<body>
    <h1>Congratulations, {{ $seeker->user->name }}!</h1>

    <p>We are pleased to inform you that your application for the position of <strong>{{ $jobPost->title }}</strong> with {{ $employer->name }} has been accepted!</p>

    <p>Our team is excited to have you onboard and looks forward to working with you. We will contact you shortly with more details on the next steps.</p>

    <p>If you have any questions or need further assistance, please feel free to reach out to us.</p>

    <p>Best regards,</p>
    <p>{{ $employer->user->name }}</p>

    <p><strong>Employer Details:</strong></p>
    <p>Name: {{ $employer->user->name }}</p>
    <p>Email: {{ $employer->user->email }}</p>
</body>
</html>
