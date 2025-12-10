
<?php
include('../config.php');
$orderstatus = isset($_GET['status']) ?$_GET['status'] : "invalid";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['order_id']) && isset($_POST['status'])) {
        $order_id = $_POST['order_id'];
        $status = $_POST['status'];
       echo $status;
        mysqli_query($conn, "UPDATE orders SET delivery_status = '$status' WHERE order_id = '$order_id'");
       return;

    }

    
    if (isset($_POST['order_id']) && isset($_POST['delivery_boy'])) {
        $order_id = $_POST['order_id'];
      
        $delivery_boy = (!empty($_POST['delivery_boy']))?$_POST['delivery_boy']:"NULL";
      
        mysqli_query($conn, "UPDATE orders SET delivery_boy_id = $delivery_boy WHERE order_id = '$order_id'");
        header("Location: listorder.php?status=$orderstatus"); // Refresh Page
        exit();
    }
}
$order_status_text = ""; 

switch ($orderstatus) {
    case '1': $order_status_text = "Order Pending"; break;
    case '2': $order_status_text = "Order Accepted"; break;
    case '3': $order_status_text = "Order Rejected"; break;
    case '4': $order_status_text = "Prepared Food"; break;
    case '5': $order_status_text = "Delivery on the Way"; break;
    case '6': $order_status_text = "Delivered"; break;
    default:  $order_status_text = "Invalid Order Status"; break;
}


// Pagination Variables
$limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1; 
$search = isset($_GET['search']) ? $_GET['search'] : ""; 
$offset = ($page - 1) * $limit; 

// Get Total Orders Count
$countQuery = "SELECT COUNT(*) AS total FROM orders  where delivery_status='$orderstatus' and DATE(created_at) = CURDATE()";
$countResult = mysqli_query($conn, $countQuery);
$totalRows = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRows / $limit);


$query = "SELECT o.order_id, o.order_number, o.customer_id, c.name AS customer_name,
c.address,c.pincode,c.city, 
                 o.total, o.total_items, o.delivery_status, 
                 o.delivery_boy_id, d.fullname AS delivery_boy_name, o.created_at 
          FROM orders o
          LEFT JOIN customer c ON o.customer_id = c.cid
          LEFT JOIN agent d ON o.delivery_boy_id = d.userid
          where delivery_status='$orderstatus' and DATE(created_at) = CURDATE()
          and  (c.name LIKE '%$search%' OR order_number LIKE '%$search%' Or created_at LIKE '%$search%' or c.pincode='%$search%' or c.address LIKE '%$search%')
          ORDER BY o.created_at DESC
          LIMIT $limit OFFSET $offset";
         
       
$result = mysqli_query($conn, $query);

// Fetch all delivery boys
$deliveryBoysQuery = "SELECT userid, fullname FROM agent";
$deliveryBoysResult = mysqli_query($conn, $deliveryBoysQuery);
$deliveryBoys = mysqli_fetch_all($deliveryBoysResult, MYSQLI_ASSOC);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $order_status_text ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

</head>
<body>
<?php include('admin-header.php'); ?>

<div class="content bg-light" id="mainContent">
    <div class="bg-white p-3 shadow">
        <h3 class="fw-bold">
        <?php echo $order_status_text ?>
        </h3>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <label for="limit">Show:</label>
                <select id="limit" class="form-select w-auto d-inline" onchange="changeLimit()">
                    <option value="5" <?php if($limit == 5) echo 'selected'; ?>>5</option>
                    <option value="10" <?php if($limit == 10) echo 'selected'; ?>>10</option>
                    <option value="20" <?php if($limit == 20) echo 'selected'; ?>>20</option>
                </select>
            </div>
            <div class="col-md-6">
                <input type="text" placeholder="Search" class="form-control" id="search" value='<?php if(isset($_GET['search'])){echo $search;} ?>' onchange="Search()">
            </div>
        </div>
      
