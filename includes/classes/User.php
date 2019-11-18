 <?php  

class User {

	private $user;
	private $con;

	public function __construct($con, $user) {

		$this->con = $con;
		$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user'");
		$this->user = mysqli_fetch_array($user_details_query);

	}

	public function getUserObj() {
		return $this->user;
	}

	public function getUsername() {
		return $this->user['username'];
	}

	public function getNumPost() {
		return $this->user['num_posts'];
	}

	public function updatePostCount() {
		$num_posts = $this->getNumPost();
		$num_posts++;
		$username = $this->user['username'];
		mysqli_query($this->con, "UPDATE users SET num_posts = $num_posts WHERE username = '$username'");
	}

	public function getFirstAndLastName() {
		return $this->user['first_name'] . " " . $this->user['last_name'];
	}

	public function isClosed() {
		return $this->user['user_closed'] == 'yes' ? true : false;
	}

	public function isFriend($username_to_check) {

		$usernameComma = "," . $username_to_check . ",";

		if ((strstr($this->user['friends_array'], $usernameComma) || $username_to_check == $this->user['username'])) {
			return true;
		} else {
			return false;
		}
	}

	public function getProfilePicPath() {
		return $this->user['profile_pic'];
	}

	public function getFriendsArray() {
		return $this->user['friends_array'];
	}

	public function didReceiveRequest($user_from) {
		$user_to = $this->user['username'];
		$check_request_query = mysqli_query($this->con, "SELECT * FROM friend_requests WHERE user_to = '$user_to' and user_from = '$user_from'");
		if (mysqli_num_rows($check_request_query) > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function didSendRequest($user_to) {
		$user_from = $this->user['username'];
		$check_request_query = mysqli_query($this->con, "SELECT * FROM friend_requests WHERE user_to = '$user_to' and user_from = '$user_from'");
		if (mysqli_num_rows($check_request_query) > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function removeFriend($user_to_remove) {

		$logged_in_user = $this->user['username'];

		// to get user_to_remove friends array
		$query = mysqli_query($this->con, "SELECT friends_array FROM users WHERE username = '$user_to_remove'");
		$row = mysqli_fetch_array($query);
		$user_to_remove_friends_array = $row['friends_array'];

		// remove logged in user from user_to_remove friend
		$new_friends_array = str_replace("$user_to_remove" . ",", "", $this->user['friends_array']);
		$remove_friend_query = mysqli_query($this->con, "UPDATE users SET friends_array = '$new_friends_array' WHERE username = '$logged_in_user'");

		// remove user to remove from logged in user friends array
		$new_friends_array = str_replace("$logged_in_user" . ",", "", $user_to_remove_friends_array);
		$remove_friend_query = mysqli_query($this->con, "UPDATE users SET friends_array = '$new_friends_array' WHERE username = '$user_to_remove'");		

	}

	public function sendRequest($user_to) {

		$user_from = $this->user['username'];
		$query = mysqli_query($this->con, "INSERT INTO friend_requests (user_to, user_from) VALUES ('$user_to', '$user_from')");

	}

	public function getMutualFriends($user_to_check) {

		$mutualFriends = 0;
		$user_array = $this->user['friends_array'];
		$user_array_explode = explode(",", $user_array);

		$query = mysqli_query($this->con, "SELECT friends_array FROM users WHERE username='$user_to_check'");
		$row = mysqli_fetch_array($query);
		$user_to_check_array = $row['friends_array'];
		$user_to_check_array_explode = explode(",", $user_array);

		foreach ($user_array_explode as $i) {
			
			foreach ($user_to_check_array_explode as $j) {

				if ($i == $j && $i != "") {

					$mutualFriends++;

				}

			}

		}
		
		return $mutualFriends;

	}

	public function getNumberOfFriendRequest() {

		$username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT * FROM friend_requests WHERE user_to='$username'");
		
		return mysqli_num_rows($query);

	}

}


?>

















