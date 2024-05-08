const form = document.getElementById('appointmentForm');
const emailError = document.getElementById('emailError');

form.addEventListener('submit', (event) => {
    event.preventDefault();

    const email = document.getElementById('email').value;

    // Email validation
    if (!email.endsWith('@acity.edu.gh')) {
        emailError.classList.remove('hidden');
        return;
    } else {
        emailError.classList.add('hidden');
    }

    // Reset form
    form.reset();

    // Submit form
    alert('Appointment request submitted successfully!');
});