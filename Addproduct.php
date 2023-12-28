<?php
session_start();
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
    <div class="container mt-5"> <?php include('Controllers/message.php'); ?> <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4>Add Product <a href="Dashboard.php" class="btn btn-danger float-end">Back</a>
              </h4>
            </div>
            <div class="card-body">
              <form action="Controllers/delete&update.php" method="POST">
                <div class="mb-3">
                  <label>Product Name</label>
                  <input type="text" name="name" class="form-control">
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
    <script src="./asset/js/addprocval.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>