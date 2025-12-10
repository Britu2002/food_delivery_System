

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/meanmenu.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"  />
</head>
<body class="bg-light">

<?php include('header-2.php'); 

?>
<?php

include '../config.php';  

$user_id = $_SESSION['user_id'];  

$sql = "SELECT name as fullname, mobile, email, address, pincode, img as photo,password FROM customer WHERE cid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<div class="container " style="margin-top:80px">
    <div class="card mx-auto shadow-lg border-0" style="max-width: 500px;">
        <div class="card-body text-center">
            <img src="/zaapin/admin/uploads/<?= !empty($user['photo']) ? $user['photo'] : 'defaultuser.png'; ?>" 
                 alt="Profile Picture" class="rounded-circle border border-warning p-1" width="130" height="130">
            <h3 class="mt-3 fw-bold text-dark"><?= htmlspecialchars($user['fullname'] ?? 'N/A'); ?></h3>
            <p class="text-muted"><i class="fa fa-envelope"></i> <?= htmlspecialchars($user['email'] ?? 'N/A'); ?></p>

            <hr>

            <div class="text-start">
                <h5 class="text-warning"><i class="fa fa-user"></i> Contact Information</h5>
                <p class="mb-1"><strong><i class="fa fa-phone"></i> Phone:</strong> <?= htmlspecialchars($user['mobile'] ?? 'N/A'); ?></p>
                <p class="mb-0"><strong><i class="fa fa-home"></i> Address:</strong> <?= htmlspecialchars($user['address'] ?? 'N/A'); ?>, Pincode: <?= htmlspecialchars($user['pincode'] ?? 'N/A'); ?></p>
                <p class="mb-1"><strong><i class="fa fa-key"></i> Password:</strong> <?= htmlspecialchars($user['password'] ?? 'N/A'); ?></p>
            </div>

            <a href="edit-user.php" class="btn btn-warning mt-3 w-100"><i class="fa fa-edit"></i> Edit Profile</a>
            <a href="index.php"  class="btn btn-secondary w-100 mt-3">Back to Home</a>
        </div>
    </div>
</div>

<script src="assets/js/jquery-1.11.3.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.countdown.js"></script>
<script src="assets/js/jquery.isotope-3.0.6.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/jquery.meanmenu.min.js"></script>
<script src="assets/js/sticker.js"></script>
<script src="assets/js/main.js"></script>
<script>



fetchCartCount()


function fetchCartCount() {
    $.ajax({
        url: "cartdata.php",
        type: "POST",
        success: function(response) {
            $("#cart-count").text(response.cart_count);
        }
    });
} 
  

</script>
</body>
</html>
