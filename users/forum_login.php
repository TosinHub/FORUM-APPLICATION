
<?php
	#script 1.2  07/01/2015
	
	session_start();
	
	include('include/db.php');


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BU SAT Forum</title>
<link href="css/style.css" rel="stylesheet" type="text/css"/>
</head>

<body>

	<div id="up">
    
    	<marquee><p>BU Interactive</p></marquee>
    
    </div>

<div id="container">
	
    <div id="text">
    <h1>BU Interactive</h1>
    <p>....improving knowledge and information sharing among students</p>
    </div>
    
 <div id="form">
  <div id="login">
    
  <!--  <p id="par">User Login</p> -->
    <p class="note">Please enter your matric number and password</p> 
    
    	<?php
		
			//to authenticate the user
			
			$error = array();
			
			if(array_key_exists('login', $_POST)){
			
					
					
					if(empty($_POST['matric'])){
						
					$error[] = "Please Enter Your Matric Number";	
					} else {
					$matric = mysqli_real_escape_string($db, $_POST['matric']);	
					}
					
					
					if(empty($_POST['pword'])){
						
						$error[] = "Please Enter Your Password";
					} else {
					
						$pword = mysqli_real_escape_string($db, $_POST['pword']);	
					}
					
					if(empty($error)){
						
			$query = mysqli_query($db, "SELECT * FROM user WHERE matric= '".$matric."' AND password= '".sha1($pword)."'")or die(mysqli_error($db));
						
						
						if(mysqli_num_rows($query) == 1){
							
							while($row = mysqli_fetch_array($query)){
								
								$_SESSION['user_id'] = $row['user_id'];
								$_SESSION['fname'] = $row['firstName'];
								$_SESSION['level'] = $row['user_level'];
								header("Location: home.php");
							}
							
						} else {
							
							$invalid = "Invalid matric number and/or password. Please try again";
							header("Location: forum_login.php?invalid=$invalid");	
						}
						
						
					} else {
					
						foreach($error as $err){
							
						echo '<p class="error">*'.$err.'</p>';	
						}
						
					}
				
			}
		
		if(isset($_GET['invalid'])){
			
				$invalid = $_GET['invalid'];
				echo '<p class="error">*'.$invalid."</p>";	
				
			}
		
		?>
    
    <!-- This Form is for registered users to login -->    
    <form action="forum_login.php" method="post">
    
    <p class="form1">Matric Number: <input type="text" name="matric"/></p>
    <p class="form1">Password:
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <input type="password" name="pword"/></p>
    <input type="submit" name="login" value="Login"/>
	
    </form>
    </div> <!-- end of login div -->
    
   <!-- <hr/> -->
    
    <div id="signup">
    <p class="note">New User? Register Here</p>
    
    
    
    	<?php
		// HERE IS VALIDATING THE SIGNUP FORM
			$wrong = array();
			
			if(array_key_exists('register', $_POST)){
				
				if(empty($_POST['firstname'])){
					
					$wrong[] = "Please Enter your Firstname";	
				} else {
				
				$firstname = mysqli_real_escape_string($db, $_POST['firstname']);	
				}
				
				
				if(empty($_POST['lastname'])){
					
					$wrong[] = "Please Enter your lastname";	
				} else {
				
				$lastname = mysqli_real_escape_string($db, $_POST['lastname']);	
				}
				
				if(empty($_POST['matnum'])){
					
					$wrong[] = "Please Enter your Matric Number";	
				} else {
				
				$matnum = mysqli_real_escape_string($db, $_POST['matnum']);	
				}
				
				
				if(empty($_POST['password'])){
					
					$wrong[] = "Please Enter your Password";	
				} else {
				
				$password = mysqli_real_escape_string($db, $_POST['password']);	
				}
				
				if(empty($wrong)){
				
			
			//THE QUERY BELOW IS TO CHECK THAT THE DETAILS SUPPLIED BY THE USER DOESN'T ALREADY EXIST IN OUR DATABASE
			
			$check = mysqli_query($db, "SELECT * FROM user WHERE matric = '".$matnum."' || password = '".sha1($password)."'") or die(mysqli_error);
			
				if(mysqli_num_rows($check) == 0){ //WHICH IS THE IDEAL THING
					
					$insert = mysqli_query($db, "INSERT INTO user VALUES (NULL,
																	'".$firstname."',
																	'".$lastname."',
																	'".$matnum."',
																	'".sha1($password)."',
																	NOW(),
																	0)") or die(mysqli_error($db));
						$reg = "You have been registered";
						header("Location:forum_login.php?reg=$reg");
					
				} else { //WHICH IS NOT IDEAL
					
					$incorrect = "Matric Number or Password already exists";
					header("Location:forum_login.php?incorrect=$incorrect");	
					
				}
					
				} else {
					
					foreach($wrong as $wrongs){
					
						echo '<p class="error">*'.$wrongs.'</p>';	
					}
				}
				
			}
		
		
			if(isset($_GET['incorrect'])){
			$incorrect = $_GET['incorrect'];
			echo '<p class="error">'.$incorrect."</p>";		
			}
		
			if(isset($_GET['reg'])){
			
				$register = $_GET['reg'];
				echo '<p class="error">'.$register."</p>";	
				
			}
		
		?>
    
    <form action="forum_login.php" method="post">
    
    	<p class="form2">Firstname: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" name="firstname" value="<?php if(isset($_POST['firstname'])){echo $_POST['firstname'];} ?>"/></p>
        <p class="form2">Lastname: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" name="lastname" value="<?php if(isset($_POST['lastname'])){echo $_POST['lastname'];} ?>"/></p>
        <p class="form2">Matric Number: &nbsp;
        <input type="text" name="matnum" value="<?php if(isset($_POST['matnum'])){echo $_POST['matnum'];} ?>"/></p>
        <p class="form2">Password: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="password" name="password"/></p>
        <input type="submit" name="register" value="Regsiter"/>
    
    </form>

	</div><!-- end of signup div -->
    
    
    </div><!-- end of form div -->
    

</div><!-- end of container div -->

</body>
</html>