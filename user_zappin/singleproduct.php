<?php
include '../config.php'; // Database connection file

$product = null; // Default value

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT p.*, ap.img AS img
              FROM add_photos ap
              LEFT JOIN product p ON p.productid = ap.entityid AND p.productname = ap.entitytitle
              WHERE p.productid = $id;";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
        $product = $row; // Store product details
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Single Product</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">

</head>
<body>
    
    <div class="single-product mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="single-product-img">
                        <div class="row">
                            <?php if ($product): ?>
                                <?php foreach ($product as $imgData): ?>
                                    <div class="col-md-6 mb-3">
                                        <img src="/zaapin/admin/uploads/<?php echo $imgData['img']; ?>" class="img-fluid" alt="Product Image">
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-md-12">
                                    <img src="default.jpg" class="img-fluid" alt="No Image Available">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="single-product-content">
                        <h3><?php echo $product ? $product[0]['productname'] : 'Product Not Found'; ?></h3>
                        <p class="single-product-pricing"><span>Per Kg</span> $<?php echo $product ? $product[0]['display_price'] : '0'; ?></p>
                        <div class="single-product-form">
                            <form action="cart.php">
                                <input type="hidden" name="id" value="<?php echo $product ? $product[0]['productid'] : ''; ?>">
                                <input type="number" name="quantity" placeholder="0">
                                <button type="submit" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                            </form>
                            <p><strong>Categories: </strong><?php echo $product ? $product[0]['categoryid'] : 'N/A'; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-1.11.3.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
