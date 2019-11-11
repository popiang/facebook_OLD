<?php  

require "config/config.php";
require "includes/forms_handler/register_handler.php";
require "includes/forms_handler/login_handler.php";

?>

<!DOCTYPE html>
<html>

<head>
	<title>Registration</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/register.js"></script>
</head>

<body>

	<?php  

	if (isset($_POST['register_button'])) {
		echo "

			<script>

				$(document).ready(function() {

					$('#first').hide();
					$('#second').show();

				});

			</script>

		";
	}

	?>

	<div class="wrapper">

		<div class="login_box">

			<section class="login_header">
				<h1>My Facebook</h1>
				Login or sign up below!
			</section>

			<div id="first">
				<form action="register.php" method="POST" id="login_form">
					<input type="email" name="log_email" placeholder="Email address" value="<?php if(isset($_SESSION['log_email'])) {echo $_SESSION['log_email']; } ?>" required>
					<br>
					<input type="password" name="log_password" placeholder="Password" required>
					<br>
					<?php if(in_array("Incorrect email or password!<br>", $error_array))
							echo "<span class='error_message'>Incorrect email or password!</span><br>"; ?>
					<input type="submit" name="login_button" value="Login">
					<br>
					<a href="#" id="signup" class="signup">Need an account? Register here!</a>
				</form>
			</div>

			<div id="second">
				<form action="register.php" method="POST" id="register_form">
					<input type="text" name="reg_fname" placeholder="First Name" value="<?php if(isset($_SESSION['reg_fname'])) {echo $_SESSION['reg_fname']; } ?>" required>
					<br>
					<?php if(in_array("Your firstname must be between 2 to 25 characters<br>", $error_array))
							echo "<span class='error_message'>Firstname must be between 2 to 25 characters</span><br>"; ?>

					<input type="text" name="reg_lname" placeholder="Last Name" value="<?php if(isset($_SESSION['reg_lname'])) {echo $_SESSION['reg_lname']; } ?>" required>
					<br>
					<?php if(in_array("Your lastname must be between 2 to 25 characters<br>", $error_array))
							echo "<span class='error_message'>Your lastname must be between 2 to 25 characters</span><br>"; ?>

					<input type="email" name="reg_email" placeholder="Email" value="<?php if(isset($_SESSION['reg_email'])) {echo $_SESSION['reg_email']; } ?>" required>
					<br>								

					<input type="email" name="reg_email2" placeholder="Confirm Email" value="<?php if(isset($_SESSION['reg_email2'])) {echo $_SESSION['reg_email2']; } ?>" required>
					<br>
					<?php if(in_array("Emails do not match<br>", $error_array)) echo "<span class='error_message'>Emails do not match</span><br>";
						  if(in_array("Invalid email format<br>", $error_array)) echo "<span class='error_message'>Invalid email format</span><br>";
						  if(in_array("Email is already in use<br>", $error_array)) echo "<span class='error_message'>Email is already in use</span><br>"; ?>		

					<input type="password" name="reg_password" placeholder="Password" required>
					<br>

					<input type="password" name="reg_password2" placeholder="Confirm Password" required="">
					<br>
					<?php if(in_array("Passwords do not match<br>", $error_array)) echo "<span class='error_message'>Passwords do not match</span><br>";
						  if(in_array("Password must only contains alphanumeric characters<br>", $error_array)) echo "<span class='error_message'>Password must only contains alphanumeric characters</span><br>";
						  if(in_array("Password must be between 2 to 30 characters<br>", $error_array)) echo "<span class='error_message'>Password must be between 2 to 30 characters</span><br>"; ?>								
					<input type="submit" value="Register" id="register_button" name="register_button">
					<br>
					<?php  if ($registration_successful) {	echo "<span>Registration successful!!</span>"; } ?>

					<a href="#" id="signin" class="signin">Already have an account? Sign in here!</a>
				
				</form>
			</div>

		</div>

	</div>

</body>
</html>