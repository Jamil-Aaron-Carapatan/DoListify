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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
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
    <div id="openTermsConModal" class="absolute inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center p-4">
        <div class="bg-white p-6 rounded-2xl shadow-lg max-w-md mx-auto animate-appear">
            <h3 class="text-xl font-bold mb-4">Terms and Conditions for DoListify</h3>
            <div class="text-gray-600 mb-6 space-y-4 max-h-[60vh] scrollbar-thin">
                <p>Welcome to DoListify, a project management web application created for educational purposes. By accessing or using this website, you agree to these Terms and Conditions ("Terms"). Please read them carefully.</p>
                <p><strong>1. Purpose</strong><br>DoListify is developed as an academic project and is not intended for commercial use. The application is designed to simulate a project management system for demonstration and learning purposes. All features and functionalities are for illustrative purposes and should not be relied upon for professional project management or organizational use.</p>
                <p><strong>2. User Responsibilities</strong><br><strong>2.1 Information Accuracy:</strong> Users are responsible for ensuring the accuracy and appropriateness of the information they input into the system.<br><strong>2.2 Educational Use Only:</strong> DoListify is solely for educational and demonstration purposes. Users agree not to use the application for commercial, professional, or real-world project management purposes.<br><strong>2.3 No Data Backup or Security Guarantee:</strong> As this is a school project, data entered into the system may not be securely stored or backed up. Users should avoid entering sensitive, personal, or confidential information.</p>
                <p><strong>3. Privacy</strong><br>DoListify does not collect, store, or share personal data beyond the educational demonstration of its functionality. Any data provided by users is used solely for the scope of this project and will not be shared with third parties.</p>
                <p><strong>4. Limitations of Liability</strong><br><strong>4.1 No Guarantee of Accuracy:</strong> The application may contain errors or incomplete features as it is developed for educational purposes only.<br><strong>4.2 No Professional Support:</strong> DoListify is not supported for real-world usage or troubleshooting beyond the scope of the academic project.<br><strong>4.3 Use at Your Own Risk:</strong> By using this application, you acknowledge and accept that it is a learning tool and agree to hold the developers and associated parties harmless from any damages or losses resulting from its use.</p>
                <p><strong>5. Modifications to Terms</strong><br>These Terms may be updated or modified at any time to reflect changes in the project scope or requirements. Users are encouraged to review the Terms periodically.</p>
            </div>
            <div class="flex justify-end gap-4 mt-4">
                <button onclick="hideTermsCon()" class="px-4 py-2 rounded-lg text-gray-600 transition-all hover:bg-gray-200">
                    Cancel
                </button>
                <button onclick="acceptTermsCon()" class="px-4 py-2 rounded-lg bg-cyan-700 text-white transition-all hover:bg-cyan-600">
                    Accept
                </button>
            </div>
        </div>
    </div>
    @vite('resources/js/app.js')
</body>

</html>
