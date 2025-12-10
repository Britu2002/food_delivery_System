<?php 
include('../config.php');

$success_message = "";
$error_message = "";

// Fetch Sections Dynamically

$sections = mysqli_query($conn, "SELECT * FROM section ");

if(isset($_GET['view_id'])){
    $id =$_GET['view_id'];
    
    $res = mysqli_query($conn, "SELECT * FROM content where contentid =$id");  
    
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
              
                
                <h3 class="p-2 fw-bold">View Content</h3>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Section Name :</strong><span class="text-info" ><?php echo $content['sectionname'] ?></span></li>
                    <li class="list-group-item"><strong>Content Title :</strong><span class="text-info" ><?php echo $content['content_title'] ?></span></li>
                    <li class="list-group-item"><strong>Content Price : </strong><span class="text-info" ><?php echo $content['price'] ?></span></li>
                    <li class="list-group-item"><strong>Location</strong><span class="text-info" ><?php echo $content['content_location'] ?></span></li>
                    <li class="list-group-item"><strong>Description :</strong><span class="text-info" ><?php echo $content['contentdesc'] ?></span></li>
                    <li class="list-group-item"><strong>Alt Tag :</strong><span class="text-info" ><?php echo $content['alt_tag'] ?></span></li>
                    <li class="list-group-item"><strong>Link</strong><span class="text-info" ><?php echo $content['link'] ?></span></li>

                    <li class="list-group-item"><strong>display Status : </strong><span class="text-info" ><?php echo ($content['display_status']==1)?"Active":"Inactive" ?></span></li>

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
