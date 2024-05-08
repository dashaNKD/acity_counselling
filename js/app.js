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

  // Email validation
  if (!validateEmail(email)) {
    showError('emailError', ERROR_MESSAGES.email);
    return;
  }

  // Date validation
  if (!validateDate(date)) {
    showError('dateError', ERROR_MESSAGES.date);
    return;
  }

  // Time validation
  if (!validateTime(time)) {
    showError('timeError', ERROR_MESSAGES.time);
    return;
  }

  // Submit form
  appointmentForm.submit();
  alert('Appointment request submitted successfully!');
});

// Function to validate email format
function validateEmail(email) {
  return /^[a-zA-Z0-9._%+-]+@acity\.edu\.gh$/.test(email);
}

// Function to validate date format and availability
function validateDate(date) {
  const today = new Date();
  const selectedDate = new Date(date);
  return selectedDate >= today && !unavailableTimesToday.has(date);
}

// Function to validate time format and availability
function validateTime(time) {
  return availableTimes.has(time) && !unavailableTimesToday.has(time);
}

// Function to show error messages
function showError(errorId, message) {
  const errorElement = document.getElementById(errorId);
  errorElement.textContent = message;
  errorElement.classList.remove('hidden');
}

// Update unavailable times when a user selects a time
appointmentForm.addEventListener('input', (event) => {
  if (event.target.name === 'time') {
    const selectedTime = event.target.value;
    unavailableTimesToday.add(selectedTime);
  }
});
