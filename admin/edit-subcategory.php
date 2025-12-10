<?php
include('../config.php');

// Fetch Subcategory Data
if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $query = "SELECT * FROM subcategory WHERE subcategoryid = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    if (!$row) {
        echo "<script>alert('Subcategory not found!'); window.location='sub-category.php';</script>";
        exit;
    }
}

// Update Subcategory
if (isset($_POST['update'])) {
    $name = $_POST['subcategoryname'];
    $category_id = $_POST['sectionid'];
    $file = $_FILES['img'];
    $target_dir = "uploads/";
    
    // Handle Image Upload
    if ($file['name']) {
        $subcategoryname = basename($file["name"]);
        $target_file =  time() . "_" . $subcategoryname;

        move_uploaded_file($file["tmp_name"], $target_dir.$target_file);
        
        // Remove Old Image
        if (file_exists($row['subcategoryimg'])) {
            unlink($row['subcategoryimg']);
        }
        
        // Update with Image
        $updateQuery = "UPDATE subcategory SET subcategoryname='$name', categoryid='$category_id', subcategoryimg='$target_file' WHERE subcategoryid=$id";
    } else {
        // Update Without Changing Image
        $updateQuery = "UPDATE subcategory SET subcategoryname='$name', categoryid='$category_id' WHERE subcategoryid=$id";
    }
    
    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Subcategory updated successfully!'); window.location='sub-category.php';</script>";
    } else {
        echo "<script>alert('Error updating subcategory!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subcategory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('admin-header.php'); ?>

<div class="content bg-light" id="mainContent">
    <div class="row ">
        <div class="col-md-6">
            <div class="card p-4 ">
                <h3 class="  fw-bold">Edit Subcategory</h3>
                <hr>
                <div class="">
                    <form method="post" enctype="multipart/form-data">
                        <label class="form-label fw-bold">Category</label>
                        <select name="sectionid" class="form-control mb-3" required>
                            <?php 
                            $category = mysqli_query($conn, "SELECT * FROM category");
                            while ($cat = mysqli_fetch_assoc($category)): ?>
                                <option value="<?php echo $cat['categoryid']; ?>" <?php echo ($row['categoryid'] == $cat['categoryid']) ? 'selected' : ''; ?>>
                                    <?php echo $cat['categoryname']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>

                        <label class="form-label fw-bold">Subcategory Name</label>
                        <!-- <input type="text" name="subcategoryname" class="form-control mb-3"  required> -->
                        <input type="text" name="subcategoryname"
                        value="<?php echo $row['subcategoryname']; ?>" 
       pattern="^[A-Za-z\s]{3,30}$" 
       minlength="3" maxlength="30" 
       required 
    class="form-control mb-3"
       PlaceHolder="Enter Subcategory Name"
       title="Sub Category Name must be 3-30 characters long and contain only letters and spaces.">
                        <label class="form-label fw-bold">Subcategory Image</label>
                        <input type="file" name="img" class="form-control mb-3">
                        <img src="<?php echo "uploads/". $row['subcategoryimg']; ?>" width="100" height="100px"class="mb-3">
                        <br>
                        
                        <button type="submit" name="update" class="btn btn-success btn-sm">Update</button>
                        <a href="sub-category.php" class="btn btn-danger btn-sm">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
