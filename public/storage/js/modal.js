// Function to show the modal
function showModal(title, message, confirmCallback, cancelCallback) {
    const modal = document.getElementById("confirmationModal");
    const modalTitle = document.getElementById("modalTitle");
    const modalMessage = document.getElementById("modalMessage");
    const confirmButton = document.getElementById("confirmButton");
    const cancelButton = document.getElementById("cancelButton");

    // Set modal title and message
    modalTitle.innerText = title;
    modalMessage.innerText = message;

    // Show the modal
    modal.classList.remove("hidden");

    // Handle confirm button click
    confirmButton.onclick = function () {
        // Hide the modal
        modal.classList.add("hidden");
        // Execute the confirm callback
        confirmCallback();
    };

    // Handle cancel button click
    cancelButton.onclick = function () {
        // Hide the modal
        modal.classList.add("hidden");
        // Execute the cancel callback
        cancelCallback();
    };
}