<?php
    session_start();
    require "./koneksi.php";

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $newStock2 = $_POST['newStock'];
        $newStock3 = $db->real_escape_string($newStock2);
        $newStock = htmlspecialchars($newStock3);
        $updateSql = "INSERT INTO `gnarab` (`gnarab_ID`,`nama_gnarab`) VALUES (NULL,'$newStock');";
        if ($db->query($updateSql) === TRUE) {
            header("Location: ../dashboard.php");
        } else {
            echo "Error: " . $db->error;
        }
    }
?>
