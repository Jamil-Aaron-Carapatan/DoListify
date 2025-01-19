<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="http://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/storage/css/dist/output.css" as="style">
    <link rel="icon" href="/storage/elements/Icon.png" type="image/png">
    <link rel="stylesheet" href="/storage/css/dist/pmspages.css" as="style">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    @vite('resources/css/app.css')
    <!-- Add font imports -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
</head>

<body>
    @include('layout.PmsHeader')

    <div class="flex flex-col lg:flex-row min-h-screen">
        @include('layout.PmsSidebar')
        @yield('content')
    </div>
</body>
<script src="/storage/js/pmstheme.js"></script>
</html>
