<?php
	session_start();
	unset($_SESSION['user_id']);
	unset($_SESSION['fname']);
	
	header("Location:forum_login.php");

?>