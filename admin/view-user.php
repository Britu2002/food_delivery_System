<?php
include('../config.php');
session_start();

if (isset($_GET['userid'])) {
    $user_id = $_GET['userid'];

    // Fetch user details
    $query = "SELECT * FROM agent WHERE userid = $user_id";
    $result=mysqli_query($conn,$query);
    $user=mysqli_fetch_assoc($result);
 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'admin-header.php'; ?>

<div class="container content bg-light" id="mainContent">
    <div class="bg-white shadow p-4">
        <h2 class="mb-3 fw-bold">User Profile</h2>
        <hr>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active show border-bottom" href="view-user.php?userid=<?php echo $user['userid']; ?>">Profile Information</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link border-bottom" href="edit-user.php?edit_id=<?php //echo $user['userid']; ?>">Update Profile</a>
            </li> -->
        </ul>

        <div class="row mt-3">
            <div class="col-md-5 d-flex gap-3">
                <img src="uploads/<?php echo (!empty($user['photo'])) ? $user['photo'] : 'defaultuser.png'; ?>" class="img-fluid border p-2" style="width:200px;height:300px">
                
              
                    <img src="uploads/<?php echo (!empty($user['aadhar_copy'])) ? $user['aadhar_copy'] : 'defaultuser.png'; ?>" class="img-fluid border p-2" style="width:200px;height:300px">
                
            </div>

            <div class="col-md-7">
                <h3 class="p-2">Personal Information :</h3>
                <hr>
                <table class="table border">
              
                    <tr><th class="col-4">Name:</th><td class="col-6"><?php echo $user['fullname']; ?></td></tr>
                    <tr><th class="col-4">Mobile:</th><td class="col-6"><?php echo $user['mobile']; ?></td></tr>
                    <tr><th class="col-4">Email:</th><td class="col-6"><?php echo $user['email']; ?></td></tr>
                    <tr><th class="col-4">User Address:</th><td class="col-6"><?php echo $user['address']." ".$user['city'].",".$user['pincode'] ; ?></td></tr>

                    <tr><th class="col-4">password:</th><td class="col-6"><?php echo $user['password']; ?></td></tr> 
                    <tr><th class="col-4">Status:</th>
                            <td class="col-6">
                                <?php echo ($user['status'] == 'Active') ? '<span class="text-success">Active</span>' : '<span class="text-danger">Inactive</span>'; ?>
                            </td>
                        </tr>
                    
                        <tr><th class="col-4">Aadhar Number:</th><td class="col-6"><?php echo $user['aadhar_number']; ?></td></tr>
                        <?php
                         $outletid =$user['res_id'];
                         $outletresult=mysqli_query($conn,"SELECT * FROM `restaurant`  where resid=$outletid");
                         $outlet=mysqli_fetch_assoc($outletresult);
                         $title =$outlet['title'];
                         $outletlocation=$outlet['addr'];
                         $outletcity=$outlet['city'];
                         $outletpincode=$outlet['pincode'];
                        ?>
                        <tr><th class="col-4"> Work At:</th><td class="col-6">
                            <p class="m-0 p-0"><?php echo $title ?></p>
                       <small><?php echo $outletlocation." ". $outletcity. ",". $outletpincode  ; ?></td></small> 
                    </tr>
                    

                </table>
            </div>
        </div>

    </div>
</div>
</body>
</html>
