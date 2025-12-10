<?php 
include('../config.php');

?>
<?php 
include('../config.php'); // Database connection include

if(isset($_POST['submit'])) {
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

    // Image Upload Handling
    $target_dir = "uploads/";
    $image_name = basename($_FILES["file"]["name"]);
    $target_file = $target_dir . $image_name;


   
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // Insert Data into Database
            $sql = "INSERT INTO restaurant  (title, email, phone, status, o_hr, c_hr, o_days, city, pincode, addr, image) 
                    VALUES ('$res_name', '$email', '$phone', '$status', '$o_hr', '$c_hr', '$o_days', '$city', '$pincode', '$address', '$image_name')";

            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Restaurant Added Successfully!'); window.location.href='list-resto.php';</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Image upload failed. Please try again.');</script>";
        }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Restaurant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/zaapin/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<?php include('admin-header.php'); ?>

<div class="content bg-white" id="mainContent">
<div class="card card-primary">
                            <div class="card-header bg-warning ">
                                <h4 class="m-b-0 text-dark">Add Restaurant</h4>
                            </div>
                            <div class="card-body">
                                <form action='' method='post'  enctype="multipart/form-data">
                                    <div class="form-body">
                                       
                                        <hr>
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label text-muted my-2">Restaurant Name</label>
                                                    <input type="text" name="res_name" class="form-control" required   minlength="3" required>
                                                   </div>
                                            </div>
                                  
                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label text-muted my-2">Bussiness E-mail</label>
                                                    <input type="email" name="email" class="form-control form-control-danger" >
                                                    </div>
                                            </div>
                                     
                                        </div>
                                   
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label text-muted my-2">Phone </label>
                                                    <input type="text" name="phone" class="form-control" pattern="\d{10}" title="Enter a valid 10-digit phone number" required>
                                                   </div>
                                            </div>
                                      
                                            <div class="col-md-6">
                                            <div class="form-group">
                                                    <label class="control-label text-muted my-2">Status </label>
                                                    <select name="status" class="form-select custom-select " data-placeholder="Select Status"  >
                                                        <option value="active">active</option>
                                                        <option value="inactive">inactive</option> 
														
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
                                                        <option value="6am">6am</option>
                                                        <option value="7am">7am</option> 
														<option value="8am">8am</option>
														<option value="9am">9am</option>
														<option value="10am">10am</option>
														<option value="11am">11am</option>
                                                        <option value="12pm">12pm</option>
                                                    </select>
                                                </div>
                                            </div>
                                        
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label text-muted my-2">Close Hours</label>
                                                    <select name="c_hr" class="form-select custom-select" data-placeholder="Choose a Category" required>
                                                     <option>--Select your Hours--</option>
                                                        <option value="3pm">3pm</option>
                                                        <option value="4pm">4pm</option> 
														<option value="5pm">5pm</option>
														<option value="6pm">6pm</option>
														<option value="7pm">7pm</option>
														<option value="8pm">8pm</option>
                                                        <option value="9pm">9pm</option>
                                                        <option value="10pm">10pm</option>
                                                        <option value="11pm">11pm</option>
                                                        <option value="12am">12am</option>
                                                        <option value="1am">1am</option>
                                                        <option value="2am">2am</option>
                                                        <option value="3am">3am</option>
                                                    </select>
                                                </div>
                                            </div>
											
											 <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label text-muted my-2">Open Days</label>
                                                    <select name="o_days" class="form-select custom-select" data-placeholder="Choose a Category" tabindex="1" required>
                                                        <option>--Select your Days--</option>
                                                        <option value="Mon-Tue">Mon-Tue</option>
                                                        <option value="Mon-Wed">Mon-Wed</option> 
														<option value="Mon-Thu">Mon-Thu</option>
														<option value="Mon-Fri">Mon-Fri</option>
														<option value="Mon-Sat">Mon-Sat</option>
														<option value="24hr-x7">24hr-x7</option>
                                                    </select>
                                                </div>
                                            </div>
											
											
											<div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label text-muted my-2">Image</label>
                                                    <input type="file" name="file"  id="lastName" class="form-control form-control-danger" placeholder="12n" required>
                                                    </div>
                                            </div>		
											
                                        </div>
                        
                                        
                                        <div class="row">
                                        <div class="col-md-6 my-2">
                                                <div class="form-group has-danger">
                                                    <label class="control-label text-muted my-2">City</label>
                                                    <input type="text" name="city"  id="" class="form-control form-control-danger" placeholder="Enter City Name" pattern="[A-Za-z ]+" title="Only letters and spaces are allowed" minlength="3">
                                                    </div>
                                            </div>
                                            <div class="col-md-6 my-2">
                                                <div class="form-group has-danger">
                                                    <label class="control-label text-muted my-2">Pincode</label>
                                                    <input type="text" name="pincode" class="form-control form-control-danger" pattern="\d{6}" title="Enter a valid 6-digit Pincode" required>
                                                    </div>
                                            </div>

                                            <div class="col-md-12 ">
                                                <div class="form-group">
                                                    
                                                    <textarea name="address" type="text" style="height:100px;" class="form-control my-2" placeholder="Enter Address" minlength="3" required></textarea>
                                                </div>
                                            </div>
                                           
                                        </div>
                                      
                                           
                                        </div>
                                    </div>
                                    <div class="form-actions m-2">
                                        <input type="submit" name="submit" class="btn btn-primary" value="Save"> 
                                    
                                    </div>
                                </form>
                            </div>
                        </div>
</div>
                 
    


</body>
</html>
