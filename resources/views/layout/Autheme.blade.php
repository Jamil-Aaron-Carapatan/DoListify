<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="http://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/storage/elements/Icon.png" type="image/png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="min-h-screen flex">
        <div id="leftSection"
            class="hidden lg:block lg:w-2/5 bg-cover bg-center transform transition-all duration-200 ease-in-out opacity-100 translate-x-0"
            style="background-image: url('/storage/elements/wallpaper.png');">
        </div>
        <div class="relative w-full lg:w-3/5 ease-in duration-400">
            <div class="w-full flex items-center justify-center" style="min-height: 90%">
                <div class="w-96 flex justify-center max-x-sm lg:max-w-lg 2xl:max-w-md ease-in duration-200 space-y-8">
                    @yield('content')
                </div>
            </div>
            <div class="flex items-end w-full max-h-[10%]">
                <img src="/storage/elements/Logo.png" alt="Logo"
                    class="my-4 w-auto mx-auto h-[30px] lg:h-[40px] 2xl:h-[45px] ease-in duration-200">
            </div>
        </div>
    </div>
    @vite('resources/js/app.js')
</body>

</html>
