<?php 
include('../config.php');

$success_message = "";
$error_message = "";

if (isset($_GET['delete_id']) ) {
    $id = $_GET['delete_id'];
  

    // Fetch all photos linked to this entity
    $photoQuery = mysqli_query($conn, "SELECT image FROM product WHERE productid=$id ");
    
    while ($photo = mysqli_fetch_assoc($photoQuery)) {
        $photoPath = "uploads/" . $photo['img'];
        
        if (file_exists($photoPath)) {
            unlink($photoPath);
        }
    }
    // Delete outlet from database
    $sql = "DELETE FROM product WHERE productid=$id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Product deleted successfully!');</script>";
        echo "<script>window.location='listproduct.php';</script>";
    }
}



$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$totalRecordsQuery = "SELECT COUNT(*) as total FROM product p LEFT JOIN category c ON p.categoryid = c.categoryid  WHERE productname LIKE '%$search%' OR categoryname LIKE '%$search%' ";
$totalRecords = mysqli_fetch_assoc(mysqli_query($conn, $totalRecordsQuery))['total'];
$totalPages = ceil($totalRecords / $limit);
$offset = ($page - 1) * $limit;

// Fetch Data with Pagination
$sql = "SELECT 
    p.productid, 
    p.categoryid, 
    c.categoryname, 
    p.productname,
    p.display_price as price,  
 r.title,
  r.resid,
    p.recommended,
    p.image
FROM product p
LEFT JOIN restaurant r on r.resid=p.resid
LEFT JOIN category c ON p.categoryid = c.categoryid WHERE productname LIKE '%$search%' OR categoryname LIKE '%$search%' order by productid desc  limit $limit  OFFSET $offset ";
$result = mysqli_query($conn, $sql);



   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - <?php echo $website_name;?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include('admin-header.php'); ?>

<div class="content mt-5" id="mainContent"> 
<form method="GET">
        <div class="row  mt-2">
            <div class="col-md-11 shadow bg-white border-0 rounded p-3 ">
                
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="p-2 fw-bold">List of Product</h5>
                    <div>
                        <a href="add-product.php" class="btn btn-orange btn-sm"><i class="bi bi-plus"></i> Add Product</a>
                    </div>
                </div>
                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Show:</label>
                        <select name="limit" class="form-control d-inline-block w-25" onchange="this.form.submit()">
                        <option value="5" <?php echo ($limit == 5) ? "selected" : ""; ?>>5</option>
                            <option value="10" <?php echo ($limit == 10) ? "selected" : ""; ?>>10</option>
                            <option value="25" <?php echo ($limit == 25) ? "selected" : ""; ?>>25</option>
                            <option value="50" <?php echo ($limit == 50) ? "selected" : ""; ?>>50</option>
                            <option value="100" <?php echo ($limit == 100) ? "selected" : ""; ?>>100</option>
                        </select>
                        <span>entries</span>
                    </div>
                    <div class="col-md-6">
                        <label for="search">Search:</label>
                        <input type="text" name="search" id="search" class="form-control d-inline-block w-75" value="<?php echo $search; ?>" onchange="this.form.submit()" placeholder="Search by Product Name and Category Name">
                    </div>
                </div>

                <table class="table table-bordered">
                <thead class="text-white" style="">

                        <tr>
                            <th class="col bg-warning text-white">S.No</th>
                            <th class="col bg-warning text-white">Image</th>
                             <th class="col bg-warning text-white">Restaurant</th> 
                            <th class="col bg-warning text-white">Category Name</th>
                            <th class="col bg-warning text-white">Product Name</th> 
                           
                            <th class="col bg-warning text-white">Recommended</th>
                            <th class="col bg-warning text-white">Action</th>
                        </tr>
                    </thead>
                    <tbody id="sectionData">
                        <?php 
                        $sno = $offset + 1;
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td ><?php echo $sno; ?></td>
                                <td><img src="/zaapin/admin/uploads/<?php echo $row['image']; ?>" width="50px" height="50px">
                           

                            </td>
                            <td><a href="view-resto.php?id=<?php echo $row['resid'] ?>" class="fw-bold text-decoration-none"><?php echo $row['title']; ?></a>
                                <td><?php echo $row['categoryname']; ?>
                           
                            </td>
                                <td ><?php echo $row['productname']; ?>
                               
                            </td> 
                                 <!-- <td ><?php// echo number_format($row['price'],0) ?>/-</td> -->

                                
                                <td ><?php echo $row['recommended']; ?></td>
                                <td>


<div class='dropdown'>
    <button class='btn btn-primary  dropdown-toggle btn-sm' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
        Actions
    </button>
    <ul class='dropdown-menu ' style='min-width:6rem'>
        <li>
         <a href='view-product.php?view_id=<?php echo $row['productid'] ?>' class='dropdown-item text-warning' >
         <i class="fa fa-folder"></i>   View
            </a>
            <a href='?delete_id=<?php echo $row['productid'] ?>' class='dropdown-item text-danger' onclick='return confirm("Are you sure?")'>
            <i class="fa fa-trash"></i>   Delete
</a>

               <a href='edit-product.php?edit_id=<?php echo $row['productid'] ?>' class='dropdown-item text-success' >
               <i class="fa fa-edit"></i>  Edit
            </a>
          
            
        </li>
        

    </ul>
</div>
</td>
                            </tr>
                        <?php 
                            $sno++;
                        } ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-end">
                    <nav>
                        <ul class="pagination">
                            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?search=<?php echo $search; ?>&limit=<?php echo $limit; ?>&page=<?php echo $page - 1; ?>">Prev</a>
                            </li>
                            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?search=<?php echo $search; ?>&limit=<?php echo $limit; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php } ?>
                            <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?search=<?php echo $search; ?>&limit=<?php echo $limit; ?>&page=<?php echo $page + 1; ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </form>
</div>

</body>
</html>