<hr>


        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Customer Name</th>
                    <th>Amount</th>
                    <th>Total Items</th>
                    <th>Delivery Address</th>
                    <th>Delivery Status</th>
                  <?php if($orderstatus !='3'): ?>  <th>Delivery Boy</th><?php endif; ?>
                    <th>Invoice</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>
                            <?php echo $row['order_number']; ?><br>
                            <small><?php echo date_format(new DateTime($row['created_at']), 'y/m/d'); ?></small>
                        </td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['total']; ?></td>
                        <td><?php echo $row['total_items']; ?></td>
                        <td><small><?php echo $row['address']." ".$row['city'].",".$row['pincode']; ?></small></td>
                        <td>
    <form method="POST">
        <?php
        // Define status labels and colors
        $statusLabels = [
            '1' => ['text' => 'Order Pending', 'color' => 'text-warning'],  
            '2' => ['text' => 'Order Accepted', 'color' => 'text-secondary'], 
            '3' => ['text' => 'Order Rejected', 'color' => 'text-danger'],  
            '4' => ['text' => 'Preparing Food', 'color' => 'text-primary'],    
            '5' => ['text' => 'Order on the Way', 'color' => 'text-warning'], 
            '6' => ['text' => 'Delivered', 'color' => 'text-success']      
        ];

        // Get current status
        $currentStatus = $row['delivery_status'];

        // Display status text with color
        if (isset($statusLabels[$currentStatus])) {
            echo "<strong class='{$statusLabels[$currentStatus]['color']}'>" . $statusLabels[$currentStatus]['text'] . "</strong>";
        } else {
            echo "<strong class='text-muted'>Unknown Status</strong>";
        }
        ?>
        
        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
    </form>
</td>



                        <?php if($orderstatus !='3'): ?>
                            <td>
    <form method="POST">
       
        <strong>
            <?php
            // Check if a delivery boy is assigned
            $assignedBoy = null;
            $assignedBoyid=null;
            foreach ($deliveryBoys as $boy) {
                if ($row['delivery_boy_id'] == $boy['userid']) {
                    $assignedBoy = $boy['fullname'];
                    $assignedBoyid=$boy['userid'];
                    break;
                }
            }
            
            echo $assignedBoy ? "<a class='text-dark text-decoration-none' href='view-user.php?userid=$assignedBoyid'>$assignedBoy</a>" : "Not Assigned";
            ?>
        </strong>
<a href=''></a>
        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
    </form>
</td>

                        <?php endif; ?>
                        <td><a href="invoice.php?order_number=<?php echo $row['order_id']; ?>" class="btn btn-success btn-sm">Invoice</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <nav>
            <ul class="pagination justify-content-end">
                <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&limit=<?php echo $limit; ?>">Previous</a>
                </li>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?php if($page >= $totalPages) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&limit=<?php echo $limit; ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<script>
    function changeLimit() {
        var limit = document.getElementById('limit').value;
        window.location.href = '?status=<?php echo $orderstatus; ?>&page=1&limit=' + limit;
    }
    function Search(){
        var search = document.getElementById('search').value;

        window.location.href = '?status=<?php echo $orderstatus; ?>&page=1&search=' + search;
    }
</script>

</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Order Status Update
        $('.update-status').change(function () {
            var order_id = $(this).data('order-id');
            var status = $(this).val();
            var span_order = $(this).closest('tr').find('.order-status-msg');
         
            $.ajax({
                url: 'listorder.php',
                type: 'POST',
                data: { order_id: order_id, status: status },
                success: function (response) {
                   
           
                    span_order.html("status Updated")
                },
                error: function () {
                    alert('Failed to update order status.');
                }
            });
        });

        // Assign Delivery Boy
        $('.assign-delivery-boy').change(function () {
            var order_id = $(this).data('del-id');
            var delivery_boy = $(this).val();
            var deliveryspan = $(this).closest('tr').find('.delivery-status-msg');
          
            $.ajax({
                url: 'listorder.php',
                type: 'POST',
                data: { order_id: order_id, delivery_boy: delivery_boy },
                success: function () {
                    deliveryspan.html("updated")
                },
                error: function () {
                    alert('Failed to assign delivery boy.');
                }
            });
        });
    });
</script>
