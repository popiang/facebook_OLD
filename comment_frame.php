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

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>

	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>
<body>

	<style type="text/css">
		* {
			font-size: 12px;
			font-family: Arial, Helvetica, Sans-serif;
			line-height: 1.5;
		}
	</style>

	<script>
		
		function toggle() {

			var element = document.getElementById('comment_section');

			if(element.style.display == 'block')
				element.style.display = 'none';
			else
				element.style.display = 'block';

		}

	</script>

	<?php  

	// get the post id sent by parent html element(post.php)
	if (isset($_GET['post_id'])) {
		$post_id = $_GET['post_id'];
	}

	$user_query = mysqli_query($con, "SELECT added_by, user_to FROM posts WHERE id='$post_id'");
	$row = mysqli_fetch_array($user_query);

	$posted_to = $row['added_by'];
	$user_to = $row['user_to'];

	// if post comment button is pressed
	if (isset($_POST['postComment' . $post_id])) {
		$post_body = $_POST['post_body'];
		$post_body = mysqli_escape_string($con, $post_body);
		$date_time_now = date('Y-m-d H:i:s');
		$insert_post = mysqli_query($con, "INSERT INTO comments (post_body, posted_by, posted_to, date_added, removed, post_id) VALUES ('$post_body', '$userLoggedIn', '$posted_to', '$date_time_now', 'no', '$post_id')");

		// insert notification
		if ($posted_to != $userLoggedIn) {
			$notification = new Notification($con, $userLoggedIn);
			$notification->insertNotification($post_id, $posted_to, "comment");		
		} 

		if($user_to != 'none' && $user_to != $userLoggedIn) {
			$notification = new Notification($con, $userLoggedIn);
			$notification->insertNotification($post_id, $user_to, "profile_comment");	
		}

		$get_commenters = mysqli_query($con, "SELECT * FROM comments WHERE post_id = '$post_id'");
		$notified_users = array();

		while($row = mysqli_fetch_array($get_commenters)) {

			if ($row['posted_by'] != $posted_to && $row['posted_by'] != $user_to
				&& $row['posted_by'] != $userLoggedIn && !in_array($row['posted_by'], $notified_users)) {

				$notification = new Notification($con, $userLoggedIn);
				$notification->insertNotification($post_id, $row['posted_by'], "comment_non_owner");	

				array_push($notified_users, $row['posted_by']);

			}

		}

		echo "<p>Comment posted!</p>";
	}

	?>

	<!-- comment form -->
	<form 	id="comment_form" 
			name="postComment<?php echo $post_id; ?>" 
			action="comment_frame.php?post_id=<?php echo $post_id; ?>" 
			method="POST">

			<textarea name="post_body"></textarea>
			<input type="submit" name="postComment<?php echo $post_id ?>" value="Post">
		
	</form>

	<!-- load comment -->
	<?php

	// get all the comments for the post
	$get_comments_query = mysqli_query($con, "SELECT * FROM comments WHERE post_id='$post_id' ORDER BY id ASC");
	$count = mysqli_num_rows($get_comments_query);

	// if there's any comment
	if ($count != 0) {

		// iterate to get all the comments data and create the html element
		while($comment = mysqli_fetch_array($get_comments_query)) {

			// get all the data of the comment
			$comment_body = $comment['post_body'];
			$posted_to = $comment['posted_to'];
			$posted_by = $comment['posted_by'];
			$date_added = $comment['date_added'];
			$remove = $comment['removed'];

			// time frame
			$date_time_now = date("Y-m-d H:i:s");	
			$start_date = new DateTime($date_added);		// time of post
			$end_date = new DateTime($date_time_now);	// current time
			$interval = $start_date->diff($end_date);	// different between the 2 dates

			if ($interval->y >= 1) {
				if ($interval->y == 1) {
					$time_message = $interval->y . " year ago";
				} else {
					$time_message = $interval->y . " years ago";
				}
			} elseif ($interval->m >= 1) {
				if ($interval->d == 0) {
					$days = " ago";
				} elseif ($interval->d == 1) {
					$days = $interval->d . " day ago";
				} elseif ($interval->d > 1) {
					$days = $interval->d . " days ago";
				}

				if ($interval->m == 1) {
					$time_message = $interval->m . " month " . $days;
				} elseif ($interval->m > 1) {
					$time_message = $interval->m . " months " . $days;
				}
			} elseif ($interval->d >= 1) {
				if ($interval->d == 1) {
					$time_message = "Yesterday";
				} else {
					$time_message = $interval->d . " days ago";
				}
			} elseif ($interval->h >= 1) {
				if ($interval->h == 1) {
					$time_message = $interval->h . " hour ago";
				} else {
					$time_message = $interval->h . " hours ago";
				}
			} elseif ($interval->i >= 1) {
				if ($interval->i == 1) {
					$time_message = $interval->i . " minute ago";
				} else {
					$time_message = $interval->i . " minutes ago";
				}
			} else {
				if ($interval->s < 30) {
					$time_message = "Just now";
				} else {
					$time_message = $interval->s . " seconds ago";
				}
			}		
			
			$user_obj = new User($con, $posted_by);	

			?>

			<div class="comment_section">
				<a href="<?php echo $posted_by ?>" target="_parent"><img src="<?php echo $user_obj->getProfilePicPath(); ?>" title="<?php echo $posted_by; ?>" style="float:left" height="30px"></a>
				<a href="<?php echo $posted_by ?>" target="_parent"><b><?php echo $user_obj->getFirstAndLastName(); ?></b></a>
				&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $time_message . "<br>" . $comment_body ?>
				<hr>
			</div>

			<?php  

		}
	} else {
		echo "<center><br><br>No comments to show!</center>";
	}

	?>




</body>
</html>


