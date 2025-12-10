<?php 
include('../config.php');

$success_message = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['img'])) {
    if (!empty($_FILES['img']['name'])) {
        $id = $_POST['id'];
        $contentTitle = $_POST['entitytitle'];
        $target_file = time() . "_" . basename($_FILES['img']['name']);
        move_uploaded_file($_FILES['img']['tmp_name'], "uploads/" . $target_file);

        $sql = "INSERT INTO add_photos (entityid, entitytitle, img) VALUES ($id, '$contentTitle', '$target_file')";
       
        if (mysqli_query($conn, $sql)) {
            $photo_id = mysqli_insert_id($conn);
            echo json_encode(["status" => "success", "message" => "Photo added successfully!", "image" => $target_file, "photo_id" => $photo_id]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error! Photo not added."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Please select an image."]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $id = $_POST['id'];
    $contentTitle = $_POST['entitytitle'];
    $photoQuery = mysqli_query($conn, "SELECT img FROM add_photos WHERE photo_id = $delete_id and entitytitle='$contentTitle'");
    $photo = mysqli_fetch_assoc($photoQuery);
    $photoPath = "uploads/" . $photo['img'];

    if (file_exists($photoPath)) {
        unlink($photoPath);
    }

    $sql = "DELETE FROM add_photos WHERE photo_id = $delete_id and entitytitle='$contentTitle'";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "success", "message" => "Photo deleted successfully!", "delete_id" => $delete_id]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error! Photo not deleted."]);
    }
    exit;
}



$id = $_GET['id'];
$contentTitle = $_GET['entitytitle'];

$res = mysqli_query($conn, "SELECT * FROM add_photos WHERE entityid = $id AND entitytitle='$contentTitle'");
$photos = mysqli_fetch_all($res, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Photo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

<?php include('admin-header.php'); ?>

<div class="content bg-light" id="mainContent">
    <div class="row ms-3 mt-2">
        <div class="col-md-11 shadow bg-white border-0 rounded p-3 me-5">
            <div id="message"></div>

            <form id="uploadForm" enctype="multipart/form-data">
                <h3 class="p-2 fw-bold">Add Photo to <?php echo htmlspecialchars($contentTitle); ?></h3>
                <hr>
                <input type="file" name="img" class="form-control d-inline-block w-25" required>
                <button type="submit" id="uploadBtn" class="my-2 p-2 fw-bold btn btn-sm" style="background-color:orange;color:white">
                    Upload Photo
                </button>
            </form>
            <hr>
            <h3 class="fw-bold p-2">Uploaded Photos</h3>
            
            <div class="row gap-5" id="photoContainer">
                <?php foreach ($photos as $p): ?>
                    <div class="col-3 p-2 border position-relative photo-box" data-id="<?php echo $p['photo_id']; ?>">
                        <a href="javascript:void(0);" class="delete-photo text-danger fs-3 position-absolute end-0 top-0" data-id="<?php echo $p['photo_id']; ?>">
                            <i class="bi bi-trash-fill"></i>
                        </a>
                        <img src="uploads/<?php echo htmlspecialchars($p['img']); ?>" width="150" height="150px">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $("#uploadForm").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append("id", "<?php echo $id; ?>");
        formData.append("entitytitle", "<?php echo addslashes($contentTitle); ?>");

        $.ajax({
            url: "add-photo.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                var res = JSON.parse(response);
                if (res.status == "success") {
                    $("#uploadForm")[0].reset();
                    $("#message").html('<div class="alert alert-success p-2">' + res.message + '</div>');
                    
                   
                    var newPhotoHtml = `
                        <div class="col-3 p-2 border position-relative photo-box" data-id="` + res.photo_id + `">
                            <a href="javascript:void(0);" class="delete-photo text-danger fs-3 position-absolute end-0 top-0" data-id="` + res.photo_id + `">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                            <img src="uploads/` + res.image + `" width="150" height="150px">
                        </div>
                    `;
                    $("#photoContainer").append(newPhotoHtml);
                } else {
                    $("#message").html('<div class="alert alert-danger p-2">' + res.message + '</div>');
                }
            }
        });
    });

    $(document).on("click", ".delete-photo", function () {
        var deleteId = $(this).data("id");
        var parentDiv = $(this).closest(".photo-box");

        $.ajax({
            url: "add-photo.php",
            type: "POST",
            data: { delete_id: deleteId, id: "<?php echo $id; ?>", entitytitle: "<?php echo addslashes($contentTitle); ?>" },
            success: function (response) {
                var res = JSON.parse(response);
                if (res.status == "success") {
                    parentDiv.remove();
                    $("#message").html('<div class="alert alert-success p-2">' + res.message + '</div>');
                } else {
                    $("#message").html('<div class="alert alert-danger p-2">' + res.message + '</div>');
                }
            }
        });
    });
});
</script>

</body>
</html>
