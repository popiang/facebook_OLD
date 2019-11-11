<?php  

if (isset($_POST['login_button'])) {

	// remove all illegal characters from the email address
	$email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL);

	// save the login email in session
	$_SESSION['log_email'] = $email;

	// encrypt the password
	$password = md5($_POST['log_password']);

	// query user in db
	$check_database_query = mysqli_query($con, "SELECT * FROM users WHERE email = '$email' AND password = '$password'");
	$check_login_query = mysqli_num_rows($check_database_query);

	if($check_login_query == 1) {	// if user exist and username and password are correct

		$row = mysqli_fetch_array($check_database_query);
		$username = $row['username'];

		// save logged in user data in session
		$_SESSION['username'] = $username;
		$_SESSION['logged_in_user'] = $row;

		// set user_closed to 'no' if it is 'yes'
		if ($row['user_closed'] == 'yes') {
			mysqli_query($con, "UPDATE users SET user_closed = 'no' WHERE email = '$email'");
		}

		// direct to index.php page after login
		header("Location: index.php");
		exit;

	} else {						// if username & password are incorrect
		array_push($error_array, "Incorrect email or password!<br>");
	}

}

?>