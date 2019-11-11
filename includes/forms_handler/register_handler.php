<?php 

// declaring variables to prevent errors
$fname = "";		// first name
$lname = "";		// last name
$em = "";			// email
$em2 = "";			// email 2
$password = "";		// password
$password2 = "";	// password 2
$date = "";			// sign up date
$error_array = "";	// holds error messages
$registration_successful = false; 

$error_array = array();

if (isset($_POST['register_button'])) {

	// registration form values

	// first name
	$fname = strip_tags($_POST['reg_fname']);	// remove html tags
	$fname = str_replace(' ', '', $fname);		// remove spaces
	$fname = ucfirst(strtolower($fname));		// uppercase first letter
	$_SESSION['reg_fname'] = $fname;			// store value in session

	// last name
	$lname = strip_tags($_POST['reg_lname']);	// remove html tags
	$lname = str_replace(' ', '', $lname);		// remove spaces
	$lname = ucfirst(strtolower($lname));		// uppercase first letter
	$_SESSION['reg_lname'] = $lname;			// store value in session

	// email
	$em = strip_tags($_POST['reg_email']);		// remove html tags
	$em = str_replace(' ', '', $em);			// remove spaces
	$_SESSION['reg_email'] = $em;				// store value in session

	// email2
	$em2 = strip_tags($_POST['reg_email2']);	// remove html tags
	$em2 = str_replace(' ', '', $em2);			// remove spaces
	$_SESSION['reg_email2'] = $em2;				// store value in session

	// password
	$password = strip_tags($_POST['reg_password']);		// remove html tags
	$password2 = strip_tags($_POST['reg_password2']);	// remove html tags

	// date
	$date = date("Y-m-d");						// get current date

	// check if emails match
	if ($em == $em2) {

		// check if email is valid format
		if (filter_var($em, FILTER_VALIDATE_EMAIL)) {

			// check if email is already in use
			$em_check = mysqli_query($con, "SELECT * FROM users WHERE email = '$em'");

			$num_rows = mysqli_num_rows($em_check);

			if ($num_rows > 0) {
				array_push($error_array, "Email is already in use<br>");
			}

		} else {
			array_push($error_array, "Invalid email format<br>");
		}

	} else {
		array_push($error_array, "Emails do not match<br>");
	}

	if (strlen($fname) < 2 || strlen($fname) > 25) {
		array_push($error_array, "Your firstname must be between 2 to 25 characters<br>");
	}

	if (strlen($lname) < 2 || strlen($lname) > 25) {
		array_push($error_array, "Your lastname must be between 2 to 25 characters<br>");
	}

	if ($password != $password2) {
		array_push($error_array, "Passwords do not match<br>");
	} else if(!preg_match('/^[A-Za-z0-9]/', $password)) {
		array_push($error_array, "Password must only contains alphanumeric characters<br>");	
	}

	if (strlen($password) < 2 || strlen($password) > 30) {
		array_push($error_array, "Password must be between 2 to 30 characters<br>");
	}

	if (empty($error_array)) {
		
		// encrypt the password
		$password = md5($password);

		// create username for user
		$username = strtolower($fname . "_" . $lname);

		// checking if username already exist
		$check_username = mysqli_query($con, "SELECT * FROM users WHERE username = '$username'");
		$i = 0;
		while(mysqli_num_rows($check_username) != 0) {

			$i++;
			$temp_username = $username;
			$temp_username = $temp_username . "_" . $i;

			$check_username = mysqli_query("SELECT * FROM users WHERE username = '$temp_username'");

		}

		$default_profile_pics = array('head_alizarin.png', 'head_amethyst.png', 'head_belize_hole.png', 'head_carrot.png', 'head_deep_blue.png', 'head_emerald.png', 'head_green_sea.png', 'head_nephritis.png', 'head_pete_river.png', 'head_pomegranate.png', 'head_pumpkin.png', 'head_red.png', 'head_sun_flower.png', 'head_turqoise.png', 'head_wet_asphalt.png', 'head_wisteria.png');

		$rand = rand(0, 15);

		// assign random default profile pic to users
		$profile_pic = "assets/images/profile_pic/default/" . "$default_profile_pics[$rand]";

		// insert the registering user into db
		$query = mysqli_query($con, "INSERT INTO users (first_name, last_name, username, email, password, signup_date, profile_pic, num_posts, num_likes, user_closed, friends_array) values ('$fname', '$lname', '$username', '$em', '$password', '$date', '$profile_pic', 0, 0, 'no', ',')");

		// delete session values once registration successful
		$_SESSION['reg_fname'] = "";
		$_SESSION['reg_lname'] = "";
		$_SESSION['reg_email'] = "";
		$_SESSION['reg_email2'] = "";

		if(sizeof($error_array) == 0) {
			$registration_successful = true;
		}
	}
}

?>