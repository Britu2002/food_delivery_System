<?php 
include('../config.php');

$success_message = "";
$error_message = "";

// Add category
if (isset($_POST['submit'])) {
    $name = $_POST['categoryname'];
    $image = $_FILES['categoryimage'];
    
    if ($image['error'] == 0) {
        $imageName = time() . '_' . basename($image['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . $imageName;
        
        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            $sql = "INSERT INTO `category`(categoryname, image) VALUES ('$name', '$imageName')";
            if (mysqli_query($conn, $sql)) {
                $success_message = "Category added successfully!";
            } else {
                $error_message = "Error! Category not added.";
            }
        } else {
            $error_message = "Error uploading image.";
        }
    } else {
        $error_message = "Please upload a valid image.";
    }
}

// Delete category
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    
    // Get image name
    $query = mysqli_query($conn, "SELECT image FROM category WHERE categoryid=$id");
    $row = mysqli_fetch_assoc($query);
    if ($row && file_exists("uploads/" . $row['image'])) {
        unlink("uploads/" . $row['image']); // Delete the image file
    }
    
    $sql = "DELETE FROM `category` WHERE categoryid=$id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Category deleted successfully!');
        window.location.href='Categories.php';
        </script>";
    } else {
        echo "<script>alert('Error deleting category!');
        window.location.href='Categories.php';
        </script>";
    }
}

// Handle AJAX Request for Limit & Search
if (isset($_GET['ajax'])) {
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    $sql = "SELECT * FROM category WHERE categoryname LIKE '%$search%' LIMIT $limit";
    $result = mysqli_query($conn, $sql);
    $sno = 1;

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $sno . "</td>";
        echo "<td>" . $row['categoryname'] . "</td>";
        echo "<td><img src='uploads/" . $row['image'] . "' width='50' height='50'></td>";
        echo "<td>
            <a href='?delete_id=" . $row['categoryid'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>
                <i class='bi bi-trash'></i> Delete
            </a>
            <a href='edit-category.php?id=" . $row['categoryid'] . "' class='btn btn-warning btn-sm'>
                <i class='bi bi-pen'></i> Edit
            </a>
        </td>";
        echo "</tr>";
        $sno++;
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

<?php include('admin-header.php'); ?>

<div class="content bg-white" id="mainContent">
    <div class="row">
        <div class="col-md-4">
            <div class="card p-3">
                <h3>Add Category</h3>
                <?php if ($success_message): ?>
                    <div class="alert alert-success"> <?php echo $success_message; ?> </div>
                <?php endif; ?>
                <?php if ($error_message): ?>
                    <div class="alert alert-danger"> <?php echo $error_message; ?> </div>
                <?php endif; ?>
                <form method="post" enctype="multipart/form-data">
                    <input type="text" name="categoryname" class="form-control" placeholder="Category Name" required>
                    <input type="file" name="categoryimage" class="form-control mt-2"  required>
                    <button type="submit" name="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card p-3">
                <h3>Category List</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Category Name</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="categoryData"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function fetchCategories() {
            $.ajax({
                url: "<?php echo $_SERVER['PHP_SELF']; ?>",
                type: "GET",
                data: { ajax: 1 },
                success: function (data) {
                    $("#categoryData").html(data);
                }
            });
        }
        fetchCategories();
    });
</script>

</body>
</html>
