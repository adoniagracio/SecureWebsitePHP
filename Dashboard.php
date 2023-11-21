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

require "./Controllers/koneksi.php";
$sql = "SELECT gnarab_ID,nama_gnarab FROM gnarab";
$result = $db->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>List barang</title>
</head>

<body>
    <h1>List barang</h1>
    <a href="logout.php">Logout</a>
    <form action="controllers/newBarang.php" method="POST">
            <input type="text" name="newStock" placeholder="nama baru" required>
            <input type="submit" value="add">
    </form>
    <table>
        <tr>
            <th>barang Name</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['nama_gnarab']; ?></td>
                <td>
                <form action="controllers/updatebarang.php" method="POST">
                        <input type="hidden" name="gnarab_ID" value="<?php echo $row['gnarab_ID']; ?>">
                        <input type="text" name="newStock" placeholder="nama baru" required>
                        <input type="submit" value="Ganti Nama">
                </form>
                <form action="controllers/deleteBarang.php" method="POST">
                        <input type="hidden" name="gnarab_ID" value="<?php echo $row['gnarab_ID']; ?>">
                        <input type="submit" value="hapus">
                </form>
                
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

</html>