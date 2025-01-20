@php $currentTask = $project->tasks->first() @endphp
<div class="p-4 block lg:hidden ">
    <div class="bg-gradient-to-br from-cyan-600 to-cyan-800 rounded-xl p-4 text-white space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold">{{ $project->title }}</h2>
            <span class="px-3 py-1 bg-cyan-800 rounded-full text-sm">{{ $project->type }}</span>
        </div>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <i class="fas fa-user"></i>
                    <span>Created by: {{ Auth::user()->first_name }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Due:
                        {{ date('M d, Y', strtotime($project->tasks->first()->due_date ?? now())) }}</span>
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
            </div>
        </div>
    </div>
</div>
<!-- this is if the project is equal to personal -->
<div id="ViewTaskPersonal" class="grid grid-cols-1 lg:grid-cols-5 gap-2 px-4 lg:p-4">
    <!-- Left Column - Tasks List -->
    <div
        class="col-span-3 bg-gradient-to-br from-cyan-800 to-cyan-950 rounded-2xl p-4 text-white flex flex-col shadow-lg">
        <div class="space-y-4 flex-grow">
            <!-- Task Header -->
            <div class="flex justify-between items-center border-b border-cyan-700 pb-4">
                <h5 class="text-2xl text-large tracking-wid animate-fade-in">
                    {{ ucfirst($project->tasks->first()->name) }}</h5>
                <div
                    class="flex items-center gap-2 bg-cyan-700/50 px-4 py-2 rounded-lg whitespace-nowrap animate-fade-in">
                    <i class="fas fa-star text-yellow-300"></i>
                    <span class="text-yellow-300 font-bold">+{{ $project->tasks->first()->points ?? 50 }} pts</span>
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
                            <form method="POST" 
                                action="{{ route('task.uploadAttachment', ['projectId' => $project->id]) }}" 
                                enctype="multipart/form-data" 
                                class="space-y-4">
                                @csrf
                                <div class="flex items-center justify-center w-full">
                                    <label
                                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="fas fa-cloud-upload-alt text-2xl text-gray-500 mb-2"></i>
                                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to
                                                    upload</span> or drag
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
        <div class="w-full flex justify-end align-bottom gap-3 mt-2">
            @if ($currentTask !== null)
                @if ($currentTask->status === 'To Do')
                    <!-- Button to start the task -->
                    <form id="startID" action="{{ route('tasks.updateStatus', $currentTask->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Ongoing">
                    </form>
                    <button type="button" onclick="showConfirmationStart()"
                        class="whitespace-nowrap px-4 py-2 lg:px-6 lg:py-2.5 text-sm lg:text-base bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200 flex items-center gap-2 shadow-lg hover:shadow-xl">
                        <i class="fas fa-play"></i>
                        <span class="hidden lg:inline">Start Task</span>
                    </button>
                    <button
                        class="whitespace-nowrap px-4 py-2 lg:px-6 lg:py-2.5 text-sm lg:text-base bg-cyan-600 text-white rounded-lg opacity-50 transition-all duration-200 cursor-not-allowed flex items-center gap-2"
                        disabled>
                        <i class="fas fa-check"></i>
                        <span>Mark as done</span>
                    </button>
                @elseif ($currentTask->status === 'Ongoing')
                    <!-- Ongoing button -->
                    <form id="markAsDoneForm" action="{{ route('tasks.updateStatus', $currentTask->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="Done">
                    </form>
                    <button
                        class="whitespace-nowrap px-4 py-2 lg:px-6 lg:py-2.5 text-sm lg:text-base bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-all duration-200 flex items-center gap-2 shadow-lg hover:shadow-xl"
                        disabled>
                        <i class="fas fa-spinner fa-spin"></i>
                        <span class="hidden lg:inline">Ongoing</span>
                    </button>
                    <button type="button" onclick="showConfirmationDone()"
                        class="whitespace-nowrap px-4 py-2 lg:px-6 lg:py-2.5 text-sm lg:text-base bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-all duration-200 flex items-center gap-2 shadow-lg hover:shadow-xl">
                        <i class="fas fa-check"></i>
                        <span>Mark as done</span>
                    </button>
                @else
                    <div
                        class="whitespace-nowrap px-4 py-2 lg:px-6 lg:py-2.5 text-sm lg:text-base bg-green-600 text-white rounded-lg transition-all duration-200 flex items-center gap-2 shadow-lg hover:shadow-xl">
                        <i class="fas fa-check"></i>
                        <span>Task Completed</span>
                    </div>
                @endif
            @endif
        </div>
        
        <!-- Mark as  Done Confirmation Modal -->
        <div id="confirmationModalDone"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
            <div class="bg-white p-8 rounded-2xl shadow-lg max-w-md mx-auto animate-appear">
                <h3 class="text-xl text-gray-600 font-bold mb-4">Mark as Done Confirmation</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to mark this task as done? Confirm to proceed.</p>
                <div class="flex justify-end gap-4">
                    <button onclick="hideConfirmationDone()"
                        class="px-4 py-2 rounded-lg text-gray-600 transition-all hover:bg-gray-200">
                        Cancel
                    </button>
                    <button onclick="submitMarkAsDoneForm()"
                        class="px-4 py-2 rounded-lg bg-cyan-700 text-white transition-all hover:bg-cyan-600">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
        <!-- Confirmation Modal -->
        <div id="confirmationModalStart"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center  justify-center">
            <div class="bg-white p-8 rounded-2xl shadow-lg max-w-md mx-auto animate-appear">
                <h3 class="text-xl  text-gray-600 font-bold mb-4">Start Task Confirmation</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to start this task? Confirm to proceed.</p>
                <div class="flex justify-end gap-4">
                    <button onclick="hideConfirmationStart()"
                        class="px-4 py-2 rounded-lg text-gray-600 transition-all hover:bg-gray-200">
                        Cancel
                    </button>
                    <button onclick="submitStartForm()"
                        class="px-4 py-2 rounded-lg bg-cyan-700 text-white transition-all hover:bg-cyan-600">
                        Confirm
                    </button>
                </div>
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
                        <span>Created by: {{ Auth::user()->first_name }}</span>
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
                </div>
            </div>
        </div>
        <!-- Comment Section -->
        <div class="bg-neutral-300 rounded-xl shadow p-4 min-h-[400px]">
            <div class="flex gap-3 border-b border-gray-400">
                @if (auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Profile Picture"
                        class="w-10 h-10 rounded-full mr-3">
                @else
                    <div
                        class="w-10 h-10 rounded-full shadow-inner shadow-black bg-teal-500 text-white flex items-center font-bold justify-center">
                        {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name, 0, 1)) }}
                    </div>
                @endif

                <div class="flex-1">
                    <!-- Comment Form -->
                    <form action="{{ route('task', $project->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <textarea class="w-full rounded-lg border-gray-200 border p-3 text-sm resize-none focus:ring-0 focus:border-gray-300"
                            placeholder="Include any additional details..." rows="1" name="comment"></textarea>

                        <div id="file-cont" class="whitespace-nowrap mt-2 w-auto hidden rounded-lg bg-cyan-800">
                            <div class="flex justify-between items-center px-2 py-1">
                                <div id="file-name" class=" text-normal text-white ">
                                </div>
                                <button type="button" onclick="closeContFile()">
                                    <i class="fas fa-times text-xs text-white"></i>
                                </button>
                            </div>
                        </div>
                        <!-- File Upload -->
                        <div class="flex justify-between items-center px-1">
                            <div class="flex items-center gap-2 mt-2">
                                <button type="button" class="text-gray-700 hover:text-gray-500"
                                    onclick="toggleEmojiPicker()">
                                    <i class="fa-regular fa-face-smile"></i>
                                </button>
                                <label for="file-upload" class="cursor-pointer text-gray-700 hover:text-gray-500">
                                    <i class="fas fa-paperclip"></i>
                                </label>
                                <input id="file-upload" type="file" name="file" class="hidden"
                                    onchange="updateFileName(event)">
                            </div>
                            <div id="emoji-picker" class="hidden mt-2">
                                <!-- Add your emoji picker implementation here -->
                            </div>
                            <div class="flex items-center gap-2 mt-2">
                                <button class="text-gray-700 hover:text-gray-500" type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Displaying Comments -->
            <div class="mt-4 max-h-[300px] overflow-y-auto scrollbar-thin animate-fade-in">
                @forelse ($project->comments->reverse() as $comment)
                    <div class="flex gap-3 mb-4">
                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <p class="text-medium text-cyan-800">You:</p>
                                <p class="text-[12px] text-gray-500">
                                    {{ $comment->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <!-- Display Comment Text -->
                            @if ($comment->comment)
                                <p class="mt-1">{{ $comment->comment }}</p>
                            @endif

                            <!-- Display File Attachment -->
                            @if ($comment->file_path)
                                <div class="mt-2 ml-4 mr-2">
                                    @if (in_array(pathinfo($comment->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                        <a href="{{ asset('storage/' . $comment->file_path) }}" target="_blank"
                                            onclick="openImageModal('{{ asset('storage/' . $comment->file_path) }}'); return false;">
                                            <img src="{{ asset('storage/' . $comment->file_path) }}" alt="Attachment"
                                                class="mt-2 w-full max-w-md rounded-lg shadow">
                                        </a>
                                    @elseif(in_array(pathinfo($comment->file_path, PATHINFO_EXTENSION), ['pdf']))
                                        <a href="{{ asset('storage/' . $comment->file_path) }}" target="_blank"
                                            class="text-cyan-700 underline flex items-center gap-2">
                                            <i class="text-2xl fa-regular fa-file-pdf"></i>
                                            <span
                                                class="text-large text-cyan-700 text-[14px] hover:text-teal-500 transition-colors duration-200">{{ basename($comment->file_path) }}</span>
                                        </a>
                                    @elseif(in_array(pathinfo($comment->file_path, PATHINFO_EXTENSION), ['doc']))
                                        <a href="{{ asset('storage/' . $comment->file_path) }}" target="_blank"
                                            class="text-blue-500 underline ">
                                            <i class="text-2xl fa-regular fa-file"></i>
                                            <span
                                                class="text-large text-cyan-700 text-[14px] hover:text-teal-500 transition-colors duration-200">{{ basename($comment->file_path) }}</span>
                                        </a>
                                    @elseif(in_array(pathinfo($comment->file_path, PATHINFO_EXTENSION), ['docx']))
                                        <a href="{{ asset('storage/' . $comment->file_path) }}" target="_blank"
                                            class="text-cyan-700 underline flex items-center gap-2">
                                            <i class="text-2xl fa-regular fa-file-word"></i>
                                            <span
                                                class="text-large text-cyan-700 text-[14px] hover:text-teal-500 transition-colors duration-200">{{ basename($comment->file_path) }}</span>
                                        </a>
                                    @elseif(in_array(pathinfo($comment->file_path, PATHINFO_EXTENSION), ['zip']))
                                        <a href="{{ asset('storage/' . $comment->file_path) }}" target="_blank"
                                            class="text-blue-500 underline "><i
                                                class="text-2xl fa-regular fa-folder"></i></i>{{ basename($comment->file_path) }}</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center h-[300px] text-gray-500/90 opacity-70">
                        <i class="fas fa-comments text-4xl mb-3 animate-bounce"></i>
                        <p class="text-xl font-semibold">No comments yet!</p>
                        <p class="text-sm mt-2">Be the first one to start the conversation 😊</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

<script>
     function closeContFile() {
        document.getElementById('file-cont').classList.add('hidden');
        document.getElementById('file-upload').value = '';
    }

    function updateFileName(event) {
        const fileInput = event.target;
        const fileNameElement = document.getElementById('file-name');
        const fileFileCont = document.getElementById('file-cont');
        const fileName = fileInput.files[0]?.name || 'No file selected';

        fileFileCont.classList.remove('hidden');
        if (fileName.length > 16) {
            fileNameElement.textContent = fileName.substring(0, 16) + '...';
            fileNameElement.title = fileName;
        } else {
            fileNameElement.textContent = fileName;
            fileNameElement.title = '';
        }
    }

    function showConfirmationDone() {
        document.getElementById('confirmationModalDone').style.display = 'flex';
    }

    function hideConfirmationDone() {
        document.getElementById('confirmationModalDone').style.display = 'none';
    }

    function submitMarkAsDoneForm() {
        document.getElementById('markAsDoneForm').submit();
        hideConfirmationDone();
    }

    function showConfirmationStart() {
        document.getElementById('confirmationModalStart').style.display = 'flex';
    }

    function hideConfirmationStart() {
        document.getElementById('confirmationModalStart').style.display = 'none';
    }

    function submitStartForm() {
        document.getElementById('startID').submit();
        hideConfirmationStart();
    }
    window.addEventListener('click', function(event) {
        const modalDone = document.getElementById('confirmationModalDone');
        const modalStart = document.getElementById('confirmationModalStart');
        
        if (event.target === modalDone) {
            hideConfirmationDone();
        }
        
        if (event.target === modalStart) {
            hideConfirmationStart();
        }
    });
</script>
