<?php
session_start();

// Regenerate the session ID periodically
if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 1800) {
    session_regenerate_id(true); // Regenerate session ID if inactive for more than 1800 seconds (30 minutes)
    $_SESSION['last_activity'] = time(); // Update last activity time
} else {
    $_SESSION['last_activity'] = time(); // Update last activity time
}

// Redirect if not logged in
if($_SESSION['is_login'] !== true) {
    header("Location: login.php");
    exit(); // Ensure no further content is processed after redirection
}

// Security headers
header("Content-Security-Policy: default-src 'self'");
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
    <title>Dashboard</title>
    <h1>TITIT</h1>
</head>
<body>
    

    <a href="logout.php">Logout</a>
</body>
</html>