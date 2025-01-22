// Ensure taskId is defined globally or passed correctly
const taskId = document.querySelector('meta[name="current-task-id"]').content;

function autoSave(field, value) {
    fetch(`/tasks/${taskId}/update`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            [field]: value
        })
    }).then(response => {
        if (response.ok) {
            console.log('Saved successfully!');
        }
    }).catch(error => console.error('Error saving data:', error));
}

function toggleChecklistItem(itemId, isCompleted) {
    fetch(`/checklist/${itemId}/toggle`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            is_completed: isCompleted
        })
    }).then(response => {
        if (response.ok) {
            console.log('Checklist item updated!');
        }
    }).catch(error => console.error('Error toggling checklist:', error));
}

function autoSaveChecklistItem(itemId, value) {
    fetch(`/checklist/${itemId}/update`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            name: value
        })
    }).then(response => {
        if (response.ok) {
            console.log('Checklist item updated!');
        }
    }).catch(error => console.error('Error saving checklist item:', error));
}

function saveChecklist() {
    const checklistItems = document.querySelectorAll('.checklist-text');
    checklistItems.forEach(item => {
        const itemId = item.getAttribute('data-id');
        const value = item.value;
        autoSaveChecklistItem(itemId, value);
    });
}

function addChecklistItem() {
    const taskId = document.querySelector('meta[name="current-task-id"]').content;
    fetch(`/checklist/create`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            task_id: taskId,
            name: 'New Item'
        })
    }).then(response => response.json())
    .then(data => {
        // Append new checklist item dynamically
        const container = document.getElementById('checklist-container');
        container.insertAdjacentHTML('beforeend', `
            <div class="flex items-center space-x-2">
                <input type="checkbox" id="checklist-item-${data.id}" 
                    class="checkbox-item" onchange="toggleChecklistItem(${data.id}, this.checked)">
                <input type="text" value="${data.name}" 
                    class="w-full border-none text-zinc-600 focus:outline-none checklist-text" 
                    data-id="${data.id}" oninput="autoSaveChecklistItem(${data.id}, this.value)">
            </div>
        `);
    }).catch(error => console.error('Error adding checklist item:', error));
}
function autoExpand(textarea) {
    // Reset the height to calculate the new height properly
    textarea.style.height = "auto";

    // Adjust the height based on the scroll height
    textarea.style.height = textarea.scrollHeight + "px";
}