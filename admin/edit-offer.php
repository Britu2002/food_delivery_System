<?php 
include('../config.php');
$success_message = isset($_GET['success_message']) ? $_GET['success_message'] : "";
$error_message = "";
$id =$_GET['id'];
$offers=mysqli_query($conn,"select * from offers where coupenid =$id ");
// Insert Outlet Data
if (isset($_POST['submit'])) {
 
    $coupencode = $_POST['coupencode'];
    $coupenpercentage = $_POST['coupenpercentage'];
    $minvalue = $_POST['minvalue'];
    $coupendesp = $_POST['coupendesp'];
    $expiredate = $_POST['expiredate'];
    $status = $_POST['status'];
    

    $imagename = $_POST['coupenophtoto'];
    echo $imagename;
   
    if (!empty($_FILES['imagename']['name'])) {
        $imagename = time() . "_" . basename($_FILES['imagename']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $imagename;
        move_uploaded_file($_FILES['imagename']['tmp_name'], $target_file);
    }
    $sql = "UPDATE `offers` SET `coupencode`='$coupencode',`coupenpercentage`='$coupenpercentage',min_value='$minvalue',`coupendesp`='$coupendesp',`status`='$status',`coupenophtoto`='$imagename',`expiredate`='$expiredate' WHERE `coupenid`=$id"; 
  
    if( mysqli_query($conn,$sql)){
        echo "<script>
        alert('coupen Updated successfully')
        window.location.href='listoffer.php'
        </script>";
       
    } else {
        $error_message = "Error! coupen not added.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Offers & Coupen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/zaapin/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<?php include('admin-header.php'); ?>

<div class="content bg-light" id="mainContent">
<?php while($row =mysqli_fetch_assoc($offers)): ?>

    <form method="post" enctype="multipart/form-data">
        <div class="row  mt-2 ms-3 ">
            <!-- Left Side: Add coupen Form -->
            <div class="col-md-6 shadow bg-white border-0 rounded p-3 me-4">
                <!-- Success & Error Messages -->
                <?php if ($success_message): ?>
                    <div class="alert alert-success p-2"><?php echo $success_message; ?></div>
                <?php endif; ?>
                <?php if ($error_message): ?>
                    <div class="alert alert-danger p-2"><?php echo $error_message; ?></div>
                <?php endif; ?>

                <h3 class="p-2 fw-bold">Edit Offers & coupen</h3>
                <hr>
                <div class="input-group mb-3">
  <input value="<?php echo $row['coupencode'] ?>" type="text" class="form-control"   name="coupencode" placeholder="Enter Coupen Code"> 
  
</div>

                 
           

                    <div class="input-group mb-3">
  <input value="<?php echo $row['coupenpercentage'] ?>" type="text" class="form-control"  name="coupenpercentage" placeholder="Enter Coupen Percentage"> 
  <span class="input-group-text" id="basic-addon2">%</span>
</div>
<div class="input-group mb-3">
  <input type="text" class="form-control"   name="minvalue" placeholder="Enter Minimum Value" value=<?php echo $row['min_value'] ?>> 
  
</div>

<div class="input-group mb-3">
  <input value="<?php echo $row['coupendesp'] ?>" type="text" class="form-control"   name="coupendesp" placeholder="Enter Description"> 
  
</div>
<div class="input-group mb-3">
  <span class="input-group-text">expire date</span>
  <input value="<?php echo $row['expiredate'] ?>" type="date" name="expiredate" class="form-control" required >
</div>   
                
 
<div class="input-group mb-3">
  <label class="input-group-text" >Status</label>
  <select class="form-select"   name="status">
  <option value="1" <?php echo ($row['status']==1)?"selected":""?>>Active</option>

  <option value="0" <?php echo ($row['status']==0)?"selected":""?>>Inactive</option>
    
  </select>
</div>



          
<div class="form-group input-group mb-3">
                        <div class="input-group-prepend" ><span class="input-group-text lh-lg" > Offer Photo</span></div>
                        <div class="form-control">
                           <input  class="" name="imagename" type="file" >

                           </div>

                       </div>  

                       <img src="uploads/<?php echo $row['coupenophtoto']?>"width=100px height=100px alt="" srcset="" class="img-fliud">       
<input type="hidden"  name="coupenophtoto" value="<?php echo $row['coupenophtoto']?>">


                <hr>
                <button type="submit" name="submit" class="my-2 p-2 fw-bold btn btn-warning">
                    <i class="bi bi-patch-check"></i> Submit
                </button>
            </div>

          
        </div>
    </form>
    <?php endwhile; ?>
</div>


</body>
</html>
