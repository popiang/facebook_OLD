<?php  

include("includes/header.php");
// include("includes/classes/User.php");
// include("includes/classes/Post.php");

// checking if post submit button is pressed
if (isset($_POST['post'])) {

	$uploadOk = 1;
	$imageName = $_FILES['fileToUpload']['name'];
	$errorMessage = "";

	if ($imageName != "") {
		
		$targetDir = "assets/images/posts/";
		$imageName = $targetDir . uniqid() . basename($imageName);
		$imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);

		if ($_FILES['fileToUpload']['size'] > 1000000) {
			$errorMessage = "Sorry your file is too large";
			$uploadOk = 0;
		}

		if (strtolower($imageFileType) != "jpeg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpg") {
			$errorMessage = "Sorry, only jpeg, jpg and png files are allowed";
			$uploadOk = 0;
		}

		if ($uploadOk) {
			if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageName)) {
				// image uploaded
			} else {
				// image did not upload
				$uploadOk = 0;
			}
		}
	}

	if ($uploadOk) {

		// create post object
		$post = new Post($con, $userLoggedIn);

		// submitted the created post
		$post->submitPost($_POST['post_text'], 'none', $imageName);

		// direct again to index.php page
		header('Location: index.php');

	} else {
		echo "<div style='text-align:center' class='alert alert-danger'>
				$errorMessage
			  </div>";
	}

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

		<div class="main_column column">

			<form class="post_form" action="index.php" method="POST" enctype="multipart/form-data">
				<input type="file" name="fileToUpload" id="fileToUpload">
				<textarea name="post_text" id="post_text" placeholder="Got something to say?"></textarea>
				<input type="submit" name="post" id="post_button" value="Post">
			</form>
			
			<hr>

			<div class="post_area"></div>
			<img id="loading" src="assets/images/icons/loading.gif">

		</div>

		<div class="user_details column">
			
			<h4>Popular</h4>

			<div class="trends">
				
				<?php  

				$query = mysqli_query($con, "SELECT * FROM trends ORDER BY hits DESC LIMIT 9");

				foreach ($query as $row) {

					$word = $row['title'];
					$word_dot = strlen($word) >= 14 ? "..." : "";

					$trimmed_word = str_split($word, 14);
					$trimmed_word = $trimmed_word[0];

					echo "<div style='padding: 1px'>";
					echo $trimmed_word . $word_dot;
					echo "<br></div>";
						
				}

				?>

			</div>

		</div>

		<script>

		// handling infinite scrolling	
		$(function(){

				var userLoggedIn = '<?php echo $userLoggedIn; ?>';
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
						url: "includes/handlers/ajax_load_posts.php",
						type: "POST",
						data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
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