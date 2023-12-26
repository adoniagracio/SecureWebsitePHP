<?php
session_start();

if (!isset($_SESSION['is_login']) || !$_SESSION['is_login'] || !isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit(); 
  header("X-XSS-Protection: 1; mode=block");
    header("X-Frame-Options: SAMEORIGIN");
    header("X-Content-Type-Options: nosniff");
    header("Referrer-Policy: strict-origin-when-cross-origin");
    header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./asset/css/addproduct.css">
    <title>Add Product</title>
  </head>
  <body>
    <div class="container mt-5"> <?php include('Controllers/message.php');  ?> <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4>Add Product <a href="Dashboard.php" class="btn btn-danger float-end">Back</a>
              </h4>
            </div>
            <div class="card-body">
              <form action="Controllers/delete&update.php" method="POST"  enctype="multipart/form-data" >
                <div class="mb-3">
                  <label>Product Name</label>
                  <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label for="picture">Product Picture</label>
                  <input type="file" name="picture" accept="image/jpg, image/jpeg, image/png" class="form-control"  required>
                </div>

                <div class="mb-3">
                  <label for="quantity">Quantity</label>
                  <input type="number" name="quantity" class="form-control" required>
                </div>

                <div class="mb-3">
                  <label for="productPrice">Product Price (Rupiah)</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Rp</span>
                    </div>
                    <input type="text" name="price" class="form-control" id="priceInput"  oninput="formatNominal(this)" required>
                    </div>
                </div>

                <div class="mb-3">
                  <label for="expirationDate">Expiration Date</label>
                  <input type="date" name="expiration_date" class="form-control" required>
                </div>
                <div class="mb-3">
                  <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script src="./asset/js/addprocval.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</html>