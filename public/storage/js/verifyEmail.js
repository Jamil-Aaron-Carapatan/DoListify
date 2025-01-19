document.addEventListener("DOMContentLoaded", function () {
    const verificationForm = document.getElementById("emailVerificationForm");
    const verificationInput = document.getElementById("verification_code");
    const resendButton = document.getElementById("resendVerificationCode");
    const errorMessage = document.querySelector(".error-message");

    // Get the form action URL from the form's value attribute
    const verifyUrl = verificationForm.getAttribute("value");

    verificationInput.addEventListener("input", function (e) {
        this.value = this.value.replace(/[^0-9]/g, "");

        clearErrorStyling();
    });

    function clearErrorStyling() {
        // Remove error styling from input
        verificationInput.classList.remove(
            "border-t",
            "border-l",
            "border-r",
            "border-red-500",
            "shadow-red-500"
        );
        verificationInput.classList.add("shadow-cyan-800/75");

        // Hide error message
        errorMessage.classList.add("hidden");

        // Reset error message styling
        errorMessage.classList.remove("text-red-500");
    }

    verificationForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent default form submission
        console.log("Form submit event triggered"); // Add a log to confirm the event is handled

        errorMessage.classList.add("hidden");

        const code = verificationInput.value.trim();

        if (code.length !== 6) {
            showError("Please enter a valid 6-digit code");
            return;
        }

        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerHTML = "Verifying...";

        // Use the route from the form's value attribute
        fetch(verifyUrl, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]')
                    .value,
                Accept: "application/json",
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                code: code,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    if (data.redirect) {
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1500);
                    }
                } else {
                    showError(data.message);
                }
            })
            .catch((error) => {
                showError("An error occurred. Please try again.");
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = "Verify Email";
            });
    });
    // Check if there is a stored timeLeft value in localStorage
    let timeLeft = localStorage.getItem("timeLeft")
        ? parseInt(localStorage.getItem("timeLeft"))
        : 0;
    if (timeLeft > 0) {
        // If there's a stored timeLeft, show the countdown immediately
        resendButton.disabled = true;
        resendButton.innerHTML = `Resend in ${timeLeft}s`;
        const interval = setInterval(() => {
            if (timeLeft <= 0) {
                resendButton.disabled = false;
                resendButton.innerHTML = "Resend Code";
                clearInterval(interval);
                localStorage.removeItem("timeLeft"); // Clear the stored timeLeft
            } else {
                resendButton.innerHTML = `Resend in ${timeLeft}s`;
                timeLeft--;
                localStorage.setItem("timeLeft", timeLeft); // Update timeLeft in localStorage
            }
        }, 1000);
    }

    resendButton.addEventListener("click", function (e) {
        e.preventDefault(); //
        this.disabled = true;
        this.innerHTML = "Sending...";

        fetch("/resend-verification", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]')
                    .value,
                Accept: "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    showSuccess(data.message);
                    timeLeft = 60;
                    localStorage.setItem("timeLeft", timeLeft); // Store timeLeft when resend is successful
                    const interval = setInterval(() => {
                        if (timeLeft <= 0) {
                            resendButton.disabled = false;
                            resendButton.innerHTML = "Resend Code";
                            clearInterval(interval);
                            localStorage.removeItem("timeLeft"); // Clear the stored timeLeft
                        } else {
                            resendButton.innerHTML = `Resend in ${timeLeft}s`;
                            timeLeft--;
                            localStorage.setItem("timeLeft", timeLeft); // Update timeLeft in localStorage
                        }
                    }, 1000);
                } else {
                    showError(data.message);
                    resendButton.disabled = false;
                    resendButton.innerHTML = "Resend Code";
                }
            })
            .catch((error) => {
                showError("Failed to resend code. Please try again.");
                resendButton.disabled = false;
                resendButton.innerHTML = "Resend Code";
            });
    });

    function showError(message) {
        errorMessage.textContent = message;
        errorMessage.classList.remove("hidden");
        errorMessage.classList.remove("text-green-500");
        errorMessage.classList.add("text-red-500");
        verificationInput.classList.add(
            "border-t",
            "border-l",
            "border-r",
            "border-red-500"
        );
    }

    function showSuccess(message) {
        errorMessage.textContent = message;
        errorMessage.classList.remove("hidden");
        errorMessage.classList.remove("text-red-500");
        errorMessage.classList.add("text-green-500");
    }
});
