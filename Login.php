
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="asset/css/style.css">
    <title>Secure Website</title>
</head>
<body>
    <div class="container">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" />
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <form class="box" action="Controllers/AuthController.php" method="POST">
                        <h1>Login</h1>
                        <p class="text-muted"> Please enter your login and password!</p>
                        <input type="email" name="email" placeholder="Enter Email" id="email" required>
                        <input type="password" name="password" placeholder="Password" id="password" required>
                         <a class="forgot text-muted" href="#">Forgot password?</a>
                         <input type="submit" name="login" value="Login">
                         <div class="col-md-12">
                            <ul class="social-network social-circle">
                                <li><a href="https://www.instagram.com/cupsnbrews_id/" class="icoFacebook" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="https://www.instagram.com/cupsnbrews_id/" class="icoTwitter" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="https://www.instagram.com/cupsnbrews_id/" class="icoGoogle" title="Google +"><i class="fab fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="asset/js/validation.js"></script>
</html>