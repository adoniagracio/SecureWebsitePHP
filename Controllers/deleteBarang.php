<?php
    session_start();
    require "./koneksi.php";

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $gnarab_ID = $_POST['gnarab_ID'];
        $updateSql = "DELETE FROM gnarab WHERE gnarab_ID = '$gnarab_ID';";
        if ($db->query($updateSql) === TRUE) {
            header("Location: ../dashboard.php");
        } else {
            echo "Error: " . $db->error;
        }
    }
?>
