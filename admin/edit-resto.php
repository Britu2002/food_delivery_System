<?php
include('../config.php'); // Database connection

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch existing restaurant details
    $query = "SELECT * FROM restaurant WHERE resid = '$id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "<script>alert('Restaurant not found!'); window.location.href='list-resto.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='list-resto.php';</script>";
    exit;
}

// Handle form submission
if(isset($_POST['update'])) {
    $res_name = mysqli_real_escape_string($conn, $_POST['res_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $o_hr = mysqli_real_escape_string($conn, $_POST['o_hr']);
    $c_hr = mysqli_real_escape_string($conn, $_POST['c_hr']);
    $o_days = mysqli_real_escape_string($conn, $_POST['o_days']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    $update_query = "UPDATE restaurant SET 
                    title='$res_name', 
                    email='$email', 
                    phone='$phone', 
                    status='$status', 
                    o_hr='$o_hr', 
                    c_hr='$c_hr', 
                    o_days='$o_days', 
                    city='$city', 
                    pincode='$pincode', 
                    addr='$address'";

    // Image Upload Handling
    if (!empty($_FILES['file']['name'])) {
        $target_dir = "uploads/";
        $image_name = basename($_FILES["file"]["name"]);
        $target_file = $target_dir . $image_name;
      
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                // Delete old image
                if (!empty($row['image']) && file_exists("uploads/" . $row['image'])) {
                    unlink("uploads/" . $row['image']);
                }
                $update_query .= ", image='$image_name'";
            } else {
                echo "<script>alert('Image upload failed. Please try again.');</script>";
            }
        
    }

    $update_query .= " WHERE resid='$id'";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Restaurant updated successfully!'); window.location.href='list-resto.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Restaurant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<?php include('admin-header.php'); ?>

<div class="content bg-white" id="mainContent">
    <div class="card card-primary">
        <div class="card-header bg-warning">
            <h4 class="m-b-0 text-dark">Edit Restaurant</h4>
        </div>
        <div class="card-body">
            <form action='' method='post' enctype="multipart/form-data">
                <div class="form-body">
                    <hr>
                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label text-muted my-2">Restaurant Name</label>
                                <input type="text" name="res_name" class="form-control" value="<?= $row['title'] ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-danger">
                                <label class="control-label text-muted my-2">Business E-mail</label>
                                <input type="email" name="email" class="form-control" value="<?= $row['email'] ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label text-muted my-2">Phone</label>
                                <input type="text" name="phone" class="form-control" value="<?= $row['phone'] ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label text-muted my-2">Status</label>
                                <select name="status" class="form-select custom-select">
                                    <option value="active" <?= ($row['status'] == 'active') ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= ($row['status'] == 'inactive') ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label text-muted my-2">Open Hours</label>
                                                    <select name="o_hr" class="form-select custom-select" data-placeholder="Choose a Category" required>
                                                     <option>--Select your Hours--</option>
                                                        <option value="6am" <?= ($row['o_hr'] == '6am') ? 'selected' : '' ?>>6am</option>
                                                        <option value="7am" <?= ($row['o_hr'] == '7am') ? 'selected' : '' ?>>7am</option> 
														<option value="8am" <?= ($row['o_hr'] == '8am') ? 'selected' : '' ?>>8am</option>
														<option value="9am"<?= ($row['o_hr'] == '9am') ? 'selected' : '' ?>>9am</option>
														<option value="10am"<?= ($row['o_hr'] == '10am') ? 'selected' : '' ?>>10am</option>
														<option value="11am"<?= ($row['o_hr'] == '11am') ? 'selected' : '' ?>>11am</option>
                                                        <option value="12pm"<?= ($row['o_hr'] == '12am') ? 'selected' : '' ?>>12pm</option>
                                                    </select>
                                                </div>
                                            </div>
                                        
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label text-muted my-2">Close Hours</label>
                                                    <select name="c_hr" class="form-select custom-select" data-placeholder="Choose a Category" required>
                                                     <option>--Select your Hours--</option>
                                                        <option value="3pm"<?= ($row['c_hr'] == '3pm') ? 'selected' : '' ?>>3pm</option>
                                                        <option value="4pm"<?= ($row['c_hr'] == '4pm') ? 'selected' : '' ?>>4pm</option> 
														<option value="5pm"<?= ($row['c_hr'] == '5pm') ? 'selected' : '' ?>>5pm</option>
														<option value="6pm"<?= ($row['c_hr'] == '6pm') ? 'selected' : '' ?>>6pm</option>
														<option value="7pm"<?= ($row['c_hr'] == '7pm') ? 'selected' : '' ?>>7pm</option>
														<option value="8pm"<?= ($row['c_hr'] == '8pm') ? 'selected' : '' ?>>8pm</option>
                                                        <option value="9pm"<?= ($row['c_hr'] == '9pm') ? 'selected' : '' ?>>9pm</option>
                                                        <option value="10pm"<?= ($row['c_hr'] == '10pm') ? 'selected' : '' ?>>10pm</option>
                                                        <option value="11pm"<?= ($row['c_hr'] == '11pm') ? 'selected' : '' ?>>11pm</option>
                                                        <option value="12am"<?= ($row['c_hr'] == '12am') ? 'selected' : '' ?>>12am</option>
                                                        <option value="1am"<?= ($row['c_hr'] == '1am') ? 'selected' : '' ?>>1am</option>
                                                        <option value="2am"<?= ($row['c_hr'] == '2am') ? 'selected' : '' ?>>2am</option>
                                                        <option value="3am"<?= ($row['c_hr'] == '3am') ? 'selected' : '' ?>>3am</option>
                                                    </select>
                                                </div>
                                            </div>
											
											 <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label text-muted my-2">Open Days</label>
                                                    <select name="o_days" class="form-select custom-select" data-placeholder="Choose a Category" tabindex="1" required>
                                                        <option>--Select your Days--</option>
                                                        <option value="Mon-Tue"<?= ($row['o_days'] == 'Mon-Tue') ? 'selected' : '' ?>>Mon-Tue</option>
                                                        <option value="Mon-Wed"<?= ($row['o_days'] == 'Mon-Wed') ? 'selected' : '' ?> >Mon-Wed</option> 
														<option value="Mon-Thu"<?= ($row['o_days'] == 'Mon-Thu') ? 'selected' : '' ?>>Mon-Thu</option>
														<option value="Mon-Fri"<?= ($row['o_days'] == 'Mon-Fri') ? 'selected' : '' ?>>Mon-Fri</option>
														<option value="Mon-Sat"<?= ($row['o_days'] == 'Mon-Sat') ? 'selected' : '' ?>>Mon-Sat</option>
														<option value="24hr-x7"<?= ($row['o_days'] == '24hr-x7') ? 'selected' : '' ?>>24hr-x7</option>
                                                    </select>
                                                </div>
                                            </div>
											
											
												
											
                                        </div>
                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label text-muted my-2">City</label>
                                <input type="text" name="city" class="form-control" value="<?= $row['city'] ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label text-muted my-2">Pincode</label>
                                <input type="text" name="pincode" class="form-control" value="<?= $row['pincode'] ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row p-t-20">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label text-muted my-2">Address</label>
                                <textarea name="address" class="form-control" required><?= $row['addr'] ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label text-muted my-2">Current Image</label><br>
                                <img src="uploads/<?= $row['image'] ?>" alt="Restaurant Image" width="150">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-danger">
                                <label class="control-label text-muted my-2">Change Image</label>
                                <input type="file" name="file" class="form-control form-control-danger">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions m-2">
                    <input type="submit" name="update" class="btn btn-primary" value="Update">
                    <a href="list-resto.php" class="btn btn-dark">back</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
