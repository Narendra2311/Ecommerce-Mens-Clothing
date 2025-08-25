<?php
session_start();
// Destroy the session
session_destroy();

// Redirect to the login page or any other appropriate page
header('location: ../adminlogin.php');
?>