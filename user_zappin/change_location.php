<?php
session_start();
include '../config.php'; // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $address = trim($_POST['address']);
    $pincode = (int) trim($_POST['pincode']); 

    // User ka address session aur database mein update karein
    $_SESSION['address'] = $address;
    $_SESSION['pincode'] = $pincode;

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $update_query = "UPDATE users SET address='$address', pincode='$pincode' WHERE userid='$user_id'";
        $conn->query($update_query);
    }

    // Fetch all outlet pincodes
    $query = "SELECT zipcode FROM outlet";
    $result = $conn->query($query);

    $delivery_available = false;

    while ($row = $result->fetch_assoc()) {
        $outlet_pincode = (int) $row['zipcode'];

      
        if (abs($pincode - $outlet_pincode) <= 10) {
            $delivery_available = true;
            break;
        }
    }

    if ($delivery_available) {
        header("Location: cart.php"); 
        exit;
    } else {
        $error = "Sorry, we do not deliver to this location.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Address </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h2 { color: #333; }
        input {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 10px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: orange;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover { background-color: darkorange; }
        .error { color: red; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Address</h2>
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="post">
            <input type="text" name="pincode" placeholder="Enter Pincode" required>
            <input type="text" name="address" placeholder="Enter Address" required>
            <button type="submit">Address</button>
        </form>
    </div>
</body>
</html>
