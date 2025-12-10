<?php session_start();
unset($_SESSION['cart']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .order-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1.5s ease-in-out;
        }
        .checkmark {
            font-size: 50px;
            color: #28a745;
            animation: pop 0.5s ease-in-out;
        }
        h1 {
            color: #ff6600;
            margin: 10px 0;
        }
        p {
            font-size: 18px;
            color: #333;
        }
        .btn {
            background-color: #ff6600;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 20px;
            transition: 0.3s;
        }
        .btn:hover {
            background-color: #e65c00;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes pop {
            0% { transform: scale(0); opacity: 0; }
            50% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>

    <div class="order-container">
        <div class="checkmark">✔️</div>
        <h1>Order Placed Successfully!</h1>
        <p>Thank you for your order. We'll notify you once it's on the way.</p>
        <button class="btn" onclick="goHome()">Go to Home</button>
        
        <div class="my-2">
        <a href="order_history.php" class="text-dark text-center ">Order History</a>
        </div>

    </div>

    <script>
        function goHome() {
            window.location.href = "index.php"; // Change to your homepage URL
        }
    </script>

</body>
</html>
