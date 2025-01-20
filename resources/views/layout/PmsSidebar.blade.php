<aside id="sidebar"
    class="fixed top-[calc(72px)] left-0 w-60 bg-gradient-black h-[calc(100vh-82px)] overflow-hidden duration-300 transition-all ease-in-out -translate-x-full ease-nav-brand lg:ml-5 rounded-2xl lg:-left-2 lg:translate-x-0 border-none">

    <div id="sidebarCont" class="flex flex-col overflow-y-auto space-y-4 h-full">
        <!-- Profile section - Now clickable -->
        <button id="profileButton" onclick="showprofileModal()"
            class="sticky top-0 flex p-3 backdrop-blur-md cursor-pointer hover:bg-[#626161] rounded-xl transition-all duration-200">
            @if (auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Profile Picture"
                    class="w-10 h-10 rounded-full mr-3">
            @else
                <div
                    class="w-10 h-10 rounded-full shadow-inner shadow-black bg-teal-500 text-white flex items-center font-bold justify-center mr-3">
                    {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name, 0, 1)) }}
                </div>
            @endif
            <div class="text-white text-normal text-start text-sm whitespace-nowrap">
                <p class="font-medium">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</p>
                <p class="text-[10px] text-cyan-500">{{ Auth::user()->email }}</p>
            </div>
        </button>
        <!-- Menu Items -->
        <div class="items-center block w-auto max-h-screen h-sidenav grow basis-full ps">
            <ul class="flex flex-col pl-0 mb-0 space-y-3">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="nav-item flex items-center mx-4 pl-3 rounded-xl gap-5 hover:bg-[#626161] ease-in duration-100"
                        aria-label="dashboard">
                        <div>
                            <img src="{{ asset('/storage/icons/home.svg') }}" alt="label icon"
                                viewBox="0 0 24 24" class="w-5 h-5">
                        </div>
                        <span class="text-medium text-white pt-3 pb-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('addTask') }}"
                        class="nav-item flex items-center mx-4 pl-3 rounded-xl gap-5 hover:bg-[#626161] ease-in duration-100"
                        aria-label="add task">
                        <div>
                            <img src="{{ asset('/storage/icons/add-project.svg') }}" alt="label icon"
                                viewBox="0 0 24 24" class="w-5 h-5">
                        </div>
                        <span class="text-medium text-white pt-3 pb-3">Add Task</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('projects') }}"
                        class="nav-item flex items-center mx-4 pl-3 rounded-xl gap-5 hover:bg-[#626161] ease-in duration-100"
                        aria-label="To Do">
                        <div>
                            <img src="{{ asset('/storage/icons/projects.svg') }}" alt="label icon"
                                viewBox="0 0 24 24" class="w-5 h-5">
                        </div>
                        <span class="text-medium text-white pt-3 pb-3">To Do</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('team') }}"
                        class="nav-item flex items-center mx-4 pl-3 rounded-xl gap-5 hover:bg-[#626161] ease-in duration-100"
                        aria-label="team">
                        <div>
                            <img src="{{ asset('/storage/icons/team.svg') }}" alt="label icon"
                                viewBox="0 0 24 24" class="w-5 h-5">
                        </div>
                        <span class="text-medium text-white pt-3 pb-3">Teams</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('calendar') }}"
                        class="nav-item flex items-center mx-4 pl-3 rounded-xl gap-5 hover:bg-[#626161] ease-in duration-100"
                        aria-label="calendar">
                        <div>
                            <img src="{{ asset('/storage/icons/calendar.svg') }}" alt="label icon"
                                viewBox="0 0 24 24" class="w-5 h-5">
                        </div>
                        <span class="text-medium text-white pt-3 pb-3">Calendar</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('leaderboard') }}"
                        class="nav-item flex items-center mx-4 pl-3 rounded-xl gap-5 hover:bg-[#626161] ease-in duration-100"
                        aria-label="leaderboard">
                        <div>
                            <img src="{{ asset('/storage/icons/leaderboard.svg') }}" alt="label icon"
                                viewBox="0 0 24 24" class="w-5 h-5">
                        </div>
                        <span class="text-medium text-white pt-3 pb-3">Leaderboard</span>
                    </a>
                </li>
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
