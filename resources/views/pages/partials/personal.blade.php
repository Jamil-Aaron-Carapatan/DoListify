<form id="completeForm" action="{{ route('addProject.post') }}" method="POST" class="space-y-4">
    @csrf
    <input type="hidden" name="type" value="personal">

    <div class="mb-4 mt-2">
        <label class="labels">Project Title <span class="asterisk">*</span></label>
        <input type="text" name="title" required class="inputTitle required-field" placeholder="Give your project a name">
        @error('title')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div id="personalTasks">
        <div class="task-item">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="labels">Task Name <span class="asterisk">*</span></label>
                    <input type="text" name="tasks[0][name]"
                        class="required-field fields error-prone @error('title') border-red-500 @enderror"
                        placeholder="What needs to be done?">
                    @error('tasks.*.name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="labels">Due Date <span class="asterisk">*</span></label>
                        <input type="date" name="tasks[0][due_date]"
                            class="required-field fields text-zinc-400 focus:text-black error-prone @error('tasks.*.due_date') border-red-500 @enderror" oninput="this.classList.remove('text-zinc-400'); this.classList.add('text-black');">
                        @error('tasks.*.due_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="labels">Time <span class="asterisk">*</span></label>
                        <input type="time" name="tasks[0][due_time]"
                            class="required-field fields text-zinc-400 focus:text-black error-prone @error('tasks.*.due_time') border-red-500 @enderror"  oninput="this.classList.remove('text-zinc-400'); this.classList.add('text-black');">
                        @error('tasks.*.due_time')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="labels">Description </label>
                    <textarea name="tasks[0][description]" class="fields"
                        placeholder="Add some details..."></textarea>
                </div>

                <div>
                    <label class="labels">Priority Level <span class="asterisk">*</span> </label>
                    <select name="tasks[0][priority]"
                        class="required-field fields text-zinc-400 error-prone @error('tasks.*.priority') border-red-500 @enderror" onchange="this.classList.remove('text-zinc-400'); this.classList.add('text-black');">
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
    <!-- Submit Button -->
    <div class="text-right">
        <button type="submit" class="px-8 py-3 bg-cyan-800 opacity-50 text-white rounded-lg transition-all cursor-not-allowed" disabled>
            Create Project
        </button>
    </div>
</form>
<script src="/storage/js/personal.js"></script>
