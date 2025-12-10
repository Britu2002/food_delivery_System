<?php
include('../config.php'); // Database connection
if (isset($_GET['status'])) {
    $restaurant_id = $_GET['res_id'];
    $new_status = $_GET['status']=="open"?"closed":"open"; // 'open' or 'closed'

    $query = "UPDATE restaurant set Working_status ='$new_status' where resid='$restaurant_id'";
    echo "<script> window.location.href='list-resto.php';</script>";
    mysqli_query($conn, $query);
}

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch image name from database
    $query = "SELECT image FROM restaurant  WHERE resid = '$id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $image_path = "uploads/" . $row['image']; // Image path

        // Delete restaurant record from database
        $deleteQuery = "DELETE FROM restaurant  WHERE resid = '$id'";
        if(mysqli_query($conn, $deleteQuery)) {
            // Delete image file from server
            if(file_exists($image_path) && !empty($row['image'])) {
                unlink($image_path);
            }

            echo "<script>alert('Restaurant deleted successfully!'); window.location.href='list-resto.php';</script>";
        } else {
            echo "<script>alert('Error deleting restaurant: " . mysqli_error($conn) . "'); window.location.href='list-resto.php';</script>";
        }
    } else {
        echo "<script>alert('Restaurant not found!'); window.location.href='list-resto.php';</script>";
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

<?php include('admin-header.php'); ?>
<div class="content bg-white" id="mainContent">
    <h2 class="mb-3">Restaurant List</h2>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                
                <th>Working Status</th>
                <th>City</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM restaurant ORDER BY resid DESC";
        $sno=1;
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".$sno."</td>";
                    echo "<td><img src='uploads/".$row['image']."' width='60' height='60'></td>";
                    echo "<td>".$row['title']."</td>";
                    echo "<td>".$row['email']."</td>";
                    echo "<td>".$row['phone']."</td>";

                    echo "<td>
                    <a href='?res_id=".$row['resid']."&status=".$row['Working_status']."'>
                    <span class='badge bg-".($row['Working_status'] == 'open' ? 'success' : 'danger')."'>".$row['Working_status']."</span>
                    </a>
                    </td>";
                    echo "<td>".$row['city']."</td>";
                    echo "<td>
                                                <a href='add-product.php' class='btn btn-dark btn-sm'><i class='bi bi-plus'></i> Menu</a>
                            <a href='edit-resto.php?id=".$row['resid']."' class='btn btn-warning btn-sm'><i class='bi bi-pencil-square'></i> Edit</a>
                            <a href='?id=".$row['resid']."' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'><i class='bi bi-trash'></i> Delete</a>
                             <a href='view-resto.php?id=".$row['resid']."' class='btn btn-primary btn-sm' ><i class='bi bi-eye'></i>View</a>
                          </td>";
                    echo "</tr>";
                    $sno++;
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>No restaurants found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
