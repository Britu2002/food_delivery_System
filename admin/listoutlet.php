<?php 
include('../config.php');

$success_message = "";
$error_message = "";
$limit = isset($_GET['limit']) ? $_GET['limit'] : 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1; 
$search = isset($_GET['search']) ? $_GET['search'] : ""; 

$offset = ($page - 1) * $limit; 

// Get Total Orders Count
$countQuery = "SELECT COUNT(*) AS total FROM outlet";
$countResult = mysqli_query($conn, $countQuery);
$totalRows = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRows / $limit);


if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
 
    

    
    $sql = "DELETE FROM outlet WHERE outletid=$id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Outlet deleted successfully!');</script>";
        echo "<script>window.location='listoutlet.php';</script>";
        exit;
    }
}


// Insert Outlet Data
if (isset($_POST['submit'])) {
    $outletlocation = htmlspecialchars($_POST['outletlocation']);
    $city = htmlspecialchars($_POST['city']);
    $pincode = htmlspecialchars($_POST['pincode']);
    $createdon = date("Y-m-d");

 
        // Insert Data
        $sql = "INSERT INTO `outlet`(`outletlocation`, city, `pincode`, `createdon`) 
                VALUES ('$outletlocation', '$city', '$pincode', '$createdon')";
        if (mysqli_query($conn, $sql)) {
            $success_message = "Outlet added successfully!";
        } else {
            $error_message = "Error! Outlet not added.";
        
    }


    // $outletlocation = $_POST['outletlocation'];
    // // $address = $_POST['address'];
    // $city = $_POST['city'];
    // // $state = $_POST['state'];
    // $pincode = $_POST['pincode'];
    // // $phone = $_POST['phone'];
    // // $email = $_POST['email'];
    // // $status = $_POST['status'];
    // $createdon = date("Y-m-d");


    // // Image Upload Handling
    // // $imagename = "";
    // // if (!empty($_FILES['imagename']['name'])) {
    // //     $imagename = time() . "_" . basename($_FILES['imagename']['name']);
    // //     $target_dir = "uploads/";
    // //     $target_file = $target_dir . $imagename;
    // //     move_uploaded_file($_FILES['imagename']['tmp_name'], $target_file);
    // // }

    // // SQL Query to Insert Outlet
    // $sql = "INSERT INTO `outlet`(`outletlocation`,city, `pincode`, `createdon`) 
    //         VALUES ('$outletlocation','$city', '$pincode', '$createdon')";

    // if ($res = mysqli_query($conn, $sql)) {
    //     // if (!empty($imagename)) {
    //     //     $outletid = mysqli_insert_id($conn); // Get last inserted outlet ID
    //     //     $phto = "INSERT INTO `add_photos`(`entityid`,entitytitle, `img`) VALUES ($outletid,'$outletlocation', '$imagename')";
    //     //     mysqli_query($conn, $phto);
    //     // }
    //     $success_message = "Outlet added successfully!";
    // } else {
    //     $error_message = "Error! Outlet not added.";
    // }
}
 $sql = "SELECT * from outlet where  outletlocation LIKE '%$search%' or pincode LIKE '%$search' ORDER BY outletid desc   LIMIT $limit   OFFSET $offset  ";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Outlet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/zaapin/css/style.css">
</head>
<body>

<?php include('admin-header.php'); ?>

<div class="content bg-light" id="mainContent">
    <form method="post" enctype="multipart/form-data" >
        <div class="row ms-3 mt-2" >
            <!-- Left Side: Add Outlet Form -->
            <div class="col-md-4 shadow bg-white border-0 rounded p-3 me-5" style="max-height:400px">
                <!-- Success & Error Messages -->
                <?php if ($success_message): ?>
                    <div class="alert alert-success p-2"><?php echo $success_message; ?></div>
                <?php endif; ?>
                <?php if ($error_message): ?>
                    <div class="alert alert-danger p-2"><?php echo $error_message; ?></div>
                <?php endif; ?>

                <h4 class="p-2 fw-bold">Add Outlet</h4>
                <hr>
              
               
                <div class="input-group mb-3">
  
  <input type="text" name="outletlocation" class="form-control"  pattern="^[A-Za-z\s]{3,200}$"  minlength="3" maxlength="200"   title="Outlet Location must be at least 3 characters." required placeholder="Enter Outlet Location">
</div>  

                
             

