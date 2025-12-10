<?php

$website_name="Zaapin";
$defaultadmin="admin@zappin.com";
$defaultpassword="admin123";
$conn =mysqli_connect("localhost:3307","root","","zaapin_db");
if(!$conn){
    die("error".mysqli_connect_error());

}
 ?>