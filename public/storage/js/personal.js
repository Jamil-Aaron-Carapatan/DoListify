
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#completeForm');
    const submitButton = form.querySelector('button[type="submit"]');
    const requiredFields = form.querySelectorAll('.required-field');

    function checkFormValidity() {
        let isValid = true;
        requiredFields.forEach(field => {
            if (!field.value) {
                isValid = false;
            }
        });
        submitButton.disabled = !isValid;
        submitButton.style.cursor = isValid ? 'pointer' : 'not-allowed';
        if (isValid) {
            submitButton.classList.remove('opacity-50');
        } else {
            submitButton.classList.add('opacity-50');
        }
    }

    requiredFields.forEach(field => {
        field.addEventListener('input', checkFormValidity);
        field.addEventListener('change', checkFormValidity);
    });
});