<div class="input-group mb-3">
               
               <span class="input-group-text">City</span>
               <!-- <input type="text" name="city"  >  -->
               <input type="text" name="city" 
       pattern="^[A-Za-z\s]{3,30}$" 
       minlength="3" maxlength="30" 
       class="form-control"
       required 
       title="City name must be 3-30 characters long and contain only letters and spaces.">


</div>  
<!--   
<div class="input-group mb-3">
               
               <span class="input-group-text">State</span>
               <input type="text" name="state" class="form-control" >

</div>  -->
     
<div class="input-group mb-3">              
               <span class="input-group-text">Pincode</span>
               <input type="text" minlength="6" maxlength="6" name="pincode"  title="Pincode must be a 6-digit number." class="form-control" required>
</div>
<!-- <div class="input-group mb-3">
               
               <span class="input-group-text">Address</span>
               <textarea class="form-control" aria-label="With textarea" name="address"></textarea>

</div>-->

              
                <!-- <div class="input-group mb-3">
  <span class="input-group-text">Phone</span>
  <input type="number" name="phone" class="form-control"  >
</div>   
                
                <div class="input-group mb-3">
  <span class="input-group-text">Email</span>
  <input type="email" name="email" class="form-control"  >
</div>   -->
               
                <!-- <div class="input-group mb-3">
  <label class="input-group-text" >Status</label>
  <select class="form-select"   name="status">

  <option value="active">Active</option>
  <option value="inactive">Inactive</option>
    
  </select>
</div> -->

<!-- <div class="form-group input-group">
                        <div class="input-group-prepend" ><span class="input-group-text lh-lg" > Outlet Photo</span></div>
                        <div class="form-control">
                           <input class="" name="imagename" type="file" >
                           </div>
                       </div> -->

                <hr>
                <button type="submit" name="submit" class="my-2 p-2 fw-bold btn btn-warning btn-sm text-white">
                <i class="fa fa-fw fa-lg fa-check-circle"></i>Submit
                </button>
                </form>
            </div>

            <!-- Right Side: Outlet List -->
            <div class="col-md-7 bg-white  shadow">
                <h4 class="fw-bold p-3">List Of Outlet</h4>
                <hr>
                <div class=" row mb-2" >
            <div class="col-md-6">
                <label for="limit">Show:</label>
                <select id="limit" class="form-select w-auto d-inline" onchange="changeLimit()">
                    <option value="5" <?php if($limit == 5) echo 'selected'; ?>>5</option>
                    <option value="10" <?php if($limit == 10) echo 'selected'; ?>>10</option>
                    <option value="20" <?php if($limit == 20) echo 'selected'; ?>>20</option>
                </select>
            </div>
            <div class="col-md-6">
            <input type="text" placeholder="Search" class="form-control" id="search" onchange="Search()" 
            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            </div>
        </div>
                <table class="table table-bordered   ">
                    <thead class="">
                        <tr class=" ">
                            <th class="bg-warning text-white">ID</th>
                            <th class="bg-warning text-white">Outlet Location</th>
                            <th class="bg-warning text-white">City</th>
                            <th class="bg-warning text-white">Pincode</th>
                       
                            <th class="bg-warning text-white ">Action</th>
                     
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $result = mysqli_query($conn, $sql);
$sno =$offset+1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td> {$sno}</td>
                                    <td>{$row['outletlocation']}</td>
                                    <td>{$row['city']}</td>
                                    <td>{$row['pincode']}</td>
                                           
                                <td col='col-6' >

                    <a href='?delete_id=" . $row['outletid'] ."' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>
   <i class='fa fa-trash'></i>   Delete
</a>

                     
                   

      
    </td>
         
     
                                 </tr>";
                                 {$sno++;}
                        }
                        ?>
                    </tbody>
                </table>
               
        <nav>
            <ul class="pagination justify-content-end">
                <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&limit=<?php echo $limit; ?>">Previous</a>
                </li>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?php if($page >= $totalPages) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&limit=<?php echo $limit; ?>">Next</a>
                </li>
            </ul>
        </nav>
            </div>
        </div>
    
</div>


</body>

<script>
    function changeLimit() {
        var limit = document.getElementById('limit').value;
        window.location.href = '?page=1&limit=' + limit;
    }
    function Search(){
        var search = document.getElementById('search').value;

        window.location.href = '?page=1&search=' + search;
    }
</script>
</html>
