<?php

	session_start();

	include("includes/data.php");
	
	

	$error = array();
	
	if(array_key_exists('submit', $_POST)){
	
		//to ensure that the user enters a username
		if(empty($_POST['username'])){
		
		$error[] = "Please enter your username";	
		} else {
			
		$username = mysqli_real_escape_string($db, $_POST['uname']);	
		}
		
		
		//to ensure that the user enters a password
		
		if(empty($_POST['pword'])){
			
		$error[] = "Please enter your password";	
		} else {
		
			$password = mysqli_real_escape_string($db, sha1($_POST['pword']));	
		}
		
		
		//if there's no error
		
		if(empty($error)){
			
			$query = mysqli_query($db, "SELECT * FROM admin WHERE username = '".$username."' AND 
			password = '".$password."'") or die(mysqli_error($db));
			
		if(mysqli_num_rows($query) == 1) { //if equal to 1
			
				
					/*while($row = mysqli_fetch_array($query)){ //while loop
					
					$_SESSION['id'] = $row['user_id'];
					$_SESSION['uname'] = $row['username'];
					header("Location: home.php");
					}  *///end of while loop
			
					
					$row = mysqli_fetch_array($query);
					
					$_SESSION['id'] = $row['admin_id'];
					$_SESSION['uname'] = $row['username'];
					header("Location: home.php");
					
		
		
		} else {
		
			$err = "Invalid Username and/or Password";
			header("Location: login.php?err=$err");			
			
		}   //if not equal to 1
			
		} else {
		
			foreach($error as $errors){
			
				echo $errors.'<br/>';	
				
			}
			
		}
		
		
	}
	

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>User Login</title>
</head>

<body>

	<h1>Admin Login</h1>
    <h3>Please enter your Username and Password</h3>
    
    
    <?php
	
		if(isset($_GET['err'])){
		
		$err = $_GET['err'];
		
		echo $err;	
		}
	
	?>
    
    <form action="login.php" method="post">
    
    	<p>Username: <input type="text" name="uname" /></p>
        <p>Password: <input type="password" name="pword"/></p>
        <input type="submit" name="submit" value="LOGIN"/>
    
    </form>


<hr/>

<!-- <video src="764202_10152999918365315_560412457_n.mp4" controls="controls" ></video> -->

</body>
</html>