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
        <div id="main-content" class="main-content py-6 px-4">
            <div class="bg-white rounded-lg shadow-lg p-6 space-y-6">
                <!-- Form Header -->
                <div class="text-center">
                    <h2 class="text-xl font-bold text-cyan-800">Create a New Task</h2>
                    <p class="text-gray-600">Plan your tasks and set reminders to stay on track.</p>
                </div>
                <!-- Form -->
                <form id="completeForm" action="{{ route('addTask.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="personal">
                    <input type="hidden" name="project_id" value="{{ $project_id ?? '' }}">
                    <!-- Task Details -->
                    <div id="tasks-container" class="space-y-4">
                        <div class="task-item p-4 border rounded-lg">
                            <h3 class="font-semibold text-gray-800 mb-3">Task Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Task Name <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="tasks[0][name]"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-cyan-800 focus:border-cyan-800"
                                        placeholder="What needs to be done?" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Priority Level <span
                                            class="text-red-500">*</span></label>
                                    <select name="tasks[0][priority]"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-cyan-800 focus:border-cyan-800"
                                        required>
                                        <option value="" disabled selected>Select Priority</option>
                                        <option value="High">High</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Low">Low</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Due Date</label>
                                    <input type="date" name="tasks[0][due_date]"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-cyan-800 focus:border-cyan-800">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Due Time</label>
                                    <input type="time" name="tasks[0][due_time]"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-cyan-800 focus:border-cyan-800">
                                </div>
                            </div>
                        </div>

                        <!-- Checklist -->
                        <div class="checklist-item p-4 border rounded-lg">
                            <h3 class="font-semibold text-gray-800 mb-3">Checklist</h3>
                            <div id="checklist-items">
                                <div class="mb-2">
                                    <input type="text" name="tasks[0][checklist][0][name]"
                                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-cyan-800 focus:border-cyan-800"
                                        placeholder="Checklist Item">
                                </div>
                            </div>
                            <button type="button" class="mt-2 text-cyan-800 font-semibold hover:underline"
                                onclick="addChecklistItem()">+ Add Checklist Item</button>
                        </div>

                        <!-- Attachment -->
                        <div class="attachment-item p-4 border rounded-lg">
                            <h3 class="font-semibold text-gray-800 mb-3">Attachment</h3>
                            <input type="file" name="tasks[0][attachment]"
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-cyan-800 focus:border-cyan-800"
                                accept="image/*">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-right mt-6">
                        <button type="submit"
                            class="px-6 py-3 bg-cyan-800 text-white rounded-md hover:bg-cyan-900 transition">
                            Create Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endsection
</body>

<script>
    function addChecklistItem() {
        const checklistItems = document.getElementById('checklist-items');
        const newItem = document.createElement('div');
        newItem.classList.add('mb-2');
        newItem.innerHTML = `
            <input type="text" name="tasks[0][checklist][][name]" 
                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-cyan-800 focus:border-cyan-800" 
                placeholder="Checklist Item">
        `;
        checklistItems.appendChild(newItem);
    }
</script>

</html>
