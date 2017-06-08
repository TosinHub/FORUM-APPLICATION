<?php
session_start();   //to start session
	
	//this is to include the db connection string
	include('include/included.php');
	page_protect();
	
	
	
	$user_id = $_SESSION['user_id'];
	$fname = $_SESSION['fname'];
	
	
	$cate_id = $_GET['cat_id'];
	$topic_id = $_GET['topic_id'];

	
	$link = mysqli_query($db, "SELECT * FROM topic_category") or die(mysqli_error($db));

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Comments</title>
<link href="css/style.css" rel="stylesheet" type="text/css"/>
</head>

<body>

	<div id="up">
    
    	<marquee><p>BU Interactive</p></marquee>
    
    </div>

	
	<?php
	
		echo '<p id="welcome">'."Logged in user: <span>".$fname.'</span></p>';
		//echo "Logged in user: $fname"."<br/>";

		//echo "Categody ID: $cate_id <br/>";
		//echo "Topic ID: $topic_id";	
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
    </div>
	<hr/>


	<!-- this section is to display the subject being commented on -->
    
    <?php
	
		$content = mysqli_query($db, "SELECT topic_content FROM topic WHERE topic_id= '".$topic_id."'") or die(mysqli_error($db));
		
		while($response = mysqli_fetch_array($content)){
			extract($response);
			
		echo "Topic".'<p id="par2">'.$topic_content."</p>";
		}
	
	?>
    
    
    	<?php
			
			$error = array();
			
			if(array_key_exists('comment', $_POST)){
				
				if(empty($_POST['box'])){
					
					$error[] = "Please post a comment";	
				} else {
					
				$comment = mysqli_real_escape_string($db, $_POST['box']);	
				}
				
				if(empty($error)){
				
				$insert = mysqli_query($db, "INSERT INTO comment VALUES
															   (NULL,
															   '".$comment."',
															   '".$topic_id."',
															   '".$fname."',
															   NOW())") or die(mysqli_error());
															   
					$success = "Your comment has been posted";
					header("Location:comment.php?cat_id=$cate_id&topic_id=$topic_id&success=$success");	
				} else {
				
					foreach($error as $er){
						echo $er;	
					}
				}
			}
		
		?>
    
    
    
    <form action="comment.php?cat_id=<?php echo $cate_id ?>&topic_id=<?php echo $topic_id ?>" method="post">
    
    	<p id="par1">Post a comment:<br/>
        	<textarea name="box" cols="20" rows="7"></textarea>
         </p>
    
    	<input type="submit" name="comment" value="Post Comment"/>
    </form>

<hr/>

	 <?php
	
		$comment = mysqli_query($db, "SELECT * FROM comment WHERE topic_id = '".$topic_id."'")or die(mysqli_error($db));
		
	?>
    
    
    	<table border="1">
        
        	<tr>
            	<!-- <th>Comment ID</th> --> <th> Comments</th><th>comment by</th><th>Date</th>
            </tr>
            
            <tr>
            	
                <?php
				
				while($result = mysqli_fetch_array($comment)){
			
			extract($result);	
		
				
				?>
            
            	<!-- <td><?php //echo $result['comment_id']; ?></td>-->
				<td><?php echo $result['content']; ?></td>
                <td><?php echo $result['comment_by']; ?></td>
                <td><?php echo $result['date']; ?></td>
            
            </tr>
            
            <?php } ?>
        </table>
<br/>
<br/>

<a href="logout.php">Logout</a>
</body>
</html>