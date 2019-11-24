<?php  

require "config/config.php";
include("includes/classes/Post.php");
include("includes/classes/User.php");
include("includes/classes/Message.php");
include("includes/classes/Notification.php");

// check if user is logged in
if (isset($_SESSION['username'])) { 

	// get logged in user details
	$data = $_SESSION['logged_in_user'];
	$userLoggedIn = $data['username'];
	$first_name = $data['first_name'];

} else { 							

	// direct user to register page if not logged in
	header("Location: register.php");
}

?>

<!DOCTYPE html>
<html>
<head>

	<title>Welcome to My Facebook</title>

	<!-- Font Awesome -->
	<script src="https://kit.fontawesome.com/c814600906.js" crossorigin="anonymous"></script>

	 <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> 

	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<!-- Custom Javascript -->
	<script src="assets/js/facebook.js"></script>

	<!-- Bootbox js -->
	<script src="assets/js/bootbox.min.js"></script>

	<script src="assets/js/jquery.jcrop.js"></script>
	<script src="assets/js/jcrop_bits.js"></script>
	<link rel="stylesheet" href="assets/css/jquery.Jcrop.css" type="text/css" />

</head>
<body>

	<header class="top_bar">

		<section class="logo">
			<a href="index.php">My Facebook</a>
		</section>

		<div class="search">
			
			<form action="search.php" method="GET" name="search_form">

				<input id="search_text_input" type="text" name="q" onkeyup="getLiveSearchUsers(this.value, '<?php echo $userLoggedIn ?>')" placeholder="Search..." autocomplete="off">

				<div class="button_holder">
					<img src="assets/images/icons/magnifying_glass.png">
				</div>
				

			</form><br>

			<div class="search_results">

			</div>

			<div class="search_results_footer_empty">

			</div>

		</div>

		<nav>

			<?php  

				// unread messages
				$messages = new Message($con, $userLoggedIn);
				$numMessages = $messages->getUnreadNumber();

				// unread notifications
				$notifications = new Notification($con, $userLoggedIn);
				$numNotifications = $notifications->getUnreadNumber();

				// number of friend requests
				$user_obj = new User($con, $userLoggedIn);
				$numRequest = $user_obj->getNumberOfFriendRequest();

			?>
			
			<a href=" <?php echo $data['username'] ?> ">
				<?php echo $first_name; ?>
			</a>
			<a href="index.php">
				<i class="fas fa-home"></i>
			</a>
			<a href="javascript:void(0)" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'message')">
				<i class="fas fa-envelope"></i>
				<?php
				
				if ($numMessages > 0) {
				  	echo "<span class='notification_badge' id='unread_message'>$numMessages</span>";
				}  
					
				?>
			</a>
			<a href="javascript:void(0)" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'notification')">
				<i class="far fa-bell"></i>
				<?php
				
				if ($numNotifications > 0) {
				  	echo "<span class='notification_badge' id='unread_notification'>$numNotifications</span>";
				}  
					
				?>				
			</a>
			<a href="requests.php">
				<i class="fas fa-users"></i>
				<?php
				
				if ($numRequest > 0) {
				  	echo "<span class='notification_badge' id='unread_request'>$numRequest</span>";
				}  
					
				?>					
			</a>
			<a href="#">
				<i class="fas fa-cog"></i>
			</a>
			<a href="includes/handlers/logout.php">
				<i class="fas fa-sign-out-alt"></i>
			</a>
		</nav>

		<div class="dropdown_data_window" style="height:0px; border:none;"></div>
		<input type="hidden" id="dropdown_data_type" value="">

	</header>

	<script>

	$(function(){
	 
			var userLoggedIn = '<?php echo $userLoggedIn; ?>';
			var dropdownInProgress = false;
	 
		    $(".dropdown_data_window").scroll(function() {
		    	var bottomElement = $(".dropdown_data_window a").last();
				var noMoreData = $('.dropdown_data_window').find('.noMoreDropdownData').val();
	 
		        // isElementInViewport uses getBoundingClientRect(), which requires the HTML DOM object, not the jQuery object. The jQuery equivalent is using [0] as shown below.
		        if (isElementInView(bottomElement[0]) && noMoreData == 'false') {
		            loadPosts();
		        }
		    });
	 
		    function loadPosts() {
		        if(dropdownInProgress) { //If it is already in the process of loading some posts, just return
					return;
				}
				
				dropdownInProgress = true;
	 
				var page = $('.dropdown_data_window').find('.nextPageDropdownData').val() || 1; //If .nextPage couldn't be found, it must not be on the page yet (it must be the first time loading posts), so use the value '1'
	 
				var pageName; //Holds name of page to send ajax request to
				var type = $('#dropdown_data_type').val();
	 
				if(type == 'notification')
					pageName = "ajax_load_notifications.php";
				else if(type == 'message')
					pageName = "ajax_load_messages.php";
	 
				$.ajax({
					url: "includes/handlers/" + pageName,
					type: "POST",
					data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
					cache:false,
	 
					success: function(response) {
	 
						$('.dropdown_data_window').find('.nextPageDropdownData').remove(); //Removes current .nextpage 
						$('.dropdown_data_window').find('.noMoreDropdownData').remove();
	 
						$('.dropdown_data_window').append(response);
	 
						dropdownInProgress = false;
					}
				});
		    }
	 
		    //Check if the element is in view
		    function isElementInView (el) {
		        var rect = el.getBoundingClientRect();
	 
		        return (
		            rect.top >= 0 &&
		            rect.left >= 0 &&
		            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && //* or $(window).height()
		            rect.right <= (window.innerWidth || document.documentElement.clientWidth) //* or $(window).width()
		        );
		    }
		});		

		/*
		var userLoggedIn = '<?php echo $userLoggedIn ?>';

		$(document).ready(function() {

			$(window).scroll(function() {

				var inner_height = $('.dropdown_data_window').innerHeight(); // div containing data
				var scroll_top = $('.dropdown_data_window').scrollTop();
				var page = $('.dropdown_data_window').find('.nextPageDropdownData').val();
				var noMoreData = $('dropdown_data_window').find('.noMoreDropdownData').val();

				if(((scroll_top + inner_height) >= $('.dropdown_data_window')[0].scrollHeight) && (noMoreData == 'false')) {

					var pageName; // holds name of page to send ajax request to
					var type = $('#dropdown_data_type').val();

					if(type == 'notification') {
						pageName = "ajax_load_notification.php";
					} else if(type == 'message') {
						pageName = "ajax_load_messages.php";
					}

					var ajaxReq = $.ajax({

						url: "includes/handlers/" + pageName,
						type: "POST",
						data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
						cache: false,

						success: function(response) {

							$('.dropdown_data_window').find('.nextPageDropdownData').remove();
							$('.dropdown_data_window').find('.noMoreDropdownData').remove();

							$('.dropdown_data_window').append(response);

						}

					});

				}

			});

		});
		*/

	</script>	

	<div class="wrapper">