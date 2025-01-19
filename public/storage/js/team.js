function removeEmailInput(button) {
    const emailInputContainer = button.closest('.email-input-container');
    emailInputContainer.remove();
}

function closePeopleModal() {
    document.getElementById('peopleModal').classList.add('hidden');
}

document.getElementById('addTeamMembersBtn').addEventListener('click', function () {
    document.getElementById('peopleModal').classList.remove('hidden');
});
// First, let's modify the modal to be scrollable and add suggestions
document.addEventListener('DOMContentLoaded', function () {
    // Make modal scrollable
    const modalContent = document.querySelector('#peopleModal > div');
    modalContent.classList.add('max-h-[80vh]', 'overflow-y-auto');

    // Initialize email input handlers
    initializeEmailInputs();

    // Add event listener for adding new email input
    const addEmailInputBtn = document.getElementById('addEmailInputBtn');

    // Add event listener to remove error message on input
    document.getElementById('emailInputsContainer').addEventListener('input', function (event) {
        if (event.target.name === 'team_members[]') {
            const errorMessage = event.target.closest('.email-input-container').querySelector('.error-message');
            if (errorMessage) {
                errorMessage.classList.add('hidden');
                event.target.classList.remove('border-red-500');
            }
        }
    });

    // Add event listener for adding new task
    document.getElementById('addTaskBtn').addEventListener('click', addTask);

    // Add event listener to enable the submit button when the form is complete
    document.getElementById('teamCompleteForm').addEventListener('input', checkFormCompletion);
});

function initializeEmailInputs() {
    const emailInputs = document.querySelectorAll('input[name="team_members[]"]');
    emailInputs.forEach(input => {
        setupEmailInput(input);
    });
}

