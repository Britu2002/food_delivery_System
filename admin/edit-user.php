<?php
session_start();
include('../config.php');

if (!isset($_GET['edit_id'])) {
    echo "<script>alert('Invalid Request!'); window.location.href='user-list.php';</script>";
    exit;
}

$user_id = $_GET['edit_id'];


// Fetch user details
$query = "SELECT * FROM users WHERE userid = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$user) {
    echo "<script>alert('User not found!'); window.location.href='user-list.php';</script>";
    exit;
}

$role = $user['role']; // User ka role fetch karna
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
 
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $aadhar_number = mysqli_real_escape_string($conn, $_POST['aadhar_number']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $aadhaar_copy = $user['aadhar_copy'];
    $photo = $user['photo'];

    // Handle Aadhaar Copy Upload
    if (!empty($_FILES['aadhar_copy']['name'])) {
        $aadhaar_copy = time() . '_' . $_FILES['aadhar_copy']['name'];
        move_uploaded_file($_FILES['aadhar_copy']['tmp_name'], "uploads/" . $aadhaar_copy);
    }

    // Handle Photo Upload
    if (!empty($_FILES['photo']['name'])) {
        $photo = time() . '_' . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/" . $photo);
    }
    $update_query = "UPDATE users SET fullname='$fullname', address='$address', pincode='$pincode', status='$status',aadhar_number='$aadhar_number', aadhar_copy='$aadhaar_copy', photo='$photo', password='$password',city='$city' WHERE userid=$user_id";
    echo $update_query;
$result=mysqli_query($conn,$update_query);
    // Update query
   
    // $stmt = $conn->prepare($update_query);
    // $stmt->bind_param("sssssssi", $fullname, $address, $pincode, $status, $aadhaar_copy, $photo, $password,$city, $user_id);

    if ($result) {
        echo "<script>alert('Profile Updated Successfully!'); window.location.href='view-user.php?userid=$user_id';</script>";
    } else {
        echo "<script>alert('Error updating profile');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-10">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'admin-header.php';?>

<div class="content bg-light" id="mainContent">
    <div class="bg-white shadow p-4">
        <h2 class="mb-2 fw-bold">Edit User Profile</h2>
        <hr>
        
        <ul class="nav nav-tabs mb-2 border-bottom">
            <li class="nav-item"><a class="nav-link border-bottom" href="view-user.php?userid=<?php echo $user['userid']; ?>">Profile Information</a></li>
            <li class="nav-item"><a class="nav-link active show border-bottom" href="edit-user.php?edit_id=<?php echo $user['userid']; ?>">Update Profile</a></li>
        </ul>

        <form method="post" enctype="multipart/form-data">
            
            <div class="mb-2 row">
                <label class="form-label col-md-2 fw-bold">Full Name:</label>
                <div class="col-md-10">
                    <input type="text" name="fullname" class="form-control" value="<?php echo htmlspecialchars($user['fullname']); ?>" required pattern="^[A-Za-z\s]+$" title="Only letters and spaces are allowed" minlength="3" maxlength="30">
                </div>
            </div>

            <div class="mb-2 row">
                <label class="form-label col-md-2 fw-bold">Mobile Number:</label>
                <div class="col-md-10">
                    <input type="text" name="mobile" disabled class="form-control" value="<?php echo htmlspecialchars($user['mobile']); ?>" required>
                </div>
            </div>

            <div class="mb-2 row">
                <label class="form-label col-md-2 fw-bold">Email:</label>
                <div class="col-md-10">
                    <input type="email" name="email" disabled class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
            </div>

            <div class="mb-2 row">
                <label class="form-label col-md-2 fw-bold">Address:</label>
                <div class="col-md-10">
                    <input type="text" name="address" pattern=".{5,}" title="Address must be at least 5 characters long" class="form-control" value="<?php echo htmlspecialchars($user['address']); ?>">
                </div>
            </div>

            <div class="mb-2 row">
                <label class="form-label col-md-2 fw-bold">City:</label>
                <div class="col-md-10">
                    <input type="text" name="city" pattern=".{3,}" title="City must be at least 3 characters long" class="form-control" value="<?php echo htmlspecialchars($user['city']); ?>">
                </div>
            </div>
            <div class="mb-2 row">
                <label class="form-label col-md-2 fw-bold">Pincode:</label>
                <div class="col-md-10">
                    <select name="pincode" id="" class="form-select">
                        <?php 
                      
                        // $outlet_pincode="";
                        $outlet_query = "SELECT pincode  FROM outlet";
                        $outlet_result = mysqli_query($conn, $outlet_query);
                        while ($row = mysqli_fetch_assoc($outlet_result)) {
                            
                            $selected = ($row['pincode'] == $user['pincode']) ? "selected" : "";

                            ?>
                            
                            <option class="" value="<?php echo $row['pincode'] ?>" <?php echo $selected?>><?php echo $row['pincode']?></option>
                            <?php
                        
                        }
                        ?>
                    </select>
                </div>
            </div>

          
                <div class="mb-2 row">
                    <label class="form-label col-md-2 fw-bold">Password:</label>
                    <div class="col-md-10">
                        <input type="text" name="password" class="form-control" value="<?php echo htmlspecialchars($user['password']); ?>">
                    </div>
                </div>
                <div class="mb-2 row">
                    <label class="form-label col-md-2 fw-bold">Status:</label>
                    <div class="col-md-10">
                        <select name="status" class="form-select">
                            <option value="Active" <?php if ($user['status'] == 'Active') echo 'selected'; ?>>Active</option>
                            <option value="Inactive" <?php if ($user['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                        </select>
                    </div>
                </div>
            <?php if ($role == 'Delivery Agent' || $role == 'admin'): ?>
                <div class="mb-2 row">
                    <label class="form-label col-md-2 fw-bold">Aadhar Number:</label>
                    <div class="col-md-10">
                        <input type="text" name="aadhar_number" class="form-control" value="<?php echo htmlspecialchars($user['aadhar_number']); ?>">
                    </div>
                </div>

                <div class="mb-2 row">
                    <label class="form-label col-md-2 fw-bold">Aadhar Copy:</label>
                    <div class="col-md-10">
                        <input type="file" name="aadhar_copy" class="form-control">
                        <?php if (!empty($user['aadhar_copy'])): ?>
                            <img src="uploads/<?php echo htmlspecialchars($user['aadhar_copy']); ?>" width="100" height="100px" class="m-2">
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-2 row">
                    <label class="form-label col-md-2 fw-bold">Photo:</label>
                    <div class="col-md-10">
                        <input type="file" name="photo" class="form-control">
                        <?php if (!empty($user['photo'])): ?>
                            <img src="uploads/<?php echo htmlspecialchars($user['photo']); ?>" width="100" height="100px" class="m-2">
                        <?php endif; ?>
                    </div>
                </div>

               
            <?php endif; ?>

            <button type="submit" class="btn btn-success">Update Profile</button>
        </form>

    </div>
</div>

</body>
</html>
