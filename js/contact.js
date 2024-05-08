const form = document.getElementById('appointmentForm');
const emailError = document.getElementById('emailError');

form.addEventListener('submit', (event) => {
    event.preventDefault();

    const name = document.getElementById('name').value;
    const rollNumber = document.getElementById('rollNumber').value;
    const email = document.getElementById('email').value;
    const message = document.getElementById('message').value;

    // Validate and sanitize form data
    if (!validateForm(name, rollNumber, email, message)) {
        return;
    }

    // Reset form
    form.reset();

    // Submit form
    alert('Appointment request submitted successfully!');
});

function validateForm(name, rollNumber, email, message) {
    // Email validation
    if (!email.endsWith('@acity.edu.gh')) {
        emailError.classList.remove('hidden');
        return false;
    } else {
        emailError.classList.add('hidden');
    }

    // Other form field validations (if needed)

    // Sanitize form data
    const sanitizedName = sanitizeInput(name);
    const sanitizedRollNumber = sanitizeInput(rollNumber);
    const sanitizedEmail = sanitizeInput(email);
    const sanitizedMessage = sanitizeInput(message);

    // Form data ready for submission
    return true;
}

function sanitizeInput(input) {
    // Remove leading and trailing whitespace
    input = input.trim();

    // Escape special characters that could be used for SQL injection
    // For example, replace single quotes (') with double single quotes ('')
    input = input.replace(/'/g, "''");

    // Other sanitization logic can be added as needed

    return input;
}