<?php
include '../config.php';

$order_id = $_GET['order_number'];

// Order Details Fetch
$order_query = "SELECT o.*, u.name as customer_name ,u.pincode,u.city,u.address, u.email, u.mobile, offers.coupencode, offers.coupenpercentage 
                FROM orders o 
                LEFT JOIN offers ON offers.coupenid = o.coupen_id
                JOIN customer u ON o.customer_id = u.cid 
                WHERE o.order_id = $order_id";
$order_result = $conn->query($order_query);
$order = $order_result->fetch_assoc();

// Ordered Items Fetch
$items_query = "SELECT oi.*, p.productname AS product_name, p.display_price, p.image 
                FROM order_items oi 
                JOIN product p ON oi.product_id = p.productid 
                WHERE oi.order_id = '$order_id'";
$items_result = $conn->query($items_query);

// Status Update Logic (Only Runs on POST Request)
// Assuming order acceptance is handled here (Order is in "Accepted" status)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['status'])) {
    if ($_POST['status'] == 2) {
        // Get the restaurant ID (resid) directly from the order
        $resid = $order['resid'];

        // Find the active delivery boy for the restaurant using the resid
        $delivery_boy_query = "SELECT userid, fullname FROM agent WHERE agent.res_id = '$resid' AND status = 'active';";
        $delivery_boy_result = $conn->query($delivery_boy_query);

        if ($delivery_boy_result->num_rows > 0) {
            $users = [];

            while ($user = $delivery_boy_result->fetch_assoc()) {
                $users[] = $user;
            }

            // Randomly select a delivery boy
            $random_user = $users[array_rand($users)];
            $deliveryid = $random_user['userid'];

            // Assign the delivery boy to the order
            $update_query = "UPDATE orders SET delivery_status = 4, delivery_boy_id = '$deliveryid' WHERE order_id = '$order_id'";
            if ($conn->query($update_query) === TRUE) {
                echo "<script>
                alert('Order Accepted and Delivery Boy Assigned!');
                window.location.href='listorder.php?status=1';
                </script>";
            } else {
                echo "<script>alert('Error Assigning Delivery Boy!');</script>";
            }
        } else {
            echo "<script>alert('No Available Delivery Boy for this Restaurant!');</script>";
        }
    } else if ($_POST['status'] == 3) {
        $updatequery = "UPDATE orders SET delivery_status = 3 WHERE order_id = '$order_id'";
        if ($conn->query($updatequery) === TRUE) {
            echo "<script>
            alert('Order Rejected!');
            window.location.href='listorder.php?status=3';
            </script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    @media print {
        #adminHeader { 
            display: none !important;
        }
        .print-btn {
            display: none !important;
        }
        #mainContent {
            margin: 0;
            padding: 0;
        }
        .print{
            display :none !important;
        }
    }
</style>
<body>
<div id="adminHeader">
    <?php include('admin-header.php'); ?> 
</div>
<div class="content bg-white border rounded p-4" id="mainContent">
    <div class="invoice-header text-center bg-warning p-3">
        <img src="/zaapin/img/logo-dark.png" alt="Logo" style="width:150px;">
    </div>

    <div class="d-flex justify-content-between p-2 bg-light">
        <div class="info-left">
            <p><strong>To:</strong> <?php echo $order['customer_name']; ?></p>
            <p><strong>Email:</strong> <?php echo $order['email']; ?></p>
            <p><strong>Mobile:</strong> <?php echo $order['mobile']; ?></p>
            <p><strong>Customer loc :</strong><?php echo $order['address']." ".$order['city']."-".$order['pincode'] ?></p>
        </div>
        <div class="info-right">
            <p><strong>Order No:</strong> <?php echo $order['order_number']; ?></p>
            <p><strong>Order Date:</strong> <?php echo date("d-m-Y", strtotime($order['created_at'])); ?></p>
           <p>
    <strong> Restaurant :</strong>   <?php
                         $outletid =$order['resid'];
                         $outletresult=mysqli_query($conn,"SELECT * FROM `restaurant`  where resid=$outletid");
                         $outlet=mysqli_fetch_assoc($outletresult);
                         $title =$outlet['title'];
                         $outletlocation=$outlet['addr'];
                         $outletcity=$outlet['city'];
                         $outletpincode=$outlet['pincode'];
                        ?>
                         <?php echo $title ?>
                        
           </p>
           <p><strong>Addrress-</strong>
          
                       
                       <?php echo $outletlocation." ". $outletcity. ",". $outletpincode  ; ?>
        </p>
        </div>
    </div>

    <table class="table">
        <thead class="table-dark">
            <tr>
                <th>Sr. No.</th>
                <th>Photo</th>
                <th>Product Name</th>
                <th>Amount</th>
                <th>Quantity</th>
                <th>Sub-Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = 0;
            $sr = 1;
            while ($item = $items_result->fetch_assoc()) { 
                $subtotal = $item['display_price'] * $item['quantity'];
                $total += $subtotal;
            ?>
            <tr>
                <td><?php echo $sr++; ?></td>
                <td><img src="/zaapin/admin/uploads/<?php echo $item['image']; ?>" class="product-img" width="50px" height="50px"></td>
                <td><?php echo $item['product_name']; ?></td>
                <td>₹ <?php echo $item['display_price']; ?>/-</td>
                <td><?php echo $item['quantity']; ?></td>
                <td>₹ <?php echo $subtotal; ?>/-</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="invoice-total">
        <p><strong>Total:</strong> ₹ <?php echo $total; ?>/-</p>
        <p><strong>Coupon Code Applied:</strong> <span class="text-success"><?php echo isset($order['coupencode']) ? $order['coupencode']." (".$order['coupenpercentage']."%)" : "-"; ?></span></p>
        <p><strong>Discount Amount:</strong> <?php echo isset($order['discount']) ? $order['discount'] : "0/-"; ?></p>
        <p><strong>Net Total:</strong> <?php echo isset($order['total']) ? $order['total'] : "0/-"; ?></p>
    </div>

    <div class="d-flex justify-content-center align-items-center gap-2">
        <button onclick="window.print();" class="btn btn-warning btn-sm print">Print</button>

        <?php if($order['delivery_status'] == 1): ?>
            <form method="POST">
                <input type="hidden" name="status" value="2">
                <button type="submit" class="btn btn-success btn-sm print">Accepted</button>
            </form>
            <form method="POST">
                <input type="hidden" name="status" value="3">
                <button type="submit" class="btn btn-danger btn-sm print">Rejected</button>
            </form>
        <?php elseif($order['delivery_status'] == 2): ?>
            <button class="btn btn-success btn-sm print" disabled>Accepted</button>
        <?php elseif($order['delivery_status'] == 3): ?>
            <button class="btn btn-danger btn-sm print" disabled>Rejected</button>
        <?php endif; ?>

        <a href="javascript:history.back()" class="btn btn-secondary btn-sm print">Back</a>
    </div>
</div>

</body>
</html>
