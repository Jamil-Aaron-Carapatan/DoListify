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
                    <input type="hidden" name="project_id" value="{{ $project_id ?? '' }}">

                    <!-- Title Input -->
                    <input type="text" name="tasks[0][name]" placeholder="Title"
                        class="w-full text-xl text-large border-b focus:outline-none focus:border-cyan-800 placeholder-gray-500"
                        required>
                    <!--Text Area -->
                    <textarea id="text-desc" name="tasks[0][description]" placeholder="Take a note..."
                        class="w-full mt-2 border-b text-medium text-lg focus:outline-none focus:border-cyan-800 placeholder:text-medium placeholder:text-lg placeholder:text-slate-400 overflow-hidden"
                        rows="3" style="max-height: 100px;" oninput="autoExpand(this)"></textarea>

                    <!-- Checklist -->
                    <div id="checklist-container" class="space-y-2 mt-3">

                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between mt-4">
                        <!-- Icon Buttons -->
                        <div class="flex items-center gap-3">
                            <!-- Due Date -->
                            <div class="relative">
                                <button type="button" class="flex items-center p-2 rounded-full hover:bg-gray-100"
                                    onclick="toggleDropdown('due-date-dropdown')" title="Set reminders">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 011 1v1h10V3a1 1 0 112 0v1h1a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h1V3a1 1 0 011-1zm0 5v14h12V7H6zm2 2a1 1 0 100 2h8a1 1 0 100-2H8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div id="due-date-dropdown"
                                    class="absolute hidden bg-white shadow-md rounded-md mt-2 p-3 z-10">
                                    <label class="block text-sm font-medium">Due Date:</label>
                                    <input type="date" name="tasks[0][due_date]"
                                        class="mt-1 w-full border-gray-300 rounded-md focus:ring-cyan-800 focus:border-cyan-800">
                                    <label class="block text-sm font-medium mt-2">Due Time:</label>
                                    <input type="time" name="tasks[0][due_time]"
                                        class="mt-1 w-full border-gray-300 rounded-md focus:ring-cyan-800 focus:border-cyan-800">
                                </div>

                            </div>

                            <!-- Priority -->
                            <div class="relative">
                                <button type="button" class="flex items-center p-2 rounded-full hover:bg-gray-100"
                                    onclick="toggleDropdown('priority-dropdown')" title="Set reminders">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927a1 1 0 011.902 0l1.286 3.957h4.191a1 1 0 01.592 1.806l-3.396 2.47 1.286 3.956a1 1 0 01-1.535 1.151L10 13.011l-3.375 2.256a1 1 0 01-1.535-1.151l1.286-3.956-3.396-2.47a1 1 0 01.592-1.806h4.191L9.05 2.927z" />
                                    </svg>
                                </button>
                                <div id="priority-dropdown"
                                    class="absolute hidden bg-white shadow-md rounded-md mt-2 p-3 z-10">
                                    <label class="block text-sm font-medium">Priority:</label>
                                    <select name="tasks[0][priority]"
                                        class="mt-1 w-full border-gray-300 rounded-md focus:ring-cyan-800 focus:border-cyan-800">
                                        <option value="High">High</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Low">Low</option>
                                    </select>
                                </div>
                            </div>
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
            <div class="bg-white rounded-2xl p-6 mx-auto space-y-2 relative mt-4 ">
                <div id="tasks-container" class="grid grid-cols-3 gap-5">
                    @foreach ($tasks as $task)
                        <div class="border border-zinc-500/20 rounded-lg p-4 cursor-pointer bg-gradient-to-r from-cyan-100 to-blue-100 hover:shadow-lg transition-shadow duration-300 group"
                            onclick="showTaskModal({{ $task->id }})">
                            <div class="flex items-center justify-between">
                                <h3 class="text-medium text-lg font-semibold text-cyan-800">{{ $task->name }}</h3>
                                <p
                                    class="text-sm text-large text-cyan-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    {{ $task->status }}
                                </p>
                            </div>
                            <p class="text-sm text-large text-gray-600 mt-2">{{ Str::limit($task->description, 50) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div id="task-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
            <div class="bg-white p-8 rounded-2xl shadow-lg max-w-md mx-auto animate-appear space-y-6">
                <form id="editTaskForm" method="POST" action="{{ route('updateTask') }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="task_id" id="task-id">

                    <!-- Task Title -->
                    <h3 id="task-title" class="text-2xl font-bold text-cyan-800">Task Title</h3>

                    <!-- Task Description -->
                    <p id="task-desc" name="description" class="text-gray-600">Task Description</p>

                    <!-- Checklist -->
                    <div class="space-y-3">
                        <h4 class="font-semibold text-lg">Checklist:</h4>
                        <div id="checklist-container" class="space-y-2">
                            <!-- Checklist items will be dynamically added here -->
                        </div>
                        <button type="button" onclick="addChecklistItem()"
                            class="text-cyan-700 hover:underline text-sm">
                            + Add Item
                        </button>
                    </div>

                    <!-- Status and Priority -->
                    <div class="flex justify-between items-center mt-4">
                        <p><strong>Status:</strong> <span id="task-status" class="text-gray-700">In Progress</span></p>
                        <p><strong>Priority:</strong> <span id="task-priority" class="text-gray-700">High</span></p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-4 mt-6">
                        <button type="button" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500"
                            onclick="closeTaskModal()">Close</button>
                        <button type="submit"
                            class="bg-cyan-800 text-white px-4 py-2 rounded hover:bg-cyan-700">Save</button>
                    </div>
                </form>
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
        checklistItem.classList.add('flex', 'items-center', 'gap-2', 'mt-2');
        checklistItem.innerHTML = `
            <input 
                type="text" 
                name="tasks[0][checklist][${checklistCounter}][name]" 
                class="flex-1 border-b focus:outline-none placeholder-gray-500"
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

        document.addEventListener('click', function(event) {
            if (!dropdown.contains(event.target) && !event.target.closest(
                    `[onclick="toggleDropdown('${id}')"]`)) {
                dropdown.classList.add('hidden');
            }
        }, {
            once: true
        });
    }

    function showTaskModal(taskId) {
        // Fetch the task data using Ajax
        fetch(`/tasks/${taskId}`)
            .then(response => response.json())
            .then(data => {
                // Populate the modal with task data
                document.getElementById('task-id').value = data.id;
                document.getElementById('task-title').textContent = data.name;
                document.getElementById('task-desc').textContent = data.description;

                // Populate checklist items
                const checklistContainer = document.getElementById('checklist-container');
                checklistContainer.innerHTML = ''; // Clear existing items
                data.checklist.forEach((item, index) => {
                    const checklistItem = document.createElement('div');
                    checklistItem.classList.add('flex', 'items-center', 'gap-2');
                    checklistItem.innerHTML = `
                    <input type="checkbox" 
                        name="checklist[${index}][completed]" 
                        ${item.completed ? 'checked' : ''} 
                        onchange="toggleChecklistItem(this)">
                    <input type="text" 
                        name="checklist[${index}][name]" 
                        value="${item.name}" 
                        class="flex-1 border-b focus:outline-none ${
                            item.completed ? 'line-through text-gray-500' : ''
                        }">
                    <button type="button" class="text-red-500 hover:text-red-700" onclick="this.parentElement.remove()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                `;
                    checklistContainer.appendChild(checklistItem);
                });

                // Populate status and priority
                document.getElementById('task-status').textContent = data.status || 'Not set';
                document.getElementById('task-priority').textContent = data.priority || 'None';

                // Show the modal
                document.getElementById('task-modal').style.display = 'flex';
            })
            .catch(error => {
                console.error('Error fetching task:', error);
            });
    }

    function closeTaskModal() {
        document.getElementById('task-modal').style.display = 'none';
    }

    function toggleChecklistItem(checkbox) {
        const textField = checkbox.nextElementSibling;
        if (checkbox.checked) {
            textField.classList.add('line-through', 'text-gray-500');
        } else {
            textField.classList.remove('line-through', 'text-gray-500');
        }
    }

    function addChecklistItem() {
        const checklistContainer = document.getElementById('checklist-container');
        const index = checklistContainer.children.length; // Get the new index
        const checklistItem = document.createElement('div');
        checklistItem.classList.add('flex', 'items-center', 'gap-2');
        checklistItem.innerHTML = `
        <input type="checkbox" 
            name="checklist[${index}][completed]" 
            onchange="toggleChecklistItem(this)">
        <input type="text" 
            name="checklist[${index}][name]" 
            placeholder="New item" 
            class="flex-1 border-b focus:outline-none">
        <button type="button" class="text-red-500 hover:text-red-700" onclick="this.parentElement.remove()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <path d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;
        checklistContainer.appendChild(checklistItem);
    }
</script>



</html>
