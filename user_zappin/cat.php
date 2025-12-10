<?php
include('../config.php');
// Fetch categories from the database
$sql = "SELECT * FROM category";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popular Cuisines</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .category-card {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            text-align: center;
            display: block;
            text-decoration: none;
            color: white;
        }

        .category-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease-in-out;
        }

        .category-card:hover img {
            transform: rotate(3deg) scale(1.05);
        }

        .category-name {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 10px;
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="container mt-5 py-2">
    <h1 class="text-center display-4 fw-bold my-5"> Popular Cuisines</h1>
    <div class="row mt-4 ">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-3 mb-4">';
                echo '<a href="category.php?id=' . urlencode($row["categoryid"]) . '" class="category-card">';
                echo '<img src="/zaapin/admin/uploads/' . $row["image"] . '" alt="' . $row["categoryname"] . '">';
                echo '<div class="category-name">' . $row["categoryname"] . '</div>';
                echo '</a>';
                echo '</div>';
            }
        } else {
            echo "<p class='text-center'>No categories found</p>";
        }
        ?>
    </div>
</div>

</body>
</html>

<?php
$conn->close();
?>
