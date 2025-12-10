<?php
include('../config.php'); // Include your database connection file
// Add Category (with image upload)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['category_image'])) {
    $categoryName = $_POST['categoryname'];
    
    // Handle file upload
    // $targetDir = "zaapin/admin/uploads/";
// $targetFile =  basename($_FILES["category_image"]["name"]);
 


        if (move_uploaded_file($_FILES["category_image"]["tmp_name"], $targetDir . $_FILES["category_image"]["name"])) {
            // Insert the category with image into the database
            $stmt = $conn->prepare("INSERT INTO categories (categoryname, image) VALUES (?, ?)");
            $stmt->bind_param("ss", $categoryName, $targetFile);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    
}

// Fetch categories from the database
$sql = "SELECT * FROM category";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Restaurant</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #343a40;
            color: white;
            padding-top: 20px;
            position: fixed;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: #495057;
        }
        .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
            transition: 0.3s;
        }
        .header {
            background: #212529;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .toggle-btn {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }
        .collapsed-sidebar {
            width: 70px;
        }
        .collapsed-sidebar a {
            text-align: center;
        }
        .collapsed-sidebar a span {
            display: none;
        }
        .collapsed-content {
            margin-left: 70px;
            width: calc(100% - 70px);
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="#" class="text-white text-center mb-3">
            <i class="fas fa-utensils"></i> <span>Admin Panel</span>
        </a>
        <a href="category.php"><i class="fas fa-list"></i> <span>Add Category</span></a>
        <a href=""><i class="fas fa-hamburger"></i> <span>Add Product</span></a>
        <a href="#"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <div class="header">
            <button class="toggle-btn" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h4>Admin </h4>
        </div>

        <div class="container mt-4">
            <h3>Category List</h3>
            
            <!-- Category Form (Add New Category) -->
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="categoryname" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="categoryname" name="categoryname" required>
                </div>
                <div class="mb-3">
                    <label for="category_image" class="form-label">Category Image</label>
                    <input type="file" class="form-control" id="category_image" name="category_image" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Category</button>
            </form>

            <h4 class="mt-5">Category List</h4>
            <div class="row">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($category = $result->fetch_assoc()): ?>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <img src="/zaapin/admin/uploads/<?= htmlspecialchars($category['image']) ?>" class="card-img-top " style="height:100px" alt="<?= htmlspecialchars($category['categoryname']) ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($category['categoryname']) ?></h5>
                                    <!-- <a href="#" class="btn btn-danger btn-sm">Delete</a> -->
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-warning" role="alert">
                            No categories found.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar functionality
        function toggleSidebar() {
            let sidebar = document.getElementById("sidebar");
            let mainContent = document.getElementById("main-content");
            if (sidebar.classList.contains("collapsed-sidebar")) {
                sidebar.classList.remove("collapsed-sidebar");
                mainContent.classList.remove("collapsed-content");
            } else {
                sidebar.classList.add("collapsed-sidebar");
                mainContent.classList.add("collapsed-content");
            }
        }
    </script>

</body>
</html>

<?php
// Close the connection
$conn->close();
?>
