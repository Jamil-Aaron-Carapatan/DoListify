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

function autoExpand(textarea) {
    // Reset the height to calculate the new height properly
    textarea.style.height = "auto";

    // Adjust the height based on the scroll height
    textarea.style.height = textarea.scrollHeight + "px";
}
document.addEventListener("DOMContentLoaded", function() {
    var textarea = document.getElementById("text-desc");
    autoExpand(textarea);
});