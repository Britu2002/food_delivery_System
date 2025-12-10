<?php 
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Menu</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/meanmenu.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"  />
    <style>
        body { background-color: #f8f9fa; font-family: Arial, sans-serif; }
        .menu-card { border-radius: 15px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s; }
        .menu-card:hover { transform: scale(1.05); }
        .menu-card img { border-top-left-radius: 15px; border-top-right-radius: 15px; height: 200px; object-fit: cover; }
        .category-title { font-size: 1.8rem; font-weight: bold; color: #F28123; margin-top: 30px; border-bottom: 2px solid #F28123; padding-bottom: 5px; }
    </style>
</head>
<body>
<?php include('header-2.php') ?>

<div class="container">
        <?php
        include('../config.php'); // Database connection
        
        // Fetch restaurant details
        $resQuery = "SELECT * FROM restaurant WHERE resid = $id";
        $resResult = $conn->query($resQuery);
        
        if ($resResult->num_rows > 0) {
            $resData = $resResult->fetch_assoc();
            echo '<div class="restaurant-header">';
            echo '<h2 class="text-left">' . $resData['title'] . '</h2>';
            echo '<p>' . $resData['addr'] . ', ' . $resData['city'] . '</p>';
            echo '</div>';
        }
        ?>

        <h2 class="menu-title text-center">Our Menu</h2>

        <?php
        // Fetch categories for the restaurant
        $categoryQuery = "SELECT DISTINCT c.* FROM category c
JOIN product p ON c.categoryid = p.categoryid
WHERE p.resid = $id";
        $categoryResult = $conn->query($categoryQuery);

        if ($categoryResult->num_rows > 0) {
            while ($category = $categoryResult->fetch_assoc()) {
                $categoryId = $category['categoryid'];
                echo '<h3 class="category-title">' . $category['categoryname'] . '</h3>';
                
                // Fetch products under this category
                $productQuery = "SELECT * FROM product WHERE categoryid = $categoryId AND resid = $id";
                $productResult = $conn->query($productQuery);
                
                if ($productResult->num_rows > 0) {
                    echo '<div class="row">';
                    while ($row = $productResult->fetch_assoc()) {
                        echo '<div class="col-md-4 mb-4">
                                <div class="card menu-card">
                                    <img src="/zaapin/admin/uploads/' . $row['image'] . '" class="card-img-top" alt="' . $row['productname'] . '">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">' . $row['productname'] . '</h5>
                                        <p class="fw-bold text-danger">₹' . $row['display_price'] . '</p>
                                        <div class="d-flex justify-content-center gap-2">
                                            <input type="number" class="form-control quantity-input" id="qty_' . $row['productid'] . '" min="1" max="20" value="1" style="width: 60px;">
                                            <button class="btn btn-success add-to-cart" data-id="' . $row['productid'] . '">Add to Cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }
                    echo '</div>'; // Close row
                } else {
                    echo '<p class="text-muted">No products available in this category.</p>';
                }
            }
        } else {
            echo '<p class="text-center">No categories available.</p>';
        }

        $conn->close();
        ?>
    </div>

    <script>
        $(document).ready(function(){
            $(".add-to-cart").click(function(){
                var productId = $(this).data("id");
                var quantity = $("#qty_" + productId).val();

                $.ajax({
                    url: "add_to_cart.php",
                    type: "POST",
                    data: { product_id: productId, quantity: quantity },
                    success: function(response) {
                        alert("Item added to cart!");
                    },
                    error: function() {
                        alert("Something went wrong!");
                    }
                });
            });
        });
    </script>

</body>
</html>
