<?php
session_start();

session_destroy(); // Destroy the session

header('location: voter_login.php');
exit(); 
?>