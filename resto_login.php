<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    if(isset($_POST['login'])){
        $mobile = $_POST['mobile'];
        $password = $_POST['password'];
    
        // Database se user check karna
        $query = "SELECT * FROM restaurant WHERE  email='$mobile' AND pincode='$password' ";
        $result = mysqli_query($conn, $query);
    
        if (mysqli_num_rows($result) > 0) {
            $row =mysqli_fetch_assoc($result);
            $_SESSION['resid']=$row['resid'];
            
           
       
            
            echo "<script>
            alert('login successfully!');
       window.location.href='/zaapin/resto/resto_dashboard.php'
            </script>";
            
        } else {
            echo "<script>
            alert('invalid Creditions!');
          
            </script>";
           
        }
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
<strong class="fs-2"><i>Restaurant</i> </strong>
        <!-- <h2 class="mb-4 loginheading">Login to <?php echo  $website_name ?></h2> -->
        <div class="position-absolute text-white " style="width: 35px; height: 35px; top:5%; right:10px;"><a href="user_zappin/products.php" class="text-decoration-none text-white">Skip</a></div>

        <form method="post">
    <div class="mb-3">
        <input type="text" class="form-control form-control1" placeholder="Enter Email" name="mobile" autocomplete="off" required>
    </div>
    <div class="mb-3">
        <input type="pincode" class="form-control form-control1" placeholder="Enter Pincode" name="password" autocomplete="off" required>
    </div>
    <button type="submit" class="btn btn-custom w-100" name="login">Login</button>
</form>



    </div>
</body>
</html>
