<?php

session_start();
include('config.php');
$outlet_options = "";
$outlet_pincode="";
$outlet_query = "SELECT *  FROM restaurant";
$outlet_result = mysqli_query($conn, $outlet_query);
while ($row = mysqli_fetch_assoc($outlet_result)) {
    $outlet_pincode .= "<option value='{$row['resid']}'>{$row['title']}/{$row['city']}-{$row['pincode']}</option>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $fullname = $_POST['fullname'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $building = $_POST['building'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];
    $aadhar_number = $_POST['aadhar_number'];
    $aadhar_copy = $_FILES['aadhar_copy']['name'];
    $photo = $_FILES['photo']['name'];
    $outlet_work = $_POST['outlet_work'];
    
    // Upload files (Aadhar copy and photo)
    $aadhar_copy_tmp = $_FILES['aadhar_copy']['tmp_name'];
    $photo_tmp = $_FILES['photo']['tmp_name'];
    $aadhar_copy_path = 'admin/uploads/' . $aadhar_copy;

    $photo_path = 'admin/uploads/' . $photo;
    // print_r($aadhar_copy_path);
   
    move_uploaded_file($aadhar_copy_tmp, $aadhar_copy_path);
    move_uploaded_file($photo_tmp, $photo_path);
    
    // Check if mobile or email already exists
    $checkQuery = "SELECT * FROM customer WHERE mobile='$mobile' OR email='$email'";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('Mobile or Email already exists!');</script>";
    } else {
        $query = "INSERT INTO agent (fullname, mobile, email, address, city, pincode, aadhar_number, aadhar_copy, photo, status, res_id, password, createdon) 
                  VALUES ('$fullname', '$mobile', '$email', '$building', '$city', '$pincode', '$aadhar_number', '$aadhar_copy', '$photo', 'Active', '$outlet_work', '$password', NOW())";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>
            alert('Signup successful!');
            window.location.href='agent_login.php';
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
    <div class="login-container text-center m-2" style="max-width:80%">
          <div  class=""><img class="my-3  " src="/zaapin/img/agent_login.jpeg" alt="" style="width: 10%;border-radius: 50%;box-shadow: 0px 0px 10px #393939; margin-bottom: 10px" ></div>
    
        <form method="post" enctype="multipart/form-data">
            <!-- Personal Information Group -->
            <span>Personal Information</span>
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="text" class="form-control form-control1" placeholder="Enter Full Name" name="fullname" required pattern="^[A-Za-z\s]+$" title="Only letters and spaces are allowed" minlength="3" maxlength="30">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control1" placeholder="Enter Mobile Number" name="mobile" required pattern="[0-9]{10}" title="Enter a valid 10-digit mobile number">
                </div>
                <div class="col-md-3">
                    <input type="email" class="form-control form-control1" placeholder="Enter Email Address" name="email" required>
                </div>
                <div class="col-md-3">
                    <input type="password" class="form-control form-control1" placeholder="Password" name="password" required>
                </div>
            </div>
            
            <!-- Address Information Group -->
            <span>Address Information</span>
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="text" class="form-control form-control1" placeholder="Enter Address" name="building" pattern=".{5,}" title="Address must be at least 5 characters long">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control1" placeholder="Enter City Name" name="city" pattern=".{3,}" title="City must be at least 3 characters long">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control1" placeholder="Enter Pincode" name="pincode">
                </div>
            </div>

            <!-- Aadhar Information Group -->
            <span>Aadhar Information</span>
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="text" class="form-control form-control1" placeholder="Enter Aadhar Number" name="aadhar_number" maxlength="12" pattern="[0-9]{12}" title="Enter a valid 12-digit Aadhar number">
                </div>
                <div class="col-md-3">
                    <input type="file" class="form-control form-control1" name="aadhar_copy" required>
                </div>
            </div>

            <!-- Photo Information Group -->
            <span>Photo Information</span>
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="file" class="form-control form-control1" name="photo" required>
                </div>
            </div>

            <!-- Outlet Information Group -->
            <span>Work Information</span>
            <div class="row mb-3">
                <div class="col-md-3">
                    <select name="outlet_work" class="form-select form-control1" required>
                        <option value="">Select Restaurant</option>
                        <?php echo $outlet_pincode; ?>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-custom w-100" name="signup">Sign Up</button>
        </form>
        <p class="mt-3">Already have an account? <a href="/zaapin/agent_login.php" class="text-decoration-none text-warning">Login</a></p>
    </div>
</body>
</html>
