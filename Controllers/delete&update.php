<?php
    session_start();
require 'condb.php';

if(isset($_POST['delete_product']))
{
    $productid = mysqli_real_escape_string($con, $_POST['delete_product']);

    $query = "DELETE FROM product WHERE id_product='$productid' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Product Deleted Successfully";
        header("Location: ../Dashboard.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Product Not Deleted";
        header("Location: ../Dashboard.php");
        exit(0);
    }
}

if(isset($_POST['update_product']))
{
    $productid = mysqli_real_escape_string($con, $_POST['product_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $query = "UPDATE product SET nama_product ='$name' WHERE id_product='$productid' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Product Updated Successfully";
        header("Location: ../Dashboard.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Product Not Updated";
        header("Location: ../Dashboard.php");
        exit(0);
    }

}


if(isset($_POST['add_product']))
{
    $name = htmlspecialchars(trim(mysqli_real_escape_string($con, $_POST['name'])));
    // berikut validasi untuk nama produk
    if (empty($name)) {
        $_SESSION['message'] = "Product name cannot be empty";
        header("Location: ../Addproduct.php");
        exit(0);
    }

    $query = "INSERT INTO product (nama_product) VALUES ('$name')";
    
    $query_run = mysqli_query($con, $query);
    if($query_run)
    {
        $_SESSION['message'] = "Product Add Successfully";
        header("Location: ../Addproduct.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Product Not Created";
        header("Location: ../Addproduct.php");
        exit(0);
    }
}
?>
