// JavaScript for smooth scrolling
$(document).ready(function() {
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top
            }, 1000);
        }
    });
});

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
        alert('Please use your acity.edu.gh email account.');
        return;
    }

    // date validation
    const today = new Date();
    const selectedDate = new Date(date);
    if (selectedDate< today) {
        alert('Sorry, this date is unavailable. Please choose another date.');
        return;
    }

    // time validation
    if (!availableTimes.includes(time)) {
        alert('Sorry, this time slot is unavailable. Please choose another time.');
        return;
    }

    // reset form
    appointmentForm.reset();

    // submit form
    alert('Appointment request submitted successfully!');
});