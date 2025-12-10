<?php
session_start();
include('config.php');
$outlet_options = "";
$outlet_pincode="";
$outlet_query = "SELECT *  FROM restaurant";
$outlet_result = mysqli_query($conn, $outlet_query);
while ($row = mysqli_fetch_assoc($outlet_result)) {
    $outlet_pincode .= "<option value='{$row['pincode']}'>{$row['pincode']}</option>";
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $fullname = $_POST['fullname'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $building = $_POST['building'];
    $city=$_POST['city'];
    $pincode = $_POST['pincode'];
    
    // Check if mobile or email already exists
    $checkQuery = "SELECT * FROM customer WHERE mobile='$mobile' OR email='$email'";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('Mobile or Email already exists!');</script>";
    } else {
        $query = "INSERT INTO customer (name, mobile, email, password, address, pincode, status,city) VALUES 
                   ('$fullname', '$mobile', '$email', '$password', '$building', '$pincode', 'Active','$city')";
       
        if (mysqli_query($conn, $query)) {
            echo "<script>
            alert('Signup successful!');
            window.location.href='login.php';
            </script>";
        } else {
            echo "<script>alert('Signup failed, try again!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup | <?php echo $website_name; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="loginlg">
    <div class="login-container text-center">
    <div  class=""><img class="my-3  " src="/zaapin/img/unnamed.png" alt="" style="width: 30%;border-radius: 50%;box-shadow: 0px 0px 10px #393939; margin-bottom: 10px" ></div>
    
    <!-- <h2 class="mb-4 loginheading">Login to <?php echo  $website_name ?></h2> -->
        <form method="post">
            <div class="mb-3">
                <input type="text" class="form-control form-control1" placeholder="Ennter Full Name" name="fullname" required pattern="^[A-Za-z\s]+$" title="Only letters and spaces are allowed" minlength="3" maxlength="30" placeholder="Enter Full Name">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control form-control1" placeholder="Enter Mobile Number" name="mobile" required pattern="[0-9]{10}" title="Enter a valid 10-digit mobile number">
            </div>
            <div class="mb-3">
                <input type="email" class="form-control form-control1" placeholder="Enter Email Address" name="email" required >
            </div>
           
            <div class="mb-3">
                <input type="text" class="form-control form-control1" placeholder="Enter Address" name="building" pattern=".{5,}" title="Address must be at least 5 characters long">
            </div>

            <div class="mb-3">
                <input type="text" class="form-control form-control1" placeholder="Enter City Name" name="city" pattern=".{3,}" title="City must be at least 3 City long">
            </div>
            <div class="mb-3">
            <input type="text" class="form-control form-control1" placeholder="Enter pincode" name="pincode" >
        <!-- <select name="pincode" class="form-select form-control1">
       
        </div>
             <option value="">Select Pincode</option>
             <?php //echo $outlet_pincode; ?>
         </select> -->
</div>
<div class="mb-3">
                <input type="password" class="form-control form-control1" placeholder="Password" name="password" required>
            </div>
           
            <button type="submit" class="btn btn-custom w-100" name="signup">Sign Up</button>
        </form>
        <p class="mt-3">Already have an account? <a href="/zaapin/login.php" class="text-decoration-none text-warning">Login</a></p>
    </div>
</body>
</html>