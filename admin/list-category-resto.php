<?php 
include('../config.php');

$success_message = "";
$error_message = "";

// Add category
if (isset($_POST['submit'])) {
    $name = $_POST['categoryname'];
    $category_id = $_POST['sectionid'];
    $file = $_FILES['img'];

   
    $target_dir = "uploads/"; // Ensure this folder exists
    $categoryname = basename($file["name"]);
    $target_file =   time() . "_" . $categoryname; // Unique file name
    move_uploaded_file($file["tmp_name"], $target_dir.$target_file);

    // Insert into DB
    $sql = "INSERT INTO `category_resto`(categoryname, resid, categoryimg) VALUES ('$name', '$category_id', '$target_file')";
    
    if (mysqli_query($conn, $sql)) {
       
        $success_message = "category added successfully!";
    } else {
        $error_message = "Error! category not added.";
    }
}


if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    
    $fetchQuery = "SELECT categoryimg FROM category WHERE categoryid = $id";
    $fetchResult = mysqli_query($conn, $fetchQuery);
    $row = mysqli_fetch_assoc($fetchResult);
    
    if ($row) {
        $imagePath = $row['categoryimg']; 

      
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        
        $sql = "DELETE FROM category WHERE categoryid = $id";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('category deleted successfully!'); window.location='sub-category.php';</script>";
        }
    }
}

// Handle AJAX Request for Pagination & Search
if (isset($_GET['ajax'])) {
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($page - 1) * $limit;

    // Get Total Records Count
    $countQuery = "SELECT COUNT(*) as total FROM category WHERE categoryname LIKE '%$search%' ";
    $countResult = mysqli_query($conn, $countQuery);
    $totalRecords = mysqli_fetch_assoc($countResult)['total'];
    $totalPages = ceil($totalRecords / $limit);

    // Fetch Data
    $sql = "SELECT s.*, c.categoryname FROM category s 
            JOIN category c ON s.categoryid = c.categoryid 
            WHERE s.categoryname LIKE '%$search%' or c.categoryname LIKE '%$search%' 
            ORDER BY categoryid desc
            LIMIT $limit OFFSET $offset ";
    
    $result = mysqli_query($conn, $sql);
    $sno = $offset + 1;

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $sno . "</td>";
        echo "<td>" . $row['categoryname'] . "</td>";
        echo "<td>" . $row['categoryname'] . "</td>";
        echo "<td><img src='uploads/" . $row['categoryimg'] . "' width='50' height='50'></td>";
        echo "<td>

<a href='?delete_id=" . $row['categoryid'] . "' class='btn btn-danger btn-sm ' onclick='return confirm(\"Are you sure?\")'>
                          <i class='fa fa-trash'></i>  Delete
                    </a>
                       <a href='edit-category.php?edit_id=" . $row['categoryid'] . "' class='btn btn-success  btn-sm' >
                         <i class='fa fa-edit'></i>   Edit
                    </a>
    </td>";
    
        echo "</tr>";
        $sno++;
    }

    // Generate Pagination Links
    echo "<tr><td colspan='5'>"; // Align text (pagination) to the right
    echo "<div class='d-flex justify-content-end'>"; 
    echo "<ul class='pagination '>"; // Align pagination to the right
    

    // Previous Button (Disabled if on First Page)
if ($page > 1) {
    echo "<li class='page-item'>
            <a class='page-link' href='#' onclick='fetchSubcategories(" . ($page - 1) . ")'>Previous</a>
          </li>";
} else {
    echo "<li class='page-item disabled'>
            <span class='page-link'>Previous</span>
          </li>";
}

// Page Number Buttons
for ($i = 1; $i <= $totalPages; $i++) {
    echo "<li class='page-item " . ($i == $page ? "active" : "") . "'>
            <a class='page-link' href='#' onclick='fetchSubcategories($i)'>$i</a>
          </li>";
}

// Next Button (Disabled if on Last Page)
if ($page < $totalPages) {
    echo "<li class='page-item'>
            <a class='page-link' href='#' onclick='fetchSubcategories(" . ($page + 1) . ")'>Next</a>
          </li>";
} else {
    echo "<li class='page-item disabled'>
            <span class='page-link'>Next</span>
          </li>";
}


    echo "</ul>
    </div>
    </td></tr>";

    exit;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Subcategories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/zaapin/css/style.css">
