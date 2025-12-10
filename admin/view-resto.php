<?php include('../config.php'); ?>

<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<h3 class='text-center text-danger'>Invalid Restaurant ID</h3>";
    exit;
}
$restaurant_id = $_GET['id'];
$query = "SELECT * FROM restaurant WHERE resid = '$restaurant_id'";
$result = mysqli_query($conn, $query);
$restaurant = mysqli_fetch_assoc($result);
if (!$restaurant) {
    echo "<h3 class='text-center text-danger'>Restaurant Not Found</h3>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $restaurant['title']; ?> - Details</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <style>
        .restaurant-container {
            max-width: 900px;
            margin: auto;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .restaurant-img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }
        .info {
            font-size: 1rem;
            color: #555;
        }
        .highlight {
            font-weight: bold;
            color: #F28123;
        }
    </style>
</head>
<body>
    <?php include('admin-header.php') ?>
    <div class="content " id="mainContent">
        <div class="restaurant-container">
            <img src="/zaapin/admin/uploads/<?php echo $restaurant['image']; ?>" alt="Restaurant Image" class="restaurant-img">
            <h2 class="mt-3 text-warning text-center"> <?php echo $restaurant['title']; ?> </h2>
            <p class="text-center text-muted"><i><?php echo $restaurant['email']; ?> | <?php echo $restaurant['phone']; ?></i></p>
            <hr>
            <p class="info"><span class="highlight">Address:</span> <?php echo $restaurant['addr'] . ', ' . $restaurant['city'] . ' - ' . $restaurant['pincode']; ?></p>
            <p class="info"><span class="highlight">Opening Hours:</span> <?php echo $restaurant['o_hr'] . ' - ' . $restaurant['c_hr']; ?></p>
            <p class="info"><span class="highlight">Open Days:</span> <?php echo $restaurant['o_days']; ?></p>
            <div class="text-center mt-4">
                <a href="resto-menu.php?id=<?php echo $restaurant['resid']; ?>" class="btn btn-warning">View Menu</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
