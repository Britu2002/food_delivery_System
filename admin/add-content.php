<?php 
include('../config.php');

$success_message = "";
$error_message = "";

// Fetch Sections Dynamically
$sections = mysqli_query($conn, "SELECT * FROM section");

// Insert Content
if (isset($_POST['submit'])) {
    $sectionid = $_POST['sectionid'];
    $contenttitle = $_POST['contenttitle'];  // Fixed field name
    $price = $_POST['price'];  // Fixed field name

    $content_location = $_POST['content_location'];
   
    $contentdesc = $_POST['contentdesc'];
    $alt_tag = $_POST['alt_tag'];
    $link = $_POST['link'];
    $display_status = $_POST['display_status'];
    $createdon = date("Y-m-d H:i:s");

    // Get section name from ID
    $sectionQuery = mysqli_query($conn, "SELECT section_name FROM section WHERE section_id = '$sectionid'");
    $sectionRow = mysqli_fetch_assoc($sectionQuery);
    $sectionname = $sectionRow['section_name'] ?? '';

    // Image Upload Handling
    $imagename = "";
    if (!empty($_FILES['imagename']['name'])) {
        $imagename = time() . "_" . basename($_FILES['imagename']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $imagename;
        move_uploaded_file($_FILES['imagename']['tmp_name'], $target_file);
    }

    // SQL Query
    $sql = "INSERT INTO `content`(`sectionname`, `sectionid`, `content_title`, `price`,  `content_location`,  `contentdesc`, `alt_tag`, `link`, `display_status`, `createdon`) 
            VALUES ('$sectionname', '$sectionid', '$contenttitle', '$price', '$content_location',  '$contentdesc', '$alt_tag', '$link', '$display_status', '$createdon')";

    if ($res=mysqli_query($conn, $sql)) {
        if (!empty($imagename)) {
            $contentid = mysqli_insert_id($conn); // Get last inserted content ID
            $target_file = "uploads/" . $imagename;
    
            $phto = "INSERT INTO `add_photos`(`entityid`,entitytitle, `img`) VALUES ($contentid,'$contenttitle', '$imagename')";
            mysqli_query($conn, $phto);
        }
        $success_message = "Content added successfully!";
    } else {
        $error_message = "Error! Content not added.";
    }
}
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
    <form method="post" enctype="multipart/form-data">
        <div class="row ms-3 mt-2">
            <div class="col-md-8 shadow bg-white border-0 rounded p-3 me-5">
                <!-- Success & Error Messages -->
                <?php if ($success_message): ?>
                    <div class="alert alert-success p-2"><?php echo $success_message; ?></div>
                <?php endif; ?>
                <?php if ($error_message): ?>
                    <div class="alert alert-danger p-2"><?php echo $error_message; ?></div>
                <?php endif; ?>
                
                <h3 class="p-2 fw-bold">Add Content</h3>
                <hr>
                
                <div class="mb-2 form-group row">
                    <label class="control-label col-md-3">Section Name</label>
                    <div class="col-md-8">
                        <select name="sectionid" class="form-control" required>
                           
                            <?php while ($row = mysqli_fetch_assoc($sections)): ?>
                                <option value="<?php echo $row['section_id']; ?>"><?php echo $row['section_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>      
                </div>

                <div class="mb-2 form-group row">
                    <label class="control-label col-md-3">Content Title</label>
                    <div class="col-md-8">
                        <input type="text" name="contenttitle" class="form-control col-md-8" required>
                    </div>      
                </div>

                <div class="mb-2 form-group row">
                    <label class="control-label col-md-3">Content Price</label>
                    <div class="col-md-8">
                        <input type="text" name="price" class="form-control col-md-8" >
                    </div>      
                </div>

               

                <div class="mb-2 form-group row">
                    <label class="control-label col-md-3">Location</label>
                    <div class="col-md-8">
                        <input type="text" name="content_location" class="form-control col-md-8">
                    </div>      
                </div>

               

                <div class="mb-2 form-group row">
                    <label class="control-label col-md-3">Description</label>
                    <div class="col-md-8">
                        <textarea name="contentdesc" class="form-control col-md-8"></textarea>
                    </div>      
                </div>

                <div class="mb-2 form-group row">
                    <label class="control-label col-md-3">Alt Tag</label>
                    <div class="col-md-8">
                        <input type="text" name="alt_tag" class="form-control col-md-8">
                    </div>      
                </div>

                <div class="mb-2 form-group row">
                    <label class="control-label col-md-3">Link</label>
                    <div class="col-md-8">
                        <input type="url" name="link" class="form-control col-md-8">
                    </div>      
                </div>

                <div class="mb-2 form-group row">
                    <label class="control-label col-md-3">Display Status</label>
                    <div class="col-md-8">
                        <select name="display_status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>      
                </div>

                <div class="mb-2 form-group row">
                    <label class="control-label col-md-3">Upload Image</label>
                    <div class="col-md-8">
                        <input type="file" name="imagename" class="form-control">
                    </div>      
                </div>

                <hr>
                <button type="submit" name="submit" class="my-2 p-2 fw-bold btn btn-warning">
                    <i class="bi bi-patch-check"></i> Submit
                </button>
            </div>
        </div>
    </form>
</div>

</body>
</html>
