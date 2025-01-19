document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("loginForm");
    const verificationForm = document.getElementById("emailVerificationForm");
    const verificationInput = document.getElementById("verification_code");
    const resendButton = document.getElementById("resendVerificationCode");
    const errorMessage = document.querySelector(".error-message");

    // Handle login form submission
    if (loginForm) {
        loginForm.addEventListener("submit", function (e) {
            e.preventDefault();
            
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = "Processing...";

            const formData = new FormData(this);

            fetch(this.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                    Accept: "application/json",
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess(data.message);
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                } else {
                    showError(data.message || Object.values(data.errors).flat().join('<br>'));
                }
            })
            .catch(error => {
                showError("An error occurred. Please try again.");
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = "Login";
            });
        });
    }

    // Handle verification code input
    if (verificationInput) {
        verificationInput.addEventListener("input", function (e) {
            this.value = this.value.replace(/[^0-9]/g, "");
            clearErrorStyling();
        });
    }

    // Handle verification form submission
    if (verificationForm) {
        verificationForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const code = verificationInput.value.trim();
            if (code.length !== 6) {
                showError("Please enter a valid 6-digit code");
                return;
            }

            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = "Verifying...";

            fetch(this.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                    Accept: "application/json",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ code: code })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess(data.message);
                    if (data.redirect) {
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1500);
                    }
                } else {
                    showError(data.message);
                }
            })
            .catch(error => {
                showError("An error occurred. Please try again.");
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.innerHTML = "Verify Email";
            });
        });
    }

    // Handle resend verification code
    if (resendButton) {
        let timeLeft = localStorage.getItem("timeLeft") ? parseInt(localStorage.getItem("timeLeft")) : 0;
        
        if (timeLeft > 0) {
            startResendTimer(timeLeft);
        }

        resendButton.addEventListener("click", function (e) {
            e.preventDefault();
            
            if (this.disabled) return;
            
            this.disabled = true;
            this.innerHTML = "Sending...";

            fetch("/resend-verification-login", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                    Accept: "application/json",
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess(data.message);
                    startResendTimer(60);
                } else {
                    showError(data.message);
                    this.disabled = false;
                    this.innerHTML = "Resend Code";
                }
            })
            .catch(error => {
                showError("Failed to resend code. Please try again.");
                this.disabled = false;
                this.innerHTML = "Resend Code";
            });
        });
    }

    function startResendTimer(duration) {
        let timeLeft = duration;
        localStorage.setItem("timeLeft", timeLeft);
        
        resendButton.disabled = true;
        
        const interval = setInterval(() => {
            if (timeLeft <= 0) {
                resendButton.disabled = false;
                resendButton.innerHTML = "Resend Code";
                clearInterval(interval);
                localStorage.removeItem("timeLeft");
            } else {
                resendButton.innerHTML = `Resend in ${timeLeft}s`;
                timeLeft--;
                localStorage.setItem("timeLeft", timeLeft);
            }
        }, 1000);
    }

    function clearErrorStyling() {
        verificationInput?.classList.remove(
            "border-t",
            "border-l",
            "border-r",
            "border-red-500",
            "shadow-red-500"
        );
        verificationInput?.classList.add("shadow-cyan-800/75");
        errorMessage?.classList.add("hidden");
        errorMessage?.classList.remove("text-red-500");
    }

    function showError(message) {
        errorMessage.innerHTML = message;
        errorMessage.classList.remove("hidden", "text-green-500");
        errorMessage.classList.add("text-red-500");
        if (verificationInput) {
            verificationInput.classList.add(
                "border-t",
                "border-l",
                "border-r",
                "border-red-500"
            );
        }
    }

    function showSuccess(message) {
        errorMessage.textContent = message;
        errorMessage.classList.remove("hidden", "text-red-500");
        errorMessage.classList.add("text-green-500");
    }
});