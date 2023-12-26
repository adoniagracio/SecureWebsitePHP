<?php
require "./koneksi.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token'])
    {
        $email = $_POST['email'];
        $pass = trim($_POST['password']);
        
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }
    
        $query = "SELECT * FROM users WHERE email=?";
        $stmt = $db->prepare($query);
        if (!$stmt) {
            die("Error preparing statement: " . $db->error);
        }
    
        $stmt->bind_param("s", $email);
        $stmt->execute();
    
        $select_users = $stmt->get_result();
    
        $row = mysqli_fetch_assoc($select_users);
    
        if (mysqli_num_rows($select_users) === 1 && password_verify($pass, $row['password'])) {
            // Destroy any existing session
            session_unset();
            session_destroy();
            session_unset();
            $_SESSION = array();
            session_start();
    
            $_SESSION['session_id'] = hash('sha256', random_bytes(32));
            $si = $_SESSION['session_id'];
            $_SESSION['is_login'] = true;
            $seconds_per_day = 86400;
            $_SESSION['username'] = $row['name'];
            $_SESSION["user_id"] = $row['id'];
            $sid = $_SESSION["user_id"];
            $updateSql = "UPDATE users set sesi = '$si' WHERE id = '$sid';";
            $db->query($updateSql);
            $cookie_expiry = time() + (7 * $seconds_per_day);
            setcookie('user_email', $email, $cookie_expiry);
            header("Location: ../Dashboard.php");
        } else {
            $_SESSION["error_message"] = "Incorrect email or password";
            header("Location: ../Login.php");
        }

    }
    else {
        $_SESSION["error_message"] = "Incorrect email or password";
        header("Location: ../Login.php");
    }
} else {
    $_SESSION["error_message"] = "Incorrect email or password";
    header("Location: ../Login.php");
}
?>
