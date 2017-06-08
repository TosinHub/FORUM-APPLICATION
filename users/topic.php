<?php    #script 1.2  07/01/2015


	session_start();   //to start session
	
	//this is to include the db connection string
	include('include/included.php');
	page_protect();
	
	
	
	$user_id = $_SESSION['user_id'];
	$fname = $_SESSION['fname'];
	$level = $_SESSION['level'];
	
	/* $cate_id = $_SESSION['cat_id'];
	$cate_name = $_SESSION['category_name']; */

	if(isset($_GET['cat_id']) && isset($_GET['category_name'])) {
	$cate_id = $_GET['cat_id'];
	$cate_name = $_GET['category_name'];
	} 
	
	
	
	$link = mysqli_query($db, "SELECT * FROM topic_category") or die(mysqli_error($db));
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Topics</title>
<link href="css/style.css" rel="stylesheet" type="text/css"/>
</head>

<body>

	<div id="up">
    
    	<marquee><p>BU Interactive</p></marquee>
    
    </div>
	
	
    <?php
	
		// echo $user_id.'<br/>';
		echo '<p id="welcome">'."Logged in user: <span>".$fname.'</span></p>';
		//echo $cate_id.'<br/>';
		//echo $cate_name.'<br/>';
		
	
	?>
    
    <hr/>
    <div id="tab">
	<a href="home.php">Home</a>	
    <a href="help.php">Help Lines</a>
<?php
		
	
	while($ref = mysqli_fetch_array($link)){
		extract($ref);
	?>
    	
	<a href="topic.php?cat_id=<?php echo $category_id; ?>&category_name=<?php echo $category_name ?>"><?php echo $category_name ?></a>
    <?php
			
	}
	
	?>
	<br/>
	
    
    </div>

	<hr/>

	
	
	
	
	<p>Category Name: <?php echo '<p id="par2">'. $cate_name.'</p><br/>'; ?></p>
		
		
		
		
        
        
        
		<?php
			
			if($cate_name == "Campus News" && $level == 0){
				
			//echo "Hey, James";
			} else {   //test section
			
			
			$error = array();
			
			if(array_key_exists('message', $_POST)){
				
				if(empty($_POST['text'])){
					
					$error[] = "Please post a topic";	
				} else {
					
				$topic = mysqli_real_escape_string($db, $_POST['text']);	
				}
				
				if(empty($error)){
				
				$insert = mysqli_query($db, "INSERT INTO topic VALUES
															   (NULL,
															   '".$topic."',
															   '".$cate_id."',
															   '".$fname."',
															   NOW())") or die(mysqli_error($db));
															   
					$success = "Your comment has been posted";
					header("Location:topic.php?cat_id=$cate_id&category_name=$cate_name&success=$success");	
				} else {
				
					foreach($error as $er){
						echo $er;	
					}
				}
			}
		
		?>

	<form action="topic.php?cat_id=<?php echo $cate_id; ?>&category_name=<?php echo $cate_name ?>" method="post">
    
    	<p id="par1">Post a topic:<br/>
        	<textarea name="text" cols="20" rows="7"></textarea>
         </p>
    
    	<input type="submit" name="message" value="Post Topic"/>
    </form>


	
    
    
    
    
    
    
  <?php } //testing section ?>   
    
    
    <hr/>
    
    <?php
	
		$topic = mysqli_query($db, "SELECT * FROM topic WHERE category_id = '".$cate_id."'")or die(mysqli_error());
		
	?>
    
    
    	<table border="1">
        
        	<tr>
            <!-- <th>topic ID</th> --> <th>topic content</th><th>topic by</th><th>Date</th>
            </tr>
            
            <tr>
            	
                <?php
				
				while($result = mysqli_fetch_array($topic)){
			
			extract($result);	
		
				
				?>
            
            <!--	<td><?php //echo $result['topic_id']; ?></td> -->
<td><a href="comment.php?cat_id=<?php echo $cate_id?>&topic_id=<?php echo $result['topic_id']?>"><?php echo $result['topic_content']; ?></a></td>
                <td><?php echo $result['topic_by']; ?></td>
                <td><?php echo $result['date']; ?></td>
            
            </tr>
            
            <?php } ?>
        </table>


<br/>

<br/>
<a href="logout.php">Logout</a>
</body>
</html>