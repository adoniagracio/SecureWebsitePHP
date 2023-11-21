<?php
    session_start();
    require "./koneksi.php";

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $gnarab_ID = $_POST['gnarab_ID'];
        $newStock2 = $_POST['newStock'];
        $newStock3 = $db->real_escape_string($newStock2);
        $newStock = htmlspecialchars($newStock3);
        $updateSql = "UPDATE gnarab SET nama_gnarab = '$newStock' WHERE gnarab_ID = '$gnarab_ID';";
        if ($db->query($updateSql) === TRUE) {
            header("Location: ../dashboard.php");
        } else {
            echo "Error: " . $db->error;
        }
    }
?>
