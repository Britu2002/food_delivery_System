<?php 
include('../config.php');

$success_message = isset($_GET['success_message'])?$_GET['success_message']:"";
$error_message = "";



if(isset($_GET['edit_id'])){
    $id =$_GET['edit_id'];
    $oldname =$_GET['entitytitle'];
    $res = mysqli_query($conn, "SELECT * FROM outlet where outletid =$id");  
    
    $content=mysqli_fetch_assoc($res);

}
if (isset($_POST['submit'])) {
    $outletname = $_POST['outletname'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $createdon = date("Y-m-d H:i:s");
   


mysqli_query($conn,"UPDATE `add_photos` SET `entitytitle`='$outletname' WHERE `entityid`=$id and entitytitle='$oldname' ");
    
    // SQL Query to Insert Outlet
    $sql = "UPDATE `outlet` SET`outletname`='$outletname',`address`='$address',`city`='$city',`state`='$state',`zipcode`='$zipcode',`phone`='$phone',`email`='$email',`status`='$status',`createdon`='$createdon' WHERE  `outletid`=$id";

    if ($res = mysqli_query($conn, $sql)) {
        echo "<script>alert('edit Data successfully')
        window.location.href='listoutlet.php'
        </script>
        
        ";
       
       

    } else {
        $error_message = "Error! Outlet not added.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Outlet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/zaapin/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<?php include('admin-header.php'); ?>


<div class="content bg-light" id="mainContent">

    <form method="post" >
 
        <div class="d-flex ms-3 mt-2">

            <div class="col-md-8 shadow bg-white border-0 rounded p-3 me-5">
            <?php if ($success_message): ?>
                    <div class="alert alert-success p-2"><?php echo $success_message; ?></div>
                <?php endif; ?>
                <?php if ($error_message): ?>
                    <div class="alert alert-danger p-2"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <div class=" d-flex">
                    <div class="">
                    <h3 class="p-2 fw-bold text-orange">Edit Outlet</h3>
                    </div>
                    <!-- <div class=""><a href="listoutlet.php ">Back</a></div> -->
                </div>
               
                <ul class="list-group mb-2">
                    <li class="list-group-item border-0  d-flex"><strong class="col-md-3">Outlet Name :</strong><div class="col-md-8"><input name="outletname" class=" form-control" value="<?php echo $content['outletname'] ?>"></div></li>
                    <li class="list-group-item border-0 d-flex"><strong class="col-md-3">Address : </strong><div class="col-md-8"><input name="address" class=" form-control" value="<?php echo $content['address'] ?>"></div></li>
                    <li class="list-group-item border-0 d-flex"><strong class="col-md-3">City :</strong><div class="col-md-8"><input name="city" class=" form-control" value="<?php echo $content['city'] ?>"></div></li>
                    <li class="list-group-item border-0 d-flex"><strong class="col-md-3">State : </strong><div class="col-md-8"><input name="state" class=" form-control" value="<?php echo $content['state'] ?>"></div></li>

                    <li class="list-group-item border-0 d-flex"><strong class="col-md-3">Zipcode :</strong><div class="col-md-8"><input name="zipcode" class=" form-control" value="<?php echo $content['zipcode'] ?>"></div></li>
                    <li class="list-group-item border-0 d-flex"><strong class="col-md-3">Email :</strong><div class="col-md-8"><input name="email" class=" form-control" value="<?php echo $content['email'] ?>"></div></li>
                    <li class="list-group-item border-0 d-flex"><strong class="col-md-3">Phone</strong><div class="col-md-8"><input name="phone" class=" form-control" value="<?php echo $content['phone'] ?>"></div></li>

                    <li class="list-group-item border-0 d-flex"><strong class="col-md-3">display Status : </strong><div class="col-md-8">
                        <select name="status" id="" class=" form-select">
                            <option value="Active" <?php echo ($content['status']=="Active")?"selected":"" ?>>Active</option>
                            <option value="Inactive" <?php echo ($content['status']=="Inactive")?"selected":"" ?>>Inactive</option>
                        </select>
     </div></li>

                </ul>
  <div class="mb-2  form-group d-flex gap-3">
                 <button type="submit" name="submit" class="btn btn-success ">Update</button>
     <a href="listoutlet.php " class="btn btn-danger">Cancel</a>
                </div>

              
                </div>
            </div>
        </div>
    </form>
</div>

</body>
</html>
