<?php  

include("includes/header.php");

if (isset($_GET['id'])) {
	$id = $_GET['id'];
} else {
	$id = 0;
}

?>

<div class="user_details column">
			
	<a href=" <?php echo $data['username'] ?> "><img src=" <?php echo $data['profile_pic'] ?> "></a>
	
	<div class="user_details_left_right">
	
		<a href=" <?php echo $data['username'] ?> ">
		<?php 
			echo $data['first_name'] . " " . $data['last_name']; 
		?>
		</a>

		<?php 
			echo "Posts: " . $data['num_posts'] . "<br>"; 
			echo "Likes: " . $data['num_likes'];
		?>
	
	</div>

</div>

<div class="main_column column" id="main_column">
	
	<div class="posts_area">

		<?php  
			$post = new Post($con, $userLoggedIn);
			$post->getSinglePost($id);
		?>
		
	</div>

</div>