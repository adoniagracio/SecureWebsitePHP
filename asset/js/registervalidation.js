function validateForm() {
    var name = document.getElementById('name').value.trim();
    var email = document.getElementById('email').value.trim();
    var phone = document.getElementById('phone').value.trim();
    var password1 = document.getElementById("password").value;
    var password = password1.replace(/\s+/g, ' ');
    var phoneRegex = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
    var passwordRegex = /^(?!.* )(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?])(?=.*[0-9])(?=.*[A-Z]).{8,}$/;

    clearErrorMessages(); 

    if (name === '' || email === '' || phone === '' || password === '') {
        displayErrorMessage('All fields must be filled out');
        return false;
    }
    if (!phoneRegex.test(phone)) {
        displayErrorMessage('Invalid phone');
        return false;
    }
    if (!passwordRegex.test(password)) {
        displayErrorMessage('Password must be at least 8 characters long and contain at least one special character, one number, and one uppercase letter.');
        return false;
    }
    return true; 
}

function displayErrorMessage(message) {
    var errorMessageDiv = document.getElementById('error-message');
    errorMessageDiv.innerHTML = message;
}

function clearErrorMessages() {
    var errorElements = document.querySelectorAll('.text-danger');
    errorElements.forEach(function(element) {
        element.innerHTML = '';
    });
}
