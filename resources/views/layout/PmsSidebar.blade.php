<aside id="sidebar"
    class="fixed top-[calc(72px)] left-0 w-60 bg-gradient-black h-[calc(100vh-82px)] overflow-hidden duration-300 transition-all ease-in-out -translate-x-full ease-nav-brand lg:ml-5 rounded-2xl lg:-left-2 lg:translate-x-0 border-none">

    <div id="sidebarCont" class="flex flex-col overflow-y-auto space-y-4 h-full">
        <div class="sticky top-0 flex items-center justify-start p-4 backdrop-blur-md">
            @if (Auth::user()->profile_picture)
                <!-- If the user has a profile picture, display it -->
                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture"
                    class="w-10 h-10 rounded-full mr-4">
            @else
                <!-- If no profile picture, display the first letter of the first and last name -->
                <a href="#"
                    class="w-10 h-10 rounded-full shadow-inner shadow-black bg-teal-500 text-white flex items-center font-bold justify-center mr-4">
                    <!-- Display the first letter of first name and last name -->
                    {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name, 0, 1)) }}
                </a>
            @endif
            <div class="text-white text-normal text-sm whitespace-nowrap ">
                <p class="font-medium">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</p>
                <p class="text-[10px] text-cyan-500">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <!-- Menu Items -->
        <div class="items-center block w-auto max-h-screen h-sidenav grow basis-full ps">
            <ul class="flex flex-col pl-0 mb-0 space-y-3">
                @php
                    $menuItems = [
                        ['url' => '/DoListify/Dashboard', 'icon' => 'home.svg', 'label' => 'Dashboard'],
                        ['url' => '/DoListify/Add-Project', 'icon' => 'add-project.svg', 'label' => 'Add Project'],
                        ['url' => '/DoListify/Projects', 'icon' => 'projects.svg', 'label' => 'Projects'],
                        ['url' => '/DoListify/Team', 'icon' => 'team.svg', 'label' => 'Team'],
                        ['url' => '/DoListify/Calendar', 'icon' => 'calendar.svg', 'label' => 'Calendar'],
                        ['url' => '/DoListify/Leaderboard', 'icon' => 'leaderboard.svg', 'label' => 'Leaderboard'],
                    ];
                    $currentUrl = request()->path();
                @endphp

                @foreach ($menuItems as $item)
                    <li>
                        <a href="{{ url($item['url']) }}"
                            class="nav-item flex items-center mx-4 pl-3 rounded-xl gap-5 hover:bg-[#626161] ease-in duration-100 
                            {{ ($currentUrl == str_replace('/DoListify/', '', $item['url']) || 
                               ($item['label'] == 'Projects' && str_contains($currentUrl, 'Task'))) 
                               ? 'bg-[#626161]' : '' }}"
                            aria-label="{{ $item['label'] }}">
                            <div>
                                <img src="{{ asset('/storage/icons/' . $item['icon']) }}"
                                    alt="{{ $item['label'] }} icon" viewBox="0 0 24 24" class="w-5 h-5">
                            </div>
                            <span class="text-medium text-white pt-3 pb-3">{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <br>
        <br>
        <!-- Settings & Logout Section -->
        <div class="flex flex-col space-y-3 ">
            <a href="{{ route('settings') }}"
                class="nav-item flex items-center mx-4 pl-3 rounded-2xl gap-5 hover:bg-[#626161] ease-in duration-100">
                <img src="{{ asset('/storage/icons/settings.svg') }}" alt="Settings" class="w-5 h-5">
                <span class="text-medium text-white pt-3 pb-3">Settings</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" id="logout-form" class="">
                @csrf
                <button type="submit" id="logout-button"
                    class="flex items-center mx-4 pl-3 pr-28 rounded-2xl gap-5 hover:bg-[#626161] ease-in duration-100">
                    <img src="{{ asset('/storage/icons/logout.svg') }}" alt="Logout" class="w-5 h-5">
                    <span class="text-medium text-white pt-3 pb-3">Logout</span>
                </button>
            </form>
        </div>
        <div class="my-2"></div>
    </div>
</aside>
@include('modal.reusableModal')

