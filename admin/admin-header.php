<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixed Sidebar with Toggle</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/zaapin/css/style.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Sidebar Fixed */
        .sidebar {
            position: fixed;
            left: 0;
            top: 25px;
            width: 200px;
            height: 100vh;
            background-color: #212529;
            transition: all 0.3s ease;
            padding-top: 20px;
        }

        /* Sidebar Hidden */
        .sidebar.hidden {
            width: 80px;
            overflow: hidden;
        }

        /* Sidebar Links */
        .sidebar a {
            display: flex;
            align-items: center;
          
            text-decoration: none;
            color: white;
        }

        .sidebar a i {
            font-size: 1rem;
            
            text-align: center;
        }

        /* Hide text when sidebar is collapsed */
        .sidebar.hidden a span {
            display: none;
        }

        /* Show text as tooltip on hover */
        .sidebar.hidden a:hover span {
            display: inline;
            position: absolute;
            left: 80px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            white-space: nowrap;
        }

        /* Main Content */
        .content {
            margin-top:50px;
            margin-left: 200px;
            transition: all 0.3s ease;
            padding: 20px;
            min-height: 100vh;
        }

        /* When Sidebar is Hidden */
        .content.expanded {
            margin-left: 80px;
        }
    </style>
</head>
<body>

<!-- Fixed Navbar -->
<nav class="navbar navbar-expand-lg fixed-top p-0 m-0" style="background-color: orange;">
    <div class="d-flex gap-1">
        <div style="width:200px;" class="bg-warning p-2">
            <a class="navbar-brand text-white" href="#">
                <img src="/zaapin/img/logo-dark.png" alt="Logo" style="width:150px;">
            </a>
        </div>
        <!-- Sidebar Toggle Button -->
        <button class="btn btn-transparent border-0" id="toggleSidebar">
            <i class="bi bi-list text-white fs-4"></i>
        </button>
    </div>
</nav>

<!-- Fixed Sidebar -->
<div class="sidebar text-white bg-dark p-4" id="sidebar">
    <ul class="list-unstyled py-3">
        <li><a href="admin-dashboard.php" class="nav-link text-white p-2 d-block"><i class="bi bi-speedometer2" title="Dashboard"></i> <span> Dashboard</span></a></li>
        <li class="nav-item">
            <a class="nav-link  d-flex  align-items-center collapsed p-2" data-bs-toggle="collapse" href="#resto">
            <i class="fa fa-handshake-o" title="Restaurant"></i>

             <span>Restaurant<i class="bi bi-chevron-right treeview-indicator"></i></span>
                
            </a>
            <div id="resto" class="collapse" style="background-color: rgb(74, 75, 74);">
                <ul class="list-unstyled p-1 flex-column">
                    <li><a class="nav-link text-white" href="add-resto.php"><i class="bi bi-plus-circle"></i> <span> Add New Restaurant</span></a></li>
                    <li><a class="nav-link text-white" href="list-resto.php"><i class="bi bi-cast"></i> <span> View Restaurant </span></a></li>
                </ul>
            </div>
        </li>
        <li><a href="Categories.php" class="nav-link text-white p-2 d-block"><i class="fa fa-object-group" title="Categories"></i><span> Categories</span></a></li>
        <!-- <li><a href="sub-category.php" class="nav-link text-white p-2 d-block"><i class="fa fa-object-group" title="Sub Categories"></i><span> Sub Categories</span></a></li> -->
        <li class="nav-item">
            <a class="nav-link  d-flex  align-items-center collapsed p-2" data-bs-toggle="collapse" href="#productMenu">
            <i class="fa fa-list" aria-hidden="true" title="product"></i>

             <span>Product</span>
                
            </a>
            <div id="productMenu" class="collapse" style="background-color: rgb(74, 75, 74);">
                <ul class="list-unstyled p-1 flex-column">
                    <li><a class="nav-link text-white" href="add-product.php"><i class="bi bi-plus-circle"></i> <span> Add New Product </span></a></li>
                    <li><a class="nav-link text-white" href="listproduct.php"><i class="bi bi-cast"></i> <span> View  Product</span></a></li>

                </ul>
            </div>
        </li>


   
        <li><a href="listoffer.php" class="nav-link text-white p-2 d-block"><i class="fa fa-ticket" title="Coupen and Offer"></i><span> Offers&Coupen</span></a></li>

         <li class="nav-item">
            <a class="nav-link  d-flex  align-items-center collapsed p-2" data-bs-toggle="collapse" href="#UserOrder">
            <i class="fa fa-shopping-cart " title="users"></i> 
             <span> Orders<i class="bi bi-chevron-right treeview-indicator "></i></span>
                
            </a>
            <div id="UserOrder" class="collapse" style="background-color: rgb(74, 75, 74);">
                <ul class="list-unstyled p-1 flex-column">
                    <li><a class="nav-link text-white" href="listorder.php?status=1"><i class="bi bi-check"></i> <span> Order Pending</span></a></li>
                    <!-- <li><a class="nav-link text-white" href="listorder.php?status=2"><i class="bi bi-check"></i> <span> Order Accepted</span></a></li> -->
                    <li><a class="nav-link text-white" href="listorder.php?status=3"><i class="bi bi-check"></i> <span> Order Rejected</span></a></li>
                    <li><a class="nav-link text-white" href="listorder.php?status=4"><i class="bi bi-check"></i> <span> Preparing Food</span></a></li>
                    <li><a class="nav-link text-white" href="listorder.php?status=5"><i class="bi bi-check"></i> <span> Order on the Way</span></a></li>
                    <li><a class="nav-link text-white" href="listorder.php?status=6"><i class="bi bi-check"></i> <span> Delivered</span></a></li>
              
                </ul>
            </div>
        </li> 
        
        <li class="nav-item">
            <a class="nav-link  d-flex  align-items-center collapsed p-2" data-bs-toggle="collapse" href="#UserMenu">
            <i class="fa fa-users " title="users"></i> 
             <span> Users<i class="bi bi-chevron-right treeview-indicator"></i></span>
                
            </a>
            <div id="UserMenu" class="collapse" style="background-color: rgb(74, 75, 74);">
                <ul class="list-unstyled p-1 flex-column">
                    <!-- <li><a class="nav-link text-white" href="add-user.php"><i class="bi bi-plus-circle"></i> <span> Add New User</span></a></li> -->
                    <li><a class="nav-link text-white" href="customer_list.php"><i class="bi bi-cast"></i> <span> View Customer</span></a></li>
                    <li><a class="nav-link text-white" href="agent_list.php"><i class="bi bi-cast"></i> <span> View Agent</span></a></li>
                </ul>
            </div>
        </li>
        <li><a href="login.php" class="text-white p-2 d-block"><i class="bi bi-box-arrow-right"></i> <span> Logout</span></a></li>
    </ul>
</div>




<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Toggle Sidebar Script -->
<script>
    document.getElementById("toggleSidebar").addEventListener("click", function () {
        let sidebar = document.getElementById("sidebar");
        sidebar.classList.toggle("hidden");

        let content = document.getElementById("mainContent");
        content.classList.toggle("expanded");
    });
</script>

</body>
</html>
