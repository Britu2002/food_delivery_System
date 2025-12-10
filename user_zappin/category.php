<?php include('../config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restaurants</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            /* background-color: #f8f9fa; */
            font-family: 'Poppins', sans-serif;
        }
        .restaurant-title {
            font-size: 2rem;
            font-weight: bold;
        }
        .restaurant-card {
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background: white;
            transition: transform 0.3s ease-in-out;
        }
        .restaurant-card:hover {
            transform: translateY(-5px);
        }
        .restaurant-card img {
            border-radius: 10px 10px 0 0;
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .restaurant-info {
            padding: 15px;
            text-align: center;
        }
        .restaurant-info h3 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .restaurant-info p {
            font-size: 0.9rem;
            color: #777;
        }
        .btn-view-menu {
            background: linear-gradient(to right, #fbbd08, #f28123);
            color: white;
            border-radius: 20px;
            padding: 8px 20px;
            text-transform: uppercase;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-view-menu:hover {
            background: linear-gradient(to right, #f28123, #fbbd08);
        }
    </style>
</head>
<body>
    <div class="container mt-5 mb-5">
        <div class="text-center">
            <h3 class="restaurant-title"><span class="text-warning">Explore</span> Restaurants</h3>
            <p class="text-muted"><i>Find restaurants serving your favorite meals!</i></p>
        </div>

        <div class="row mt-4">
            <?php
            if(isset($_GET['id'])){
                $id =$_GET['id'];
                $query = "select DISTINCT r.title,r.`addr`,r.city,r.resid,r.image,o_hr,c_hr,o_days,Working_status FROM product p left join restaurant r on r.resid =p.resid where p.categoryid=$id and  status='active'";
            }else{
                $query="select * from restaurant where status='active' ";
            }
         
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)):
            ?>

                <div class="col-md-3 mb-4">
                    <div class="restaurant-card">
                    <a href="foodresto.php?id=<?php echo $row['resid']; ?>" class="text-decoration-none">
                        <img src="/zaapin/admin/uploads/<?php echo $row['image']; ?>" alt="">
                        <div class="restaurant-info">
                            <h3 class="text-left "><?php echo $row['title']; ?></h3>
                            <p class="text-left p-1 m-0"><i class="fa-solid fa-location-dot"></i>
                            <?php 
        $full_address = $row['addr'] . ', ' . $row['city'];
        $short_address = (strlen($full_address) > 30) ? substr($full_address, 0, 27) . '...' : $full_address;
        echo $short_address; 
    ?>
                        </p>
                            <p class='text-left p-1 m-0'> <strong>Opening : </strong> <?php echo $row['o_days']; ?> (<?php echo $row['o_hr'] . ' - ' . $row['c_hr']; ?>)</p>
                            <p class='text-left <?php echo $row['Working_status']=="open"?"text-success":"text-danger" ?>'><strong><?php echo $row['Working_status']=="open"?"Open Now":"Closed Now" ?></strong> </p>
                      
                        </div>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>