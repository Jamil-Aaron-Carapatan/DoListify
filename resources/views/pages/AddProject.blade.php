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
            <form id="teamCompleteForm" action="{{ route('projects.storeTeam') }}" method="POST" class="space-y-4">
                @csrf
                <div class="bg-white px-8  rounded-2xl p-5 shadow-md">
                    <input type="text" name="tasks[0][name]" placeholder="Project Title (Required)"
                        class="w-full text-[32px] text-large border-b border-cyan-800/30 pb-2 focus:outline-none focus:border-cyan-800 placeholder-slate-400"
                        id="teamTasks">
                    <textarea id="text-desc" name="project[0][description]" placeholder="Add Project Description..."
                        class="w-full mt-2 border-b border-cyan-800/30 focus:outline-none text-medium  focus:border-cyan-800 placeholder:text-normal placeholder:text-sm placeholder:text-md placeholder:text-slate-400 scrollbar-thin"
                        style="max-height: 200px; resize: none;" oninput="autoExpand(this)"></textarea>
                </div>
                <div id="task-container" class="bg-white rounded-2xl p-4 task-item space-y-2">
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <!-- Task Name -->
                        <div>
                            <label for="tasks[0][name]" class="text-[12px] text-cyan-700 text-medium">Task Name<span
                                    class="text-red-400">
                                    *</span></label>
                            <input type="text" name="tasks[0][name]"
                                class="border-b p-2 text-medium error-prone border-cyan-800/30 placeholder:text-normal placeholder:text-sm placeholder:text-slate-400 focus:outline-none w-full"
                                placeholder="What needs to be accomplished?">
                            @error('task.*.name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Assignee -->
                        <div class="relative">
                            <label for="tasks[0][assignee]" class="text-[12px] text-cyan-700 text-medium">
                                Assignee<span class="text-red-400"> *</span>
                            </label>
                            <input type="text" name="tasks[0][assignee]" id="assignee-input"
                                class="p-2 border-b text-medium text-slate-400 assignee-input placeholder:text-normal border-cyan-800/30 placeholder:text-sm placeholder:text-slate-400 focus:outline-none w-full"
                                placeholder="Start typing to search for a member..." autocomplete="off">

                            <!-- Suggestions Dropdown -->
                            <ul id="assignee-suggestions"
                                class="absolute bg-white border border-gray-300 shadow-md rounded-md w-full hidden max-h-48 overflow-y-auto z-10">
                                <!-- Suggestions will be dynamically inserted here -->
                            </ul>
                        </div>
                    </div>
                    <!-- Description -->
                    <div>
                        <label for="tasks[0][description]" class="text-[12px] text-cyan-700 text-medium">Description<span
                                class="text-red-400"> *</span></label>
                        <textarea name="tasks[0][description]"
                            class="w-full mt-2 border-b border-cyan-800/30 text-medium  resize-none focus:border-cyan-800 placeholder:text-normal placeholder:text-sm placeholder:text-md placeholder:text-slate-400 focus:outline-none scrollbar-thin"
                            placeholder="Add detailed instructions or notes for clarity." oninput="autoExpand(this)"></textarea>
                    </div>
                    <!-- Icon Buttons -->
                    <div class="flex items-center justify-between mt-6">
                        <div class="flex items-center gap-3">
                            <!--  date -->
                            <!-- Due Date Dropdown -->
                            <div class="relative" id="due-date-container">
                                <div class="flex items-center">
                                    <button type="button" id="due-date-button"
                                        class="flex items-center p-2 rounded-full hover:bg-gray-100 border {{ $errors->has('tasks.0.name') ? 'border-red-500' : '' }}"
                                        onclick="toggleDropdown('due-date-dropdown')" title="Specify Due Date">
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
                                    <span id="due-date-display" class="ml-2 text-medium text-cyan-800"></span>
                                </div>
                                <div id="due-date-dropdown"
                                    class="dropdown absolute hidden bg-white shadow-md rounded-md mt-2 p-4 z-10 w-64">
                                    <p class="block text-sm font-medium text-gray-700 mb-2">Set Due Date & Time:</p>
                                    <label for="due-date-input"
                                        class="text-sm border font-medium text-gray-600 block">Date</label>
                                    <input type="date" id="due-date-input" name="tasks[0][due_date]"
                                        class="mt-1 w-full border-gray-300 rounded-md focus:ring-cyan-800 focus:border-cyan-800 px-2 py-1">
                                    <label for="due-time-input"
                                        class="text-sm font-medium border text-gray-600 block mt-3">Time</label>
                                    <input type="time" id="due-time-input" name="tasks[0][due_time]"
                                        class="mt-1 w-full border-gray-300 rounded-md focus:ring-cyan-800 focus:border-cyan-800 px-2 py-1">
                                    <button type="button"
                                        class="mt-4 px-4 py-2 bg-cyan-800 text-white rounded-md hover:bg-cyan-900 transition w-full"
                                        onclick="saveDueDate()">Set</button>
                                </div>
                            </div>
                            <!-- Priority Dropdown -->
                            <div class="relative" id="priority-container">
                                <div class="flex items-center">
                                    <button type="button" id="priority-button"
                                        class="flex items-center p-2 rounded-full hover:bg-gray-100 border {{ $errors->has('tasks.0.name') ? 'border-red-500' : '' }}"
                                        onclick="toggleDropdown('priority-dropdown')" title="Assign Priority">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14.6358 3.90949C15.2888 3.47412 15.6153 3.25643 15.9711 3.29166C16.3269 3.32689 16.6044 3.60439 17.1594 4.15938L19.8406 6.84062C20.3956 7.39561 20.6731 7.67311 20.7083 8.02888C20.7436 8.38465 20.5259 8.71118 20.0905 9.36424L18.4419 11.8372C17.88 12.68 17.5991 13.1013 17.3749 13.5511C17.2086 13.8845 17.0659 14.2292 16.9476 14.5825C16.7882 15.0591 16.6889 15.5557 16.4902 16.5489L16.2992 17.5038C16.2986 17.5072 16.2982 17.5089 16.298 17.5101C16.1556 18.213 15.3414 18.5419 14.7508 18.1351C14.7497 18.1344 14.7483 18.1334 14.7455 18.1315C14.7322 18.1223 14.7255 18.1177 14.7189 18.1131C11.2692 15.7225 8.27754 12.7308 5.88691 9.28108C5.88233 9.27448 5.87772 9.26782 5.86851 9.25451C5.86655 9.25169 5.86558 9.25028 5.86486 9.24924C5.45815 8.65858 5.78704 7.84444 6.4899 7.70202C6.49113 7.70177 6.49282 7.70144 6.49618 7.70076L7.45114 7.50977C8.44433 7.31113 8.94092 7.21182 9.4175 7.05236C9.77083 6.93415 10.1155 6.79139 10.4489 6.62514C10.8987 6.40089 11.32 6.11998 12.1628 5.55815L14.6358 3.90949Z"
                                                fill="#14b8a6" stroke="#14b8a6" stroke-width="2" />
                                            <path d="M5 19L9.5 14.5" stroke="#083344" stroke-width="2"
                                                stroke-linecap="round" />
                                        </svg>
                                    </button>
                                    <span id="priority-display" class="ml-2 text-medium text-cyan-800"></span>
                                    <input type="text" id="priority-input" class="hidden" value="">
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
                            <!-- points -->
                            <div class="relative">
                                <div class="flex items-center">
                                    <button type="button"
                                        class="flex border items-center p-2 rounded-full hover:bg-gray-100 {{ $errors->has('tasks.0.name') ? 'border-red-500' : '' }}"
                                        onclick="openPointsModal()" title="Specify Required Points">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.3072 7.21991C10.9493 5.61922 11.2704 4.81888 11.7919 4.70796C11.9291 4.67879 12.0708 4.67879 12.208 4.70796C12.7295 4.81888 13.0506 5.61922 13.6927 7.21991C14.0578 8.13019 14.2404 8.58533 14.582 8.8949C14.6778 8.98173 14.7818 9.05906 14.8926 9.12581C15.2874 9.36378 15.7803 9.40793 16.7661 9.49621C18.4348 9.64566 19.2692 9.72039 19.524 10.1961C19.5768 10.2947 19.6127 10.4013 19.6302 10.5117C19.7146 11.0448 19.1012 11.6028 17.8744 12.7189L17.5338 13.0289C16.9602 13.5507 16.6735 13.8116 16.5076 14.1372C16.4081 14.3325 16.3414 14.5429 16.3101 14.7598C16.258 15.1215 16.342 15.5 16.5099 16.257L16.5699 16.5275C16.8711 17.885 17.0217 18.5637 16.8337 18.8974C16.6649 19.1971 16.3538 19.3889 16.0102 19.4053C15.6277 19.4236 15.0887 18.9844 14.0107 18.106C13.3005 17.5273 12.9454 17.2379 12.5512 17.1249C12.191 17.0216 11.8089 17.0216 11.4487 17.1249C11.0545 17.2379 10.6994 17.5273 9.98917 18.106C8.91119 18.9844 8.37221 19.4236 7.98968 19.4053C7.64609 19.3889 7.33504 19.1971 7.16617 18.8974C6.97818 18.5637 7.12878 17.885 7.42997 16.5275L7.48998 16.257C7.65794 15.5 7.74191 15.1215 7.6898 14.7598C7.65854 14.5429 7.59182 14.3325 7.49232 14.1372C7.32645 13.8116 7.03968 13.5507 6.46613 13.0289L6.12546 12.7189C4.89867 11.6028 4.28527 11.0448 4.36975 10.5117C4.38724 10.4013 4.42312 10.2947 4.47589 10.1961C4.73069 9.72039 5.56507 9.64566 7.23384 9.49621C8.21962 9.40793 8.71251 9.36378 9.10735 9.12581C9.2181 9.05906 9.32211 8.98173 9.41793 8.8949C9.75954 8.58533 9.94211 8.13019 10.3072 7.21991Z"
                                                fill="#059669" stroke="#059669" stroke-width="2" />
                                        </svg>
                                    </button>
                                    <span id="points-display" class="ml-2 text-medium text-cyan-800"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" id="addTaskBtn" onclick="addAnotherTask()"
                    class="w-full p-4 bg-cyan-800 text-white
                    text-medium text-[16px] rounded-xl hover:bg-cyan-900 transition-all flex items-center justify-center
                    gap-2">
                    <i class="fas fa-plus-circle"></i>
                    Add Another Task
                </button>
                <div class="text-right">
                    <button type="submit"
                        class="w-full p-4 bg-cyan-950 text-white text-medium text-[16px] rounded-xl hover:bg-cyan-900 transition-all flex items-center justify-center gap-2 ">
                        Create Project
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div id="assignee-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md animate-appear">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg text-large text-teal-800">Add Assignee</h3>
                <button type="button" onclick="closeAssigneeModal()" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div>
                <!-- Search Bar -->
                <input type="text" id="assignee-search" placeholder="Search for a member..."
                    class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
            </div>
            <div class="mt-4">
                <button type="button" onclick="addAssignee()"
                    class="w-full p-2 bg-cyan-800 text-white rounded-md hover:bg-cyan-900 transition">
                    Add Assignee
                </button>
            </div>
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
@endsection
<script src="/storage/js/team.js"></script>
