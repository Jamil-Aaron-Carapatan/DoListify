function autoExpand(textarea) {
    // Reset the height to calculate the new height properly
    textarea.style.height = "auto";

    // Adjust the height based on the scroll height
    textarea.style.height = textarea.scrollHeight + "px";
}

function showAssigneeModal() {
    document.getElementById("assignee-modal").style.display = "flex";
}

// Close the modal
function closeAssigneeModal() {
    document.getElementById("assignee-modal").style.display = "none";
}

// Set the assignee in the input field
function setAssignee(name) {
    document.getElementById("assignee-input").value = name;
    closeAssigneeModal();
}

function openPointsModal() {
    document.getElementById("points-modal").style.display = "flex";
}

// Function to close the Points modal
function closePointsModal() {
    document.getElementById("points-modal").style.display = "none";
}

function adjustDropdownPosition(buttonId, dropdownId) {
    const button = document.getElementById(buttonId);
    const dropdown = document.getElementById(dropdownId);

    const buttonRect = button.getBoundingClientRect();
    const dropdownHeight = dropdown.offsetHeight;
    const spaceBelow = window.innerHeight - buttonRect.bottom;
    const spaceAbove = buttonRect.top;

    // Reset dropdown class
    dropdown.classList.remove("above");

    if (spaceBelow < dropdownHeight && spaceAbove > dropdownHeight) {
        // Not enough space below, but enough above
        dropdown.style.top = `auto`;
        dropdown.style.bottom = `100%`; // Position above button
        dropdown.classList.add("above");
    } else {
        // Default behavior (position below)
        dropdown.style.top = `${buttonRect.height}px`;
        dropdown.style.bottom = `auto`;
    }
}

function toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    if (!dropdown) {
        console.error(`Dropdown with ID "${dropdownId}" does not exist.`);
        return;
    }

    // Close other dropdowns
    document.querySelectorAll(".dropdown").forEach((d) => {
        if (d.id !== dropdownId) d.classList.add("hidden");
    });

    dropdown.classList.toggle("hidden");

    if (!dropdown.classList.contains("hidden")) {
        const buttonId = dropdownId.includes("due-date-dropdown")
            ? dropdownId.replace("dropdown", "button")
            : dropdownId.replace("dropdown", "button");
        adjustDropdownPosition(buttonId, dropdownId);
    }
}

// Close dropdown when clicking outside
document.addEventListener("click", function (event) {
    const dueDateDropdowns = document.querySelectorAll(
        '[id^="due-date-dropdown"]'
    );
    const priorityDropdowns = document.querySelectorAll(
        '[id^="priority-dropdown"]'
    );
    const dueDateButtons = document.querySelectorAll('[id^="due-date-button"]');
    const priorityButtons = document.querySelectorAll(
        '[id^="priority-button"]'
    );

    dueDateDropdowns.forEach((dropdown, index) => {
        const button = dueDateButtons[index];
        if (
            !dropdown.contains(event.target) &&
            !button.contains(event.target)
        ) {
            dropdown.classList.add("hidden");
        }
    });

    priorityDropdowns.forEach((dropdown, index) => {
        const button = priorityButtons[index];
        if (
            !dropdown.contains(event.target) &&
            !button.contains(event.target)
        ) {
            dropdown.classList.add("hidden");
        }
    });
});

function saveDueDate() {
    const date = document.getElementById("due-date-input").value;
    const time = document.getElementById("due-time-input").value;
    const display = document.getElementById("due-date-display");
    display.textContent = date && time ? `${date} ${time}` : "No date set";

    toggleDropdown("due-date-dropdown");
}
// Function to save the points
function savePoints() {
    const points = document.getElementById("points-input").value;
    const display = document.getElementById("points-display");
    display.textContent = points || "No points set";
    if (points) {
        alert(`Points set to: ${points}`); // Replace with actual saving logic
        closePointsModal(); // Close modal after saving
    } else {
        alert("Please enter a valid number of points");
    }
}

function setPriority(priority) {
    const priorityDisplay = document.getElementById("priority-display");
    priorityDisplay.textContent = priority;
    const priorityInput = document.getElementById("priority-input");
    priorityInput.value = priority;
    toggleDropdown("priority-dropdown");
}

