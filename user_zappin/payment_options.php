<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Payment Options</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <style>
    body { background-color: #f8f9fa; font-family: 'Poppins', sans-serif; }
    .container { max-width: 600px; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); }
    .payment-card { cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 15px; padding: 15px; border-radius: 10px; border: 2px solid #ddd; background: #fff; }
    .payment-card:hover, .payment-card.active { border-color:#051922; box-shadow: 0 0 15px 051922; }
    .payment-card i { color: rgb(44, 56, 61); }
    input[type="radio"] { transform: scale(1.3); margin-right: 10px; }
    .btn-primary { background: blue; border: none; padding: 12px; font-size: 18px; border-radius: 8px; }
    .btn-primary:hover { background: #blue; }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Choose Payment Method</h2>
    <div class="row">
      <div class="col-12 mb-3">
        <div class="payment-card active" onclick="selectPayment(this)">
          <input type="radio" name="payment" value="cash" checked>
          <i class="fas fa-wallet fa-2x"></i>
          <h5 class="mt-2">Cash on Delivery</h5>
        </div>
      </div>
      <div class="col-12 mb-3">
        <div class="payment-card" onclick="selectPayment(this)">
          <input type="radio" name="payment" value="card">  
          <i class="fas fa-credit-card fa-2x"></i>
          <h5 class="mt-2">Credit / Debit Card</h5>
        </div>
      </div>
      <div class="col-12 mb-3">
        <div class="payment-card" onclick="selectPayment(this)">
          <input type="radio" name="payment" value="upi">
          <i class="fas fa-university fa-2x"></i>
          <h5 class="mt-2">UPI / Net Banking</h5>
        </div>
      </div>
      <div class="col-12 mb-3">
        <div class="payment-card" onclick="selectPayment(this)">
          <input type="radio" name="payment" value="paypal">
          <i class="fab fa-paypal fa-2x"></i>
          <h5 class="mt-2">PayPal</h5>
        </div>
      </div>
    </div>
    <!-- Modified button with onclick event -->
    <button class="btn w-100 mt-3" style="background-color:#051922;color:#fff" onclick="proceedToPayment()">
      <strong>Proceed to Payment</strong>
    </button>
  </div>

  <script>
    function selectPayment(element) {
      document.querySelectorAll('.payment-card').forEach(card => card.classList.remove('active'));
      element.classList.add('active');
      element.querySelector('input[type="radio"]').checked = true;
    }
    
    function proceedToPayment() {
      // Get the value of the selected payment method
      const selectedPayment = document.querySelector('input[name="payment"]:checked').value;
      // Redirect to payment.html with a query parameter
      if(selectedPayment=="cash"){
        window.location.href = "cart.php";
      }else{
        window.location.href = "payment.php?method=" + encodeURIComponent(selectedPayment)+"&total=<?php echo  $_GET['total'] ?>&discount=<?php echo  $_GET['discount'] ?>";
      }
     
    }
  </script>
</body>
</html>
