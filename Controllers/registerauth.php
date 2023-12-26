    <?php
    require "./koneksi.php";
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = mysqli_real_escape_string($db, $_POST['name']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $phone = mysqli_real_escape_string($db, $_POST['phone']);
        $password = trim(mysqli_real_escape_string($db, $_POST['password']));
        
        if (empty($name) || empty($email) || empty($phone) || empty($password)) {
            $_SESSION["error_message"] = "All fields are required";
            header("Location: ../Register.php");
            exit();
        }

        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        $check_query = "SELECT * FROM users WHERE email=?";
        $check_stmt = $db->prepare($check_query);
        if (!$check_stmt) {
            die("Error preparing statement: " . $db->error);
        }
        
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $_SESSION["error_message"] = "Email is already registered";
            header("Location: ../Register.php");
            exit();
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $insert_query = "INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)";
        $insert_stmt = $db->prepare($insert_query);
        if (!$insert_stmt) {
            die("Error preparing statement: " . $db->error);
        }

        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
        $pass = htmlspecialchars($pass, ENT_QUOTES, 'UTF-8');
        $user_type = htmlspecialchars($user_type, ENT_QUOTES, 'UTF-8');

        $insert_stmt->bind_param("ssss", $name, $email, $phone, $hashed_password);
        $insert_stmt->execute();

        if ($insert_stmt->affected_rows > 0) {
            $_SESSION["success_message"] = "Registration success. You can now log in.";
            header("Location: ../Login.php");
        } else {
            $_SESSION["error_message"] = "Registration failed. Please try again.";
            header("Location: ../Register.php");
        }
    }
    ?>
