<?php 
include('../config.php');

$success_message = "";
$error_message = "";
$selected_category = "";
$subcategories = [];

// Fetch categories and outlets
$category = mysqli_query($conn, "SELECT * FROM category");
$Restaurant = mysqli_query($conn, "SELECT * FROM `restaurant` ");
// $subcategory = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM subcategory"), MYSQLI_ASSOC);
// $outlet = mysqli_query($conn, "SELECT * FROM outlet");
$product = mysqli_query($conn, "SELECT * FROM product");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['submit'])) {
        $Restaurant = $_POST['Restaurant'];
        $categoryid = $_POST['categoryid'];
      $desp =$_POST['desp'];
        $product_type = $_POST['product_type'];
        $productname = $_POST['productname'];
        $recommended = $_POST['recommended'];
    // $striked_price=$_POST['striked_price'];
    $display_price=$_POST['display_price'];
        $imagename = "";
        if (!empty($_FILES['imagename']['name'])) {
            $imagename = time() . "_" . basename($_FILES['imagename']['name']);
            $target_dir = "uploads/";
            $target_file = $target_dir . $imagename;
            move_uploaded_file($_FILES['imagename']['tmp_name'], $target_file);
        }

        // Insert product data
        $query = "INSERT INTO `product` (resid,`categoryid`, `prodect_type`, `productname`, `recommended`, `image`,display_price,desp) 
                  VALUES ($Restaurant,$categoryid, '$product_type', '$productname', '$recommended', '$imagename',$display_price,'$desp')";
   
        if (mysqli_query($conn, $query)) {
           
           
            echo "<script>alert('product added successfully!');
            window.location.href='add-product.php';
            </script>";
            $success_message = "Product added successfully!";
            
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('admin-header.php'); ?>

<div class="content bg-light" id="mainContent"> 
    <form method="post" id="productform"  enctype="multipart/form-data" >
        <div class="row">
            <div class="col-md-8 bg-white p-4 shadow-sm rounded">
                <h3 class="mb-3 form-group row fw-bold">Add Menu</h3>
             
                <div>
                    <a href="add-resto.php" class="btn btn-dark btn-sm"><i class='bi bi-plus'></i>Restaurant</a>
                    <a href="Categories.php" class="btn btn-dark btn-sm"><i class='bi bi-plus'></i>Category</a>
                </div>
                <hr>
                <?php if ($success_message) echo "<div class='alert alert-success mb-2'>$success_message</div>"; ?>
                <?php if ($error_message) echo "<div class='alert alert-danger mb-2'>$error_message</div>"; ?>

                <div class="mb-3 form-group row ">
                    <strong class="col-md-3" >Restaurant </strong>
                    <div class="col-md-8">     
                    <select name="Restaurant" id="" class="form-select" required >
                        <option value="">--Select Restaurant--</option>
                        <?php while ($row = mysqli_fetch_assoc($Restaurant)) { ?>
                            <option value="<?php echo $row['resid']; ?>" 
                                <?php if ($row['resid'] == $selected_category) echo "selected"; ?>>
                                <?php echo $row['title']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    </div>   
                </div>
                <div class="mb-3 form-group row form-group row">
                    <strong class="col-md-3" >Category </strong><div class="col-md-8">
                    
                       
                    <select name="categoryid" id="categoryid" class="form-select " required >
                        <option value="">--Select Category--</option>
                        <?php while ($row = mysqli_fetch_assoc($category)) { ?>
                            <option value="<?php echo $row['categoryid']; ?>" 
                                <?php if ($row['categoryid'] == $selected_category) echo "selected"; ?>>
                                <?php echo $row['categoryname']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    </div>
   
                </div>

               

                <div class="mb-3 form-group row">
                    <strong class="col-md-3">Product Type</strong><div class="col-md-8">
                    <select name="product_type" class="form-control">
                        <option value="1">Veg</option>
                        <option value="2">Non-Veg </option>
                        
                    </select>
                        </div>
                </div>
                <div class="mb-3 form-group row">
                    <strong class="col-md-3">Product Name</strong><div class="col-md-8">
                    <input id="product" type="text" name="productname" class="form-control" List="productList"  autocomplete="off" required>
                    <datalist id="productList">
                    <?php while ($row = mysqli_fetch_assoc($product)): ?>
    <option value="<?php  echo $row['productname'] ?>">
        <?php endwhile; ?>
</datalist>
                        </div>
                </div>
          
                <!-- <div class="mb-3 form-group row">
                    <strong class="col-md-3">Product Size</strong><div class="col-md-8">
                    <input type="text" name="size" class="form-control" >
                    
                
                </div>

                </div> -->

                <!-- <div class="mb-3 form-group row">
                    <strong class="col-md-3">Striked Price-MRP (Rs.)</strong><div class="col-md-8">
                    <input type="number" min="0" name="striked_price" class="form-control"></div>
                </div> -->
     
                    <div class="mb-3 form-group row">
                    <strong class="col-md-3">Product Description :</strong><div class="col-md-8">
                    <textarea name="desp" id="" class="form-control" ></textarea>
                  </div>
                </div>
                <div class="mb-3 form-group row">
                    <strong class="col-md-3">Display Price (Rs.)</strong><div class="col-md-8">
                    <input type="number" min="0" name="display_price" class="form-control" required></div>
                </div>

                <!-- <div class="mb-3 form-group row">
                    <strong class="col-md-3">Available in Outlet</strong><div class="col-md-8">
                    <select name="available_in_outlet" class="form-control" required>
                        <option value="">--Select Outlet--</option>
                        <?php// while ($row = mysqli_fetch_assoc($outlet)) { ?>
                            <option value="<?php// echo $row['outletid']; ?>"><?php //echo $row['outletlocation']; ?> / <?php //echo $row['city']; ?></option>
                        <?php //} ?>
                    </select>
                        </div>
                </div> -->
           
                <div class="mb-3 form-group row">
                    <strong class="col-md-3">Recommended</strong><div class="col-md-8">
                    <select name="recommended" class="form-control">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                        </div>
                </div>

                <div class="mb-3 form-group row">
        <strong class="col-md-3">Product Image</strong>
        <div class="col-md-8">
            <input type="file" name="imagename" class="form-control" required>
        </div>
    </div>

           

                <button type="submit" name="submit" class="btn btn-orange">Submit</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>
<!-- <script src="validation.js"></script> -->
<script>
    // PHP se subcategories ka data JavaScript me pass karna
    // const subcategories = <?php echo json_encode($subcategory); ?>;

    // document.addEventListener("DOMContentLoaded", function () {
        // const categoryDropdown = document.getElementById("categoryid");
        // const subcategoryDropdown = document.getElementById("subcategoryid"); // ✅ FIXED: Correct ID

        // Function jo subcategories ko update karega
        function updateSubcategories(categoryId) {
            subcategoryDropdown.innerHTML = '<option value="">--Select Subcategory--</option>'; // Reset dropdown

            // Sirf selected category ki subcategories show karo
            subcategories.forEach(subcat => {
                if (subcat.categoryid == categoryId) {
                    let option = document.createElement("option");
                    option.value = subcat.subcategoryid;
                    option.textContent = subcat.subcategoryname;
                    subcategoryDropdown.appendChild(option);
                }
            });
        }

        // Jab category change ho, tab subcategories update karein
        categoryDropdown.addEventListener("change", function () {
            updateSubcategories(this.value);
        });

        // Agar koi category pehle se selected hai, to uski subcategories dikhao
        if (categoryDropdown.value) {
            updateSubcategories(categoryDropdown.value);
        }
    });

  


    


</script>
