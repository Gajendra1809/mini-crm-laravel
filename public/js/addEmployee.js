$(document).ready(function () {
    $('.js-example-basic-single').select2();
});

document.addEventListener('DOMContentLoaded', function() {
const fnameField = document.getElementById('fname');
const lnameField = document.getElementById('lname');
const emailField = document.getElementById('email');
const phoneField = document.getElementById('phone');
const companyField = document.getElementById('companyId');
console.log(companyField);
const submitBtn = document.getElementById('submitBtn');

fnameField.addEventListener('input', validateForm);
lnameField.addEventListener('input', validateForm);
emailField.addEventListener('input', validateForm);
phoneField.addEventListener('input', validateForm);
companyField.addEventListener('click', function() {
validateForm();
});

function validateForm() {
console.log('Form validation triggered');
let fnameValid = fnameField.value.trim() !== '';
let lnameValid = lnameField.value.trim() !== '';
let emailValid = isValidEmail(emailField.value);
let phoneValid = isValidPhone(phoneField.value);
let companyValid = companyField.value !== '';

const fnameError = document.getElementById('fnameError');
const lnameError = document.getElementById('lnameError');
const emailError = document.getElementById('emailError');
const phoneError = document.getElementById('phoneError');
const companyError = document.getElementById('companyError');

fnameError.textContent = fnameValid ? '' : '*First Name is required';
lnameError.textContent = lnameValid ? '' : '*Last Name is required';
emailError.textContent = emailValid ? '' : '*Please enter a valid email address';
phoneError.textContent = phoneValid ? '' : '*Phone number must be 10 characters and Numeric only';
companyError.textContent = companyValid ? '' : '*Please select a company';

if (fnameValid && lnameValid && emailValid && phoneValid && companyValid) {
    submitBtn.style.display ="block";
} else {
    submitBtn.style.display ="none";
}
}

function isValidEmail(email) {
return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function isValidPhone(phone) {
    return /^\d{10}$/.test(phone);
}

});