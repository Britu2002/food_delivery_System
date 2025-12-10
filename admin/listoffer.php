<?php 
include('../config.php');

$success_message = "";
$error_message = "";

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    // Fetch all photos linked to this coupen
    $photoQuery = mysqli_query($conn, "SELECT coupenophtoto FROM offers WHERE coupenid=$id");
    
$photo = mysqli_fetch_assoc($photoQuery);
        $photoPath = "uploads/" . $photo['coupenophtoto'];
        
        // Check if file exists before deleting
        if (file_exists($photoPath)) {
            unlink($photoPath);
        }
    



    // Delete coupen from database
    $sql = "DELETE FROM offers WHERE coupenid=$id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('coupen deleted');</script>";
        echo "<script>window.location='listoffer.php';</script>";
    }
}

// Insert coupen Data
if (isset($_POST['submit'])) {
   
    $coupencode = $_POST['coupencode'];
    $coupenpercentage = $_POST['coupenpercentage'];
    $minvalue = $_POST['minvalue'];
  
    $coupendesp = $_POST['coupendesp'];
    $expiredate = $_POST['expiredate'];
    $status = $_POST['status'];
    $imagename = "";
    if (!empty($_FILES['imagename']['name'])) {
        $imagename = time() . "_" . basename($_FILES['imagename']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $imagename;
        move_uploaded_file($_FILES['imagename']['tmp_name'], $target_file);
    }
   

     
        $sql = "INSERT INTO `offers`( `coupencode`, `coupenpercentage`,min_value, `coupendesp`, `status`, `coupenophtoto`, `expiredate`) VALUES ('$coupencode', '$coupenpercentage','$minvalue', '$coupendesp', '$status', '$imagename', '$expiredate')"; 
  
        if( mysqli_query($conn,$sql)){
            $success_message = "coupen added successfully!";
        } else {
            $error_message = "Error! coupen not added.";
        }
      
    

 
  
}
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;
$page =isset($_GET['page'])?intval($_GET['page']):1;
$toalrecords =mysqli_fetch_assoc(mysqli_query($conn,"select count(*) as total from offers "))['total'];
$totalpages =ceil($toalrecords/$limit);
$offset =($page -1)*$limit;

$sql = "SELECT * from offers order by coupenid desc limit $limit OFFSET $offset ";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add coupen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/zaapin/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<?php include('admin-header.php'); ?>

<div class="content bg-light" id="mainContent">
    <form method="post" enctype="multipart/form-data">
        <div class="row  mt-2">
            <!-- Left Side: Add coupen Form -->
            <div class="col-md-4 shadow bg-white border-0 rounded p-3 me-4" style="height:620px">
                <!-- Success & Error Messages -->
                <?php if ($success_message): ?>
                    <div class="alert alert-success p-2"><?php echo $success_message; ?></div>
                <?php endif; ?>
                <?php if ($error_message): ?>
                    <div class="alert alert-danger p-2"><?php echo $error_message; ?></div>
                <?php endif; ?>

                <h4 class="p-2 fw-bold">Add coupen</h4>
                <hr>
                <div class="input-group mb-3">

                <input type="text" name="coupencode" 
       pattern="^[A-Za-z0-9]{5,10}$" 
       minlength="5" maxlength="10" 
       required 
       title="Coupon Code must be 5-10 characters long and contain only letters & numbers."
       placeholder="Enter Copen Code"
       class="form-control"
       >

  <div class="input-group ">
  <span class="text-danger "><?php echo isset($_code_err)?"$_code_err":"" ?></span>
                </div>

 
</div>

                 
           

                    <div class="input-group mb-3">
  <input required type="number" class="form-control" min="1" max="100" name="coupenpercentage" placeholder="Enter Coupen Percentage" > 
  <span class="input-group-text" id="basic-addon2">%</span>


</div>

<div class="input-group mb-3">
  <input required type="number" class="form-control"  min="0"  name="minvalue" placeholder="Enter Minimum Value" > 
 
</div>
<div class="input-group mb-3">
  <input  type="text" class="form-control"   name="coupendesp" minlength="5" placeholder="Enter Description"> 
 
</div>
<div class="input-group mb-3">
  <span class="input-group-text">expire date</span>
 
  <input required type="date" name="expiredate" class="form-control" min="<?= date('Y-m-d'); ?>"   >

</div>   
                
 
<div class="input-group mb-3">
  <label class="input-group-text" >Status</label>
  <select class="form-select"   name="status">

  <option value="1">Active</option>
  <option value="0">Inactive</option>
    
  </select>
</div>



          
<div class="form-group input-group">
                        <div class="input-group-prepend" ><span class="input-group-text lh-lg" > Offer Photo</span></div>
                        <div class="form-control">
                           <input required class="" name="imagename" type="file" >
                           </div>
                       </div>  

             



                <hr>
                <button type="submit" name="submit" class="my-2 p-2 fw-bold btn btn-warning">
                    <i class="bi bi-check-circle"></i> Submit
                </button>
                </form>
            </div>

            <!-- Right Side: coupen List -->
            <div class="col-md-7 bg-white shadow">

                <h4 class="fw-bold p-3">List of Offer & Coupen</h4>
                <hr>

<div class="row mb-3">
 
    <div class="col-md-6">
        <form action="">
        <label>Show:</label>
        <select name="limit" class="form-control d-inline-block w-25" onchange="this.form.submit()">
        <option value="5" <?php echo ($limit == 5) ? "selected" : ""; ?>>5</option>
            <option value="10" <?php echo ($limit == 10) ? "selected" : ""; ?>>10</option>
            <option value="25" <?php echo ($limit == 25) ? "selected" : ""; ?>>25</option>
            <option value="50" <?php echo ($limit == 50) ? "selected" : ""; ?>>50</option>
            <option value="100" <?php echo ($limit == 100) ? "selected" : ""; ?>>100</option>
        </select>
        
        <span>entries</span>
        </form>
    </div>
    <div class="col-md-6" >
        <!-- <label for="search">Search:</label> -->
        <!-- <input required type="text" name="search" id="search" class="form-control d-inline-block w-75" value="<?php// echo $search; ?>" onchange="this.form.submit()"> -->
    </div>
</div>
<div style="overflow-x: auto; max-height: 400px;">


                <table class="table table-bordered  ">
                    <thead>
                        <tr class="">
                            <th class="bg-warning text-white ">ID</th>
                            <th class="bg-warning text-white ">Image</th>
                            <th class="bg-warning text-white ">Coupen</th>
                            <th class="bg-warning text-white ">Description</th>
                            <th class="bg-warning text-white ">Status</th>
                            <th class="bg-warning text-white ">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                      
$sno =$offset+1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td class='col-1'>{$sno}</td>
                                     <td class='col-4'><img src='uploads/".$row['coupenophtoto']."' width=150px height=80px><br>
                                     <small class='text-danger'>Expiry : ".date("M jS, Y", strtotime($row['expiredate']))."</small>
                                     </td>
                                    <td class='col-1'><span class='bg-success-subtle p-1'>{$row['coupencode']}</span><br>
 
                                         <small>  discount :  {$row['coupenpercentage']}%<br> min order: {$row['min_value']}</small>
                                    </td>
                                     <td class='col-2'>
                                     
                                
                                     <small>{$row['coupendesp']}<small><br>
                              
                                     </td> 
                                
    
                                    <td class='col-1'><span class='badge bg-" . ($row['status'] == '1' ? 'success' : 'danger') . "'>
                                     " . ($row['status'] == '1' ? 'Active' : 'InActive') . "
                                    </span>
                                   
                                    </td>
                                <td class='col-1'>


        <div class='dropdown'>
            <button class='btn btn-primary btn-sm dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                Actions
            </button>
            <ul class='dropdown-menu ' style='min-width:6rem'>
                <li>
                
                    <a href='?delete_id=" . $row['coupenid'] . "' class='dropdown-item text-danger' onclick='return confirm(\"Are you sure?\")'>
                       <i class='fa fa-trash'></i>    Delete
                    </a>
                       <a href='edit-offer.php?id=" . $row['coupenid'] . "' class='dropdown-item text-success ' >
                       <i class='fa fa-edit'></i>  Edit
                    </a>
                   
                    
                </li>
                

            </ul>
        </div>
    </td>
                                 </tr>";
                                 {$sno++;}
                        }
                        ?>
                    </tbody>
                </table>
                </div>
                <nav aria-label="Page navigation example">
  <ul class="pagination justify-content-end">
    <li class="page-item <?php echo($page<=1)?'disabled':'';?>">
      <a class="page-link" href="?page=<?php echo $page-1; ?>&limit=<?php echo $limit ?>">Previous</a>
    </li>
    <?php for ($i=1; $i <= $totalpages; $i++) : ?>
    <li class="page-item"><a class="page-link" href="?limit=<?php echo $limit; ?>&page=<?php echo $i; ?>"><?php echo  $i ?></a></li>
    <?php endfor; ?>
   
    <li class="page-item <?php echo($page==$totalpages)?'disabled':'';?>">
      <a class="page-link" href="href=?page=<?php echo $page+1; ?>&limit=<?php echo $limit ?>">Next</a>
    </li>
  </ul>
</nav>
            </div>
        </div>
    
</div>


</body>
</html>
