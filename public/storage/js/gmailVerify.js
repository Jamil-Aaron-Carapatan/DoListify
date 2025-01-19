function addEmailValidation(formSelector) {
    $(`${formSelector} [name="email"]`).on("input", function () {
        const emailField = $(this);
        const emailValue = emailField.val();
        const emailRegex = /^[\w.+-]+@gmail\.com$/;
        emailField.siblings(".text-amber-600").remove();

        if (emailValue && !emailRegex.test(emailValue)) {
            emailField.addClass("border-red-500");
            emailField.after(
                '<p class="text-amber-600 text-xs mt-1">Please use a @gmail address</p>'
            );
        } else {
            emailField.removeClass("border-red-500");
            emailField.siblings(".text-red-500").remove();
        }
    });
}
$(document).ready(function () {
    addEmailValidation("#registerForm form");
    addEmailValidation("#loginForm form");
});

// Auto-remove error when user starts typing in the input fields
document.querySelectorAll("input").forEach((input) => {
    input.addEventListener("input", function () {
        const errorElement = this.parentElement.querySelector(".text-red-500");
        if (errorElement) {
            errorElement.remove();
            this.classList.remove("border-red-500");
        }
        if (this.type === "checkbox") {
            // For checkbox, find error message by name attribute
            const errorElement = document.querySelector(
                `[data-error="${this.name}"]`
            );
            if (errorElement) {
                errorElement.remove();
            }
        }
    });
});
