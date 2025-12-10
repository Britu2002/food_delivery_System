<?php
session_start();
unset($_SESSION['user_id']);  
unset($_SESSION['address']); 
header("Location: index.php"); 
exit();
?>
