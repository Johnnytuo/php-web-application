<?php 
require '../../config/config.php';
	
	if(isset($_GET['post_id']))
		$post_id = $_GET['post_id'];

	if(isset($_POST['result'])) {

		if($_POST['result'] == 'true'){
			
			$query = mysqli_query($con, "UPDATE posts SET deleted='yes' WHERE id='$post_id'");
			$post_query = mysqli_query($con, "SELECT * FROM posts WHERE id='$post_id'");
			$row = mysqli_fetch_array($post_query);
			$added_by=$row['added_by'];
			$user_query = mysqli_query($con, "SELECT * FROM users WHERE username='$added_by'");
			$row2 = mysqli_fetch_array($user_query);
			$num_posts=$row2['num_posts'];
			$num_posts--;
			$update_query = mysqli_query($con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");
		}
			
			
	}

?>