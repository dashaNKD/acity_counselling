// Constants
const ERROR_MESSAGES = {
  email: 'Please use your acity.edu.gh email account.',
  date: 'Sorry, this date is unavailable. Please choose another date.',
  time: 'Sorry, this time slot is unavailable. Please choose another time.',
};

// Form validation and date availability
const appointmentForm = document.getElementById('appointmentForm');
const availableTimes = new Set(['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30']);
const unavailableTimesToday = new Set();

appointmentForm.addEventListener('submit', (event) => {
  event.preventDefault();

  const formData = new FormData(appointmentForm);
  const email = formData.get('email');
  const date = formData.get('date');
  const time = formData.get('time');

  // email validation
  if (!email.match(/^[a-zA-Z0-9._%+-]+@acity\.edu\.gh$/)) {
    showError('emailError', ERROR_MESSAGES.email);
    return;
  }

  // date validation
  const today = new Date();
  const selectedDate = new Date(date);
  if (selectedDate < today) {
    showError('dateError', ERROR_MESSAGES.date);
    return;
  } else if (selectedDate.toDateString() === today.toDateString() &&!isAvailableToday(time)) {
    showError('dateError', ERROR_MESSAGES.date);
    return;
  }

  // time validation
  if (!availableTimes.has(time)) {
    showError('timeError', ERROR_MESSAGES.time);
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

function isAvailableToday(time) {
  return!unavailableTimesToday.has(time);
}

// Update unavailable times when a user selects a time
appointmentForm.addEventListener('input', (event) => {
  if (event.target.name === 'time') {
    const selectedTime = event.target.value;
    unavailableTimesToday.add(selectedTime);
  }
});