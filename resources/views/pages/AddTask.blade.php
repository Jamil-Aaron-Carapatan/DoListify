<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/storage/elements/Icon.png" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/storage/css/dist/addproject.css">
    @extends('layout.PmsTheme')
    @section('title', 'Add Task | DoListify: Make a plan to success')
</head>

<body>
    @section('content')
        <div id="main-content" class="main-content py-2 px-4">
            <div class="bg-white rounded-2xl shadow-lg p-8 mx-auto space-y-3 relative">
                <!-- Task Input Area -->
                <form id="completeForm" action="{{ route('addTask.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="personal">
                    <input type="hidden" name="created_by" value="{{ Auth::id() }}">
                    <input type="hidden" name="project_id" value="{{ request('project_id') }}">

                    <!-- Title Input -->
                    <input type="text" name="tasks[0][name]" placeholder="Title"
                        class="w-full text-xl text-large border-b focus:outline-none focus:border-cyan-800 placeholder-gray-500"
                        required>
                    <!--Text Area -->
                    <textarea id="text-desc" name="tasks[0][description]" placeholder="Take a note..."
                        class="w-full mt-2 border-b text-medium text-lg focus:outline-none focus:border-cyan-800 placeholder:text-medium placeholder:text-lg placeholder:text-slate-400 overflow-hidden"
                        rows="3" style="max-height: 500px;" oninput="autoExpand(this)"></textarea>

                    <!-- Checklist -->
                    <div id="checklist-container" class="space-y-2 mt-3">

                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between mt-6">
                        <!-- Icon Buttons -->
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <button type="button" id="due-date-button"
                                    class="flex items-center p-2 rounded-full hover:bg-gray-100"
                                    onclick="toggleDropdown('due-date-dropdown')" title="Set Due Date">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 011 1v1h10V3a1 1 0 112 0v1h1a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h1V3a1 1 0 011-1zm0 5v14h12V7H6zm2 2a1 1 0 100 2h8a1 1 0 100-2H8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div id="due-date-dropdown"
                                    class="absolute hidden bg-white shadow-md rounded-md mt-2 p-4 z-10 w-64">
                                    <p class="block text-sm font-medium text-gray-700 mb-2">Set Due Date & Time:</p>
                                    <label for="due-date-input" class="text-sm font-medium text-gray-600 block">Date</label>
                                    <input type="date" id="due-date-input" name="tasks[0][due_date]"
                                        class="mt-1 w-full border-gray-300 rounded-md focus:ring-cyan-800 focus:border-cyan-800 px-2 py-1">
                                    <label for="due-time-input"
                                        class="text-sm font-medium text-gray-600 block mt-3">Time</label>
                                    <input type="time" id="due-time-input" name="tasks[0][due_time]"
                                        class="mt-1 w-full border-gray-300 rounded-md focus:ring-cyan-800 focus:border-cyan-800 px-2 py-1">
                                    <button type="button"
                                        class="mt-4 px-4 py-2 bg-cyan-800 text-white rounded-md hover:bg-cyan-900 transition w-full"
                                        onclick="saveDueDate()">Set</button>
                                </div>
                            </div>
                            <!-- Priority Dropdown -->
                            <div class="relative">
                                <button type="button" id="priority-button"
                                    class="flex items-center p-2 rounded-full hover:bg-gray-100"
                                    onclick="toggleDropdown('priority-dropdown')" title="Set Priority">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927a1 1 0 011.902 0l1.286 3.957h4.191a1 1 0 01.592 1.806l-3.396 2.47 1.286 3.956a1 1 0 01-1.535 1.151L10 13.011l-3.375 2.256a1 1 0 01-1.535-1.151l1.286-3.956-3.396-2.47a1 1 0 01.592-1.806h4.191L9.05 2.927z" />
                                    </svg>
                                </button>
                                <div id="priority-dropdown"
                                    class="absolute hidden bg-white shadow-md rounded-md mt-2 p-4 z-10 w-48">
                                    <p class="block text-sm font-medium text-gray-700 mb-2">Set Priority:</p>
                                    <ul class="space-y-2">
                                        <li>
                                            <button type="button"
                                                class="w-full text-left px-4 py-2 rounded-md hover:bg-cyan-100 text-gray-800"
                                                onclick="setPriority('High')">High</button>
                                        </li>
                                        <li>
                                            <button type="button"
                                                class="w-full text-left px-4 py-2 rounded-md hover:bg-cyan-100 text-gray-800"
                                                onclick="setPriority('Medium')">Medium</button>
                                        </li>
                                        <li>
                                            <button type="button"
                                                class="w-full text-left px-4 py-2 rounded-md hover:bg-cyan-100 text-gray-800"
                                                onclick="setPriority('Low')">Low</button>
                                        </li>
                                    </ul>
                                </div>
                                <input type="hidden" id="priority-input" name="tasks[0][priority]" value="">
                            </div>
                            <!-- checklist button -->
                            <div class="relative">
                                <button type="button" class="flex items-center p-2 rounded-full hover:bg-gray-100"
                                    onclick="addChecklistItem()" title="New List">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit"
                            class="px-4 py-2 bg-cyan-800 text-white rounded-md hover:bg-cyan-900 transition">
                            Save
                        </button>
                    </div>
                </form>
            </div>
            <div class="bg-white rounded-2xl p-8 mx-auto space-y-2 relative mt-3">
                <div id="tasks-container" class="grid grid-cols-3 gap-5">
                    @foreach ($tasks as $task)
                        <a href="{{ route('task.view', ['id' => $task->id]) }}"
                            class="border border-zinc-500/20 rounded-lg p-4 cursor-pointer bg-gradient-to-r from-cyan-100 to-blue-100 hover:shadow-lg transition-shadow duration-300 group">
                            <div class="flex items-center justify-between">
                                <h3 class="text-medium text-lg font-semibold text-cyan-800">{{ $task->name }}</h3>
                                <p
                                    class="text-[12px] text-medium text-cyan-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    {{ $task->status }}
                                </p>
                            </div>
                            <p class="text-sm text-large text-gray-600 mt-2">{{ Str::limit($task->description, 50) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endsection
</body>

<script>
    let checklistCounter = 0;

    function autoExpand(textarea) {
        // Reset the height to calculate the new height properly
        textarea.style.height = "auto";

        // Adjust the height based on the scroll height
        textarea.style.height = textarea.scrollHeight + "px";
    }

    function addChecklistItem() {
        const checklistContainer = document.getElementById('checklist-container');
        const checklistItem = document.createElement('div');
        checklistItem.classList.add('flex', 'items-center', 'gap-2', 'mt-3');
        checklistItem.innerHTML = `
            <input 
                type="text" 
                name="tasks[0][checklist][${checklistCounter}][name]" 
                class="flex-1 border-b py-2 focus:outline-none placeholder-gray-500"
                placeholder="List item">
            <button 
                type="button" 
                class="text-red-500 hover:text-red-700" 
                onclick="this.parentElement.remove()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        `;
        checklistContainer.appendChild(checklistItem);
        checklistCounter++;
    }

    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        dropdown.classList.toggle('hidden');
        if (!dropdown.classList.contains('hidden')) {
            document.addEventListener('click', outsideClickHandler);
        } else {
            document.removeEventListener('click', outsideClickHandler);
        }
    }

    // Close dropdown when clicking outside
    function outsideClickHandler(event) {
        const dueDateDropdown = document.getElementById('due-date-dropdown');
        const dueDateButton = document.getElementById('due-date-button');
        const priorityDropdown = document.getElementById('priority-dropdown');
        const priorityButton = document.getElementById('priority-button');

        if (!dueDateDropdown.contains(event.target) && !dueDateButton.contains(event.target)) {
            dueDateDropdown.classList.add('hidden');
        }
        if (!priorityDropdown.contains(event.target) && !priorityButton.contains(event.target)) {
            priorityDropdown.classList.add('hidden');
        }
    }

    // Save due date and time
    function saveDueDate() {
        const date = document.getElementById('due-date-input').value;
        const time = document.getElementById('due-time-input').value;
        alert(`Due Date: ${date}\nDue Time: ${time}`);
        toggleDropdown('due-date-dropdown');
    }
</script>

</html>
