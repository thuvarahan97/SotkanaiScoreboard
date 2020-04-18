<?php 

include_once 'config.php';
session_start();
date_default_timezone_set("Asia/Colombo");

if(isset($_SESSION['user_id'])){
    echo "<script>location.replace('competitions.php')</script>";
}
else {
    echo "<script>location.replace('login.php')</script>";
}
?>