function setupEmailInput(input) {
    // Create suggestions container
    const suggestionsContainer = document.createElement('div');
    suggestionsContainer.className =
        'suggestions absolute w-full bg-white shadow-lg rounded-lg mt-1 hidden z-50 max-h-48 overflow-y-auto';
    input.parentNode.appendChild(suggestionsContainer);

    let timeoutId = null;

    input.addEventListener('input', function () {
        const email = this.value;

        // Clear previous timeout
        if (timeoutId) {
            clearTimeout(timeoutId);
        }

        // Don't search if input is too short
        if (email.length < 2) {
            suggestionsContainer.classList.add('hidden');
            return;
        }

        // Set new timeout
        timeoutId = setTimeout(async () => {
            try {
                const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
                const csrfToken = csrfTokenMeta ? csrfTokenMeta.content : null;

                if (!csrfToken) {
                    console.error('CSRF token not found');
                    return;
                }

                const response = await fetch(
                    `/api/search-users?query=${encodeURIComponent(email)}`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const data = await response.json();

                if (data.users && data.users.length > 0) {
                    suggestionsContainer.innerHTML = data.users.map(user => `
                                <div class="suggestion p-2 hover:bg-gray-100 cursor-pointer">
                                    <div class="text-sm">${user.email}</div>
                                    <div class="text-xs text-gray-600">${user.first_name} ${user.last_name}</div>
                                </div>
                            `).join('');

                    suggestionsContainer.classList.remove('hidden');

                    // Add click handlers
                    suggestionsContainer.querySelectorAll('.suggestion').forEach((div,
                        index) => {
                        div.addEventListener('click', function () {
                            input.value = data.users[index].email;
                            suggestionsContainer.classList.add('hidden');
                        });
                    });
                } else {
                    suggestionsContainer.innerHTML =
                        '<div class="p-2 text-gray-500">No users found</div>';
                    suggestionsContainer.classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error fetching suggestions:', error);
            }
        }, 300);
    });
}

// Update the addEmailInput function to ensure error message div is created
function addEmailInput() {
    const emailInputs = document.getElementById('emailInputsContainer');
    const emailInput = document.createElement('div');
    emailInput.classList.add('email-input-container', 'relative');
    emailInput.innerHTML = `
        <div class="relative">
            <input type="email" name="team_members[]"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                placeholder="Enter team member's email">
            <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" onclick="removeEmailInput(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
    `;
    emailInputs.appendChild(emailInput);

    // Initialize the new email input
    const newInput = emailInput.querySelector('input[name="team_members[]"]');
    setupEmailInput(newInput);

    // Add event listener to remove error message on input
    newInput.addEventListener('input', function () {
        const errorMessage = newInput.closest('.email-input-container').querySelector('.error-message');
        if (errorMessage) {
            errorMessage.classList.add('hidden');
            newInput.classList.remove('border-red-500');
        }
    });
}
async function saveTeamMembers() {
    try {
        const emailInputs = Array.from(document.querySelectorAll('input[name="team_members[]"]'));
        const emails = emailInputs.map(input => input.value.trim()).filter(email => email);

        if (emails.length === 0) {
            showNotification('Please add at least one email before submitting.', 'error');
            return;
        }

        clearErrors();

        const response = await fetch('http://127.0.0.1:8000/api/validate-user', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ emails }),
        });

        const data = await response.json();

        if (response.ok && data.success) {
            // Clear any existing hidden team member inputs
            const existingInputs = document.querySelectorAll('input[name="team_members[]"][type="hidden"]');
            existingInputs.forEach(input => input.remove());

            // Add hidden inputs for team members to the form
            const form = document.querySelector('#teamCompleteForm');
            emails.forEach(email => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'team_members[]';
                hiddenInput.value = email;
                form.appendChild(hiddenInput);
            });

            updateAssigneeDropdowns(data.users);
            closePeopleModal();
            showNotification('Team members added successfully', 'success');
        } else {
            if (data.errors) {
                data.errors.forEach(error => {
                    const input = emailInputs.find(i => i.value.trim().toLowerCase() === error.email.toLowerCase());
                    if (input) {
                        const container = input.closest('.email-input-container');
                        const errorDiv = container.querySelector('.error-message');
                        errorDiv.textContent = error.message;
                        errorDiv.classList.remove('hidden');
                        input.classList.add('border-red-500');
                    }
                });
            } else {
                showNotification('An error occurred while validating team members.', 'error');
            }
        }
    } catch (error) {
        console.error('Error saving team members:', error);
        showNotification('Unable to validate team members. Please try again.', 'error');
    }
}
// Function to show notifications
function showNotification(message, type = 'error') {
    const notification = document.createElement('div');
    notification.className =
        `fixed bottom-4 right-4 p-4 rounded-lg ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white z-50`;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Function to update assignee dropdowns
function updateAssigneeDropdowns(users) {
    if (!users || !Array.isArray(users)) {
        console.error('Invalid users data:', users);
        return;
    }

    const assigneeSelects = document.querySelectorAll('.assignee-select');

    // Create options HTML
    const optionsHTML = users.map(user => {
        if (user && user.id && user.first_name && user.last_name) {
            return `<option value="${user.id}">${user.first_name} ${user.last_name}</option>`;
        }
        return '';
    }).join('');

    // Update each select element
    assigneeSelects.forEach(select => {
        if (select) {
            // Keep the default "Select Assignee" option
            const defaultOption = `<option value="" disabled selected>Select Assignee</option>`;
            select.innerHTML = defaultOption + optionsHTML;
        }
    });
}

function clearErrors() {
    // Clear error messages
    const errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(errorMessage => {
        errorMessage.classList.add('hidden');
        errorMessage.textContent = '';
    });

    // Clear input highlighting
    const inputs = document.querySelectorAll('input[name="team_members[]"]');
    inputs.forEach(input => {
        input.classList.remove('border-red-500');
    });
}
// Function to display errors
function displayErrors(errors) {
    errors.forEach(error => {
        const input = document.querySelector(`input[name="team_members[]"][value="${error.email}"]`);
        if (input) {
            const errorMessage = input.parentNode.querySelector('.error-message');
            if (errorMessage) {
                errorMessage.textContent = error.message;
                errorMessage.classList.remove('hidden');
            }
        }
    });
}

function addTask() {
    const taskIndex = document.querySelectorAll('.task-item').length;
    const taskContainer = document.createElement('div');
    taskContainer.classList.add('task-item');
    taskContainer.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="labels">Task Name <span class="asterisk">*</span></label>
                <input type="text" name="tasks[${taskIndex}][name]"
                    class="required-field fields error-prone"
                    placeholder="What needs to be done?">
            </div>
            <div>
                <label class="labels">Assignee <span class="asterisk">*</span></label>
                <select name="tasks[${taskIndex}][assignee]"
                    class="required-field fields text-zinc-400 assignee-select error-prone">
                    <option value="" disabled selected>Select Assignee</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="labels">Due Date <span class="asterisk">*</span></label>
                <input type="date" name="tasks[${taskIndex}][due_date]"
                    class="required-field fields text-zinc-400 focus:text-black error-prone"
                    oninput="this.classList.remove('text-zinc-400'); this.classList.add('text-black');">
            </div>
            <div>
                <label class="labels">Time <span class="asterisk">*</span></label>
                <input type="time" name="tasks[${taskIndex}][due_time]"
                    class="required-field fields text-zinc-400 focus:text-black error-prone"
                    oninput="this.classList.remove('text-zinc-400'); this.classList.add('text-black');">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="labels">Description </label>
                <textarea name="tasks[${taskIndex}][description]" class="fields" placeholder="Add some details..."></textarea>
            </div>
            <div>
                <label class="labels">Priority Level <span class="asterisk">*</span> </label>
                <select name="tasks[${taskIndex}][priority]"
                    class="required-field fields text-zinc-400 error-prone"
                    onchange="this.classList.remove('text-zinc-400'); this.classList.add('text-black');">
                    <option value="" disabled selected>Select Priority Level</option>
                    <option value="High">High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                </select>
            </div>
        </div>
    `;
    document.getElementById('teamTasks').appendChild(taskContainer);

    // Update assignee dropdowns with existing users
    updateAssigneeDropdowns(existingUsers);
}

function checkFormCompletion() {
    const form = document.getElementById('teamCompleteForm');
    const requiredFields = form.querySelectorAll('.required-field');
    let allFieldsFilled = true;

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            allFieldsFilled = false;
        }
    });

    const submitButton = form.querySelector('button[type="submit"]');
    if (allFieldsFilled) {
        submitButton.disabled = false;
        submitButton.classList.remove('cursor-not-allowed');
        submitButton.classList.remove('opacity-50');
    } else {
        submitButton.disabled = true;
        submitButton.classList.add('cursor-not-allowed');
    }
}
