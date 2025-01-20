<!-- Project Info Card -->
<div class="p-4 block lg:hidden">
    <div class="bg-gradient-to-br from-cyan-600 to-cyan-800 rounded-xl p-4 text-white space-y-4">
        <div class="flex items-center justify-between animate-fade-in">
            <h2 class="text-large text-3xl">{{ $project->title }}</h2>
            <span class="px-3 py-1 bg-cyan-800 rounded-full text-sm">{{ $project->type }}</span>
        </div>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <i class="fas fa-user"></i>
                    @if ($project->creator)
                        <span>Created by: {{ $project->creator->first_name }}
                            {{ $project->creator->last_name }}</span>
                    @else
                        <span>Created by: Unknown</span>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Due: {{ date('M d, Y', strtotime($project->tasks->first()->due_date ?? now())) }}</span>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <i class="fas fa-flag"></i>
                    <span>Priority: {{ $project->tasks->first()->priority ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-info-circle"></i>
                    <span>Status: {{ $project->tasks->first()->status ?? 'To Do' }}</span>
                </div>
                <span class="flex items-center">Team:
                    <div class="flex -space-x-3 ml-2">
                        @if ($project->members->count() > 0)
                            @foreach ($project->members as $member)
                                <div class="relative group">
                                    @if ($member->avatar)
                                        <!-- Show avatar if available -->
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                            alt="{{ $member->first_name }}'s Profile Picture"
                                            class="w-8 h-8 rounded-full object-cover border-2 border-white shadow-md cursor-pointer hover:z-10 transition-transform hover:scale-110">
                                    @else
                                        <!-- Fallback to initials if no avatar -->
                                        <div
                                            class="w-8 h-8 rounded-full {{ ['bg-cyan-800', 'bg-teal-800', 'bg-blue-800', 'bg-indigo-800', 'bg-purple-800'][array_rand(['bg-cyan-800', 'bg-teal-800', 'bg-blue-800', 'bg-indigo-800', 'bg-purple-800'])] }} text-white flex items-center justify-center font-bold cursor-pointer hover:z-10 transition-transform hover:scale-110">
                                            {{ strtoupper(substr($member->first_name, 0, 1)) }}{{ strtoupper(substr($member->last_name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <!-- Tooltip for member's full name -->
                                    <div
                                        class="absolute -top-8 left-1/2 -translate-x-1/2 bg-cyan-900 text-white px-2 py-1 rounded text-xs whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity z-20">
                                        {{ $member->first_name }} {{ $member->last_name }}
                                    </div>
                                </div>
                            @endforeach
                            @if ($project->members->count() > 5)
                                <div
                                    class="w-8 h-8 rounded-full bg-cyan-700 text-white flex items-center justify-center text-xs font-medium border-2 border-white">
                                    +{{ $project->members->count() - 5 }}
                                </div>
                            @endif
                        @else
                            <p class="text-gray-200 text-sm italic ml-2">No team members yet</p>
                        @endif
                    </div>
                </span>
            </div>
        </div>
    </div>
</div>
<div id="ViewTaskTeam" class="grid grid-cols-1 lg:grid-cols-5 gap-2 px-4 lg:p-4">
    <div class="col-span-3 space-y-2">
        <div class=" bg-cyan-900 rounded-2xl p-4 text-white min-h-[100vh-84px] flex flex-col">
            <div class="space-y-4 flex-grow">
                <!-- Task Header -->
                <div class="flex justify-between items-center border-b border-cyan-700 pb-4 animate-fade-in">
                    <h5 class="text-2xl text-large tracking-wide">{{ ucfirst($project->tasks->first()->name) }}</h5>
                    <div class="flex items-center gap-2 bg-cyan-700/50 px-4 py-2 rounded-lg whitespace-nowrap">
                        <i class="fas fa-star text-yellow-300"></i>
                        <span class="text-yellow-300 font-bold">+{{ $project->tasks->first()->points ?? 50 }}
                            pts</span>
                    </div>
                </div>

                <!-- Main Content -->
                <div>
                    <div class="flex">
                        <button onclick="switchTab('description')" id="descriptionTab"
                            class="w-auto px-4 text-normal text-black py-1.5 bg-white rounded-t-2xl"><i
                                class="fas fa-file-alt mr-2"></i>Description</button>
                        <button onclick="switchTab('attachment')" id="attachmentTab"
                            class="w-auto px-4 text-normal text-black py-1.5 bg-gray-200 rounded-t-2xl"><i
                                class="fas fa-paperclip mr-2"></i>Attachments</button>
                    </div>
                    <div id="descriptionCont" class="bg-white rounded-2xl rounded-tl-none p-4">
                        <div class="">
                            <div class="border rounded-md p-4 min-h-[200px] lg:min-h-[300]">
                                <p class="text-normal text-black">
                                    {{ $project->tasks->first()->description }}
                                </p>
                                @if (empty($project->tasks->first()->description))
                                    @php
                                        $motivationalMessages = [
                                            'Every task is a step toward success! Add a description to get started.',
                                            "Clear descriptions lead to better outcomes. What's your vision?",
                                            'The journey of a thousand miles begins with a single task description.',
                                            'Your goals are waiting! Define them with a great description.',
                                            'Organization is the key to success. Start with a task description!',
                                        ];
                                        $randomMessage = $motivationalMessages[array_rand($motivationalMessages)];
                                    @endphp
                                    <div
                                        class="flex flex-col items-center justify-center text-gray-500 min-h-[200px] lg:min-h-[300]">
                                        <i class="fas fa-lightbulb text-3xl mb-3 text-yellow-500 animate-pulse"></i>
                                        <p class="text-center italic">{{ $randomMessage }}</p>
                                        <p class="text-center text-sm">Hmm, it's a mystery... No description
                                            available!</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div id="attachmentCont" class="hidden bg-white rounded-2xl rounded-tl-none p-4">
                        <div class="">
                            <div class="border rounded-md p-4 min-h-[200px] lg:min-h-[300]">
                                <form method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    <div class="flex items-center justify-center w-full">
                                        <label
                                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <i class="fas fa-cloud-upload-alt text-2xl text-gray-500 mb-2"></i>
                                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click
                                                        to upload</span> or drag
                                                    and
                                                    drop</p>
                                                <p class="text-xs text-gray-500">PDF, DOC, Images (MAX.
                                                    10MB)
                                                </p>
                                            </div>
                                            <input type="file" name="attachment" class="hidden"
                                                accept=".pdf,.doc,.docx,.png,.jpg,.jpeg" />
                                        </label>
                                    </div>
                                    <button type="submit"
                                        class="w-full px-4 py-2 text-white bg-cyan-600 rounded-lg hover:bg-cyan-700">
                                        <i class="fas fa-upload mr-2"></i> Upload File
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="w-full flex justify-end gap-3 mt-2">
                <button
                    class="whitespace-nowrap px-4 py-2 lg:px-6 lg:py-2.5 text-sm lg:text-base bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200 flex items-center gap-2 shadow-lg hover:shadow-xl">
                    <i class="fas fa-play"></i>
                    <span class="hidden lg:inline">Start Task</span>
                </button>
                <button
                    class="whitespace-nowrap px-4 py-2 bg-cyan-600 text-white rounded-lg opacity-50 transition-all duration-200 cursor-not-allowed flex items-center gap-2"
                    disabled>
                    <i class="fas fa-check"></i>
                    <span>Mark as done</span>
                </button>
            </div>
        </div>
    </div>
    <!-- Right Column - Task Details & Project Info -->
    <div class="col-span-2 space-y-2">
        <!-- Project Info Card -->
        <div class="bg-gradient-to-br from-cyan-600 to-cyan-800 rounded-xl hidden lg:block p-4 text-white space-y-4">
            <div class="flex items-center justify-between animate-fade-in">
                <h2 class="text-large text-3xl">{{ $project->title }}</h2>
                <span class="px-3 py-1 bg-cyan-800 rounded-full text-sm">{{ $project->type }}</span>
            </div>
            <div class="grid grid-cols-2 gap-4 text-sm animate-fade-in">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-user"></i>
                        @if ($project->creator)
                            <span>Created by: {{ $project->creator->first_name }}
                                {{ $project->creator->last_name }}</span>
                        @else
                            <span>Created by: Unknown</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Due: {{ date('M d, Y', strtotime($project->tasks->first()->due_date ?? now())) }}</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-flag"></i>
                        <span>Priority: {{ $project->tasks->first()->priority ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        <span>Status: {{ $project->tasks->first()->status ?? 'To Do' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-users"></i>
                        <span class="flex items-center">Team:
                            <div class="flex -space-x-3 ml-2">
                                @if ($project->members->count() > 0)
                                    @foreach ($project->members as $member)
                                        <div class="relative group">
                                            @if ($member->avatar)
                                                <!-- Show avatar if available -->
                                                <img src="{{ asset('storage/' . $member->avatar) }}"
                                                    alt="{{ $member->first_name }}'s Profile Picture"
                                                    class="w-8 h-8 rounded-full object-cover border-2 border-white shadow-md cursor-pointer hover:z-10 transition-transform hover:scale-110">
                                            @else
                                                <!-- Fallback to initials if no avatar -->
                                                <div
                                                    class="w-8 h-8 rounded-full {{ ['bg-cyan-800', 'bg-teal-800', 'bg-blue-800', 'bg-indigo-800', 'bg-purple-800'][array_rand(['bg-cyan-800', 'bg-teal-800', 'bg-blue-800', 'bg-indigo-800', 'bg-purple-800'])] }} text-white flex items-center justify-center font-bold cursor-pointer hover:z-10 transition-transform hover:scale-110">
                                                    {{ strtoupper(substr($member->first_name, 0, 1)) }}{{ strtoupper(substr($member->last_name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <!-- Tooltip for member's full name -->
                                            <div
                                                class="absolute -top-8 left-1/2 -translate-x-1/2 bg-cyan-900 text-white px-2 py-1 rounded text-xs whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity z-20">
                                                {{ $member->first_name }} {{ $member->last_name }}
                                            </div>
                                        </div>
                                    @endforeach
                                    @if ($project->members->count() > 5)
                                        <div
                                            class="w-8 h-8 rounded-full bg-cyan-700 text-white flex items-center justify-center text-xs font-medium border-2 border-white">
                                            +{{ $project->members->count() - 5 }}
                                        </div>
                                    @endif
                                @else
                                    <p class="text-gray-200 text-sm italic ml-2">No team members yet</p>
                                @endif
                            </div>
                        </span>

                    </div>
                </div>
            </div>
        </div>
        <!-- Comments Section -->
        <div class="bg-neutral-300 rounded-xl shadow p-4 min-h-[400px]">
            <div class="flex gap-3 border-b border-gray-400 pb-3">
                @if (auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Profile Picture"
                        class="w-10 h-10 rounded-full mr-3">
                @else
                    <!-- If no profile picture, display the first letter of the first and last name -->
                    <div
                        class="w-10 h-10 rounded-full shadow-inner shadow-black bg-teal-500 text-white flex items-center font-bold justify-center">
                        <!-- Display the first letter of first name and last name -->
                        {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name, 0, 1)) }}
                    </div>
                @endif

                <div class="flex-1">
                    <textarea class="w-full rounded-lg border-gray-200 border p-3 text-sm resize-none focus:ring-0 focus:border-gray-300"
                        placeholder="Include any additional details..." rows="1"></textarea>

                    <div class="flex items-center gap-2 mt-2">
                        <button class="text-gray-700 hover:text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                        <button class="text-gray-700 hover:text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <!-- No Comments -->
            <div class="flex flex-col items-center justify-center h-[300px] text-gray-500/90 opacity-70">
                <i class="fas fa-comments text-4xl mb-3 animate-bounce"></i>
                <p class="text-xl font-semibold">No comments yet!</p>
                <p class="text-sm mt-2">Be the first one to start the conversation 😊</p>
            </div>
            <div>
                <!-- Comments will go here -->
            </div>
        </div>
    </div>
</div>
