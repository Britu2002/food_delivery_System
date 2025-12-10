<?php 
include('../config.php');

$success_message = isset($_GET['success_message'])?$_GET['success_message']:"";
$error_message = "";


if(isset($_GET['edit_id'])){
    $id = $_GET['edit_id'];
    $entitytitle =$_GET['entitytitle']; 
    // Fetch product details
    $query = "SELECT * FROM product WHERE productid = $id";
    $res = mysqli_query($conn, $query);  
    $content = mysqli_fetch_assoc($res);

}

// Fetch dynamic categories
$category_query = "SELECT * FROM category";
$category_result = mysqli_query($conn, $category_query);

// Fetch dynamic subcategories
$subcategory_query = "SELECT * FROM restaurant";
$subcategory_result = mysqli_query($conn, $subcategory_query);

// Fetch dynamic outlets
// $outlet_query = "SELECT * FROM outlet";
// $outlet_result = mysqli_query($conn, $outlet_query);

// Fetch dynamic offers
// $offer_query = "SELECT * FROM offers";
// $offer_result = mysqli_query($conn, $offer_query);

// Handle Form Submission
if(isset($_POST['submit'])){
    $categoryid = $_POST['categoryid'];
    $subcategoryid = $_POST['subcategoryid'];
    $prodect_type = $_POST['product_type'];
    $productname = $_POST['productname'];
    // $size = $_POST['size'];
$desp =$_POST['desp'];
    $display_price = $_POST['display_price'];
    // $available_in_outlet = $_POST['available_in_outlet'];
    // $offer_available = ($_POST['offer_available'] == "NULL") ? "NULL" : "'".$_POST['offer_available']."'";
    $recommended = $_POST['recommended'];
  
  

    
    
    // Image upload handling
    if(!empty($_FILES['product_image']['name'])) {
        $target_dir = "uploads/";
        $image_name = basename($_FILES['product_image']['name']);
        $target_file = $target_dir . $image_name;
        move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file);
    } else {
       
        $image_name = $content['image']; // Retain existing image if no new upload
    }

    
    $update_query = "UPDATE product SET 
                     categoryid='$categoryid', 
                     resid=$subcategoryid, 
                     prodect_type='$prodect_type', 
                     productname='$productname', 
                   desp='$desp',
                    display_price='$display_price',
                   
                    
                     recommended='$recommended',
                     image='$image_name' 
                     WHERE productid = $id";

    if(mysqli_query($conn, $update_query)){
        echo "<script>alert('Product updated successfully'); window.location.href='listproduct.php';</script>";
    } else {
        $error_message = "Error updating product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('admin-header.php'); ?>

<div class="content bg-light" id="mainContent"  enctype="multipart/form-data">
    <form method="post" enctype="multipart/form-data">
        <div class="d-flex ms-3 mt-2">
            <div class="col-md-8 shadow bg-white border-0 rounded p-3 me-5">
                <?php if ($success_message): ?>
                    <div class="alert alert-success p-2"><?php echo $success_message; ?></div>
                <?php endif; ?>
                <?php if ($error_message): ?>
                    <div class="alert alert-danger p-2"><?php echo $error_message; ?></div>
                <?php endif; ?>
                
                <h3 class="p-2 fw-bold">Edit Product</h3>
                <ul class="list-group mb-2">
                <li class="list-group-item border-0 d-flex">
    <strong class="col-md-3">Product Image:</strong>
    <div class="col-md-8">
        <input type="file" name="product_image" class="form-control">
        <?php if(!empty($content['image'])): ?>
            <img src="uploads/<?php echo $content['image']; ?>" width="100" class="mt-2">
        <?php endif; ?>
    </div>
</li>

<li class="list-group-item border-0 d-flex">
                        <strong class="col-md-3">Restaurant :</strong>
                        <div class="col-md-8">
                            <select name="subcategoryid" class="form-select">
                                <?php while($row = mysqli_fetch_assoc($subcategory_result)): ?>
                                    <option value="<?php echo $row['resid']; ?>" 
                                        <?php echo ($row['resid'] == $content['resid']) ? "selected" : ""; ?>>
                                        <?php echo $row['title']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </li>

                    <li class="list-group-item border-0 d-flex">
                        <strong class="col-md-3">Product Name :</strong>
                        <div class="col-md-8"><input name="productname" class="form-control" value="<?php echo $content['productname']; ?>"></div>
                    </li>
                    <li class="list-group-item border-0 d-flex">
                        <strong class="col-md-3">Product Description :</strong>
     <div class="col-md-8">       <textarea name="desp" id="" class="form-control" ><?php echo $content['desp'] ?></textarea></div>
                 
                    </li>

                    <li class="list-group-item border-0 d-flex">
                        <strong class="col-md-3">Category :</strong>
                        <div class="col-md-8">
                            <select name="categoryid" class="form-select">
                                <?php while($row = mysqli_fetch_assoc($category_result)): ?>
                                    <option value="<?php echo $row['categoryid']; ?>" 
                                        <?php echo ($row['categoryid'] == $content['categoryid']) ? "selected" : ""; ?>>
                                        <?php echo $row['categoryname']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </li>

                
                   
             
                    <li class="list-group-item border-0 d-flex">
                        <strong class="col-md-3">Product Type :</strong>
                        <div class="col-md-8">
                            <select name="product_type" class="form-select">
                            <option value="1" <?php echo ($content['prodect_type'] == 1) ? "selected" : ""; ?>>Veg</option>
                        <option value="2" <?php echo ($content['prodect_type'] == 2) ? "selected" : ""; ?>>Non-Veg </option>
                      
                               
                        
                              
                            </select>
                        </div>
                    </li>
                    
                    

                     <!-- <li class="list-group-item border-0 d-flex">
                        <strong class="col-md-3">Product Size :</strong>
                        <div class="col-md-8" >
                            
                        <input name="size" class="form-control" value="<?php //echo $content['size']; ?>">
                        
                    </div>
                    </li> -->

                   

                    <li class="list-group-item border-0 d-flex">
                        <strong class="col-md-3">Display Price :</strong>
                        <div class="col-md-8"><input name="display_price" type="number" min="0" class="form-control" value="<?php echo $content['display_price']; ?>"></div>
                    </li> 

                    <li class="list-group-item border-0 d-flex">
                        <strong class="col-md-3">Recommended :</strong>
                        <div class="col-md-8">
                            <select name="recommended" class="form-select">
                                <option value="Yes" <?php echo ($content['recommended'] == "Yes") ? "selected" : ""; ?>>Yes</option>
                                <option value="No" <?php echo ($content['recommended'] == "No") ? "selected" : ""; ?>>No</option>
                            </select>
                        </div>
                    </li>

                    
                </ul>

                <div class="mb-2 form-group d-flex gap-3">
                    <button type="submit" name="submit" class="btn btn-success">Update</button>
                    <a href="listproduct.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>

</body>
</html>
