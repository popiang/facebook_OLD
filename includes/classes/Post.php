 <?php  

class Post {

	private $user;
	private $con;

	public function __construct($con, $user) {
		$this->con = $con;
		$this->user_obj = new User($con, $user);
	}

	// submit a post
	public function submitPost($body, $user_to) {

		// remove html tags
		$body = strip_tags($body);

		// remove any special character in the string
		$body = mysqli_real_escape_string($this->con, $body);

		// to preserve line breaks in post text
		$body = str_replace('\r\n', '\n', $body);
		$body = nl2br($body);

		// remove empty spaces
		$check_empty = preg_replace('/\s+/', '', $body);

		if ($check_empty != "") {
			
			// current date and time
			$date_added = date('Y-m-d H:i:s');

			// get username
			$added_by = $this->user_obj->getUsername();

			// if user is on own prfile, user_to is none
			if ($user_to == $added_by) {
				$user_to = 'none';
			}

			// insert post into table
			$insert_query = mysqli_query($this->con, "INSERT INTO posts (body, added_by, user_to, date_added, user_closed, deleted, likes) VALUES ('$body', '$added_by', '$user_to', '$date_added', 'no', 'no', 0)");

			// return the id of the saved post
			$returned_id = mysqli_insert_id($this->con);

			// insert notification

			// update post count
			$this->user_obj->updatePostCount();			

		}
	}

	// load all posts
	public function loadPostFriends($data, $limit) {

		$page = $data['page'];
		$userLoggedIn = $this->user_obj->getUsername();

		if($page == 1) {
			$start = 0;
		} else {
			$start = ($page - 1) * $limit;
		}

		$str = "";
		$data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE deleted = 'no' ORDER BY id DESC");

		if (mysqli_num_rows($data_query) > 0) {

			$num_iterations = 0;	// number of results checked (not necessarily posted)
			$count = 1;

			// iteration to get all the posts data and create the html element 
			while($row = mysqli_fetch_array($data_query)) {

				$id = $row['id'];
				$body = $row['body'];
				$added_by = $row['added_by'];
				$date_time = $row['date_added'];

				if ($row['user_to'] == 'none') {
					$user_to = "";
				} else {
					$user_to_obj = new User($this->con, $row['user_to']);
					$user_to_name = $user_to_obj->getFirstAndLastName();
					$user_to = "to <a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>";
				}

				$added_by_obj = new User($this->con, $added_by);

				// check for closed accounts
				if ($added_by_obj->isClosed()) {
					continue;
				}

				// check for friends then display only their posts
				$user_logged_obj = new User($this->con, $userLoggedIn);
				if(!$user_logged_obj->isFriend($added_by)) {
					continue;
				}

				if ($num_iterations++ < $start) {
					continue;
				}

				// once 10 posts have been loaded, break
				if ($count > $limit) {
					break;
				} else {
					$count++;
				}

				// inserting delete button if a post belongs to logged in user
				if($userLoggedIn == $added_by) {
					$delete_button = "<button class='delete_button btn-danger' id='post$id'>X</button>";
				} else {
					$delete_button = "";
				}

				$user_details = $added_by_obj->getUserObj();
				$first_name = $user_details['first_name'];
				$last_name = $user_details['last_name'];
				$profile_pic = $user_details['profile_pic'];

				?>

				<script>
					
					function toggle<?php echo $id; ?>() {

						var target = $(event.target);

						if(!target.is('a')) {

							var element = document.getElementById("toggleComment<?php echo $id; ?>");

							if (element.style.display == "block") {
								element.style.display = "none";
							} else {
								element.style.display = "block";
							}
						}
					}

				</script>

				<?php

				$comments_check = 

				// timeframe 
				$date_time_now = date("Y-m-d H:i:s");	
				$start_date = new DateTime($date_time);		// time of post
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

				// get number of comment for a post
				$commentsCount = $this->postCommentsCount($id);

				// create the html section to display all the posts and comments
				$str .= "<div class='status_post' onClick='javascript:toggle$id()'>
							<div class='post_profile_pic'>
								<img src='$profile_pic' width='50'>
							</div>

							<div class='posted_by' style='color:#ACACAC;'>
								<a href='$added_by'> $first_name $last_name </a> $user_to &nbsp;&nbsp;&nbsp;&nbsp; $time_message
								$delete_button
							</div>

							<div id='post_body'>
								$body
								<br>
								<br>
							</div>

							<div class='newsFeedPostOptions'>
								Comments($commentsCount)&nbsp;&nbsp;&nbsp;
								<iframe src='like.php?post_id=$id' scrolling='no'></iframe> 
							</div>

						</div>

						<div class='post_comment' id='toggleComment$id' style='display:none'>
							<iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
						</div>

						<hr>";

				?>

				<script>
					
					// js script to delete a post
					$(document).ready(function() {

						$('#post<?php echo $id; ?>').on('click', function(event) {

							bootbox.confirm("Are you sure want to delete this post?", function(result) {

								$.post("includes/forms_handler/delete_post.php?post_id=<?php echo $id; ?>", {result:result});

								if(result) {
									location.reload();
								}

							});

						});

					});

				</script>

				<?php

			}

			if ($count > $limit) {
				$str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
				<input type='hidden' class='noMorePosts' value='false'>";
			} else {
				$str .= "<input type='hidden' class='noMorePosts' value='true'>
				<p style='text-align:centre;'> No more posts to show! </p>";				
			}

		}

		echo $str;		
	}

