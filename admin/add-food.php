<!-- <?php include('../config.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Food & Food Sizes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body { background-color: #f4f4f4; font-family: Arial, sans-serif; }
        .container { margin-top: 20px; }
        .nav-pills .nav-link { font-weight: bold; color: #000; text-align: left; cursor: pointer; }
        .nav-pills .nav-link.active { background-color: #ff6600; color: white; transition: 0.3s ease; }
        .tab-content { padding: 20px; border-radius: 12px; }
        .btn-remove { background-color: #dc3545; color: white; border: none; padding: 6px 10px; border-radius: 5px; }
        .btn-remove:hover { background-color: #c82333; }
        .btn-remove i { font-size: 14px; }
    </style>
</head>
<body>
    <!-- <?php //include('admin-header.php') ?> -->

    <div class="content bg-white" id="mainContent">
       
        <div class="row border bg-white">
            <!-- Left Side Navigation Tabs -->
            <div class="col-md-3   border-end">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="pill" href="#step1">Step 1: Basic Food Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" id="step2Tab" data-bs-toggle="pill" href="#step2">Step 2: Food Sizes</a>
                    </li>
                </ul>
            </div>

            <!-- Right Side Form -->
            <div class="col-md-9">
                <div class="tab-content">
                    <form id="foodForm" action="process_add_food.php" method="POST" enctype="multipart/form-data">

                        <!-- Step 1: Basic Details -->
                        <div id="step1" class="tab-pane fade show active">
                            <h4 class="mb-3">Step 1: Basic Food Details</h4>
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select name="cid" id="cid" class="form-select required" required>
                                    <option value="">Select Category</option>
                                    <?php 
                                    $res = mysqli_query($conn, "SELECT cid, cname FROM category");
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo "<option value='" . $row['cid'] . "'>" . $row['cname'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Restaurant</label>
                                <select name="rid" id="rid" class="form-select required" required>
                                    <option value="">Select Restaurant</option>
                                    <?php 
                                    $res = mysqli_query($conn, "SELECT resid, title FROM restaurant WHERE status='active'");
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo "<option value='" . $row['resid'] . "'>" . $row['title'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Food Name</label>
                                <input type="text" id="fname" name="fname" class="form-control required" placeholder="Enter food name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="fdesp" id="fdesp" class="form-control required" rows="3" placeholder="Write a short description" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Upload Image</label>
                                <input type="file" name="img" id="img" class="form-control required" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Is Veg?</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input required" type="radio" name="is_veg" value="1" required>
                                    <label class="form-check-label">Veg</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input required" type="radio" name="is_veg" value="0" required>
                                    <label class="form-check-label">Non-Veg</label>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary mt-3" id="nextStep">Next</button>
                        </div>

                        <!-- Step 2: Food Sizes -->
                        <div id="step2" class="tab-pane fade">
                            <h4 class="mb-3">Step 2: Food Sizes</h4>
                            <div id="sizeContainer">
                                <div class="size-group mb-3 d-flex gap-2">
                                    <input type="text" name="fsname[]" class="form-control" placeholder="Size Name (Small, Medium, Large)" required>
                                    <input type="text" name="fsvalue[]" class="form-control" placeholder="Size Value (250g, 500ml)" required>
                                    <input type="number" name="price[]" class="form-control" placeholder="Price" required>
                                    <button type="button" class="btn-remove" onclick="removeSize(this)">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success mt-2" onclick="addSize()">+ Add More Size</button>
                            <button type="submit" class="btn btn-primary mt-3">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addSize() {
            let container = document.getElementById("sizeContainer");
            let sizeGroup = document.createElement("div");
            sizeGroup.classList.add("size-group", "mb-3", "d-flex", "gap-2");

            sizeGroup.innerHTML = `
                <input type="text" name="fsname[]" class="form-control" placeholder="Size Name" required>
                <input type="text" name="fsvalue[]" class="form-control" placeholder="Size Value" required>
                <input type="number" name="price[]" class="form-control" placeholder="Price" required>
                <button type="button" class="btn-remove" onclick="removeSize(this)">
                    <i class="fa fa-trash"></i>
                </button>
            `;
            container.appendChild(sizeGroup);
            sizeGroup.querySelector("input").focus();
        }

        function removeSize(button) {
            button.parentElement.remove();
        }

        document.getElementById("nextStep").addEventListener("click", function() {
            let requiredFields = document.querySelectorAll(".required");
            let valid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.focus();
                    return;
                }
            });

            if (valid) {
                document.getElementById("step2Tab").classList.remove("disabled");
                document.querySelector("[href='#step2']").click();
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 
