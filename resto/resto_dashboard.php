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
            <h4>Admin Dashboard</h4>
        </div>

        <div class="container mt-4">
            <h2>Welcome to the Restaurant Admin Panel</h2>
            <p>Use the left menu to manage categories and products.</p>
        </div>
    </div>

    <script>
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
