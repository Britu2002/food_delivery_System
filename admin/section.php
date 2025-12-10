<?php 
include('../config.php');

$success_message = "";
$error_message = "";

// Add Section
if (isset($_POST['submit'])) {
    $name = $_POST['section_name'];
    $sql = "INSERT INTO `section`(section_name) VALUES ('$name')";
    
    if (mysqli_query($conn, $sql)) {
        $success_message = "Section added successfully!";
        
    } else {
        $error_message = "Error! Section not added.";
    }
}

// Delete Section
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM `section` WHERE section_id=$id";
    
    if (mysqli_query($conn, $sql)) {
       
        echo "<script>alert('Section deleted successfully!')</script>";
    } 
}

// Handle AJAX Request for Limit & Search
if (isset($_GET['ajax'])) {
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    $sql = "SELECT * FROM section WHERE section_name LIKE '%$search%' LIMIT $limit";
    $result = mysqli_query($conn, $sql);
    $sno = 1;

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $sno . "</td>";
        echo "<td>" . $row['section_name'] . "</td>";
        echo "<td>
            <a href='?delete_id=" . $row['section_id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>
                <i class='bi bi-trash'></i> Delete
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
    <title>Section</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/zaapin/css/style.css">
  
</head>
<body>

<?php include('admin-header.php'); ?>

<div class="content bg-light" id="mainContent">
    <form method="post">
        <div class="row ms-3 mt-2">
            <div class="col-md-4 shadow bg-white border-0 rounded p-3 me-5" style="max-height:300px">
                <!-- Success & Error Messages -->
                <?php if ($success_message): ?>
                    <div class="alert alert-success p-2"><?php echo $success_message; ?></div>
                <?php endif; ?>
                <?php if ($error_message): ?>
                    <div class="alert alert-danger p-2"><?php echo $error_message; ?></div>
                <?php endif; ?>
                
                <h3 class="p-2 fw-bold">Add Section</h3>
                <hr>
                <input type="text" name="section_name" class="form-control" placeholder="Enter Section Name" required>
                <hr>
                <button type="submit" name="submit" class="my-2 p-2 fw-bold btn " style="background-color:orange;color:white">
                    <i class="bi bi-patch-check"></i> Submit
                </button>
            </div>

            <div class="col-md-7 bg-white shadow border-0 rounded p-3">
                <h3 class="p-2 fw-bold">List of Sections</h3>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="limit">Show:</label>
                        <select name="limit" class="form-control d-inline-block w-25">
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
                    <thead class="table-dark text-white">
                        <tr>
                            <th scope="col">Section ID</th>
                            <th scope="col">Section Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="sectionData">
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
        function fetchSections() {
            let limit = $('select[name="limit"]').val();
            let search = $('#search').val();
            
            $.ajax({
                url: "<?php echo $_SERVER['PHP_SELF']; ?>",
                type: "GET",
                data: { ajax: 1, limit: limit, search: search },
                success: function (data) {
                    $("#sectionData").html(data);
                }
            });
        }

        // Fetch data on page load
        fetchSections();

        // Change limit dropdown
        $('select[name="limit"]').change(fetchSections);

        // Search input event
        $('#search').on("keyup", function () {
            fetchSections();
        });
    });
</script>

</body>
</html>
