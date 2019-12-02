<?php  

include("../../config/config.php");
include("../classes/User.php");

// what is typed in the search field
$query = $_POST['query'];

// current logged in user
$userLoggedIn = $_POST['userLoggedIn'];

// splitted into an array
$names = explode(" ", $query);

if (strpos($query, "_") !== false) {	
	// when query is username
	$usersReturned = mysqli_query($con, "SELECT * FROM users WHERE username LIKE '$query%' AND user_closed='no' LIMIT 8");
} elseif (count($names) == 2) {
	// when query contains first name and last name
	$usersReturned = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '%$names[0]%' AND last_name LIKE '%$names[1]%') AND user_closed='no' LIMIT 8");
} else {
	// when query contains first name or last name
	$usersReturned = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '%$names[0]%' OR last_name LIKE '%$names[0]%') AND user_closed='no' LIMIT 8");
}

// if something is typed in the search field
if ($query != "") {
	
	while($row = mysqli_fetch_array($usersReturned)){

		$user = new User($con, $userLoggedIn);

		// get the number of mutual friends
		if($row['username'] != $userLoggedIn) {
			$mutual_friends = $user->getMutualFriends($row['username']) . " friends in common";
		} else {
			$mutual_friends = "";
		}

		// display only friends
		if ($user->isFriend($row['username'])) {
			echo "	<div class='resultDisplay'>
						<a href='messages.php?u=" . $row['username'] . "' style='color:#000;'>
							<div class='liveSearchProfilePic'>
								<img src='" . $row['profile_pic'] . "' >
							</div>
							<div class='liveSearchText'>
								" . $row['first_name'] . " " . $row['last_name'] .  "
								<p>" . $row['username'] . "</p>
								<p id='grey'>" . $mutual_friends . "</p>
							</div>
						</a>
					</div>";
		}

	}

}

?>