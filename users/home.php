<?php    #script 1.2  07/01/2015


	session_start();   //to start session
	
	//this is to include the db connection string
	include('include/included.php');
	page_protect();
	
	
	
	$user_id = $_SESSION['user_id'];
	$fname = $_SESSION['fname'];
	$level = $_SESSION['level'];
	
	$link = mysqli_query($db, "SELECT * FROM topic_category") or die(mysqli_error($db));
	
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home</title>

<link href="css/style.css" rel="stylesheet" type="text/css"/>

</head>

<body>


	<div id="up">
    
    	<marquee><p>BU Interactive</p></marquee>
    
    </div>

	<?php
		
		echo '<p id="welcome">'."Welcome, <span>{$fname}</span> to <strong>BU Interactive</strong>. <br/>
		Please feel free to browse through the various links below to see what people <br/>
		in the University community are talking about.<br/>
		You can raise a topic if you so wish and you can as well contribute to<br/>
		what other people are saying where applicable.</p><hr/>";
		//echo $fname;
	?>
    
    <div id="tab">	
   
	<a href="home.php">Home</a>
    <a href="help.php">Help Lines</a>
	
	 <?php
	while($ref = mysqli_fetch_array($link)){
	
		//$_SESSION['cat_id'] = $ref['category_id'];
		//$_SESSION['category_name'] = $ref['category_name'];
		extract($ref);
	
	?>
    	
	
	<a href="topic.php?cat_id=<?php echo $category_id; ?>&category_name=<?php echo $category_name ?>"><?php echo $category_name ?></a>
    <?php
			
	}
	
	?>
</div>

<br/>

<a href="logout.php">Logout</a>
</body>
</html>