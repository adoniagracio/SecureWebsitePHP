<?php
    session_start();

require 'condb.php';

$sid = $_SESSION["user_id"];
$query = "SELECT sesi FROM users WHERE id = ?";
$prepstate = $con->prepare($query);
$prepstate->bind_param("i",$sid);
$prepstate->execute();
$result = $prepstate->get_result();
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
            exit();
        }
}

if($_SESSION['is_login'] !== true) {
    header("Location: ../login.php");
    exit(); 
}




if (isset($_POST['delete_product'])) {
    check($sesiFromDatabase);
    $hashedProductId = mysqli_real_escape_string($con, $_POST['barang_id']);
    $query = "SELECT id_product, gambar_product FROM product WHERE SHA2(id_product, 256) = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $hashedProductId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $productId = $row['id_product'];
        $imageFilename = $row['gambar_product'];
        $image_folder = '../uploaded_img/' . $imageFilename;
        if (file_exists($image_folder)) {
            unlink($image_folder);
        }
        $deleteQuery = "DELETE FROM product WHERE id_product = ?";
        $deleteStmt = mysqli_prepare($con, $deleteQuery);
        mysqli_stmt_bind_param($deleteStmt, "i", $productId);
        $deleteQueryResult = mysqli_stmt_execute($deleteStmt);

        if ($deleteQueryResult) {
            $_SESSION['message'] = "Product and Image Deleted Successfully";
            header("Location: ../Dashboard.php");
            exit(0);
        } else {
            $_SESSION['message'] = "Product Not Deleted";
            header("Location: ../Dashboard.php");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Product Not Found";
        header("Location: ../Dashboard.php");
        exit(0);
    }
}



if (isset($_POST['update_product'])) {
    check($sesiFromDatabase);

    $name = trim(mysqli_real_escape_string($con, $_POST['name']));
    if ($name === '') {
        $_SESSION['message'] = 'Product Name cannot be empty or contain only spaces';
        header("Location: ../Dashboard.php");
        exit(0);
    }

    $update_image = $_FILES['image']['name'];
    $imagesize = $_FILES['image']['size'];
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $quantity = trim(mysqli_real_escape_string($con, $_POST['quantity']));

    if ($quantity === '') {
        $_SESSION['message'] = 'Quantity cannot be empty or contain only spaces';
        header("Location: ../Dashboard.php");
        exit(0);
    }

    $expiration_date = mysqli_real_escape_string($con, $_POST['expiration_date']);
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $update_image;
    $allowed_extensions = array('jpg', 'jpeg', 'png');
    $barang_id = $_POST['barang_id'];
    $update_image_extension = strtolower(pathinfo($update_image, PATHINFO_EXTENSION));

    $query = "UPDATE product SET 
        nama_product = ?, 
        quantity = ?, 
        harga_product = ?, 
        tanggal_exp_product = ? 
        WHERE SHA2(id_product, 256) = ?";
    
    $prep_state = $con->prepare($query);
    $prep_state->bind_param("ssssi", $name, $quantity, $price, $expiration_date, $barang_id);
    $prep_state->execute();
    
    if (!empty($update_image)) {
        if (!in_array($update_image_extension, $allowed_extensions)) {
            $_SESSION['message'] = 'Only JPEG, JPG, and PNG files are allowed';
            header("Location: ../UpdateBarang.php");
            exit(0);
        }

        if ($imagesize > 2000000) {
            $_SESSION['message'] = 'Image file size is too large.';
            header("Location: ../UpdateBarang.php");
            exit(0);
        }

        $query_image = "UPDATE product SET gambar_product = ? WHERE SHA2(id_product, 256) = ?";
        $prep_state_image = $con->prepare($query_image);
        $prep_state_image->bind_param("si", $update_image, $barang_id);
        $prep_state_image->execute();

        move_uploaded_file($image_tmp_name, $image_folder);
    }

    $_SESSION['message'] = "Update Data Successfully";
    header("Location: ../Dashboard.php");
    exit();
}





if (isset($_POST['add_product'])) {
    check($sesiFromDatabase);   
    $name = trim(mysqli_real_escape_string($con, $_POST['name']));

    if ($name === '') {
        $_SESSION['message'] = 'Product Name cannot be empty or contain only spaces';
        header("Location: ../Addproduct.php");
        exit(0);
    }

    $image = $_FILES['picture']['name']; 
    $imagesize = $_FILES['picture']['size']; 
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $quantity = trim(mysqli_real_escape_string($con, $_POST['quantity']));

    if ($name === '') {
        $_SESSION['message'] = 'quantity cannot be empty or contain only spaces';
        header("Location: ../Addproduct.php");
        exit(0);
    }

    $expiration_date = mysqli_real_escape_string($con, $_POST['expiration_date']);
    $image_tmp_name = $_FILES['picture']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;
    $allowed_extensions = array('jpg', 'jpeg', 'png');
    $image_extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    

    if (!in_array($image_extension, $allowed_extensions)) {
        $_SESSION['message'] = 'Only JPEG, JPG, and PNG files are allowed';
        header("Location: ../Addproduct.php");
        exit(0);
    }

    if($imagesize > 2000000){
        $_SESSION['message'] = 'Image size is too large';
    }


            if (move_uploaded_file($image_tmp_name, $image_folder)) {
                $query = "INSERT INTO product (id_user,nama_product, gambar_product, harga_product, tanggal_exp_product,quantity) VALUES (?,?, ?, ?, ? ,?)";
                $stmt = mysqli_prepare($con, $query);
                $image = htmlspecialchars($image, ENT_QUOTES, 'UTF-8');
                $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
                $price = htmlspecialchars($price, ENT_QUOTES, 'UTF-8');
                $expiration_date = htmlspecialchars($expiration_date, ENT_QUOTES, 'UTF-8');
                $quantity = htmlspecialchars($quantity, ENT_QUOTES, 'UTF-8');
            
                mysqli_stmt_bind_param($stmt, "isssss",$sid, $name, $image, $price, $expiration_date, $quantity);
            
                $add_product_query = mysqli_stmt_execute($stmt);
                $_SESSION['message'] = "Product Added Successfully";
                header("Location: ../Addproduct.php");
                
                exit(0);
            } else {
                $_SESSION['message'] = "Product Not Created";
                header("Location: ../Addproduct.php");
                exit(0);
            }
    
  mysqli_stmt_close($stmt);
}
