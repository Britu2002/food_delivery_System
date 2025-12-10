<?php include('../config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restaurant Menu</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php include('admin-header.php'); ?>

<div class="content " id="mainContent">
    <?php
    if(isset($_GET['id'])) {
        $resid = intval($_GET['id']);
        $categories = mysqli_query($conn, "SELECT DISTINCT c.categoryid, c.categoryname FROM product p JOIN category c ON p.categoryid = c.categoryid WHERE p.resid = $resid");

        if(mysqli_num_rows($categories) > 0) {
            $title_query = mysqli_query($conn, "SELECT title FROM restaurant WHERE resid = $resid");
            $title_row = mysqli_fetch_assoc($title_query);
            echo "<h2 class='text-center text-warning'>" . $title_row['title'] . " Menu</h2><hr>";
            ?>
            
            <div class="d-flex gap-2 mb-3">
                <a href="add-product.php" class="btn btn-dark btn-sm">Add Menu</a>
                <a href="Categories.php" class="btn btn-dark btn-sm">Add Category</a>
                <a href="javascript:history.back()" class="btn btn-dark btn-sm">Go Back</a>
            </div>

            <?php
            while ($category = mysqli_fetch_assoc($categories)) {
                echo "<div class='bg-warning text-white text-center py-2 rounded mt-4'>" . $category['categoryname'] . "</div>";
                ?>
                
                <ul class="list-group">
                <?php
                $query = "SELECT * FROM product WHERE resid = $resid AND categoryid = " . $category['categoryid'];
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?php echo $row['productname']; ?></span>
                        <span class="fw-bold text-success">₹<?php echo $row['display_price']; ?></span>
                    </li>
                    <?php
                }
                ?>
                </ul>
                <?php
            }
        } else {
            echo "<h3 class='text-center text-danger'>No menu items available</h3>";
        }
    } else {
        echo "<h3 class='text-center text-danger'>Invalid Restaurant</h3>";
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
