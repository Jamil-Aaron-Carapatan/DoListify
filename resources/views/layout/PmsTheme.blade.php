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
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
</head>

<body>
    @include('layout.PmsHeader')

    <div class="flex flex-col lg:flex-row min-h-screen">
        @include('layout.PmsSidebar')
        @yield('content')
    </div>
    <div id="profileModal" class="fixed hidden inset-0 bg-gray-600 bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white  p-8 rounded-3xl shadow-2xl w-full h-auto max-w-3xl mx-2 animate-appear">
            <h3 class="text-3xl text-large mb-6 text-cyan-900 drop-shadow-lg">User Profile</h3>
            <div class="flex flex-col lg:flex-row items-center lg:items-start gap-6">
                @if (auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Profile Picture"
                        class="w-28 h-28 rounded-full mr-3">
                @else
                    <div
                        class="w-28 h-28 rounded-full bg-teal-400 text-large text-cyan-900 flex items-center justify-center text-4xl  shadow-lg border-4 border-white">
                        {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name, 0, 1)) }}
                    </div>
                @endif
                <div class="flex flex-col items-center lg:items-start">
                    <h4 class="text-2xl text-large lg:text-3xl text-cyan-900 drop-shadow-md">
                        {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</h4>
                    <p class="text-cyan-900 text-medium text-lg drop-shadow-sm">{{ Auth::user()->email }}</p>
                    <div class="flex items-center gap-3 text-cyan-900">
                        <i class="fas fa-star text-emerald-600 text-base text-normal  drop-shadow-lg"></i>
                        <p class="text-base text-normal text-emerald-600 drop-shadow-sm">Points:
                            <span class="text-emerald-600 text-base text-normal">{{ Auth::user()->points ?? 0 }}</span>
                        </p>
                    </div>
                </div>

            </div>
            <div class="flex justify-center lg:justify-end gap-6">
                <button onclick="hideprofileModal()"
                    class="px-5 py-2 rounded-xl bg-white text-cyan-800 font-bold shadow-lg border transition-all hover:bg-zinc-300">
                    Close
                </button>
            </div>
        </div>
    </div>
</body>
<script src="/storage/js/pmstheme.js"></script>
<script>
    function showprofileModal() {
        document.getElementById('profileModal').style.display = 'flex';
    }

    function hideprofileModal() {
        document.getElementById('profileModal').style.display = 'none';
    }
    window.onclick = function(event) {
        var modal = document.getElementById('profileModal');
        if (event.target == modal) {
            hideprofileModal();
        }
    }
</script>

</html>
