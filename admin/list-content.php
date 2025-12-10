<?php 
include('../config.php');

// Delete Section
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM `content` WHERE contentid=$id";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Content deleted successfully!');</script>";
        echo "<script>window.location='list-content.php';</script>";
    }
}

// Pagination and Search Logic
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$totalRecordsQuery = "SELECT COUNT(*) as total FROM content WHERE content_title LIKE '%$search%' OR sectionname LIKE '%$search%'";
$totalRecords = mysqli_fetch_assoc(mysqli_query($conn, $totalRecordsQuery))['total'];
$totalPages = ceil($totalRecords / $limit);
$offset = ($page - 1) * $limit;

// Fetch Data with Pagination
$sql = "SELECT * FROM content WHERE content_title LIKE '%$search%' OR sectionname LIKE '%$search%' LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/zaapin/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<?php include('admin-header.php'); ?>

<div class="content bg-light" id="mainContent">
    <form method="GET">
        <div class="row ms-3 mt-2">
            <div class="col-md-11 shadow bg-white border-0 rounded p-3 ">
                
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="p-2 fw-bold">List of Content</h3>
                    <div>
                        <a href="add-content.php" class="btn btn-orange btn-sm"><i class="bi bi-plus"></i> Add Content</a>
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
                        <input type="text" name="search" id="search" class="form-control d-inline-block w-75" value="<?php echo $search; ?>" onchange="this.form.submit()">
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead class="table-dark text-white">
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">Section Name</th>
                            <th scope="col">Content Title</th> 
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="sectionData">
                        <?php 
                        $sno = $offset + 1;
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $sno; ?></td>
                                <td><?php echo $row['sectionname']; ?></td>
                                <td><?php echo $row['content_title']; ?></td>
                                <td>
                                    <a href="view-content.php?view_id=<?php echo $row['contentid']; ?>" class="btn btn-success btn-sm">
                                        <i class="bi bi-card-text"></i> View
                                    </a>
                                    <a href="edit-content.php?edit_id=<?php echo $row['contentid']; ?>&entitytitle=<?php echo $row['content_title'] ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pen"></i> Edit
                                    </a>
                                    <a href="?delete_id=<?php echo $row['contentid']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </a>
                                    <a href="add-photo.php?id=<?php echo $row['contentid']; ?>&entitytitle=<?php echo $row['content_title'] ?>" class="btn btn-primary btn-sm">
                                        <i class="bi bi-images"></i> Photos
                                    </a>
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

<script>

</script>

</body>
</html>
