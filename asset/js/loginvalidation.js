function validateForm() {
    var email = document.getElementById('email').value;
    var password1 = document.getElementById("password").value;
    var password = password1.replace(/\s+/g, ' ');


    clearErrorMessages(); 


    if ( email.trim() === '' || password.trim() === '') {
        displayErrorMessage('All fields must be filled out');
        return false;
    }   
    return true; 

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
}