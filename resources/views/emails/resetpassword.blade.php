<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #267268;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Reset Your Password</h1>
    <p>We received a request to reset your password. Click the button below to reset it:</p>
    <a href="{{ $resetLink }}" class="button" style="color: white;">Reset Password</a>
    <p>If you did not request a password reset, please ignore this email.</p>
    <p>Thank you,<br>Your Company Name</p>
</body>
</html>