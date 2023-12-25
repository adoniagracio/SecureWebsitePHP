<?php
session_start();
require 'Controllers/condb.php';

if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 1800) {
    session_regenerate_id(true);
    $_SESSION['last_activity'] = time();
} else {
    $_SESSION['last_activity'] = time();
}

if ($_SESSION['is_login'] !== true) {
    header("Location: login.php");
    exit();
}


require "./Controllers/koneksi.php";
$sql = "SELECT id_product, nama_product FROM product";
$result = $db->query($sql);
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Dashboard</title>
</head>
<body> 
    <div class="container mt-4">
        <?php include('Controllers/message.php'); ?>
        <div class="row">
            <div class="col">
                <a href="logout.php" class="btn btn-danger float-end">Logout</a>
            </div>       
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Stock Barang
                            <a href="Addproduct.php" class="btn btn-primary float-end">Add Product</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $query = "SELECT * FROM product";
                                    $query_run = mysqli_query($con, $query);
                                    if(mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $barang)
                                        {
                                            ?>
                                            <tr>
                                                <td><?= htmlspecialchars($barang['nama_product']); ?></td>
                                                <td>
                                                    <a href="UpdateBarang.php?id=<?= htmlspecialchars($barang['id_product']); ?>" class="btn btn-success btn-sm">Edit</a>
                                                    <form action="Controllers/delete&update.php" method="POST" class="d-inline">
                                                        <button type="submit" name="delete_product" value="<?= htmlspecialchars($barang['id_product']); ?>" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        echo "<h5> No Record Found </h5>";
                                    }
                                ?> 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
