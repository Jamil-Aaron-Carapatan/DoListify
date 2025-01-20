<form id="completeForm" action="{{ route('addProject.post') }}" method="POST" class="bg-white rounded-2xl p-4 shadow-md">
    @csrf
    <input type="hidden" name="type" value="personal">
    <div id="personalTasks" class="">
        <div class="task-item">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="labels text-medium">Task Name <span class="asterisk">*</span></label>
                    <input type="text" name="tasks[0][name]"
                        class="required-field fields error-prone @error('title') border-red-500 @enderror placeholder:text-medium placeholder:text-slate-400"
                        placeholder="What needs to be done?">
                    @error('tasks.*.name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="labels text-medium">Due Date <span class="asterisk">*</span></label>
                        <input type="date" name="tasks[0][due_date]"
                            class="required-field fields text-medium text-slate-400  focus:text-black error-prone @error('tasks.*.due_date') border-red-500 @enderror placeholder:text-medium placeholder:text-slate-400" oninput="this.classList.remove('text-slate-400'); this.classList.add('text-black');">
                        @error('tasks.*.due_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="labels text-medium">Time <span class="asterisk">*</span></label>
                        <input type="time" name="tasks[0][due_time]"
                            class="required-field fields text-medium text-slate-400  focus:text-black error-prone @error('tasks.*.due_time') border-red-500 @enderror placeholder:text-medium placeholder:text-slate-400"  oninput="this.classList.remove('text-slate-400'); this.classList.add('text-black');">
                        @error('tasks.*.due_time')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="labels text-medium">Description </label>
                    <textarea name="tasks[0][description]" class="fields placeholder:text-medium placeholder:text-slate-400"
                        placeholder="Add some details..."></textarea>
                </div>

                <div>
                    <label class="labels text-medium">Priority Level <span class="asterisk">*</span> </label>
                    <select name="tasks[0][priority]"
                        class="required-field fields text-medium text-slate-400 error-prone @error('tasks.*.priority') border-red-500 @enderror " onchange="this.classList.remove('text-zinc-400'); this.classList.add('text-black');">
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
