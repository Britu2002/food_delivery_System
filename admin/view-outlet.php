<?php 
include('../config.php');

$success_message = "";
$error_message = "";



if(isset($_GET['view_id'])){
    $id =$_GET['view_id'];
    
    $res = mysqli_query($conn, "SELECT * FROM outlet where outletid =$id");  
    
    $content=mysqli_fetch_assoc($res);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/zaapin/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<?php include('admin-header.php'); ?>

<div class="content bg-light" id="mainContent">
    <form method="post" enctype="multipart/form-data">
        <div class="row ms-3 mt-2">
            <div class="col-md-8 shadow bg-white border-0 rounded p-3 me-5">
              
                
                <h3 class="p-2 fw-bold">View Outlet</h3>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Outlet Name :</strong><span class="text-info" ><?php echo $content['outletname'] ?></span></li>
                    <li class="list-group-item"><strong>Address : </strong><span class="text-info" ><?php echo $content['address'] ?></span></li>
                    <li class="list-group-item"><strong>City :</strong><span class="text-info" ><?php echo $content['city'] ?></span></li>
                    <li class="list-group-item"><strong>State : </strong><span class="text-info" ><?php echo $content['state'] ?></span></li>

                    <li class="list-group-item"><strong>Zipcode :</strong><span class="text-info" ><?php echo $content['zipcode'] ?></span></li>
                    <li class="list-group-item"><strong>Email :</strong><span class="text-info" ><?php echo $content['email'] ?></span></li>
                    <li class="list-group-item"><strong>Phone</strong><span class="text-info" ><?php echo $content['phone'] ?></span></li>

                    <li class="list-group-item"><strong>display Status : </strong><span class="text-info" ><?php echo ($content['status']=="Active")?"Active":"Inactive" ?></span></li>

                </ul>
                

               

           

               



                <!-- <div class="mb-2  form-group row">
                    <strong class="control-strong col-md-3">Upload Image</strong>
                  <img src="" alt="img" width="100px" height="100px" class="d-inline-block">      
                </div> -->

              
                </div>
            </div>
        </div>
    </form>
</div>

</body>
</html>
