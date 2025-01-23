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
        <div id="main-content" class="main-content py-2 px-4 space-y-3">
            <div class="bg-white rounded-2xl shadow-lg p-8 mx-auto space-y-3 relative">
                @if ($errors->any())
                    <div class="p-4 mb-4 text-sm text-red-800 bg-red-50 rounded-lg">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Task Input Area -->
                <form id="completeForm" action="{{ route('addTask.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="personal">
                    <input type="hidden" name="created_by" value="{{ Auth::id() }}">
                    <input type="hidden" name="project_id" value="{{ request('project_id') }}">

                    <!-- Title Input -->
                    <input type="text" name="tasks[0][name]" placeholder="Title"
                        class="w-full text-xl text-large border-b border-cyan-800/30 focus:outline-none focus:border-cyan-800 placeholder-gray-500"
                        required>
                    <!--Text Area -->
                    <textarea id="text-desc" name="tasks[0][description]" placeholder="Take a note..."
                        class="w-full mt-2 border-b text-medium text-lg border-cyan-800/30 resize-none focus:outline-none focus:border-cyan-800 placeholder:text-medium placeholder:text-lg placeholder:text-slate-400 overflow-hidden"
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
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" class="g">
                                        <path
                                            d="M2 9C2 7.11438 2 6.17157 2.58579 5.58579C3.17157 5 4.11438 5 6 5H18C19.8856 5 20.8284 5 21.4142 5.58579C22 6.17157 22 7.11438 22 9C22 9.4714 22 9.70711 21.8536 9.85355C21.7071 10 21.4714 10 21 10H3C2.5286 10 2.29289 10 2.14645 9.85355C2 9.70711 2 9.4714 2 9Z"
                                            fill="#0e7490" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M2.58579 21.4142C2 20.8284 2 19.8856 2 18V13C2 12.5286 2 12.2929 2.14645 12.1464C2.29289 12 2.5286 12 3 12H21C21.4714 12 21.7071 12 21.8536 12.1464C22 12.2929 22 12.5286 22 13V18C22 19.8856 22 20.8284 21.4142 21.4142C20.8284 22 19.8856 22 18 22H6C4.11438 22 3.17157 22 2.58579 21.4142ZM8 16C7.44772 16 7 16.4477 7 17C7 17.5523 7.44772 18 8 18H16C16.5523 18 17 17.5523 17 17C17 16.4477 16.5523 16 16 16H8Z"
                                            fill="#0e7490" />
                                        <path d="M7 3L7 6" stroke="#0e7490" stroke-width="2" stroke-linecap="round" />
                                        <path d="M17 3L17 6" stroke="#0e7490" stroke-width="2" stroke-linecap="round" />
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
                                <input type="text" id="priority-display" class="hidden" value="">
                                <button type="button" id="priority-button"
                                    class="flex items-center p-2 rounded-full hover:bg-gray-100"
                                    onclick="toggleDropdown('priority-dropdown')" title="Set Priority">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M14.6358 3.90949C15.2888 3.47412 15.6153 3.25643 15.9711 3.29166C16.3269 3.32689 16.6044 3.60439 17.1594 4.15938L19.8406 6.84062C20.3956 7.39561 20.6731 7.67311 20.7083 8.02888C20.7436 8.38465 20.5259 8.71118 20.0905 9.36424L18.4419 11.8372C17.88 12.68 17.5991 13.1013 17.3749 13.5511C17.2086 13.8845 17.0659 14.2292 16.9476 14.5825C16.7882 15.0591 16.6889 15.5557 16.4902 16.5489L16.2992 17.5038C16.2986 17.5072 16.2982 17.5089 16.298 17.5101C16.1556 18.213 15.3414 18.5419 14.7508 18.1351C14.7497 18.1344 14.7483 18.1334 14.7455 18.1315C14.7322 18.1223 14.7255 18.1177 14.7189 18.1131C11.2692 15.7225 8.27754 12.7308 5.88691 9.28108C5.88233 9.27448 5.87772 9.26782 5.86851 9.25451C5.86655 9.25169 5.86558 9.25028 5.86486 9.24924C5.45815 8.65858 5.78704 7.84444 6.4899 7.70202C6.49113 7.70177 6.49282 7.70144 6.49618 7.70076L7.45114 7.50977C8.44433 7.31113 8.94092 7.21182 9.4175 7.05236C9.77083 6.93415 10.1155 6.79139 10.4489 6.62514C10.8987 6.40089 11.32 6.11998 12.1628 5.55815L14.6358 3.90949Z"
                                            fill="#14b8a6" stroke="#14b8a6" stroke-width="2" />
                                        <path d="M5 19L9.5 14.5" stroke="#083344" stroke-width="2"
                                            stroke-linecap="round" />
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
                                        viewBox="0 0 24 24" stroke="#4338ca" stroke-width="2">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="text-right mt-2">
                <button type="button" onclick="openPersnoalTaskModal()"
                    class="w-full p-4 bg-cyan-950 text-white text-medium text-[16px] rounded-xl hover:bg-cyan-900 transition-all flex items-center justify-center gap-2">
                    Create Project
                </button>
            </div>
        </div>
        <div id="savePersonalTaskModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 hidden items-center justify-center">
            <div class="bg-white p-8 rounded-2xl shadow-lg max-w-md mx-auto animate-appear">
                <h3 class="text-xl font-bold mb-4">Confirm Name Update</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to update your name?</p>
                <div class="flex justify-end gap-4">
                    <button onclick="hidePersonalTaskModal()"
                        class="px-4 py-2 rounded-lg text-gray-600 transition-all hover:bg-gray-200">
                        Cancel
                    </button>
                    <button onclick="submitPersonalTaskModal"
                        class="px-4 py-2 rounded-lg bg-cyan-700 text-white hover:bg-cyan-600">
                        Confirm
                    </button>
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

    function openPersnoalTaskModal() {
        const modal = document.getElementById('savePersonalTaskModal').style.display = 'flex';
    }
    function hidePersonalTaskModal() {
        const modal = document.getElementById('savePersonalTaskModal').style.display = 'none';
    }
    function submitPersonalTaskModal() {
        document.getElementById('completeForm').submit();
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

    // Set the selected priority and update the hidden input field
    function setPriority(priority) {
        // Update the button text or icon
        const button = document.getElementById('priority-button');
        const inputField = document.getElementById('priority-input');

        button.innerHTML = `
            <span class="text-medium text-gray-800">${priority}</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600"
                viewBox="0 0 20 20" fill="currentColor">
                <path d="M9.049 2.927a1 1 0 011.902 0l1.286 3.957h4.191a1 1 0 01.592 1.806l-3.396 2.47 1.286 3.956a1 1 0 01-1.535 1.151L10 13.011l-3.375 2.256a1 1 0 01-1.535-1.151l1.286-3.956-3.396-2.47a1 1 0 01.592-1.806h4.191L9.05 2.927z" />
            </svg>
        `;

        // Set the hidden input value
        inputField.value = priority;

        // Close the dropdown
        toggleDropdown('priority-dropdown');
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
