<?php
    session_start();

require 'condb.php';

$sid = $_SESSION["user_id"];
$query = "SELECT sesi FROM users WHERE id = '$sid';";
$result = $con->query($query);
$row = $result->fetch_assoc();
$sesiFromDatabase = $row['sesi'];
function check($sesiFromDatabase)
{
        if ($_SESSION['session_id'] !== $sesiFromDatabase) {
            header("Location: ../login.php");
            session_unset();
        session_destroy();
        $_SESSION = array();
        $_SESSION['is_login'] = false;
            exit;
        }
}

if($_SESSION['is_login'] !== true) {
    header("Location: ../login.php");
    exit(); // Ensure no further content is processed after redirection
}

if(isset($_POST['delete_product']))
{
    check($sesiFromDatabase);
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
    check($sesiFromDatabase);
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
    check($sesiFromDatabase);
    $name = mysqli_real_escape_string($con, $_POST['name']);

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
