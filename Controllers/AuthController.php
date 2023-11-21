<?php
require "./koneksi.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "SELECT * FROM users WHERE email=? AND password=?;";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ss", $email, $password);

    $stmt->execute();
    $result = $stmt->get_result();
    
    $db->close();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        $_SESSION["success_message"] = "Login Success";
        $_SESSION["id"] = $row['id'];
        $_SESSION['is_login'] = true;
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['fullname'] = $row['fullname'];

        header("Location: ../Dashboard.php");
    }
    else {
        $_SESSION["error_message"] = "Login Failed";

        header("Location: ../Login.php");
    }
}
?>