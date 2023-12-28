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
    $hashedProductId = mysqli_real_escape_string($con, $_POST['barang_id']);
    $query = "SELECT id_product FROM product WHERE SHA2(id_product, 256) = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $hashedProductId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $productId = $row['id_product'];
        $deleteQuery = "DELETE FROM product WHERE id_product = ?";
        $deleteStmt = mysqli_prepare($con, $deleteQuery);
        mysqli_stmt_bind_param($deleteStmt, "i", $productId);
        $deleteQueryResult = mysqli_stmt_execute($deleteStmt);

        if ($deleteQueryResult) {
            $_SESSION[ 'message' ] = "Product Deleted Successfully";
            header("Location: ../Dashboard.php");
            exit(0);
        }  else {
            $_SESSION['message'] = "Product Not Deleted";
            header("Location: ../Dashboard.php");
            exit(0);
        }
    } else {
    $_SESSION[ 'message'] = "Product Not Found";
    header("Location: ../Dashboard.php");
    exit(0);
    }
}

if(isset($_POST['update_product']))
{
    check($sesiFromDatabase);
    $productid = mysqli_real_escape_string($con, $_POST['barang_id']);
    $name = htmlspecialchars(trim(mysqli_real_escape_string($con, $_POST['name'])));

    $query = "UPDATE product SET nama_product = ? WHERE SHA2(id_product, 256) = ? ";
    $stmt = mysqli_prepare($con, $query);

    mysqli_stmt_bind_param($stmt, 'ss', $name, $productid);
    $query_run = mysqli_stmt_execute($stmt);

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