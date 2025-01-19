<!DOCTYPE html>
<html lang="en">

<head>
    <title>Email Verification</title>
    <style> 
        @import url('https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css');
    </style>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="max-w-lg mx-auto my-10 bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-gray-800">Hello {{ $firstName ?? 'User' }}!</h1>
        <p class="mt-4 text-gray-600">Thank you for signing up for DoListify. To complete your registration, please verify your email address by entering the code below:</p>
        <div class="mt-6 text-center">
            <h2 class="text-3xl font-bold text-indigo-600"><strong>{{ $verificationCode }}</strong></h2>
        </div>
        <p class="mt-6 text-gray-600">If you didn’t request this, please ignore this message.</p>
        <p class="mt-4 text-gray-600">Thank you,<br>
            <span class="ml-4">The DoListify Team</span></p>
    </div>
</body>

</html>
