<form id="teamCompleteForm" action="{{ route('addProject.post') }}" method="POST" class="space-y-4">
    @csrf
    <input type="hidden" name="type" value="team">
    <div class="flex justify-center">
        <button type="button" id="addTeamMembersBtn"
            class="w-full p-4 bg-zinc-300/80 text-gray-700 rounded-lg hover:text-cyan-800 transition-all flex items-center justify-center gap-2">
            <i class="fas fa-users"></i>
            Add Team Members
        </button>
    </div>
    <!-- Title -->
    <div class="mb-4">
        <label class="labels">Project Title <span class="asterisk">*</span></label>
        <input type="text" name="title" required class="inputTitle" placeholder="Give your project a name">
        @error('title')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <!-- Team Tasks -->
    <div id="teamTasks" class="space-y-4">
        <div class="task-item">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Task Name -->
                <div>
                    <label class="labels">Task Name <span class="asterisk">*</span></label>
                    <input type="text" name="tasks[0][name]"
                        class="required-field fields error-prone @error('tasks.*.name') border-red-500 @enderror"
                        placeholder="What needs to be done?">
                    @error('task.*.name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Assignee -->
                <div>
                    <label class="labels">Assignee <span class="asterisk">*</span></label>
                    <select name="tasks[0][assignee]"
                        class="required-field fields text-zinc-400 assignee-select error-prone @error('tasks.*.assignee') border-red-500 @enderror">
                        <!-- Options will be populated dynamically -->
                        <option value="" disabled selected>Select Assignee
                        </option>
                    </select>
                    @error('tasks.*.assignee')
                        <span class="text-red-500 text-sm">{{ $message }} </span>
                    @enderror
                </div>
            </div>
            <!-- Due Date & Time -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="labels">Due Date <span class="asterisk">*</span></label>
                    <input type="date" name="tasks[0][due_date]"
                        class="required-field fields text-zinc-400 focus:text-black error-prone @error('tasks.*.due_date') border-red-500 @enderror"
                        oninput="this.classList.remove('text-zinc-400'); this.classList.add('text-black');">
                    @error('tasks.*.due_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="labels">Time <span class="asterisk">*</span></label>
                    <input type="time" name="tasks[0][due_time]"
                        class="required-field fields text-zinc-400 focus:text-black error-prone @error('tasks.*.due_time') border-red-500 @enderror"
                        oninput="this.classList.remove('text-zinc-400'); this.classList.add('text-black');">
                    @error('tasks.*.due_time')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!-- Description -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="labels">Description </label>
                    <textarea name="tasks[0][description]" class="fields" placeholder="Add some details..."></textarea>
                </div>

                <div>
                    <label class="labels">Priority Level <span class="asterisk">*</span> </label>
                    <select name="tasks[0][priority]"
                        class="required-field fields text-zinc-400 error-prone @error('tasks.*.priority') border-red-500 @enderror"
                        onchange="this.classList.remove('text-zinc-400'); this.classList.add('text-black');">
                        <option value="" disabled selected>Select Priority Level
                        </option>
                        <option value="High">High</option>
                        <option value="Medium">Medium</option>
                        <option value="Low">Low</option>
                    </select>
                    @error('tasks.*.priority')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <button type="button" id="addTaskBtn"
        class="w-full p-4 bg-zinc-300/80 text-gray-700 rounded-lg hover:bg-violet-200 transition-all flex items-center justify-center gap-2">
        <i class="fas fa-plus-circle"></i>
        Add Another Task
    </button>
    <div class="text-right">
        <button type="submit" class="px-8 py-3 bg-cyan-800 opacity-50 text-white rounded-lg transition-all cursor-not-allowed" disabled>
            Create Project
        </button>
    </div>
</form>

<!-- Team Members Modal -->
<div id="peopleModal" class="fixed inset-0 bg-black/50 items-center justify-center hidden z-50">
    <div
        class="bg-white px-4 sm:px-8 py-5 rounded-lg w-[95%] sm:w-[80%] md:w-[60%] lg:w-[500px] absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4 sm:mb-6">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">Add Team Members</h2>
        </div>

        <div id="emailInputsContainer" class="email-input-container space-y-3 sm:space-y-4">
            <div class="email-input-container relative">
                <div class="relative">
                    <input type="email" name="team_members[]"
                        class="w-full p-2.5 sm:p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-sm sm:text-base"
                        placeholder="Enter team member's email">
                </div>
                <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
            </div>
        </div>

        <button onclick="addEmailInput()"
            class="mt-4 sm:mt-6 mb-6 sm:mb-8 w-full p-2.5 sm:p-3 bg-zinc-300/90 text-gray-700 rounded-lg hover:bg-gray-400 transition-all flex items-center justify-center gap-2 text-sm sm:text-base"
            id="addEmailInputBtn">
            <i class="fas fa-plus"></i>
            Add Another Email
        </button>

        <div class="flex justify-end gap-2 sm:gap-3">
            <button onclick="closePeopleModal()"
                class="px-4 sm:px-6 py-2 sm:py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all text-sm sm:text-base">
                Cancel
            </button>
            <button onclick="saveTeamMembers()" id="saveTeamMembersBtn"
                class="px-4 sm:px-6 py-2 sm:py-2.5 bg-cyan-800 text-white rounded-lg hover:bg-cyan-800 transition-all text-sm sm:text-base cursor-not-allowed">
                Add Members
            </button>
        </div>
    </div>
</div>
<script src="/storage/js/team.js"></script>
