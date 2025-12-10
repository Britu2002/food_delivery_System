<?php
include('../config.php');

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
  
   
    $deleteQuery = "DELETE FROM customer WHERE cid='$delete_id'";
    
    if (mysqli_query($conn, $deleteQuery)) {
        echo "<script>alert('User deleted successfully!'); 
        window.location.href='customer_list.php'</script>";
        exit();
    } else {
        echo "<script>alert('Error deleting user!');</script>";
    }
}

// Pagination & Search Settings
$limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch total records count
$countQuery = "SELECT COUNT(*) AS total FROM customer WHERE  ( name LIKE '%$search%' OR email LIKE '%$search%' OR mobile LIKE '%$search%')";
$countResult = mysqli_query($conn, $countQuery);
$totalRows = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRows / $limit);

// Fetch users with pagination & search
$query = "SELECT * FROM customer   WHERE  (name LIKE '%$search%' OR email LIKE '%$search%' OR mobile LIKE '%$search%' ) LIMIT $offset, $limit";
$result = mysqli_query($conn, $query);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php include('admin-header.php'); ?>

<div class="content bg-light" id="mainContent">
    <div class="bg-white shadow  p-4 "> 
    <h2 class="mb-3 fw-bold">Agent List</h2>
    <div class=" row mb-3">
      <div class="col-md-6 d-flex align-items-center">
     <label for="">Show: </label>
      <select id="limit" class="form-select w-25">
            <option value="10" <?php echo ($limit == 10) ? 'selected' : ''; ?>>10</option>
            <option value="20" <?php echo ($limit == 20) ? 'selected' : ''; ?>>20 </option>
            <option value="25" <?php echo ($limit == 25) ? 'selected' : ''; ?>>25 </option>
            <option value="50" <?php echo ($limit == 50) ? 'selected' : ''; ?>>50</option>
            <option value="100" <?php echo ($limit == 100) ? 'selected' : ''; ?>>100 </option>
            <option value="1000" <?php echo ($limit == 100) ? 'selected' : ''; ?>>1000 </option>  
            
        </select>
        <span>entites</span>
      </div>
        <div class="col-md-6">
        <input type="text" id="search" class="form-control " placeholder="Search Users...">
        </div>
    </div>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                  
                    <th>Full Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Address</th>
                    
              
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTable">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                      
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['mobile']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            
                        <small><?php  echo $row['address']." ".$row["city"]."-".$row['pincode']?></small>
                    </td>
                        
                        <td>
                           
                            <a href="?delete_id=<?php echo $row['cid']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-end">
                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?role=<?php echo $role; ?>&page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>&limit=<?php echo $limit; ?>">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?role=<?php echo $role; ?>&page=<?php echo $i; ?>&search=<?php echo $search; ?>&limit=<?php echo $limit; ?>"> <?php echo $i; ?> </a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?role=<?php echo $role; ?>&page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>&limit=<?php echo $limit; ?>">Next</a>
                </li>
            </ul>
        </nav>
    <?php else: ?>
        <p class="alert alert-warning">No users found!</p>
    <?php endif; ?>
</div>
    </div>
<script>
    $(document).ready(function(){
        $("#search").on("keyup", function() {
            let value = $(this).val().toLowerCase();
            $("#userTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $("#limit").on("change", function() {
            let newLimit = $(this).val();
            window.location.href = "limit=" + newLimit + "&search=<?php echo $search; ?>";
        });
    });
</script>
</body>
</html>