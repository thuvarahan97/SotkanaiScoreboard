<?php

include_once("db_config.php");

if(isset($_SESSION['user_id']))
{
	unset($_SESSION['user_id']);
	unset($_SESSION['firstname']);
	unset($_SESSION['lastname']);
	unset($_SESSION['username']);
    echo "<script>location.replace('login.php')</script>";
}
else {
    echo "<script>location.replace('competitions.php')</script>";
}

?>