function addAnotherTask() {
    // Get the task index from the number of existing task containers
    const currentIndex = document.querySelectorAll(".task-container").length;

    // Create a new task container
    const newTask = document.createElement("div");
    newTask.classList.add("task-container");
    newTask.className = "bg-white rounded-2xl p-4 task-item space-y-2";

    // Create the inner HTML for the new task container
    newTask.innerHTML = `
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div>
                    <label for="tasks[${currentIndex}][name]" class="text-[12px] text-cyan-700 text-medium">Task Name<span class="text-red-400"> *</span></label>
                    <input type="text" name="tasks[${currentIndex}][name]" class="border-b p-2 text-medium error-prone border-cyan-800/30 placeholder:text-normal placeholder:text-sm placeholder:text-slate-400 focus:outline-none w-full" placeholder="What needs to be accomplished?">
                </div>
                <div class="relative">
                    <label for="tasks[${currentIndex}][assignee]" class="text-[12px] text-cyan-700 text-medium">Assignee<span class="text-red-400"> *</span></label>
                    <input type="text" name="tasks[${currentIndex}][assignee]" id="assignee-input-${currentIndex}" class="p-2 border-b text-medium text-slate-400 assignee-input error-prone placeholder:text-normal border-cyan-800/30 placeholder:text-sm placeholder:text-slate-400 focus:outline-none w-full pr-10" placeholder="Start typing to search for a member...">
                    <ul id="assignee-suggestions"
                        class="absolute bg-white border border-gray-300 shadow-md rounded-md w-full hidden max-h-48 overflow-y-auto z-10">
                    </ul>
                </div>
            </div>
            <div>
                <label for="tasks[${currentIndex}][description]" class="text-[12px] text-cyan-700 text-medium">Description<span class="text-red-400"> *</span></label>
                <textarea name="tasks[${currentIndex}][description]" class="w-full mt-2 border-b border-cyan-800/30 text-medium resize-none focus:border-cyan-800 placeholder:text-normal placeholder:text-sm placeholder:text-md placeholder:text-slate-400 focus:outline-none scrollbar-thin" placeholder="Add detailed instructions or notes for clarity." oninput="autoExpand(this)"></textarea>
            </div>
            <div class="flex items-center justify-between mt-6">
                <div class="flex items-center gap-3">
                    <div class="relative" id="due-date-container-${currentIndex}">
                        <button type="button" id="due-date-button-${currentIndex}" class="flex items-center p-2 border {{ $errors->has('tasks.0.name') ? 'border-red-500' : '' }} rounded-full hover:bg-gray-100" onclick="toggleDropdown('due-date-dropdown-${currentIndex}')" title="Specify Due Date">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="g">
                                <path d="M2 9C2 7.11438 2 6.17157 2.58579 5.58579C3.17157 5 4.11438 5 6 5H18C19.8856 5 20.8284 5 21.4142 5.58579C22 6.17157 22 7.11438 22 9C22 9.4714 22 9.70711 21.8536 9.85355C21.7071 10 21.4714 10 21 10H3C2.5286 10 2.29289 10 2.14645 9.85355C2 9.70711 2 9.4714 2 9Z" fill="#0e7490" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.58579 21.4142C2 20.8284 2 19.8856 2 18V13C2 12.5286 2 12.2929 2.14645 12.1464C2.29289 12 2.5286 12 3 12H21C21.4714 12 21.7071 12 21.8536 12.1464C22 12.2929 22 12.5286 22 13V18C22 19.8856 22 20.8284 21.4142 21.4142C20.8284 22 19.8856 22 18 22H6C4.11438 22 3.17157 22 2.58579 21.4142ZM8 16C7.44772 16 7 16.4477 7 17C7 17.5523 7.44772 18 8 18H16C16.5523 18 17 17.5523 17 17C17 16.4477 16.5523 16 16 16H8Z" fill="#0e7490" />
                                <path d="M7 3L7 6" stroke="#0e7490" stroke-width="2" stroke-linecap="round" />
                                <path d="M17 3L17 6" stroke="#0e7490" stroke-width="2" stroke-linecap="round" />
                            </svg>
                        </button>
                        <div id="due-date-dropdown-${currentIndex}" class="dropdown absolute hidden bg-white shadow-md rounded-md mt-2 p-4 z-10 w-64">
                            <p class="block text-sm font-medium text-gray-700 mb-2">Set Due Date & Time:</p>
                            <label for="due-date-input-${currentIndex}" class="text-sm border font-medium text-gray-600 block">Date</label>
                            <input type="date" id="due-date-input-${currentIndex}" name="tasks[${currentIndex}][due_date]" class="mt-1 w-full border-gray-300 rounded-md focus:ring-cyan-800 focus:border-cyan-800 px-2 py-1">
                            <label for="due-time-input-${currentIndex}" class="text-sm font-medium border text-gray-600 block mt-3">Time</label>
                            <input type="time" id="due-time-input-${currentIndex}" name="tasks[${currentIndex}][due_time]" class="mt-1 w-full border-gray-300 rounded-md focus:ring-cyan-800 focus:border-cyan-800 px-2 py-1">
                            <button type="button" class="mt-4 px-4 py-2 bg-cyan-800 text-white rounded-md hover:bg-cyan-900 transition w-full" onclick="saveDueDate(${currentIndex})">Set</button>
                        </div>
                    </div>
                    <div class="relative" id="priority-container-${currentIndex}">
                        <div class="flex items-center">
                            <button type="button" id="priority-button-${currentIndex}" class="flex items-center p-2 border {{ $errors->has('tasks.0.name') ? 'border-red-500' : '' }} rounded-full hover:bg-gray-100" onclick="toggleDropdown('priority-dropdown-${currentIndex}')" title="Assign Priority">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.6358 3.90949C15.2888 3.47412 15.6153 3.25643 15.9711 3.29166C16.3269 3.32689 16.6044 3.60439 17.1594 4.15938L19.8406 6.84062C20.3956 7.39561 20.6731 7.67311 20.7083 8.02888C20.7436 8.38465 20.5259 8.71118 20.0905 9.36424L18.4419 11.8372C17.88 12.68 17.5991 13.1013 17.3749 13.5511C17.2086 13.8845 17.0659 14.2292 16.9476 14.5825C16.7882 15.0591 16.6889 15.5557 16.4902 16.5489L16.2992 17.5038C16.2986 17.5072 16.2982 17.5089 16.298 17.5101C16.1556 18.213 15.3414 18.5419 14.7508 18.1351C14.7497 18.1344 14.7483 18.1334 14.7455 18.1315C14.7322 18.1223 14.7255 18.1177 14.7189 18.1131C11.2692 15.7225 8.27754 12.7308 5.88691 9.28108C5.88233 9.27448 5.87772 9.26782 5.86851 9.25451C5.86655 9.25169 5.86558 9.25028 5.86486 9.24924C5.45815 8.65858 5.78704 7.84444 6.4899 7.70202C6.49113 7.70177 6.49282 7.70144 6.49618 7.70076L7.45114 7.50977C8.44433 7.31113 8.94092 7.21182 9.4175 7.05236C9.77083 6.93415 10.1155 6.79139 10.4489 6.62514C10.8987 6.40089 11.32 6.11998 12.1628 5.55815L14.6358 3.90949Z" fill="#14b8a6" stroke="#14b8a6" stroke-width="2" />
                                    <path d="M5 19L9.5 14.5" stroke="#083344" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </button>
                            <input type="text" id="priority-display-${currentIndex}" class="hidden" value="">
                        </div>
                        <div id="priority-dropdown-${currentIndex}" class="dropdown absolute hidden bg-white shadow-md rounded-md mt-2 p-4 z-10 w-48">
                            <p class="block text-sm font-medium text-gray-700 mb-2">Set Priority:</p>
                            <ul class="space-y-2">
                                <li>
                                    <button type="button" class="w-full text-left px-4 py-2 rounded-md hover:bg-cyan-100 text-gray-800" onclick="setPriority('High', ${currentIndex})">High</button>
                                </li>
                                <li>
                                    <button type="button" class="w-full text-left px-4 py-2 rounded-md hover:bg-cyan-100 text-gray-800" onclick="setPriority('Medium', ${currentIndex})">Medium</button>
                                </li>
                                <li>
                                    <button type="button" class="w-full text-left px-4 py-2 rounded-md hover:bg-cyan-100 text-gray-800" onclick="setPriority('Low', ${currentIndex})">Low</button>
                                </li>
                            </ul>
                        </div>
                        <input type="hidden" id="priority-input-${currentIndex}" name="tasks[${currentIndex}][priority]" value="">
                    </div>
                    <div class="relative">
                        <button type="button" class="flex border items-center p-2 rounded-full {{ $errors->has('tasks.0.name') ? 'border-red-500' : '' }} hover:bg-gray-100" onclick="openPointsModal(${currentIndex})" title="Specify Required Points">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.3072 7.21991C10.9493 5.61922 11.2704 4.81888 11.7919 4.70796C11.9291 4.67879 12.0708 4.67879 12.208 4.70796C12.7295 4.81888 13.0506 5.61922 13.6927 7.21991C14.0578 8.13019 14.2404 8.58533 14.582 8.8949C14.6778 8.98173 14.7818 9.05906 14.8926 9.12581C15.2874 9.36378 15.7803 9.40793 16.7661 9.49621C18.4348 9.64566 19.2692 9.72039 19.524 10.1961C19.5768 10.2947 19.6127 10.4013 19.6302 10.5117C19.7146 11.0448 19.1012 11.6028 17.8744 12.7189L17.5338 13.0289C16.9602 13.5507 16.6735 13.8116 16.5076 14.1372C16.4081 14.3325 16.3414 14.5429 16.3101 14.7598C16.258 15.1215 16.342 15.5 16.5099 16.257L16.5699 16.5275C16.8711 17.885 17.0217 18.5637 16.8337 18.8974C16.6649 19.1971 16.3538 19.3889 16.0102 19.4053C15.6277 19.4236 15.0887 18.9844 14.0107 18.106C13.3005 17.5273 12.9454 17.2379 12.5512 17.1249C12.191 17.0216 11.8089 17.0216 11.4487 17.1249C11.0545 17.2379 10.6994 17.5273 9.98917 18.106C8.91119 18.9844 8.37221 19.4236 7.98968 19.4053C7.64609 19.3889 7.33504 19.1971 7.16617 18.8974C6.97818 18.5637 7.12878 17.885 7.42997 16.5275L7.48998 16.257C7.65794 15.5 7.74191 15.1215 7.6898 14.7598C7.65854 14.5429 7.59182 14.3325 7.49232 14.1372C7.32645 13.8116 7.03968 13.5507 6.46613 13.0289L6.12546 12.7189C4.89867 11.6028 4.28527 11.0448 4.36975 10.5117C4.38724 10.4013 4.42312 10.2947 4.47589 10.1961C4.73069 9.72039 5.56507 9.64566 7.23384 9.49621C8.21962 9.40793 8.71251 9.36378 9.10735 9.12581C9.2181 9.05906 9.32211 8.98173 9.41793 8.8949C9.75954 8.58533 9.94211 8.13019 10.3072 7.21991Z" fill="#059669" stroke="#059669" stroke-width="2" />
                            </svg>
                        </button>
                        <input type="hidden" name="tasks[${currentIndex}][points]" id="points-input-${currentIndex}" value="">
                    </div>
                </div>
            </div>
        `;

    // Insert the new task container before the "Add Another Task" button
    const addTaskBtn = document.getElementById("addTaskBtn");
    addTaskBtn.parentNode.insertBefore(newTask, addTaskBtn);
}

