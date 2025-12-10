<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Easy to Order - Zaapin</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    .order-step {
        display:flex;
        justify-content:center;
        align-items:center;
      margin: 0;
      font-family: 'Inter', sans-serif;
      width: 100vw;
      height:100vh;
      background-color: #051922;
      color: #fff;
      /* background-image: url('assets/img/pattern.png'); */
      background-size: cover;
    }

    h1 {
       
       padding-bottom:20px;
     color: #f9c89b;
     font-size: 32px;
     margin-bottom: 50px;
   }

    .container {
      text-align: center;
      /* padding: 80px 20px; */
    }

   

    .steps {
      display: flex;
      justify-content: center;
      gap: 80px;
      flex-wrap: wrap;
    }

    .step {
      max-width: 250px;
    }

    .step-icon {
      background-color: #2b2341;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      margin: 0 auto 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      color:rgb(246, 244, 250);
      border: 2px solid #c6b4f8;
    }

    .step-title {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .step-desc {
      font-size: 14px;
      color: #d3d3d3;
    }

    .footer {
      margin-top: 60px;
      font-size: 16px;
      color: #f5d3a4;
    }

    @media (max-width: 768px) {
      .steps {
        flex-direction: column;
        align-items: center;
      }
    }
  </style>
</head>
<body>
  <section class="order-step">
    <div class="container">
      <h1>Easy to Order</h1>
      <div class="steps">
        <div class="step">
          <div class="step-icon"><i class="fas fa-store"></i></div>
          <div class="step-title">Choose a restaurant</div>
          <div class="step-desc">We've got you covered with menus from a variety of delivery restaurants online.</div>
        </div>
        <div class="step">
          <div class="step-icon"><i class="fas fa-utensils"></i></div>
          <div class="step-title">Choose a dish</div>
          <div class="step-desc">We've got you covered with a variety of delivery restaurants online.</div>
        </div>
        <div class="step">
          <div class="step-icon"><i class="fas fa-motorcycle"></i></div>
          <div class="step-title">Pick up or Delivery</div>
          <div class="step-desc">Get your food delivered! And enjoy your meal!</div>
        </div>
      </div>
      <div class="footer">Cash on Delivery</div>
    </div>
  </section>

  
</body>
</html>
