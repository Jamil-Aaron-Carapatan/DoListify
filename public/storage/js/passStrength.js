function checkPasswordStrength() {
    const password = document.getElementById("reg_password").value;
    const strengthBar = document.getElementById("passwordStrengthIndicator");
    const strengthText = document.getElementById("passwordStrengthText");
    const eyeIcon = document.getElementById('eyeIcon');
    const strengthLevels = [
        { color: 'red', text: 'Very Weak' },
        { color: 'orange', text: 'Weak' },
        { color: 'yellow', text: 'So-so' },
        { color: 'lightgreen', text: 'Good' },
        { color: 'green', text: 'Strong' }
    ];

    // Show or hide the eye icon based on password input
    if (password.length > 0) {
        eyeIcon.style.display = 'flex'; // Show the eye icon
    } else {
        eyeIcon.style.display = 'none'; // Hide the eye icon when password is empty
    }

    let score = 0;

    // Check password strength criteria
    if (password.length >= 8) score++; // Length >= 8
    if (/[A-Z]/.test(password)) score++; // Contains uppercase letters
    if (/[a-z]/.test(password)) score++; // Contains lowercase letters
    if (/[0-9]/.test(password)) score++; // Contains numbers
    if (/[@$!%*?&#]/.test(password)) score++; // Contains special characters

    // Adjust strength bar and text
    strengthBar.style.width = (score / strengthLevels.length) * 100 + '%';
    strengthBar.style.backgroundColor = strengthLevels[score - 1]?.color || 'gray';
    strengthText.textContent = strengthLevels[score - 1]?.text || '';
    strengthText.style.color = strengthLevels[score - 1]?.color || 'gray';
}

function togglePassword() {
    const passwordField = document.getElementById('reg_password');
    const eyeIconClass = document.getElementById('eyeIconClass');
    if (passwordField.type === 'password') {
        passwordField.type = 'text'; // Show the password
        eyeIconClass.classList.remove('fa-eye-slash');
        eyeIconClass.classList.add('fa-eye'); // Change to open eye icon
    } else {
        passwordField.type = 'password'; // Hide the password
        eyeIconClass.classList.remove('fa-eye');
        eyeIconClass.classList.add('fa-eye-slash'); // Change to closed eye icon
    }
}
