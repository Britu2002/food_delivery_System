<?php
session_start();

if (isset($_SESSION['role']) && $_SESSION['role'] == "Admin") {
    session_unset();  // Sabhi session variables clear kar dega
    session_destroy(); // Puri session ko destroy kar dega
    header("Location: login.php"); // Redirect to login page
    exit();
} 
?>
