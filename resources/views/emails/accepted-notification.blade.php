<!DOCTYPE html>
<html>
<head>
    <title>You Got Accepted!</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa; padding: 20px;">
    <div class="container">
        <div class="text-center mb-4">
            <img src="https://static.vecteezy.com/system/resources/previews/011/401/355/original/job-finder-logo-vector.jpg" alt="Website Logo" style="width: 150px; height: auto;">
        </div>
        <div class="card">
            <div class="card-header bg-success text-white">
                <h2>Congratulations, {{ $seeker->user->name }}!</h2>
            </div>
            <div class="card-body">
                <p class="lead">We are pleased to inform you that your application for the position of <strong>{{ $jobPost->title }}</strong> with {{ $employer->name }} has been accepted!</p>

                <p>Our team is excited to have you onboard and looks forward to working with you. We will contact you shortly with more details on the next steps.</p>

                <p>If you have any questions or need further assistance, please feel free to reach out to us.</p>

                <p>Best regards,</p>
                <p>{{ $employer->user->name }}</p>

                <hr>

                <p><strong>Employer Details:</strong></p>
                <p><strong>Name:</strong> {{ $employer->user->name }}</p>
                <p><strong>Email:</strong> {{ $employer->user->email }}</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (Optional if you plan to include any JS functionality in your emails) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
