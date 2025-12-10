<?php
session_start();
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $newPassword = trim($_POST['newPassword']);

    
  

    
    $result=mysqli_query($conn,"SELECT * FROM admin WHERE email = '$email'");

    if (mysqli_num_rows($result) > 0) {

       $res= mysqli_query($conn,"UPDATE admin SET password = '$newPassword' WHERE email = '$email'");
       
        if ($res) {
            echo "<script>
            alert('change password successfully');
            window,location.href='login.php';
            </script>";
        } else {
            echo "<script>
            alert(' password not change');
            
            </script>";
        }
    } else {
        echo "<script>
            alert(' email not found');
            
            </script>";
    }

  
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
    <link rel="stylesheet" href="/zaapin/css/style.css">
</head>
<body class="adminbg">

    <div class="login-container text-center">
        <h2 class="mb-4 loginheading">Reset Password</h2>
        <span class="text-danger" id="reset-error"></span>
        <form id="reset-form" method="post">
            <div class="mb-3">
                <input type="email" class="form-control form-control1" name="email"placeholder="Enter Registered Email" required id="resetEmail">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control form-control1" name="newPassword" placeholder="Enter New Password" required id="newPassword">
            </div>
            <button type="submit" class="btn btn-custom w-100">Reset Password</button>
        </form>
        <p class="mt-3">
            <a href="login.php" class="text-warning">Back to Login</a>
        </p>
    </div>
    <!-- <script src="auth.js"></script> -->
<script>
   
</script>

</body>
</html>
