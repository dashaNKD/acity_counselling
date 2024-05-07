// JavaScript for toggling forms
// Select the sign up button in the sign in form
const signUpButtonInSignInForm = document.getElementById('signIn').querySelector('#signUpButton');

// Select the sign in button in the sign up form
const signInButtonInSignUpForm = document.getElementById('signup').querySelector('#signInButton');

// Add a click event listener to the sign up button in the sign in form
signUpButtonInSignInForm.addEventListener('click', () => {
    // When clicked, hide the sign in form and show the sign up form
    document.getElementById('signup').style.display = 'block';
    document.getElementById('signIn').style.display = 'none';
});

// Add a click event listener to the sign in button in the sign up form
signInButtonInSignUpForm.addEventListener('click', () => {
    // When clicked, hide the sign up form and show the sign in form
    document.getElementById('signup').style.display = 'none';
    document.getElementById('signIn').style.display = 'block';
});

// Hide the sign up form initially
document.getElementById('signup').style.display = 'none';

// Show the sign in form initially
document.getElementById('signIn').style.display = 'block';