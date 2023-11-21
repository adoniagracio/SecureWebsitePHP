<?php
require "./koneksi.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Check the database connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Prepare and bind the SQL query
    $query = "SELECT * FROM users WHERE email=? AND password=?";
    $stmt = $db->prepare($query);
    if (!$stmt) {
        die("Error preparing statement: " . $db->error);
    }
    
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // The user has been authenticated
        $row = $result->fetch_assoc();

        // Destroy any existing session
        session_unset();
        session_destroy();
        session_start();

        $_SESSION["success_message"] = "Login Success";
        $_SESSION["user_id"] = $row['id'];
        $_SESSION['is_login'] = true;
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['fullname'] = $row['fullname'];

        // Set a cookie to remember the user for 7 days
        $seconds_per_day = 86400;
        $cookie_expiry = time() + (7 * $seconds_per_day);
        setcookie('user_email', $email, $cookie_expiry);

        header("Location: ../Dashboard.php");
    } else {
        $_SESSION["error_message"] = "Incorrect email or password";
        header("Location: ../Login.php");
    }
}
?>