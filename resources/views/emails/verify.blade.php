<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email Address</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa; padding: 20px;">
    <div class="container">
        <div class="text-center mb-4">
            <img src="https://static.vecteezy.com/system/resources/previews/011/401/355/original/job-finder-logo-vector.jpg" alt="Website Logo" style="width: 150px; height: auto;">
        </div>
        <div class="card">
            <div class="card-header bg-info text-white">
                <h2>Verify Your Email Address</h2>
            </div>
            <div class="card-body">
                <p>Dear user,</p>
                <p>Please use the following token to verify your email address:</p>
                <p class="text-center" style="font-size: 1.5em;"><strong>{{ $token }}</strong></p>
                <p>You can verify your email by sending this token to our verification endpoint.</p>
                <p><strong>Note:</strong> This token is valid for one hour.</p>
                <p>Thank you for registering with us!</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (Optional if you plan to include any JS functionality in your emails) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
