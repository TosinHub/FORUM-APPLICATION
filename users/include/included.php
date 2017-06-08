<?php

	include('db.php');
	
	function page_protect(){
	
	if(!isset($_SESSION['user_id']) && !isset($_SESSION['fname'])) {
			
			header("Location:forum_login.php");
		}
	
	/*	if(isset($_SESSION['admin_id']) && isset($_SESSION['username'])) {
			
		session_start();	
		} elseif(!isset($_SESSION['admin_id']) && !isset($_SESSION['username'])) {
			
			header("Location:eee.php");
		} */
		
		
	}


?>