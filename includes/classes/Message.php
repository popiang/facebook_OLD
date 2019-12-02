 <?php  

class Message {

	private $user;
	private $con;

	// constructor
	public function __construct($con, $user) {
		$this->con = $con;
		$this->user_obj = new User($con, $user);
	}	

	// get the other user of the most recent conversation
	public function getMostRecentUser() {

		$userLoggedIn = $this->user_obj->getUserName();

		$query = mysqli_query($this->con, "SELECT user_to, user_from FROM messages WHERE user_to='$userLoggedIn' OR user_from='$userLoggedIn' ORDER BY id DESC LIMIT 1");

		// if no message found
		if (mysqli_num_rows($query) == 0) {
			return false;
		}

		$row = mysqli_fetch_array($query);
		$user_to = $row['user_to'];
		$user_from= $row['user_from'];

		// return the other user of the most recent conversation
		if ($user_to != $userLoggedIn) {
			return $user_to;
		} else {
			return $user_from;
		}

	}

	// insert message into db
	public function sendMessage($user_to, $body, $date) {

		if ($body != "") {
			
			$userLoggedIn = $this->user_obj->getUserName();
			$query = mysqli_query($this->con, "INSERT INTO messages (user_to, user_from, body, date, opened, viewed, deleted) VALUES ('$user_to', '$userLoggedIn', '$body', '$date', 'no', 'no', 'no')");

		}

	}

	// get all the messages between two users
	public function getMessages($otherUser) {

		$userLoggedIn = $this->user_obj->getUserName();
		$data = "";

		// to turn off notification by setting opened to yes when user open the message 
		$query = mysqli_query($this->con, "UPDATE messages SET opened='yes' WHERE user_to='$userLoggedIn' AND user_from='$otherUser'");

		$get_messages_query = mysqli_query($this->con, "SELECT * FROM messages WHERE (user_to='$userLoggedIn' AND user_from='$otherUser') OR (user_from='$userLoggedIn' AND user_to='$otherUser')");

		while($row = mysqli_fetch_array($get_messages_query)) {
			
			$user_to = $row['user_to'];
			$user_from = $row['user_from'];
			$body = $row['body'];

			// toggle between color green and blue between logged in user and the other user
			$div_top = ($user_to == $userLoggedIn) ? "<div class='message' id='green'>" : "<div class='message' id='blue'>";

			// append the message
			$data = $data . $div_top . $body . "</div><br><br>";

		}

		return $data;

	}

	// get the latest message along with the timeframe message in an array
	public function getLatestMessage($userLoggedIn, $user_to) {

		// array will be used to store the result of this method
		$details_array = array();

		$query = mysqli_query($this->con, "SELECT body, user_to, date FROM messages WHERE (user_to='$userLoggedIn' AND user_from='$user_to') OR (user_to='$user_to' AND user_from='$userLoggedIn') ORDER BY id DESC LIMIT 1");

		$row = mysqli_fetch_array($query);
		$sent_by = ($row['user_to'] == $userLoggedIn) ? "They said: " : "You said: ";

		// timeframe 
		$date_time_now = date("Y-m-d H:i:s");	
		$start_date = new DateTime($row['date']);	// time of post
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

		// push data in array
		array_push($details_array, $sent_by);
		array_push($details_array, $row['body']);
		array_push($details_array, $time_message);

		return $details_array;

	}

