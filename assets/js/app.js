// Form validation and date availability
const appointmentForm = document.getElementById('appointmentForm');
const availableTimes = ['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30'];

appointmentForm.addEventListener('submit', (event) => {
    event.preventDefault();

    const formData = new FormData(appointmentForm);
    const email = formData.get('email');
    const date = formData.get('date');
    const time = formData.get('time');

    // email validation
    if (!email.endsWith('@acity.edu.gh')) {
        showError('emailError', 'Please use your acity.edu.gh email account.');
        return;
    }

    // date validation
    const today = new Date();
    const selectedDate = new Date(date);
    if (selectedDate < today) {
        showError('dateError', 'Sorry, this date is unavailable. Please choose another date.');
        return;
    }

    // time validation
    if (!availableTimes.includes(time)) {
        showError('timeError', 'Sorry, this time slot is unavailable. Please choose another time.');
        return;
    }

    // submit form
    appointmentForm.submit();
    alert('Appointment request submitted successfully!');
});

function showError(errorId, message) {
    const errorElement = document.getElementById(errorId);
    errorElement.textContent = message;
    errorElement.classList.remove('hidden');
}