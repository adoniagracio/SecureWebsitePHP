<?php
session_start();

$_SESSION = array();

session_destroy();
session_unset();

if (isset($_COOKIE['user_email'])) {
    unset($_COOKIE['user_email']);
    setcookie('user_email', '', time() - 3600, '/');
}

header("Location: Login.php");
exit();
?>