	// get all the conversations of the logged in user
	public function getConvos() {

		$userLoggedIn = $this->user_obj->getUserName();
		$return_string = "";
		$convos = array();

		$query = mysqli_query($this->con, "SELECT user_to, user_from FROM messages WHERE user_to='$userLoggedIn' OR user_from='$userLoggedIn' ORDER BY id DESC");

		while($row = mysqli_fetch_array($query)) {

			$user_to_push = ($row['user_to'] != $userLoggedIn) ? $row['user_to'] : $row['user_from'];

			if (!in_array($user_to_push, $convos)) {
				array_push($convos, $user_to_push);
			}

		}

		// list all the conversation 
		foreach ($convos as $username) {

			$user_found_obj = new User($this->con, $username);
			$latest_message_details = $this->getLatestMessage($userLoggedIn, $username);

			$dots = (strlen($latest_message_details[1]) >= 12) ? "..." : "";
			$split = str_split($latest_message_details[1], 12);
			$split = $split[0] . $dots;

			$return_string .= " <a href='messages.php?u=$username'>
									<div class='user_found_messages'>
										<img src='" . $user_found_obj->getProfilePicPath() . "' style='border-radius:5px; margin-right:5px;'>
										" . $user_found_obj->getFirstAndLastName() . "
										<br>
										<span class='timestamp_smaller' id='grey'> " . $latest_message_details[2] . "</span>
										<p id='grey' style='margin:0;'>" . $latest_message_details[0] . $split . "</p>
							   		</div>
							    </a>";

		}

		return $return_string;

	}

	// create the list of dropdown of conversations in the navigation header message menu
	public function getConvosDropdown($data, $limit) {

		$page = $data['page'];
		$userLoggedIn = $this->user_obj->getUserName();
		$return_string = "";
		$convos = array();

		if ($page == 1) {
			$start = 0;
		} else {
			$start = ($page - 1) * $limit;
		}

		$set_viewed_query = mysqli_query($this->con, "UPDATE messages SET viewed='yes' WHERE user_to='$userLoggedIn'");

		$query = mysqli_query($this->con, "SELECT user_to, user_from FROM messages WHERE user_to='$userLoggedIn' OR user_from='$userLoggedIn' ORDER BY id DESC");

		while($row = mysqli_fetch_array($query)) {

			// pushing the user other than the one logged in
			$user_to_push = ($row['user_to'] != $userLoggedIn) ? $row['user_to'] : $row['user_from'];

			// push the user into an array if not pushed yet
			if (!in_array($user_to_push, $convos)) {
				array_push($convos, $user_to_push);
			}

		}

		// number of messages checked
		$num_interations = 0;

		// number of messages posted
		$count = 1;

		// list all the conversation 
		foreach ($convos as $username) {

			
			if($num_interations++ < $start)
				continue;

			if($count > $limit) 
				break;
			else 
				$count++;

			$is_unread_query = mysqli_query($this->con, "SELECT opened FROM messages WHERE user_to = '$userLoggedIn' AND user_from = '$username' ORDER BY id DESC");
			$row = mysqli_fetch_array($is_unread_query);
			$style = ($row['opened'] == 'no') ? "background-color: #DDEDFF;" : "";

			$user_found_obj = new User($this->con, $username);
			$latest_message_details = $this->getLatestMessage($userLoggedIn, $username);

			$dots = (strlen($latest_message_details[1]) >= 12) ? "..." : "";
			$split = str_split($latest_message_details[1], 12);
			$split = $split[0] . $dots;

			$return_string .= " <a href='messages.php?u=$username'>
									<div class='user_found_messages' style='" . $style . "'>
										<img src='" . $user_found_obj->getProfilePicPath() . "' style='border-radius:5px; margin-right:5px;'>
										" . $user_found_obj->getFirstAndLastName() . "
										
										<span class='timestamp_smaller' id='grey'> " . $latest_message_details[2] . "</span>
										<p id='grey' style='margin:0;'>" . $latest_message_details[0] . $split . "</p>
							   		</div>
							    </a>";

		}

		// if posts were loaded
		if($count > $limit)
			$return_string .= "<input type='hidden' class='nextPageDropdownData' value='" . ($page + 1) . "'><input type='hidden' class='noMoreDropdownData' value='false'>";
		else
			$return_string .= "<input type='hidden' class='noMoreDropdownData' value='true'><p style='text-align:center;'>No more messages to load</p>";

		return $return_string;		

	}

	// get the number of unread messages to be used in notification
	public function getUnreadNumber() {

		$userLoggedIn = $this->user_obj->getUserName();

		$query = mysqli_query($this->con, "SELECT * FROM messages WHERE viewed='no' AND user_to='$userLoggedIn'");

		return mysqli_num_rows($query);

	}

}

?>