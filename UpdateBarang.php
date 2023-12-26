<?php
session_start();
require 'Controllers/condb.php';

if (!isset($_SESSION['is_login']) || !$_SESSION['is_login'] || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit(); 
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Update Product</title>
</head>
<body>
  
    <div class="container mt-5">

        <?php include('Controllers/message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Product Update
                            <a href="Dashboard.php" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <?php
                        if (isset($_POST['edit_product'])) 
                         {
                            $product_id = mysqli_real_escape_string($con, $_POST['product_id']);
                            $query = "SELECT * FROM product WHERE SHA2(id_product, 256)='$product_id' ";
                            $query_run = mysqli_query($con, $query);
                            if(mysqli_num_rows($query_run) > 0)
                            {
                                $product = mysqli_fetch_array($query_run);
                                ?>
                        <form action="Controllers/delete&update.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="barang_id" value="<?= hash('sha256', $product['id_product']); ?>">
                                    <div class="mb-3">
                                <label>Product Name</label>
                                <input type="text" name="name" class="form-control" value="<?= $product['nama_product']; ?>" required>
                             </div>

                             <label for="image">Product Picture</label> 
                            <div class="mb-3">
                                <td><img src="<?= 'uploaded_img/' . $product['gambar_product']; ?>" alt="Product Image" style="width: 200px; height: 200px; margin-bottom:20px;"></td>
                                <input type="file" name="image" class="form-control" value="<?= $product['gambar_product']; ?>">
                            </div>
         
                             <div class="mb-3">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" class="form-control" value="<?= $product['quantity']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="productPrice">Product Price (Rupiah)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" name="price" class="form-control" id="priceInput" value="<?= $product['harga_product']; ?>" oninput="formatNominal(this)" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="expirationDate">Expiration Date</label>
                                <input type="date" name="expiration_date" class="form-control" value="<?= $product['tanggal_exp_product']; ?>" required>
                            </div>
                            <div class="mb-3">
                                 <button type="submit" name="update_product" class="btn btn-primary">Update Product</button>
                            </div>

                       </form>
                                <?php
                            }
                            else
                            {
                                echo "<h4>No Such Id Found</h4>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="./asset/js/addprocval.js"></script>
</html>