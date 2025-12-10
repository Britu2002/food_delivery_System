<?php
include('../config.php');
session_start();
$id=$_GET['id'];
$current_date = date("Y-m-d");
$cart_value = isset($_GET['total']) ? $_GET['total'] : 0;
$discounted_price = $cart_value;
$discount_amount = 0;
$message = "";

// Fetch active offers
$sql = "SELECT * FROM offers WHERE status = 1 AND expiredate >= '$current_date'";
$result = $conn->query($sql);
$offers = [];
while ($row = $result->fetch_assoc()) {
    $offers[] = $row;
}

// Apply Coupon on Form Submit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['coupon_code'])) {
    $coupon_code = $_POST['coupon_code'];

    // Get coupon details
    $sql = "SELECT * FROM offers WHERE coupencode = '$coupon_code' AND status = 1 AND expiredate >= '$current_date'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $coupon = $result->fetch_assoc();
        $discount_percentage = $coupon['coupenpercentage'];
        $min_value = $coupon['min_value'];

        // Check if coupon is valid based only on min cart value
        if ($cart_value >= $min_value) {
            $_SESSION['coupon_code'] = $coupon['coupenid'];
            $discount_amount = ($cart_value * $discount_percentage) / 100;
            $discounted_price = $cart_value - $discount_amount;
            $message = "<span style='color: green;'>Coupon applied successfully!</span>";
            echo "<script>
                alert('Coupon applied successfully');
                window.location.href='foodresto.php?id=$id';
            </script>";
        } else {
            $message = "<span style='color: red;'>Cart value must be at least Rs. $min_value.</span>";
        }
    } else {
        $message = "<span style='color: red;'>Invalid or Expired Coupon</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zaapin Offers</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"  />
</head>
<body class="bg-light">
    <nav class="text-white py-2" style="background-color:#051922">
        <div class="d-flex align-items-center gap-2">
            <a href="foodresto.php?id=<?php echo $_GET['id'] ?>" class="text-white"> 
                <i class="fa-solid fa-arrow-left fa-2x mx-3"></i>
            </a>
            <div>
                <h4 class="m-0 text-white">Coupon</h4>
                <p class="text-white">Your cart value: Rs. <?php echo number_format($discounted_price, 2); ?></p>
            </div>
        </div>
    </nav>

    <div class="container my-3">
        <form method="POST">
            <div class="coupon-input">
                <span><strong>Have a Coupon Code?</strong></span>
                <div class="bg-white d-flex p-2 shadow-sm rounded">
                    <input type="text" name="coupon_code" placeholder="Type Offer code here..." class="border-0 form-control shadow-none" required>
                    <button type="submit" class="bg-light fw-bold text-dark border-0">Apply</button>
                </div>
            </div>
        </form>
        <div id="couponMessage"><?php echo $message; ?></div>
    </div>

    <div class="container my-3">
        <h3>Offers</h3>
        <div class="row">
            <?php foreach ($offers as $coupon) { 
                $min_value = $coupon['min_value'];
                $disable_btn = ($cart_value >= $min_value) ? '' : 'disabled';
            ?>
                <div class="col-md-4 mb-3">
                    <div class="card p-3 border-0 shadow-sm position-relative w-100 h-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="ml-3 w-100 h-100">
                                <img src="/zaapin/admin/uploads/<?php echo $coupon['coupenophtoto'] ?>" width="35px" height="35px">
                                <strong class="mt-2"> <?php echo $coupon['coupencode']; ?> </strong>  
                                <p class="text-muted"> <?php echo substr($coupon['coupendesp'], 0, 30); ?>...</p>
                            </div>
                            <div class="pl-3" style="border-left:1px dashed #ccc;">
                                <b>Save <?php echo $coupon['coupenpercentage']; ?>% With This Offer</b><br>
                                <form method="POST">
                                    <input type="hidden" name="coupon_code" value="<?php echo $coupon['coupencode']; ?>">
                                    <button type="submit" class="btn btn-danger mt-3" <?php echo $disable_btn; ?>>
                                        <strong>Apply</strong>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <small class="text-danger text-center mt-2" style="display: <?php echo ($cart_value < $min_value) ? 'block' : 'none'; ?>;">
                            Cart value must be at least Rs. <?php echo $min_value; ?>
                        </small>
                    </div>  
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>