</head>
<body>

<?php include('admin-header.php'); ?>

<div class="content bg-light" id="mainContent">
    <form method="post" enctype="multipart/form-data">
        <div class="row ms-3 mt-2">
            <div class="col-md-4 shadow bg-white border-0 rounded p-3 me-5" style="max-height:500px">
                <!-- Success & Error Messages -->
                <?php if ($success_message): ?>
                    <div class="alert alert-success p-2"><?php echo $success_message; ?></div>
                <?php endif; ?>
                <?php if ($error_message): ?>
                    <div class="alert alert-danger p-2"><?php echo $error_message; ?></div>
                <?php endif; ?>
                
                <h3 class="p-2 fw-bold">Add category</h3>
                <hr>
                
                <!-- Category Selection -->
                <label for="category" class="label-control mb-1 fw-bold">Category</label>
                <select name="sectionid" class="form-control mb-3" required>
                    <?php 
                    $category = mysqli_query($conn, "SELECT * FROM restaurant");
                    while ($row = mysqli_fetch_assoc($category)): ?>
                        <option value="<?php echo $row['resid']; ?>"><?php echo $row['title']; ?></option>
                    <?php endwhile; ?>
                </select>

                <!-- category Name -->
                <label for="categoryname" class="label-control mb-1 fw-bold">category Name</label>
                <!-- <input type="text" name="categoryname" class="form-control mb-3" placeholder="Enter category Name" required> -->
                <input type="text" name="categoryname" 
       pattern="^[A-Za-z\s]{3,30}$" 
       minlength="3" maxlength="30" 
       required 
    class="form-control mb-3"
       PlaceHolder="Enter category Name"
       title="Sub Category Name must be 3-30 characters long and contain only letters and spaces.">

                <!-- categoryimage Upload -->
                <label for="img" class="label-control mb-1 fw-bold">category image</label>
                <input type="file" name="img" class="form-control" required>
                <hr>
                
                <button type="submit" name="submit" class="my-2 p-2 fw-bold btn btn-warning text-white">
                    <i class="bi bi-patch-check"></i> Submit
                </button>
            </div>

            <!-- category List -->
            <div class="col-md-7 bg-white shadow border-0 rounded p-3">
                <h3 class="p-2 fw-bold">List of Subcategories</h3>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="limit">Show:</label>
                        <select name="limit" class="form-control d-inline-block w-25">
                        <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span>entries</span>
                    </div>
                    <div class="col-md-6">
                        <label for="search">Search:</label>
                        <input type="text" id="search" class="form-control d-inline-block w-75">
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead class=" ">
                        <tr>
                            <th class='bg-warning text-white' >#</th>                  
                            <th class='bg-warning text-white'>category</th>
                            <th class='bg-warning text-white'>Image</th>
                            <th class='bg-warning text-white'>Action</th>
                        </tr>
                    </thead>
                    <tbody id="categoryData">
                        <!-- Data will be loaded here via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    function fetchSubcategories(page = 1) {
        let limit = $('select[name="limit"]').val();
        let search = $('#search').val();
        
        $.ajax({
            url: "<?php echo $_SERVER['PHP_SELF']; ?>",
            type: "GET",
            data: { ajax: 1, limit: limit, search: search, page: page },
            success: function (data) {
                $("#categoryData").html(data);
            }
        });
    }

    // Fetch data on page load
    fetchSubcategories();

    // Change limit dropdown
    $('select[name="limit"]').change(function () {
        fetchSubcategories();
    });

    // Search input event
    $('#search').on("keyup", function () {
        fetchSubcategories();
    });

    // Handle pagination clicks
    $(document).on("click", ".page-link", function (e) {
        e.preventDefault();
        let page = $(this).text();
        if ($(this).text() === "Previous") {
            page = parseInt($(".pagination .active a").text()) - 1;
        } else if ($(this).text() === "Next") {
            page = parseInt($(".pagination .active a").text()) + 1;
        }
        fetchSubcategories(page);
    });
});

</script>

</body>
</html>
