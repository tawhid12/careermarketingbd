<?php
session_start();
if(isset($_GET['logout'])){
	session_destroy();
	HEADER('LOCATION:login.php');	
}
if(isset($_GET['logout']) && isset($_GET['page'])){
	session_destroy();
	HEADER('LOCATION:../index.php');	
}



?>