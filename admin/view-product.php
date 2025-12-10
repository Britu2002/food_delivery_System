<?php 
include('../config.php');

$success_message = "";
$error_message = "";

if(isset($_GET['view_id'])){
    $id = $_GET['view_id'];
    
    // Fetch product details with category and outlet
    $query = "SELECT p.*, c.categoryname,title,p.image
              FROM product p 
              JOIN category c ON p.categoryid = c.categoryid
              JOIN restaurant r ON r.resid = p.resid
        
              WHERE p.productid = $id";

    $res = mysqli_query($conn, $query);  
    $content = mysqli_fetch_assoc($res);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

<?php include('admin-header.php'); ?>

<div class="content bg-light" id="mainContent">
    <div class="row">
        <div class="col-md-8 shadow bg-white border-0 rounded p-3">
            <h3 class="p-2 fw-bold">Product Details</h3>
            <ul class="list-group">
                <li class="list-group-item"><strong>Product Name :</strong> <span class="text-info"><?php echo $content['productname']; ?></span></li>
                <li class="list-group-item"><strong>Category :</strong> <span class="text-info"><?php echo $content['categoryname']; ?></span></li>
                <li class="list-group-item"><strong>Restaurant :</strong> <span class="text-info"><?php echo $content['title']; ?></span></li>
                <li class="list-group-item"><strong>Product Type :</strong> <span class="text-info"><?php echo ($content['prodect_type'] == 1) ? 'Veg' : (($content['prodect_type'] == 2) ? 'Non-Veg' : 'Vegan'); ?></span></li>
                
                <li class="list-group-item"><strong>Recommended :</strong> <span class="text-info"><?php echo $content['recommended']; ?></span></li>
                <li class="list-group-item"><strong>Display Price :</strong> <span class="text-info"><?php echo $content['display_price']; ?> </li>
 <li class="list-group-item : "><strong>Image</strong><img src="/zaapin/admin/uploads/<?php echo $content['image'] ?>" alt="image" width="200px" height="100px"></li>

            </ul>

           
            
            <a href="listproduct.php" class="btn btn-secondary mt-3">Back</a>
        </div>
    </div>
</div>

</body>
</html>
