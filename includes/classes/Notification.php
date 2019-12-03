<?php  

class Notification {

	private $user;
	private $con;

	// constructor
	public function __construct($con, $user) {
		$this->con = $con;
		$this->user_obj = new User($con, $user);
	}	

	// get the number of unread notification
	public function getUnreadNumber() {

		$userLoggedIn = $this->user_obj->getUserName();

		$query = mysqli_query($this->con, "SELECT * FROM notifications WHERE viewed='no' AND user_to='$userLoggedIn'");

		return mysqli_num_rows($query);

	}

	// list out all the notifications of the logged in user
	public function getNotifications($data, $limit) {

		$page = $data['page'];
		$userLoggedIn = $this->user_obj->getUserName();
		$return_string = "";

		if ($page == 1) {
			$start = 0;
		} else {
			$start = ($page - 1) * $limit;
		}

		// set the notification for the logged in user as viewed
		$set_viewed_query = mysqli_query($this->con, "UPDATE notifications SET viewed='yes' WHERE user_to='$userLoggedIn'");

		// get all the notifications for the logged in user
		$query = mysqli_query($this->con, "SELECT * FROM notifications WHERE user_to='$userLoggedIn' ORDER BY id DESC");

		if (mysqli_num_rows($query) == 0) {
			echo "You have no notifications!";
			return;
		}

		// number of messages checked
		$num_interations = 0;

		// number of messages posted
		$count = 1;

		// list all the conversation 
		while ($row = mysqli_fetch_array($query)) {

			if($num_interations++ < $start)
				continue;

			if($count > $limit) 
				break;
			else 
				$count++;

			$user_from = $row['user_from'];

			// get the data of the user who the notification is from
			$user_data_query = mysqli_query($this->con, "SELECT * FROM users WHERE username = '$user_from'");
			$user_data = mysqli_fetch_array($user_data_query);

			// timeframe 
			$date_time_now = date("Y-m-d H:i:s");	
			$start_date = new DateTime($row['datetime']);	// time of post
			$end_date = new DateTime($date_time_now);		// current time
			$interval = $start_date->diff($end_date);		// different between the 2 dates

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

			$opened = $row['opened'];
			$style = ($row['opened'] == 'no') ? "background-color: #DDEDFF;" : "";

			$return_string .= " <a href='" . $row['link'] . "'>
									<div class='resultDisplay resultDisplayNotification' style='" . $style . "'>
										<div class='notificationsProfilePic'>
											<img src='" . $user_data['profile_pic'] . "' >
										</div>
										<p class='timestamp_smaller' id='grey'>" . $time_message . "</p>" . $row['message'] . "
									</div>
							    </a>";

		}

		// if posts were loaded
		if($count > $limit)
			$return_string .= "<input type='hidden' class='nextPageDropdownData' value='" . ($page + 1) . "'><input type='hidden' class='noMoreDropdownData' value='false'>";
		else
			$return_string .= "<input type='hidden' class='noMoreDropdownData' value='true'><p style='text-align:center;'>No more notifactions to load</p>";

		return $return_string;	

	}

	public function insertNotification($post_id, $user_to, $type) {

		$userLoggedIn = $this->user_obj->getUserName();
		$userLoggedInName = $this->user_obj->getFirstAndLastName();

		$date_time = date("Y-m-d H:i:s");

		switch ($type) {

			case 'comment':
				$message = $userLoggedInName . " commented on your post";
				break;

			case 'like':
				$message = $userLoggedInName . " liked on your post";
				break;

			case 'profile_post':
				$message = $userLoggedInName . " posted on your profile";
				break;
			
			case 'comment_non_owner':
				$message = $userLoggedInName . " commented on a post you commented on";
				break;

			case 'profile_comment':
				$message = $userLoggedInName . " commented on your profile post";
				break;

		}

		$link = "post.php?id=" . $post_id;

		$insert_query = mysqli_query($this->con, "INSERT INTO notifications (user_to, user_from, message, link, datetime, opened, viewed) VALUES ('$user_to', '$userLoggedIn', '$message', '$link', '$date_time', 'no', 'no')"); 

	}

}

?>