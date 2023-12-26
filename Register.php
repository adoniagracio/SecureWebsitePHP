<?php
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); 
}

if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 1800) {
    session_regenerate_id(true); 
    $_SESSION['last_activity'] = time(); 
} else {
    $_SESSION['last_activity'] = time(); 
}

if (isset($_SESSION['is_login']) && $_SESSION['is_login'] === true) {
    header("Location: Dashboard.php");
    exit();
}

header("X-XSS-Protection: 1; mode=block");
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="asset/css/register.css">
    <title>Secure Website</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <form class="box" action="Controllers/registerauth.php" method="POST" onsubmit="return validateForm()">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" />

                        <h1>Sign Up</h1>
                        <div id="error-message" class="text-danger"></div>
                        <p class="text-muted"> Please Input to register</p>
                        <input type="text" name="name" placeholder="Name" id="name" required>
                        <input type="email" name="email" placeholder="Enter Email" id="email" required>
                        <input type="tel" name="phone" placeholder="Phone Number" id="phone" required>
                        <input type="password" name="password" placeholder="Password" id="password" required>
                        <span class="text" style="color: white;">if you already have an account <a class="forgot text-muted" href="./Login.php">Sign In</a></span>
                         <input type="submit" name="Register" value="Sign Up">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="./asset/js/registervalidation.js"></script>
</body>
</html>