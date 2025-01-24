@extends('layout.PmsTheme')
<link rel="stylesheet" href="/storage/css/dist/addproject.css">
@section('title', 'Create Project | DoListify: Build and manage your project team')
@section('content')
    <div id="main-content" class="main-content px-2">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl relative" role="alert">
                <strong class="font-bold">Whoops!</strong>
                <span class="block sm:inline">There were some problems with your input.</span>
                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="rounded-2xl pb-5 space-y-3">
            <form action="{{ route('projects.storeTeam') }}" method="POST" class="space-y-4">
                @csrf
                <div class="bg-white px-8  rounded-2xl p-5 shadow-md">
                    <div>
                        <label for="title" class="hidden">Project Title</label>
                        <input type="text" id="title" placeholder="Project Title (Required)" name="title"
                            class="w-full text-[32px] text-large border-b border-cyan-800/30 pb-2 focus:outline-none focus:border-cyan-800 placeholder-slate-400"
                            required>
                    </div>

                    <div>
                        <label for="description" class="hidden">Description</label>
                        <textarea id="description" name="description" placeholder="Add Project Description..."
                            class="w-full mt-2 border-b border-cyan-800/30 focus:outline-none text-medium  focus:border-cyan-800 placeholder:text-normal placeholder:text-sm placeholder:text-md placeholder:text-slate-400 scrollbar-thin  "
                            style="max-height: 200px; resize: none;" oninput="autoExpand(this)"required></textarea>
                    </div>

                    <div class="hidden">
                        <label for="type">Project Type</label>
                        <select id="type" name="type" required>
                            <option value="team">Team</option>
                            <option value="personal">Personal</option>
                        </select>
                    </div>
                </div>
                <!-- Task Section -->
                <div id="task-container" >
                    <!-- Task Input Template -->
                    <div class="task-input bg-white px-8  rounded-2xl p-5 shadow-md">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label for="task-name" class="text-[12px] text-cyan-700 text-medium">Task Name<span
                                        class="text-red-400">
                                        *</span></label>
                                <input type="text" name="tasks[0][name]"
                                    class="border-b p-2 text-medium error-prone border-cyan-800/30 placeholder:text-normal placeholder:text-sm placeholder:text-slate-400 focus:outline-none w-full"
                                    placeholder="What needs to be accomplished?" required>
                            </div>
                            <div>
                                <label for="task-assignee" class="text-[12px] text-cyan-700 text-medium">Assignee<span
                                        class="text-red-400"> *</span></label>
                                <input type="email" name="tasks[0][assignee]" id="task-assignee-1"
                                    class="p-2 border-b text-medium text-slate-400 assignee-input placeholder:text-normal border-cyan-800/30 placeholder:text-sm placeholder:text-slate-400 focus:outline-none w-full"
                                    placeholder="Start typing to search for a member..." autocomplete="off" required>
                                <ul id="suggestions" class="list-group"
                                    style="display:none; border: 1px solid #ccc; position: absolute;"></ul>
                            </div>
                        </div>
                        <div>
                            <label for="task-description" class="text-[12px] text-cyan-700 text-medium">Description<span
                                    class="text-red-400"> *</span></label>
                            <textarea name="tasks[0][description]" required
                                class="w-full mt-2 border-b border-cyan-800/30 text-medium  resize-none focus:border-cyan-800 placeholder:text-normal placeholder:text-sm placeholder:text-md placeholder:text-slate-400 focus:outline-none scrollbar-thin"
                                placeholder="Add detailed instructions or notes for clarity." oninput="autoExpand(this)"></textarea>
                        </div>

                        <div class="flex space-x-3 mt-3">
                            <!-- Due Date -->
                            <div class="flex">
                                <div class="flex items-center">
                                    <button type="button" id="due-date-button"
                                        class="flex items-center p-2 rounded-full hover:bg-gray-100 border {{ $errors->has('tasks.0.name') ? 'border-red-500' : '' }}"
                                        onclick="toggleDropdown('due-date-dropdown')" title="Specify Due Date">
                                        <img src="{{ asset('/storage/icons/duedate.svg') }}" alt="label icon">
                                    </button>
                                    <span id="due-date-display" class="ml-2 text-xs text-medium text-cyan-800">Set Due
                                        Date</span>
                                </div>
                                <div id="due-date-dropdown"
                                    class="dropdown absolute hidden bg-white shadow-md rounded-md mt-2 p-4 z-10 w-64">
                                    <p class="block text-sm font-medium text-gray-700 mb-2">Set Due Date & Time:</p>
                                    <label for="due-date-input" class="text-sm text-medium text-cyan-800">Date</label>
                                    <input type="date" id="due-date-input" name="tasks[0][due_date]"
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none" required>
                                    <label for="due-date-input" class="text-sm text-medium text-cyan-800">Time</label>
                                    <input type="time" id="due-date-input" name="tasks[0][due_date]"
                                        class="w-full p-2 border border-gray-300 rounded-md focus:outline-none " required>
                                    <button type="button"
                                        class="mt-4 px-6 py-2 bg-cyan-800 text-white rounded-md hover:bg-cyan-900 transition-all"
                                        onclick="saveDueDate()">Set</button>
                                </div>
                            </div>
                            <!-- Priority -->
                            <div class="relative" id="priority-container">
                                <div class="flex items-center">
                                    <button type="button" id="priority-button"
                                        class="flex items-center p-2 rounded-full hover:bg-gray-100 border {{ $errors->has('tasks.0.name') ? 'border-red-500' : '' }}"
                                        onclick="toggleDropdown('priority-dropdown')" title="Assign Priority">
                                        <img src="{{ asset('/storage/icons/priority.svg') }}" alt="label icon">
                                    </button>
                                    <span id="priority-display"
                                        class="ml-2 text-xs text-medium text-cyan-800">Priority</span>
                                    <input type="text" id="priority-input" name="tasks[0][priority]" class="hidden"
                                        value="">
                                </div>
                                <div id="priority-dropdown"
                                    class="dropdown absolute hidden bg-white shadow-md rounded-md mt-2 p-4 z-10 w-48">
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
                            </div>
                            <!-- Points -->
                            <div class="relative">
                                <div class="flex items-center">
                                    <button type="button"
                                        class="flex border items-center p-2 rounded-full hover:bg-gray-100 {{ $errors->has('tasks.0.name') ? 'border-red-500' : '' }}"
                                        onclick="openPointsModal()" title="Specify Required Points">
                                        <img src="{{ asset('/storage/icons/points.svg') }}" alt="label icon">
                                    </button>
                                    <span id="points-display" class="ml-2 text-medium text-cyan-800">Set Points</span>
                                    <input type="number" id="points-input" name="tasks[0][points]" class="hidden"
                                        value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Button to Add New Task -->
                <button type="button" id="add-task">Add Another Task</button>
                <button type="submit">Create Project</button>
            </form>
        </div>
    </div>
    <div id="points-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white p-6 rounded-md shadow-lg w-1/3 animate-appear">
            <h2 class="text-lg text-large text-teal-800">Enter Required Points</h2>
            <div class="mt-4">
                <label for="points-input" class="block text-sm font-medium text-gray-600">Points</label>
                <input type="number" id="points-input" name="points" min="1"
                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500"
                    placeholder="Enter points">
            </div>
            <div class="mt-4 flex justify-end space-x-2">
                <button type="button" onclick="closePointsModal()"
                    class="px-4 py-2 bg-gray-300 rounded-md">Cancel</button>
                <button type="button" onclick="savePoints()"
                    class="px-4 py-2 bg-cyan-800 text-white rounded-md">Save</button>
            </div>
        </div>
    </div>
    <script>
        function autoExpand(textarea) {
            // Reset the height to calculate the new height properly
            textarea.style.height = "auto";
            // Adjust the height based on the scroll height
            textarea.style.height = textarea.scrollHeight + "px";
        }

        let taskCount = 1;

        // Add task input dynamically
        document.getElementById('add-task').addEventListener('click', function() {
            const taskContainer = document.getElementById('task-container');
            const newTaskDiv = document.createElement('div');
            newTaskDiv.classList.add('task-input','bg-white', 'px-8',  'rounded-2xl', 'p-5', 'shadow-md');

            newTaskDiv.innerHTML = `
        <div>
            <label for="task-name">Task Name</label>
            <input type="text" name="tasks[${taskCount}][name]" required>
        </div>

        <div>
            <label for="task-description">Description</label>
            <textarea name="tasks[${taskCount}][description]" required></textarea>
        </div>

        <div>
            <label for="task-assignee-${taskCount}" class="form-label">Assignee (Email)</label>
            <input type="email" name="tasks[${taskCount}][assignee]" class="form-control" id="task-assignee-${taskCount}" required>
            <ul id="suggestions-${taskCount}" class="list-group" style="display:none; border: 1px solid #ccc; position: absolute;"></ul>
        </div>

        <div>
            <label for="task-due-time">Due Time</label>
            <input type="time" name="tasks[${taskCount}][due_time]" required>
        </div>

        <div>
            <label for="task-priority">Priority</label>
            <select name="tasks[${taskCount}][priority]" required>
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
            </select>
        </div>

        <div>
            <label for="task-points">Points</label>
            <input type="number" name="tasks[${taskCount}][points]" min="1" required>
        </div>

        <button type="button" class="remove-task">Remove Task</button>
    `;

            // Append the new task input to the container
            taskContainer.appendChild(newTaskDiv);

            // Add event listener for suggestions for the newly created task
            document.getElementById('task-assignee-' + taskCount).addEventListener('input', function() {
                const query = this.value;
                const suggestionsList = document.getElementById('suggestions-' + taskCount);

                if (query.length < 3) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                // Make AJAX call to search users by email
                fetch(`http://127.0.0.1:8000/api/search-users?query=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        suggestionsList.innerHTML = ''; // Clear previous suggestions

                        // Check if the response data is an array
                        if (Array.isArray(data)) {
                            if (data.length === 0) {
                                suggestionsList.innerHTML =
                                    '<li class="list-group-item">No users found</li>';
                            } else {
                                data.forEach(user => {
                                    const li = document.createElement('li');
                                    li.classList.add('list-group-item');
                                    li.textContent = user.email;
                                    li.addEventListener('click', function() {
                                        document.getElementById('task-assignee-' +
                                                taskCount)
                                            .value = user.email;
                                        suggestionsList.style.display = 'none';
                                    });
                                    suggestionsList.appendChild(li);
                                });
                            }
                        } else {
                            // If data is not an array, log it for debugging
                            console.error('Unexpected data format:', data);
                            suggestionsList.innerHTML =
                                '<li class="list-group-item">No users found</li>';
                        }

                        suggestionsList.style.display = 'block';
                    })
                    .catch(error => {
                        console.error('Error fetching user data:', error);
                        suggestionsList.innerHTML =
                            '<li class="list-group-item">Error fetching users</li>';
                        suggestionsList.style.display = 'block';
                    });
            });

            // Increment task count
            taskCount++;
        });

        // Remove task input
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-task')) {
                e.target.closest('.task-input').remove();
            }
        });

        // Hide suggestions when the user clicks outside the input
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.task-input')) {
                document.querySelectorAll('.list-group').forEach(function(suggestionList) {
                    suggestionList.style.display = 'none';
                });
            }
        });
    </script>
@endsection
