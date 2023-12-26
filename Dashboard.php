    <?php
    session_start();
    require 'Controllers/condb.php';

    if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 1800) {
        session_regenerate_id(true); 
        $_SESSION['last_activity'] = time(); 
    } else {
        $_SESSION['last_activity'] = time(); 
    }

    if (!isset($_SESSION['is_login']) || !$_SESSION['is_login'] || !isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit(); 
    }
    session_regenerate_id();
    $_SESSION['last_activity'] = time(); 
    $user_id = $_SESSION['user_id'];

    header("X-XSS-Protection: 1; mode=block");
    header("X-Frame-Options: SAMEORIGIN");
    header("X-Content-Type-Options: nosniff");
    header("Referrer-Policy: strict-origin-when-cross-origin");
    header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

    require "./Controllers/koneksi.php";
    $sql = "SELECT id_product,nama_product FROM product";
    $result = $db->query($sql);
    ?>


    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="./asset/css/dashboard.css">
        <title>Dashboard</title>
    </head>
    <body> 
        <div class="container mt-4">
        <h1 class="display-5">Stored Product</h1>
            <?php include('Controllers/message.php'); ?>
            <div class="row">
            <div class="col">
                <p class="text-muted">Hello, <?= $_SESSION['username']; ?>!</p>
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
                                        <th>Gambar Barang</th>
                                        <th>Harga Barang</th>
                                        <th>Quantity Barang</th>
                                        <th>Tanggal Exp Barang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php   
                                        $query = "SELECT * FROM product WHERE id_user = ?";
                                        $prep_state = $con->prepare($query);
                                        $prep_state->bind_param("i", $user_id);
                                        $prep_state->execute();
                                        $result = $prep_state->get_result();
                                        
                                        if ($result->num_rows > 0) {
                                            while ($barang = $result->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td><?= $barang['nama_product']; ?></td>
                                                    <td><img src="<?= 'uploaded_img/' . $barang['gambar_product']; ?>" alt="Product Image" style="width: 200px; height: 200px;"></td>
                                                    <td><?= "Rp. " . $barang['harga_product'] ?></td>
                                                    <td><?= $barang['quantity']; ?></td>
                                                    <td><?= $barang['tanggal_exp_product']; ?></td>
                                                    <td>
                                                        <form action="UpdateBarang.php" method="POST" class="d-inline">
                                                            <input type="hidden" name="product_id" value="<?= hash('sha256', $barang['id_product']); ?>">
                                                            <button type="submit" name="edit_product" class="btn btn-success btn-sm">Edit</button>
                                                        </form>
                                        
                                                        <form action="Controllers/delete&update.php" method="POST" class="d-inline">
                                                            <input type="hidden" name="barang_id" value="<?= hash('sha256', $barang['id_product']); ?>">
                                                            <button type="submit" name="delete_product" class="btn btn-danger btn-sm">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            echo "<h5> No Record Found </h5>";
                                        }
                                        
                                     $prep_state->close();
                               
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





