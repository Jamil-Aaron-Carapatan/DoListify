<div class="p-4 block lg:hidden ">
    <div class="bg-gradient-to-br from-cyan-600 to-cyan-800 rounded-xl p-4 text-white space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold">{{ $currentTask->name }}</h2>
            <span class="px-3 py-1 bg-cyan-800 rounded-full text-sm">Personal</span>
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
                        {{ date('M d, Y', strtotime($currentTask->due_date ?? now())) }}</span>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <i class="fas fa-flag"></i>
                    <span>Priority: {{ $currentTask->priority ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-info-circle"></i>
                    <span>Status: {{ $currentTask->status ?? 'To Do' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="taskCompleted" name="taskCompleted"
                        {{ $currentTask->status === 'Done' ? 'checked' : '' }} disabled>
                    <label for="taskCompleted">Task Completed</label>
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
                    Things To Do
                </h5>

                <button type="button" class="px-4 py-2 bg-cyan-800 text-white rounded-md hover:bg-cyan-900 transition"
                    onclick="openSaveModal()">Save</button>
            </div>

            <!-- Main Content -->
            <div>
                <div class="flex">
                    <div
                        class="w-auto  pl-3 pt-2 pb-0 px-3 pr-10 text-zinc-600 py-1.5 bg-white rounded-t-2xl text-medium">
                        <i class="fas fa-tasks"></i> <span>Task Overview</span>
                    </div>
                </div>
                <div id="descriptionCont" class="bg-white rounded-2xl rounded-tl-none p-4">
                    <div class="">
                        <div class="border rounded-md p-4 min-h-[200px] lg:min-h-[300]">
                            @if (empty($currentTask->description || $currentTask->checklist))
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
                            @else
                                <form id="taskDescriptionForm" method="POST" data-task-id="{{ $currentTask->id }}">
                                    @csrf
                                    <textarea id="text-desc" name="description" placeholder="Take a note..."
                                        class="w-full mt-2 text-medium text-zinc-600 whitespace-pre-line focus:outline-none focus:border-cyan-800 placeholder:text-medium placeholder:text-lg placeholder:text-slate-400 overflow-hidden"
                                        rows="3"
                                        style="max-height: 500px; padding: 0; text-indent: 0; margin: 0; border: none; white-space: pre-wrap;"
                                        oninput="autoExpand(this)">{{ $currentTask->description }}</textarea>
                                    <div id="checklist-container">
                                        @foreach ($currentTask->checklist as $item)
                                            <div class="mt-2 checklist-item group cursor-default"
                                                data-id="{{ $item->id }}">
                                                <div class="flex items-center space-x-2">
                                                    <input type="checkbox" id="checklist-item-{{ $item->id }}"
                                                        class="checkbox-item cursor-pointer"
                                                        {{ $item->completed ? 'checked' : '' }}
                                                        onchange="toggleChecklistItem({{ $item->id }}, this.checked)">
                                                    <input type="text" value="{{ $item->name }}"
                                                        class="w-full border-none text-medium text-zinc-600 focus:outline-none checklist-text {{ $item->completed ? 'line-through' : '' }}"
                                                        oninput="markChecklistItemDirty({{ $item->id }}, this.value)">

                                                    <!-- Hidden input for deletion flag -->
                                                    <input type="hidden" name="items[{{ $item->id }}][deleted]"
                                                        class="deleted-flag " value="{{ $item->deleted ? '1' : '0' }}">


                                                    <!-- Add delete button -->
                                                    <button type="button"
                                                        class="delete-button text-red-500 text-lg cursor-pointer text-medium flex transition-all items-center p-0 m-0 opacity-0 group-hover:opacity-100"
                                                        onclick="deleteChecklistItem({{ $item->id }})">
                                                        <i class="fa-solid fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <button type="submit">Save Task</button>
                                </form>
                            @endif
                            <div>
                                <button
                                    class="text-slate-400  p-0 hover:text-cyan-800 w-auto text-medium flex space-x-2 "
                                    onclick="addChecklistItem()">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 6L12 18" stroke="#95A5B8" stroke-width="2"
                                            stroke-linecap="round" />
                                        <path d="M18 12L6 12" stroke="#95A5B8" stroke-width="2"
                                            stroke-linecap="round" />
                                    </svg>
                                    <span>Add Items</span>
                                </button>
                            </div>
                            <div>
                                save
                            </div>
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
                    <form id="markAsDoneForm" action="{{ route('tasks.updateStatus', $currentTask->id) }}"
                        method="POST">
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
                <h2 class="text-large text-3xl">{{ $currentTask ? $currentTask->name : 'No Task Selected' }}</h2>
                <span class="px-3 py-1 bg-cyan-800 rounded-full text-sm">Personal</span>
            </div>
            <div class="grid grid-cols-2 gap-4 text-sm animate-fade-in">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-user"></i>
                        <span>Created by: {{ Auth::user()->first_name }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Due: {{ date('M d, Y', strtotime($currentTask->due_date ?? now())) }}</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-flag"></i>
                        <span>Priority: {{ $currentTask->priority ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        <span>Status: {{ $currentTask->status ?? 'To Do' }}</span>
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
                    <form action="{{ route('task.view', $currentTask->id) }}" method="POST"
                        enctype="multipart/form-data">
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
                @forelse ($currentTask->task_comments->reverse() as $comment)
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
<script src="{{ asset('storage/js/personal.js') }}"></script>
<script>
    function openSaveModal() {
        document.getElementById('saveChangesModal').style.display = 'flex';
    }

    function hidesaveChanges() {
        document.getElementById('saveChangesModal').style.display = 'none';
    }


    function addChecklistItem() {
        const container = document.getElementById('checklist-container');
        const newItemId = `new-${Date.now()}`; // Temporary unique ID
        const newItemHtml = `
        <div class="mt-2 checklist-item" data-id="${newItemId}">
            <div class="flex items-center space-x-2">
                <input type="checkbox" id="checklist-item-${newItemId}" class="checkbox-item" onchange="toggleChecklistItem('${newItemId}', this.checked)">
                <input type="text" value="" class="w-full border-none text-medium text-zinc-600 focus:outline-none checklist-text" placeholder="New Item" oninput="markChecklistItemDirty('${newItemId}', this.value)">
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', newItemHtml);
    }

    function deleteChecklistItem(itemId) {
        let itemContainer = document.querySelector(`[data-id="${itemId}"]`);
        if (itemContainer) {
            let deletedInput = itemContainer.querySelector('input[name="items[' + itemId + '][deleted]"]');
            if (deletedInput) {
                deletedInput.value = '1'; // Mark as deleted
            }

            // Optionally, hide the item for visual feedback
            itemContainer.style.display = 'none';
        }
    }
    // On form submission, deleted items will be included automatically in the request
    document.getElementById('taskDescriptionForm').addEventListener('submit', function(e) {
        const deletedItems = document.querySelectorAll('input[name="deleted_items[]"][value]');
        if (deletedItems.length > 0) {
            // The deleted items will be sent as part of the form data
            // You can add additional logic here if needed
        }
    });

    function toggleChecklistItem(id, isChecked) {
        const checklistItem = document.querySelector(`.checklist-item[data-id="${id}"]`);
        const textInput = checklistItem.querySelector('.checklist-text');

        if (isChecked) {
            textInput.classList.add('line-through'); // Add strike-through style
        } else {
            textInput.classList.remove('line-through'); // Remove strike-through style
        }

        console.log(`Item ${id} marked as ${isChecked ? 'completed' : 'incomplete'}`);
        // Optionally, save changes immediately via AJAX
    }

    function SubmitEditForm() {
        const description = document.getElementById('text-desc').value;

        // Collect all checklist items, including the 'deleted' flag
        const items = Array.from(document.querySelectorAll('.checklist-item')).map(item => {
            const itemId = item.dataset.id;
            const name = item.querySelector('.checklist-text').value;
            const completed = item.querySelector('.checkbox-item').checked;
            const deletedFlag = item.querySelector('input[name="items[' + itemId + '][deleted]"]')?.value ||
                '0'; // Get the deleted flag

            return {
                id: itemId,
                name: name,
                completed: completed,
                deleted: deletedFlag === '1' ? true : false, // If the deleted flag is '1', mark it as deleted
            };
        });

        // Retrieve the task ID
        const taskId = document.getElementById('taskDescriptionForm').dataset.taskId;

        // Send the data to the backend
        fetch(`/tasks/update/${taskId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    description,
                    items,
                }),
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(errorText => {
                        throw new Error(errorText);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Task updated successfully:', data);
            })
            .catch(error => {
                console.error('Error saving form:', error.message);
            });
        document.getElementById('saveChangesModal').style.display = 'none'
    }
</script>
