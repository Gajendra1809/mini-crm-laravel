document.addEventListener('DOMContentLoaded', function() {
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');
    const loginBtn=document.getElementById('loginBtn');

    emailField.addEventListener('input', validateForm);
    passwordField.addEventListener('input', validateForm);

    function validateForm() {
        let emailValid = isValidEmail(emailField.value);
        let passwordValid = passwordField.value.length >= 5;

        emailError.textContent = emailValid ? '' : '*Please enter a valid email address';
        passwordError.textContent = passwordValid ? '' : '*Password must be at least 5 characters';

        if (emailValid && passwordValid) {
            loginBtn.style.display = 'block';
        } else {
            loginBtn.style.display = 'none';
        }
    }

    

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);

        this.classList.toggle('fa-eye-slash');
        this.classList.toggle('fa-eye');
    });
});