<?php
// Assuming you have a MySQL connection $conn
// Include your database connection file here if needed
include('../config.php');
// $id=$_Get['id'];
// Fetch categories from the database
$categoryQuery = "Select DISTINCT categoryname,category.categoryid,category.image FROM product left JOIN category on product.categoryid=category.categoryid where  resid=4";
$categoryResult = mysqli_query($conn, $categoryQuery);

// Fetch products from the product table
$productQuery = "SELECT `productid`, `categoryid`, `resid`, `prodect_type`, `productname`, `desp`, `image`, `display_price`, `recommended`, `createdon` FROM `product` WHERE resid=4";
$productResult = mysqli_query($conn, $productQuery);

// Create an array to organize products by category
$productsByCategory = [];
while ($product = mysqli_fetch_assoc($productResult)) {
    $productsByCategory[$product['categoryid']][] = $product;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Navigation Pills</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <!-- Navigation Pills -->
    <ul class="nav nav-pills" id="categoryPills" role="tablist">
        <?php
        $i = 0; // For setting the active class on the first tab
        while ($category = mysqli_fetch_assoc($categoryResult)) {
            $activeClass = ($i == 0) ? 'active' : ''; // First tab will be active by default
        ?>
            <li class="nav-item" role="presentation">
                <a class="nav-link <?php echo $activeClass; ?>" id="pill-<?php echo $category['categoryid']; ?>-tab" data-bs-toggle="pill" href="#pill-<?php echo $category['categoryid']; ?>" role="tab" aria-controls="pill-<?php echo $category['categoryid']; ?>" aria-selected="true">
                    <?php echo $category['categoryname']; ?>
                </a>
            </li>
        <?php
        $i++;
        }
        ?>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="categoryPillsContent">
        <?php
        // Reset the result pointer for category data and loop through again
        mysqli_data_seek($categoryResult, 0);
        $i = 0; // Reset counter for content active class
        while ($category = mysqli_fetch_assoc($categoryResult)) {
            $activeClass = ($i == 0) ? 'show active' : ''; // Set active class for the first content tab
        ?>
            <div class="tab-pane fade <?php echo $activeClass; ?>" id="pill-<?php echo $category['categoryid']; ?>" role="tabpanel" aria-labelledby="pill-<?php echo $category['categoryid']; ?>-tab">
            

                <!-- Display products for this category -->
                <div class="row">
                    <?php
                    // Check if products exist for this category
                    if (isset($productsByCategory[$category['categoryid']])) {
                        foreach ($productsByCategory[$category['categoryid']] as $product) {
                    ?>
                        <div class="col-md-12">
                            <div class="d-flex">
                                <img src="/zaapin/admin/uploads/<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['productname']; ?>" style="height: 70px;width:70px;">
                                <div class="">
                                    <h5 class="card-title"><?php echo $product['productname']; ?></h5>
                                    <p class="card-text"><?php echo $product['desp']; ?></p>
                                    <p class="card-text"><strong>Price:</strong> ₹<?php echo $product['display_price']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    } else {
                        echo "<p>No products available in this category.</p>";
                    }
                    ?>
                </div>
            </div>
        <?php
        $i++;
        }
        ?>
    </div>
</div>

<!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
