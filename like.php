<?php  

require "config/config.php";
include("includes/classes/User.php");
include("includes/classes/Post.php");
include("includes/classes/Notification.php");

// check if user is logged in
if (isset($_SESSION['username'])) {

	$data = $_SESSION['logged_in_user'];
	$userLoggedIn = $data['username'];
	$first_name = $data['first_name'];

} else {
	header("Location: register.php");
}

// post id sent by parent html element(post.php)
if (isset($_GET['post_id'])) {
	$post_id = $_GET['post_id'];
}

// get existing total likes for the post
$get_likes = mysqli_query($con, "SELECT likes, added_by FROM posts WHERE id='$post_id'");
$row = mysqli_fetch_array($get_likes);
$total_likes = $row['likes'];
$user_liked = $row['added_by']; 

// get existing total likes for the user
$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user_liked'");
$row = mysqli_fetch_array($user_details_query);
$total_user_likes = $row['num_likes'];

// if like button is pressed
if(isset($_POST['like_button'])) {

	// increment likes
	$total_likes++;
	$total_user_likes++;

	// update data in db
	$query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
	$user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
	$insert_query = mysqli_query($con, "INSERT INTO likes (username, post_id) VALUES ('$userLoggedIn', '$post_id')");	

	// insert notification
	// only when liking other users post
	if ($user_liked != $userLoggedIn) {
		$notification = new Notification($con, $userLoggedIn);
		$notification->insertNotification($post_id, $user_liked, "like");		
	}
}
	
// if unlike button is pressed
if(isset($_POST['unlike_button'])) {

	// decrement likes
	$total_likes--;
	$total_user_likes--;

	// update data in db
	$query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
	$user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
	$insert_query = mysqli_query($con, "DELETE FROM likes WHERE username='$userLoggedIn' AND post_id='$post_id'");	

}

// check for previous like
$check_query = mysqli_query($con, "SELECT * FROM likes WHERE username='$userLoggedIn' AND post_id='$post_id'");
$num_rows = mysqli_num_rows($check_query);
$post_id = trim($post_id);

// if previously liked, then will display dislike/unlike button
if($num_rows > 0) {

	// unlike button
	echo "<form action='like.php?post_id=$post_id' method='POST'>
				<input type='submit' class='comment_like' name='unlike_button' value='Unlike'>
				<div class='like_value'>
					" . $total_likes . " Likes
				</div>
	      </form>";

} else {

	// like button
	echo "<form action='like.php?post_id=$post_id' method='POST'>
				<input type='submit' class='comment_like' name='like_button' value='Like'>
				<div class='like_value'>
					" . $total_likes . " Likes
				</div>
	      </form>";

}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>

	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<style type="text/css">

		body {
			background-color: #fff;
			margin-top: 3px;
		}

		* {
			font-family: Arial, Helvetica, Sans-serif;
		}

	</style>

</head>
<body>


</body>
</html>