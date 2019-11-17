<?php  

include("includes/header.php");
// include("includes/classes/User.php");
// include("includes/classes/Post.php");
// include("includes/classes/Message.php");

$message_obj = new Message($con, $userLoggedIn);

if (isset($_GET['profile_username'])) {
	
	$username = $_GET['profile_username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
	
	// get the data of the profile owner
	$user_array = mysqli_fetch_array($user_details_query);

	// get the number of friends of the profile owner
	$num_friends = substr_count($user_array['friends_array'], ",") - 1;

}

// when remove friend button pressed
if (isset($_POST['remove_friend'])) {
	$user_to_remove = $username;
	$logged_in_user_obj = new User($con, $userLoggedIn);
	$logged_in_user_obj->removeFriend($user_to_remove);
}

// when add friend button pressed
if (isset($_POST['add_friend'])) {
	$user_to = $username;
	$logged_in_user_obj = new User($con, $userLoggedIn);
	$logged_in_user_obj->sendRequest($user_to);
}

// diverting to request.php page
if (isset($_POST['response_request'])) {
	header("Location: requests.php");
}

// when post message button pressed
if (isset($_POST['post_message'])) {

	// sending the message
	if (isset($_POST['message_body'])) {
		$body = mysqli_real_escape_string($con, $_POST['message_body']);
		$date = date('Y-m-d H:i:s');
		$message_obj->sendMessage($username, $body, $date);
	}

	?>

	<script>

		// to keep control in the same tab after post message button is pressed
		$(function() {

			$("#profileTabs a[href='#messages_div']").tab('show');

		});

	</script>

	<?php

}

?>

	<style type="text/css">
		
		.wrapper {
			margin-left: 0;
    		padding-left: 0;
		}

	</style>


		<div class="profile_left">
			
			<img src="<?php echo $user_array['profile_pic']; ?>">

			<div class="profile_info">
				
				<p><?php echo "Posts: " . $user_array['num_posts']; ?></p>
				<p><?php echo "Likes: " . $user_array['num_likes']; ?></p>
				<p><?php echo "Friends: " . $num_friends; ?></p>

			</div>

			<form action="<?php echo $username; ?>" method="POST">
				
				<?php  
				
				$profile_user_obj = new User($con, $username);

				if ($profile_user_obj->isClosed()) {
					header("Location: user_closed.php");
				}

				$logged_in_user_obj = new User($con, $userLoggedIn);

				if($userLoggedIn != $username) {

					if ($logged_in_user_obj->isFriend($username)) {
						echo "<input type='submit' name='remove_friend' class='danger' value='Remove Friend'><br>";
					} elseif ($logged_in_user_obj->didReceiveRequest($username)) {
						echo "<input type='submit' name='response_request' class='warning' value='Response to Request'><br>";
					} elseif ($logged_in_user_obj->didSendRequest($username)) {
						echo "<input type='submit' name='' class='default' value='Request Sent'><br>";
					} else {
						echo "<input type='submit' name='add_friend' class='success' value='Add Friend'><br>";
					}

				}
				
				?>

			</form>

			<input type="submit" class="deep_blue" data-toggle="modal" data-target="#post_form" value="Post Something">

			<?php  

				if ($userLoggedIn != $username) {
					
					echo "<div class='profile_info_bottom'>";
					echo $logged_in_user_obj->getMutualFriends($username) . " Mutual friends";
					echo "</div>";

				}

			?>

		</div>

		<div class="profile_main_column column">

			<ul class="nav nav-tabs" id="profileTabs" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="home-tab" data-toggle="tab" href="#newsfeed_div" role="tab" aria-controls="newsfeed_div" aria-selected="true">Newsfeed</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="profile-tab" data-toggle="tab" href="#about_div" role="tab" aria-controls="about_div" aria-selected="false">About</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="contact-tab" data-toggle="tab" href="#messages_div" role="tab" aria-controls="messages_div" aria-selected="false">Messages</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="newsfeed_div" role="tabpanel" aria-labelledby="home-tab">
					<div class="post_area"></div>
					<img id="loading" src="assets/images/icons/loading.gif">
				</div>
				<div class="tab-pane fade" id="about_div" role="tabpanel" aria-labelledby="profile-tab">
					
				</div>
				<div class="tab-pane fade" id="messages_div" role="tabpanel" aria-labelledby="contact-tab">
					
					<?php  

						echo "<h4>You and <a href='$username'>" . $profile_user_obj->getFirstAndLastName() . "</a></h4><hr><br>";
						echo "<div class='loaded_messages' id='scroll_message'>";
							echo $message_obj->getMessages($username);
						echo "</div>";

					?>

					<div class="message_post"> 	
						
						<form action="" method="POST">
							<textarea name='message_body' id='message_textarea' placeholder='Write you message..'></textarea>
							<input type='submit' name='post_message' class='info' id='message_submit' value='Send'>
						</form>

					</div>

					<script>
						
						// to scroll to the latest message
						$("a[data-toggle='tab']").on('shown.bs.tab', function() {
							var div = document.getElementById("scroll_message");
							div.scrollTop = div.scrollHeight;							
						});

					</script>

				</div>
			</div>

		</div>

		<!-- Modal -->
		<div class="modal fade" id="post_form" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">

					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Post something!</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>

					<div class="modal-body">
						
						<p>This will appear on the user's profile page and also their newsfeed for your friends to see!</p>

						<form class="profile_post" action="" method="POST">
							
							<div class="form-group">
								
								<textarea class="form-control" name="post_body"></textarea>

								<input type="hidden" name="user_from" value="<?php echo $userLoggedIn ?>">
								<input type="hidden" name="user_to" value="<?php echo $username ?>">

							</div>

						</form>

					</div>
						
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" name="post_button" id="submit_profile_post">Post</button>
					</div>

				</div>
			</div>
		</div>

		<script>

			// handling infinite scrolling	
			$(function(){

				var userLoggedIn = '<?php echo $userLoggedIn; ?>';
				var profileUsername = '<?php echo $username; ?>'
				var inProgress = false;
				loadPosts(); //Load first posts

				$(window).scroll(function() {
					var bottomElement = $(".status_post").last();
					var noMorePosts = $('.post_area').find('.noMorePosts').val();
					// isElementInViewport uses getBoundingClientRect(), which requires the HTML DOM object, not the jQuery object. The jQuery equivalent is using [0] as shown below.
					if (isElementInView(bottomElement[0]) && noMorePosts === 'false') {
						loadPosts();
					}
				});
				
				function loadPosts() {
				
					if(inProgress) { //If it is already in the process of loading some posts, just return
						return;
					}
				
					inProgress = true;
					$('#loading').show();
					var page = $('.post_area').find('.nextPage').val() || 1; //If .nextPage couldn't be found, it must not be on the page yet (it must be the first time loading posts), so use the value '1'
					
					$.ajax({
						url: "includes/handlers/ajax_load_profile_posts.php",
						type: "POST",
						data: "page=" + page + "&userLoggedIn=" + userLoggedIn + "&profileUsername=" + profileUsername,
						cache:false,
						success: function(response) {
							$('.post_area').find('.nextPage').remove(); //Removes current .nextpage
							$('.post_area').find('.noMorePosts').remove(); 
							$('.post_area').find('.noMorePostsText').remove();
							$('#loading').hide();
							$(".post_area").append(response);                                     
							inProgress = false;
						}
					});
				}
				
				//Check if the element is in view
				function isElementInView (el) {

					if(el == null) {
						return;
					}

					var rect = el.getBoundingClientRect();

					return (
						rect.top >= 0 &&
						rect.left >= 0 &&
						rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && 
						rect.right <= (window.innerWidth || document.documentElement.clientWidth) 
					);
				}
			});

		</script>

	</div>

</body>
</html>