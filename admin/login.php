<?php
session_start();
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists
    $sql = "SELECT * FROM admin WHERE email = '$email' and password= '$password'";
  
   $result= mysqli_query($conn,$sql);

    if (mysqli_num_rows($result)==1) {
        // $user = $result->fetch_assoc();
        $user =mysqli_fetch_assoc($result);
     
   
            $_SESSION['user_id'] = $user['id'];
            // $_SESSION['role'] = $user['role'];
            // Redirect based on role

           
                echo "<script>alert('login successfully') 
                window.location.href='admin-dashboard.php';
                </script>";
                
            
           
        } else {
          echo "<script>alert('invaild password');
        
          </script>";
        }
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Zappin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/zaapin/css/style.css">
</head>
<body class="adminbg ">

    <div class="login-container text-center">
    <div class="mb-2">
        <img src="/zaapin/img/logo-dark.png" class="p-2" alt="Logo" style="filter: invert(60%) sepia(99%) saturate(683%) hue-rotate(348deg) brightness(101%) contrast(99%);width:150px">
        </div>
    
        <span class="text-danger" id="error-message"></span>
        <form id="login-form" method="post">
            <div class="mb-3">
                <input type="email" class="form-control form-control1" placeholder="Enter email" required id="email" name="email">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control form-control1" placeholder="Enter Password" required id="password" name="password">
            </div>
            <button type="submit" class="btn btn-custom w-100">Login</button>
        </form>
        <p class="mt-3">
            <a href="foreget-password.php" class="text-warning">Forget Password</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></>
   
</script>

</body>
</html>
