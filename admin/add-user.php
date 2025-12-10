<?php
include('../config.php'); // Database connection

$success_message = "";
$error_message = "";

// Fetch outlets from database
$outlet_options = "";
$outlet_pincode="";
$outlet_query = "SELECT *  FROM outlet";
$outlet_result = mysqli_query($conn, $outlet_query);
while ($row = mysqli_fetch_assoc($outlet_result)) {
    $outlet_options .= "<option value='{$row['outletid']}'>{$row['outletlocation']}/{$row['city']}/{$row['pincode']}</option>";
    $outlet_pincode .= "<option value='{$row['outletid']}'>{{$row['pincode']}</option>";
}

if (isset($_POST['submit'])) {
    $role = $_POST['role'];
    $fullname = $_POST['fullname'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $building = $_POST['building'];
    $city=$_POST['city'];
    $password = $_POST['password'];
    $pincode = $_POST['pincode'];
    $status = $_POST['status'];

    // Aadhaar fields sirf Delivery Boy ke liye
    $adhar_number = ($role == "Customer") ? " " : $_POST['adhar_number'];
    $aadhaar_file = ($role == "Customer") ? " " : $_FILES['aadhaar']['name'];
    $passport_file = $_FILES['passport']['name'];

    // Outlet Work field sirf Delivery Boy ke liye
    $outlet_work = ($role == "Customer") ? 'NULL' : $_POST['outlet_work'];

    // File paths
    $aadhaar_tmp = $_FILES['aadhaar']['tmp_name'];
    $passport_tmp = $_FILES['passport']['tmp_name'];
    $upload_dir = "uploads/";
    $checkQuery = "SELECT * FROM users WHERE mobile='$mobile' OR email='$email' ";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('Mobile or Email already exists!');</script>";
    }else{

    
    // Insert Query
    $query = "INSERT INTO users (role, fullname, mobile, email, address,city, pincode, password, status, aadhar_number, aadhar_copy, photo, outlet_work) 
              VALUES ('$role', '$fullname', '$mobile', '$email', '$building','$city', '$pincode', '$password', '$status', '$adhar_number', '$aadhaar_file', '$passport_file', $outlet_work)";
echo $query;

    // File Upload
    if ($aadhaar_file) move_uploaded_file($aadhaar_tmp, $upload_dir . $aadhaar_file);
    if ($passport_file) move_uploaded_file($passport_tmp, $upload_dir . $passport_file);

    // Execute Query
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('User added successfully!');</script>";
        header("Location: listuser.php?role=" . $role);
        exit();
    } else {
        $error_message = "Error: " . mysqli_error($conn);
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function toggleFields() {
            var role = document.querySelector('select[name="role"]').value;
            var extraFields = document.querySelectorAll('.extra-fields');
            var outletField = document.querySelector('.outlet-field');

            if (role === 'Customer') {
                extraFields.forEach(field => field.style.display = 'none');
                outletField.style.display = 'none';
            } else {
                extraFields.forEach(field => field.style.display = 'block');
                outletField.style.display = 'block';
            }
        }

        window.onload = toggleFields;
    </script>
</head>
<body>

<?php include('admin-header.php'); ?>

<div class="content bg-light" id="mainContent">
   <div class="row m-3">
    <div class="col-md-7 bg-white shadow p-4">
        
        <h3 class="mb-3 fw-bold">Add New User</h3>
        <hr>
        <?php if ($success_message) echo "<div class='alert alert-success'>$success_message</div>"; ?>
        <?php if ($error_message) echo "<div class='alert alert-danger'>$error_message</div>"; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label fw-bold">Select Role</label>
                <select name="role" class="form-control" onchange="toggleFields()">
                <option value="Delivery Agent">Delivery Agent</option>
                    <option value="Customer">Customer</option>
                  
                </select>
            </div>

            <div class="mb-3"><input name="fullname" class="form-control" pattern="^[A-Za-z\s]+$" title="Only letters and spaces are allowed" minlength="3" maxlength="30" placeholder="Enter Full Name" required></div>
            <div class="mb-3"><input type="text"  name="mobile" class="form-control" placeholder="Enter Mobile Number" required pattern="[0-9]{10}" title="Enter a valid 10-digit mobile number"></div>
            <div class="mb-3"><input type="email" name="email" class="form-control" placeholder="Enter Email" required></div>
 <!-- Address Validation -->
 <div class="mb-3">
        <input type="text" name="building" class="form-control" placeholder="Enter Address " 
               required pattern=".{5,}" title="Address must be at least 5 characters long">
    </div>
    <div class="mb-3">
        <input type="text" name="city" class="form-control" placeholder="Enter City Name" 
               required pattern=".{3,}" title="City must be at least 3 City long">
    </div>

    <!-- Pincode Validation (Only 6 Digits) -->
    <div class="mb-3">
        <!-- <input type="number" name="pincode" class="form-control" placeholder="Enter Pincode" 
               required pattern="[0-9]{6}" title="Enter a valid 6-digit pincode"> -->
               <select name="pincode" class="form-select ">
             <option value="">Select Pincode</option>
             <?php echo $outlet_pincode; ?>
         </select>
               
    </div>

    
    <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Enter Password" 
               required >
    </div>
            <div class="mb-3"><label>Passport Size Photo</label><input type="file" name="passport" class="form-control"></div>

            <!-- Extra Fields for Delivery Boy -->
            <div class="extra-fields">
                <div class="mb-3"><input name="adhar_number" class="form-control" placeholder="Enter Aadhaar Number"></div>
                <div class="mb-3"><label>Aadhaar Copy</label><input type="file" name="aadhaar" class="form-control"></div>
            </div>

            <!-- Outlet Work Field for Delivery Boy -->
            <div class="mb-3 outlet-field">
                <label class="form-label fw-bold">Select Outlet</label>
                <select name="outlet_work" class="form-control">
                    <option value="">Select Outlet</option>
                    <?php echo $outlet_options; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Active Status</label>
                <select name="status" class="form-control">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-success">Submit</button>
            <button type="reset" class="btn btn-secondary">Clear</button>
        </form>
    </div>
    </div>
   </div>

</body>
</html>
