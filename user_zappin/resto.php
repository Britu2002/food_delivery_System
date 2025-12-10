<?php
include('../config.php');

// Fetch categories
$categoryQuery = "SELECT * FROM category";
$categoryResult = mysqli_query($conn, $categoryQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Restaurant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Select a Category to Find Restaurants</h2>

    <!-- Category Selection -->
    <div class="mb-3">
        <label for="category" class="form-label">Choose Category:</label>
        <select id="category" class="form-select">
            <option value="">-- Select Category --</option>
            <?php while ($row = mysqli_fetch_assoc($categoryResult)) { ?>
                <option value="<?= $row['categoryid']; ?>"><?= $row['categoryname']; ?></option>
            <?php } ?>
        </select>
    </div>

    <!-- Restaurant List -->
    <h3>Available Restaurants:</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Restaurant ID</th>
                <th>Restaurant Name</th>
            </tr>
        </thead>
        <tbody id="restaurantList">
            <tr><td colspan="2" class="text-center">Select a category to see restaurants</td></tr>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function () {
    $('#category').change(function () {
        var categoryId = $(this).val();
        
        if (categoryId !== "") {
            $.ajax({
                url: "", // The same file
                type: "POST",
                data: { fetch_restaurants: 1, categoryid: categoryId },
                success: function (data) {
                    $('#restaurantList').html(data);
                }
            });
        } else {
            $('#restaurantList').html('<tr><td colspan="2" class="text-center">Select a category to see restaurants</td></tr>');
        }
    });
});
</script>

</body>
</html>

<?php
// Fetch restaurants based on category (AJAX request)
if (isset($_POST['fetch_restaurants']) && isset($_POST['categoryid'])) {
    $categoryid = $_POST['categoryid'];
echo $categoryid;
    $sql = "SELECT DISTINCT r.resid, r.title as name 
            FROM restaurant r
            JOIN product p ON r.resid = p.resid
            WHERE p.categoryid = $categoryid";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['resid']}</td>
                    <td>{$row['name']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='2' class='text-center text-danger'>No restaurants found</td></tr>";
    }
    exit; // Stop further execution
}
?>
