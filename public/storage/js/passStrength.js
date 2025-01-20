function checkPasswordStrength() {
    const password = document.getElementById("reg_password").value;
    const strengthBar = document.getElementById("passwordStrengthIndicator");
    const strengthText = document.getElementById("passwordStrengthText");
    const strengthLevels = [{
            color: 'red',
            text: 'Very Weak'
        },
        {
            color: 'orange',
            text: 'Weak'
        },
        {
            color: 'yellow',
            text: 'So-so'
        },
        {
            color: 'lightgreen',
            text: 'Good'
        },
        {
            color: 'green',
            text: 'Strong'
        }
    ];

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