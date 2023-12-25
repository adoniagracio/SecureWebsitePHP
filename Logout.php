<?php
session_start();
require "./Controllers/koneksi.php";

$sid = $_SESSION["user_id"];
if (isset($_SESSION["user_id"])) {
$updateSql = "UPDATE users set sesi = 'NULL' WHERE id = '$sid';";
$db->query($updateSql);
session_unset();
session_destroy();
$_SESSION = array();
}


if (isset($_COOKIE['user_email'])) {
    unset($_COOKIE['user_email']);
    setcookie('user_email', '', time() - 3600, '/');
}



header("Location: Login.php");
exit();
?>