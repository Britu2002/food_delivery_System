<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['mobile']);
    $newPassword = trim($_POST['password']);

    
  

    
    $result=mysqli_query($conn,"SELECT * FROM customer WHERE email = '$email'");

    if (mysqli_num_rows($result) > 0) {

       $res= mysqli_query($conn,"UPDATE customer SET password = '$newPassword' WHERE email = '$email' ");
       
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
    <title>Login | <?php echo $website_name; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body class="loginlg">
    <div class="login-container text-center position-relative">
        <div  class=""><img class="my-3  " src="/zaapin/img/unnamed.png" alt="" style="width: 30%;border-radius: 50%;box-shadow: 0px 0px 10px #393939; margin-bottom: 10px" ></div>
    
        <!-- <h2 class="mb-4 loginheading">Login to <?php echo  $website_name ?></h2> -->
        <div class="position-absolute text-white " style="width: 35px; height: 35px; top:5%; right:10px;"><a href="user_zappin/products.php" class="text-decoration-none text-white">Skip</a></div>
<h4><i>Change Password</i></h4>
        <form method="post">
    <div class="mb-3">
        <input type="text" class="form-control form-control1" placeholder="Enter Register Email id" name="mobile" required>
    </div>
    <div class="mb-3">
        <input type="password" class="form-control form-control1" placeholder="Enter New Password" name="password" required>
    </div>
    <button type="submit" class="btn btn-custom w-100" name="login">Update Password</button>
  
</form>

<!-- Delivery Boy Login Button -->
<a href="login.php" class="btn btn-warning w-100 mt-2">Back</a>



    </div>
</body>
</html>