function showAssigneeModal(index) {
    document.getElementById("assignee-modal").style.display = "flex";
    document.getElementById("assignee-modal").setAttribute("data-index", index);
}

function setAssignee(email) {
    const index = document
        .getElementById("assignee-modal")
        .getAttribute("data-index");
    document.getElementById(`assignee-input-${index}`).value = email;
    closeAssigneeModal();
}

function openPointsModal(index) {
    document.getElementById("points-modal").style.display = "flex";
    document.getElementById("points-modal").setAttribute("data-index", index);
}

//serach bar
document.addEventListener("DOMContentLoaded", function () {
    const assigneeInput = document.getElementById("assignee-input");
    const suggestionsList = document.getElementById("assignee-suggestions");

    assigneeInput.addEventListener("input", async function () {
        const query = this.value.trim();

        if (query.length < 2) {
            suggestionsList.innerHTML = "";
            suggestionsList.classList.add("hidden");
            return;
        }

        try {
            const response = await fetch(
                `http://127.0.0.1:8000/api/search-users?query=${encodeURIComponent(
                    query
                )}`
            );
            if (!response.ok) throw new Error("Failed to fetch suggestions");

            const data = await response.json();

            // Check if users array exists in response and is actually an array
            const users = Array.isArray(data.users) ? data.users : [];
            if (users.length === 0) {
                suggestionsList.innerHTML =
                    '<li class="p-2 text-gray-500">No users found</li>';
                suggestionsList.classList.remove("hidden");
                return;
            }

            suggestionsList.innerHTML = users
                .map(
                    (user) => `
                <li class="p-2 cursor-pointer hover:bg-gray-100" data-email="${user.email}">
                    ${user.name} <span class="text-sm text-gray-500">(${user.email})</span>
                </li>
            `
                )
                .join("");

            suggestionsList.classList.remove("hidden");
        } catch (error) {
            console.error("Error fetching suggestions:", error);
            suggestionsList.innerHTML =
                '<li class="p-2 text-red-500">Error loading users</li>';
            suggestionsList.classList.remove("hidden");
        }
    });

    suggestionsList.addEventListener("click", function (event) {
        const listItem = event.target.closest("li");
        if (listItem) {
            assigneeInput.value = listItem.dataset.email; // Set input value to the selected email
            suggestionsList.classList.add("hidden"); // Hide suggestions
        }
    });

    // Hide suggestions when clicking outside
    document.addEventListener("click", function (event) {
        if (
            !assigneeInput.contains(event.target) &&
            !suggestionsList.contains(event.target)
        ) {
            suggestionsList.classList.add("hidden");
        }
    });
});
