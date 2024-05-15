document.addEventListener('DOMContentLoaded', function() {
    const nameField = document.getElementById('name');
    const emailField = document.getElementById('email');
    const logoField = document.getElementById('logo');
    const websiteField = document.getElementById('website');
    const locationField = document.getElementById('location');
    const submitBtn = document.getElementById('submitBtn');

    nameField.addEventListener('input', validateForm);
    emailField.addEventListener('input', validateForm);
    logoField.addEventListener('change', validateForm);
    websiteField.addEventListener('input', validateForm);

    function validateForm() {
        let nameValid = nameField.value.trim() !== '';
        let emailValid = isValidEmail(emailField.value);
        let logoValid = isPngFile(logoField.value);
        let websiteValid = isValidUrl(websiteField.value);

        document.getElementById('nameError').textContent = nameValid ? '' : '*Name is required';
        document.getElementById('emailError').textContent = emailValid ? '' : '*Please enter a valid email address';
        document.getElementById('logoError').textContent = logoValid ? '' : '*Please upload a PNG file';
        document.getElementById('websiteError').textContent = websiteValid ? '' : '*Please enter a valid URL';

        if (nameValid && emailValid && logoValid && websiteValid) {
            submitBtn.style.display = 'block';
        } else {
            submitBtn.style.display = 'none';
        }
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function isPngFile(filename) {
        return filename.toLowerCase().endsWith('.png');
    }

    function isValidUrl(url) {
        try {
            new URL(url);
            return true;
        } catch (e) {
            return false;
        }
    }
});