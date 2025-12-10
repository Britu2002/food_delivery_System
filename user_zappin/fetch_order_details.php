<?php 
include("../config.php");

if(isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $query = mysqli_query($conn, "SELECT delivery_status FROM orders WHERE order_id = $order_id");
    $order = mysqli_fetch_assoc($query);
    
    $delivery_status = isset($order['delivery_status']) ? (int)$order['delivery_status'] : 0;

    // Define Order Stages
    $stages = [
        'Order Placed' => [0, 1, 2], 
        'Preparing' => [3],          
        'Order on the Way' => [4],   
        'Delivered' => [5]           
    ];
    
    $current_stage = 'Order Placed';
    foreach ($stages as $stage => $values) {
        if (in_array($delivery_status, $values)) {
            $current_stage = $stage;
            break;
        }
    }

    echo json_encode(['status' => $current_stage]);
}
?>
