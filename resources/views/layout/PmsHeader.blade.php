<div>
    <nav class="w-full shadow-lg fixed top-0 left-0 right-0 mx-auto max-w-full z-50 bg-white">
        <div class="w-full relative flex min-h-[60px] items-center px-8 justify-between shadow-sm">
            <!--      -->
            <!-- Logo -->
            <!--      -->
            <div class="h-auto m-0 p-0 w-32 flex space-x-3">
                <img src="/storage/elements/LogoCut.png" alt="Dolistify">
            </div>
            <!--            -->
            <!-- Search Bar -->
            <!--            -->
            <div class="w-96 hidden md:block transition ease-in-out duration-150">
                <div class="relative">
                    <button
                        class="absolute inset-y-0 left-0 flex items-center px-3.5 opacity-80 hover:bg-gray-400 ease-in duration-200 rounded-l-md">
                        <svg width="18" height="16" viewBox="0 0 24 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.7079 19.2499C16.7577 19.2499 20.8513 15.3511 20.8513 10.5416C20.8513 5.73211 16.7577 1.83325 11.7079 1.83325C6.65811 1.83325 2.56445 5.73211 2.56445 10.5416C2.56445 15.3511 6.65811 19.2499 11.7079 19.2499Z"
                                stroke="#787486" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M21.8139 20.1666L19.8889 18.3333" stroke="#787486" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <input type="text" id="searchInput"
                        class="block w-full pl-[50px] py-1 text-[12px] text-gray-900 border border-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-cyan-800/50 overflow-hidden"
                        placeholder="Search for project..." />
                    <div id="searchSuggestions"
                        class="hidden absolute w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg z-50">
                        <!-- Suggestions will be populated here -->
                    </div>
                </div>
            </div>
            <div class="flex space-x-5 items-center">
                <div class="ntfy flex space-x-3">
                    <!--            -->
                    <!-- Search Icon -->
                    <!--            -->
                    <div class="block md:hidden ease-in-out duration-300">
                        <button id="mobileSearchToggle" class="pt-2 pr-1.5 rounded-full">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.7079 19.2499C16.7577 19.2499 20.8513 15.3511 20.8513 10.5416C20.8513 5.73211 16.7577 1.83325 11.7079 1.83325C6.65811 1.83325 2.56445 5.73211 2.56445 10.5416C2.56445 15.3511 6.65811 19.2499 11.7079 19.2499Z"
                                    stroke="#787486" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M21.8139 20.1666L19.8889 18.3333" stroke="#787486" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                    <!--            -->
                    <!-- Notif Bell -->
                    <!--            -->
                    <div class="relative">
                        <!-- Form to mark notifications as read (hidden) -->
                        <form id="markNotificationsReadForm" action="{{ route('notifications.markAllAsRead') }}"
                            method="POST" style="display: none;">
                            @csrf
                        </form>

                        <!-- Notification Bell -->
                        <button id="notificationBell" class="relative" type="button">
                            <svg class="bell ease-in-out duration-300" width="30" height="31" viewBox="0 1 25 25"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6.44784 8.96942C6.76219 6.14032 9.15349 4 12 4V4C14.8465 4 17.2378 6.14032 17.5522 8.96942L17.804 11.2356C17.8072 11.2645 17.8088 11.279 17.8104 11.2933C17.9394 12.4169 18.3051 13.5005 18.8836 14.4725C18.8909 14.4849 18.8984 14.4973 18.9133 14.5222L19.4914 15.4856C20.0159 16.3599 20.2782 16.797 20.2216 17.1559C20.1839 17.3946 20.061 17.6117 19.8757 17.7668C19.5971 18 19.0873 18 18.0678 18H5.93223C4.91268 18 4.40291 18 4.12434 17.7668C3.93897 17.6117 3.81609 17.3946 3.77841 17.1559C3.72179 16.797 3.98407 16.3599 4.50862 15.4856L5.08665 14.5222C5.10161 14.4973 5.10909 14.4849 5.11644 14.4725C5.69488 13.5005 6.06064 12.4169 6.18959 11.2933C6.19123 11.279 6.19283 11.2645 6.19604 11.2356L6.44784 8.96942Z"
                                    stroke="#222222" stroke-width="0.7" />
                                <path
                                    d="M9.10222 18.4059C9.27315 19.1501 9.64978 19.8077 10.1737 20.2767C10.6976 20.7458 11.3396 21 12 21C12.6604 21 13.3024 20.7458 13.8263 20.2767C14.3502 19.8077 14.7269 19.1501 14.8978 18.4059"
                                    stroke="#222222" stroke-width="0.7" stroke-linecap="round" />
                            </svg>
                            <span id="notificationCount"
                                class="absolute {{ $unreadCount > 0 ? '' : 'hidden' }} top-3 md:top-2 right-5 translate-x-1/3 -translate-y-2/3 pflex items-center justify-center w-4 h-4 rounded-full bg-red-500 text-[11px] align-center">
                                {{ $unreadCount }}
                            </span>
                        </button>

                        <!-- Notifications Dropdown -->
                        <div id="notificationsDropdown"
                            class="hidden absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-50 max-h-96 overflow-hidden">
                            <div class="overflow-y-auto scrollbar-thin max-h-96">
                                <div class="p-4 border-b sticky top-0 bg-slate-100 z-10">
                                    <div class="flex justify-between items-center">
                                        <h3 class="text-large text-xl text-cyan-800">Notifications</h3>
                                        <button id="markAllReadButton" class="text-sm text-blue-600">Mark All as
                                            Read</button>
                                    </div>
                                </div>
                                <div id="notificationsList" class="divide-y">
                                    @if ($notifications->isEmpty())
                                        <p class="p-4 text-center text-gray-500">You have no notifications at the
                                            moment.</p>
                                    @else
                                        <ul class="list-none p-0 m-0">
                                            @foreach ($notifications as $notification)
                                                <a href="{{ $notification->link }}">
                                                    <li id="notification-{{ $notification->id }}"
                                                        class="p-4 text-normal text-cyan-900 border-b  {{ $notification->status === 'unread' ? 'bg-gray-100' : '' }} hover:bg-gray-50 transition duration-150 ease-in-out">
                                                        <div class="flex flex-col">
                                                            <div>{{ $notification->message }}</div>
                                                            <small
                                                                class="text-xs text-normal text-gray-400">{{ $notification->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </li>
                                                </a>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--        -->
                    <!-- Burger -->
                    <!--        -->
                    <div class="lg:hidden ease-in-out duration-300">
                        <button type="btn" id="burger"
                            class="relative inline-flex items-center justify-center rounded-md pt-2 pb-2 text-gray-400 hover:text-cyan-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                            aria-controls="mobile-menu" aria-expanded="false">
                            <span class="absolute -inset-0.5"></span>
                            <span class="sr-only">Open main menu</span>

                            <svg class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" aria-hidden="true" data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>

                            <svg class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" aria-hidden="true" data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!--                              -->
        <!-- Search bar for small screens -->
        <!--                              -->
        <div id="mobileSearchBar"
            class="block md:hidden w-full overflow-hidden transition-all duration-300 ease-in-out max-h-0 ">
            <div class="w-full px-4 py-3">
                <div class="relative">
                    <button
                        class="absolute inset-y-0 left-0 flex items-center px-3.5 opacity-80 hover:bg-gray-400 ease-in duration-200 rounded-l-md">
                        <svg width="18" height="16" viewBox="0 0 24 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.7079 19.2499C16.7577 19.2499 20.8513 15.3511 20.8513 10.5416C20.8513 5.73211 16.7577 1.83325 11.7079 1.83325C6.65811 1.83325 2.56445 5.73211 2.56445 10.5416C2.56445 15.3511 6.65811 19.2499 11.7079 19.2499Z"
                                stroke="#787486" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M21.8139 20.1666L19.8889 18.3333" stroke="#787486" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <input type="text"
                        class="block w-full pl-[50px] py-1 text-[12px] text-gray-900 border border-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-cyan-800/50 overflow-hidden"
                        placeholder="Search for task..." />
                </div>
            </div>
        </div>
    </nav>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const suggestionsContainer = document.getElementById('searchSuggestions');
        let debounceTimer;

        if (!searchInput || !suggestionsContainer) {
            console.error('Search elements not found');
            return;
        }

        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            const query = this.value;
            console.log('Search query:', query); // Debug log

            if (query.length < 2) {
                suggestionsContainer.classList.add('hidden');
                return;
            }

            debounceTimer = setTimeout(() => {
                const searchUrl = '{{ route('search.projects') }}';
                console.log('Fetching from:', searchUrl); // Debug log

                fetch(`${searchUrl}?query=${encodeURIComponent(query)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Search results:', data); // Debug log
                        suggestionsContainer.innerHTML = '';

                        if (data.projects && data.projects.length > 0) {
                            data.projects.forEach(project => {
                                const div = document.createElement('div');
                                div.className =
                                    'p-2 hover:bg-gray-100 cursor-pointer';
                                div.innerHTML = `
                            <div class="text-sm">${project.title}</div>
                            <div class="text-xs text-gray-500">${project.type}</div>
                        `;
                                div.onclick = () => window.location.href =
                                    `/DoListify/Task/${project.id}`;
                                suggestionsContainer.appendChild(div);
                            });
                            suggestionsContainer.classList.remove('hidden');
                        } else {
                            const div = document.createElement('div');
                            div.className = 'p-2 text-sm text-gray-500';
                            div.textContent = 'No results found';
                            suggestionsContainer.appendChild(div);
                            suggestionsContainer.classList.remove('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        suggestionsContainer.innerHTML = `
                    <div class="p-2 text-sm text-red-500">
                        Error searching projects
                    </div>
                `;
                        suggestionsContainer.classList.remove('hidden');
                    });
            }, 300);
        });

        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
                suggestionsContainer.classList.add('hidden');
            }
        });
    });


    document.addEventListener('DOMContentLoaded', () => {
        const notificationBell = document.getElementById('notificationBell');
        const notificationsDropdown = document.getElementById('notificationsDropdown');
        const notificationCount = document.getElementById('notificationCount');

        // Toggle dropdown visibility and reset the notification count when the bell is clicked
        notificationBell.addEventListener('click', () => {
            notificationsDropdown.classList.toggle('hidden');
            notificationCount.textContent = '0';
            notificationCount.classList.add('hidden');

            // Send request to mark all notifications as read
            fetch("{{ route('notifications.markAllAsRead') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    }
                }).then(response => response.json())
                .then(data => {
                    // Optionally, you can handle UI updates here
                    notificationCount.classList.add('hidden'); // Hide the count
                }).catch(error => {
                    console.error('Error marking all as read:', error);
                });
        });

        // Fetch notifications count dynamically
        const fetchNotificationsCount = async () => {
            try {
                const response = await fetch("{{ route('notifications.getUnreadCount') }}");
                const {
                    unreadCount
                } = await response.json();
                notificationCount.textContent = unreadCount;
                notificationCount.classList.toggle('hidden', unreadCount === 0);
            } catch (error) {
                console.error('Error fetching notifications count:', error);
            }
        };

        // Fetch notifications count on page load
        fetchNotificationsCount();

        // Optionally, refresh count periodically
        setInterval(fetchNotificationsCount, 60000); // Every 60 seconds

        document.addEventListener('click', function (e) {
        // If the click is outside the notification bell and dropdown, hide the dropdown
        if (!notificationBell.contains(e.target) && !notificationsDropdown.contains(e.target)) {
            notificationsDropdown.classList.add('hidden');
        }
    });
    });
</script>