	// load all posts
	public function loadProfilePosts($data, $limit) {

		$page = $data['page'];
		$profileUser = $data['profileUsername'];
		$userLoggedIn = $this->user_obj->getUsername();

		if($page == 1) {
			$start = 0;
		} else {
			$start = ($page - 1) * $limit;
		}

		$str = "";
		$data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE deleted = 'no' AND ((added_by='$profileUser' AND user_to='none') OR user_to='$profileUser') ORDER BY id DESC");

		if (mysqli_num_rows($data_query) > 0) {

			$num_iterations = 0;	// number of results checked (not necessarily posted)
			$count = 1;

			// iteration to get all the posts data and create the html element 
			while($row = mysqli_fetch_array($data_query)) {

				$id = $row['id'];
				$body = $row['body'];
				$added_by = $row['added_by'];
				$date_time = $row['date_added'];

				$added_by_obj = new User($this->con, $added_by);

				if ($num_iterations++ < $start) {
					continue;
				}

				// once 10 posts have been loaded, break
				if ($count > $limit) {
					break;
				} else {
					$count++;
				}

				// inserting delete button if a post belongs to logged in user
				if($userLoggedIn == $added_by) {
					$delete_button = "<button class='delete_button btn-danger' id='post$id'>X</button>";
				} else {
					$delete_button = "";
				}

				$user_details = $added_by_obj->getUserObj();
				$first_name = $user_details['first_name'];
				$last_name = $user_details['last_name'];
				$profile_pic = $user_details['profile_pic'];

				?>

				<script>
					
					function toggle<?php echo $id; ?>() {

						var target = $(event.target);

						if(!target.is('a')) {

							var element = document.getElementById("toggleComment<?php echo $id; ?>");

							if (element.style.display == "block") {
								element.style.display = "none";
							} else {
								element.style.display = "block";
							}
						}
					}

				</script>

				<?php

				$comments_check = 

				// timeframe 
				$date_time_now = date("Y-m-d H:i:s");	
				$start_date = new DateTime($date_time);		// time of post
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

				// get number of comment for a post
				$commentsCount = $this->postCommentsCount($id);

				// create the html section to display all the posts and comments
				$str .= "<div class='status_post' onClick='javascript:toggle$id()'>
							<div class='post_profile_pic'>
								<img src='$profile_pic' width='50'>
							</div>

							<div class='posted_by' style='color:#ACACAC;'>
								<a href='$added_by'> $first_name $last_name </a> &nbsp;&nbsp;&nbsp;&nbsp; $time_message
								$delete_button
							</div>

							<div id='post_body'>
								$body
								<br>
								<br>
							</div>

							<div class='newsFeedPostOptions'>
								Comments($commentsCount)&nbsp;&nbsp;&nbsp;
								<iframe src='like.php?post_id=$id' scrolling='no'></iframe> 
							</div>

						</div>

						<div class='post_comment' id='toggleComment$id' style='display:none'>
							<iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
						</div>

						<hr>";

				?>

				<script>
					
					// js script to delete a post
					$(document).ready(function() {

						$('#post<?php echo $id; ?>').on('click', function(event) {

							bootbox.confirm("Are you sure want to delete this post?", function(result) {

								$.post("includes/forms_handler/delete_post.php?post_id=<?php echo $id; ?>", {result:result});

								if(result) {
									location.reload();
								}

							});

						});

					});

				</script>

				<?php

			}

			if ($count > $limit) {
				$str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
				<input type='hidden' class='noMorePosts' value='false'>";
			} else {
				$str .= "<input type='hidden' class='noMorePosts' value='true'>
				<p style='text-align:centre;'> No more posts to show! </p>";				
			}

		}

		echo $str;		
	}

	// return the number of comments for a post
	public function postCommentsCount($id) {

		$query = mysqli_query($this->con, "SELECT * FROM comments WHERE post_id='$id'");
		$commentsCount = mysqli_num_rows($query);

		return $commentsCount;
	}
}


?>