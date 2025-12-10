<?php
include('../config.php');

$id = $_GET['id'];
$success = $error = "";

$query = mysqli_query($conn, "SELECT * FROM category WHERE categoryid = $id");
$category = mysqli_fetch_assoc($query);

if (!$category) {
    die("Category not found.");
}

// Update logic
if (isset($_POST['update'])) {
    $name = $_POST['categoryname'];
    $new_image = $_FILES['categoryimage'];

    if ($new_image['error'] == 0) {
        $imageName = time() . '_' . basename($new_image['name']);
        $targetFile = "uploads/" . $imageName;

        if (move_uploaded_file($new_image['tmp_name'], $targetFile)) {
            if (file_exists("uploads/" . $category['image'])) {
                unlink("uploads/" . $category['image']);
            }
            $update = "UPDATE category SET categoryname='$name', image='$imageName' WHERE categoryid=$id";
        } else {
            $error = "Image upload failed.";
        }
    } else {
        $update = "UPDATE category SET categoryname='$name' WHERE categoryid=$id";
    }

    if (mysqli_query($conn, $update)) {
        $success = "Category updated successfully!";
        header("Location: Categories.php");
        exit;
    } else {
        $error = "Failed to update category.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('admin-header.php'); ?>
<div class="content mt-5"  id="mainContent">
    <h3>Edit Category</h3>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="categoryname" class="form-control" value="<?= $category['categoryname'] ?>" required>
        <p class="mt-2">Current Image:</p>
        <img src="uploads/<?= $category['image'] ?>" width="100" class="mb-2">
        <input type="file" name="categoryimage" class="form-control mt-2">
        <button type="submit" name="update" class="btn btn-success mt-3">Update</button>
        <a href="Categories.php" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
</body>
</html>
