// function isValidEmail(email) {
// 	const emailRegex = /\S+@\S+\.\S+/;
// 	return emailRegex.test(email);
// }

// if (!isValidPassword(password)) {
//     console.log('Password is required');
//     ErrorPopup();
//     return;
// }

// function login(){
//     const email = document.getElementById('email').value;
//     const password = document.getElementById('password').value;
//     if (!isValidEmail(email)) {
//         console.log('Email is not valid, use this format "example@example.com"');
// 		ErrorPopup();
//         return;
//     }
//     if (!isValidPassword(password)) {
//         console.log('Password is required');
// 		ErrorPopup();
//         return;
//     }
// }

// const phoneInput = document.getElementById('phone');

// if (!/\+?([ -]?\d+)+|\(\d+\)([ -]\d+)/.test(phoneInput)) {
//     alert("Please enter a valid Indonesian phone number!");
//     return false;
// }

function validateFormPass() {
    var password1 = document.getElementById("password").value;
    var password = password1.replace(/\s+/g, ' ');
    var passwordRegex = /^(?!.* )(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?])(?=.*[0-9])(?=.*[A-Z]).{8,}$/;
    if (!passwordRegex.test(password)) {
        alert("Password must be at least 8 characters long and contain at least one special character, one number, and one uppercase letter.");
        return false;
    }
    return true;
}

function validateFromPhone(){
    var phone = document.getElementById("phone").value;
    var phoneRegex = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
    if(!phoneRegex.test(phone)){
        alert("Invalid phone");
        return false;
    }
    return true;
}