<?php 

include_once 'config.php';

if(isset($_SESSION['user_id'])){
    echo "<script>location.replace('competitions.php')</script>";
}
else {
    echo "<script>location.replace('login.php')</script>";
}
?>
