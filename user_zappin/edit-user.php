<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT name as fullname, mobile, email, address, pincode, img as photo ,city FROM customer WHERE cid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $building = $_POST['building'];
    $pincode = $_POST['pincode'];
    $city =$_POST['city'];
    // Handle Profile Picture Upload
    if (!empty($_FILES['photo']['name'])) {
        $photo_name = time() . '_' . $_FILES['photo']['name'];
        $target = "../admin/uploads/" . $photo_name;
        move_uploaded_file($_FILES['photo']['tmp_name'], $target);
    } else {
        $photo_name = $user['photo'];
    }

    // Update Query
    $update_sql = "UPDATE customer SET name = ?, address = ?, pincode = ?, img = ?,city=? WHERE cid = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssssi", $fullname, $building, $pincode, $photo_name,$city, $user_id);
    if ($stmt->execute()) {

        $_SESSION['success'] = "Profile updated successfully!";
        echo "<script>
        alert('updated')
        window.history.go(-2);</script>";
        exit();
    } else {
        $error = "Error updating profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container my-5" style="">
    <div class="card mx-auto shadow-lg border-0" style="max-width: 500px;">
        <div class="card-body">
            <h3 class="text-center text-dark"><strong>Edit Profile</strong></h3>
            <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($user['fullname']); ?>" required>
                </div>
                <div class="mb-3 row" >
                    <div class="col">
                    <label class="form-label" >Mobile</label>
                   
                    <input type="text" disabled name="mobile" class="form-control"  value="<?= htmlspecialchars($user['mobile']);  ?> " >
                    


                    </div>
                    <div class="col">
                    <label class="form-label">Email</label>
                    <input type="email"disabled name="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
                </div>
                </div>
               
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="building" class="form-control" cols="30" rows="2" required><?= htmlspecialchars($user['address']); ?></textarea>

                </div>
                <div class="mb-3">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control" value="<?= htmlspecialchars($user['city']); ?>" required>

                </div>
                <div class="mb-3">
                    <label class="form-label">Pincode</label>
                    <input type="text" name="pincode" class="form-control" value="<?= htmlspecialchars($user['pincode']); ?>" required>
                    <!-- <select name="pincode" id="" class="form-select">
                        <?php 
                      
                        // $outlet_pincode="";
                        // $outlet_query = "SELECT pincode  FROM restaurant";
                        // $outlet_result = mysqli_query($conn, $outlet_query);
                        // while ($row = mysqli_fetch_assoc($outlet_result)) {
                            
                        //     $selected = ($row['pincode'] == $user['pincode']) ? "selected" : "";

                            ?>
                            
                            <option class="" value="<?php //echo $row['pincode'] ?>" <?php// echo $selected?>><?php //echo $row['pincode']?></option>
                            <?php
                        
                       // }
                        ?>
                    </select> -->
                </div>
                <div class="mb-3">
                    <label class="form-label">Profile Picture</label>
                    <input type="file" name="photo" class="form-control">
                </div>
                <button type="submit" class="btn btn-warning w-100">Update Profile</button>
             <!-- <a href="index.php"  class="btn btn-secondary w-100 mt-3">Back to Home</a> -->
           
            </form>
        </div>
    </div>
</div>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>