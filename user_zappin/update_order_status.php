<?php
session_start();
include("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $update_query = "UPDATE orders SET delivery_status = '$status' WHERE order_id = '$order_id'";
    if (mysqli_query($conn, $update_query)) {
        echo "Order status updated successfully!";
    } else {
        echo "Error updating order status: " . mysqli_error($conn);
    }
}
?>
