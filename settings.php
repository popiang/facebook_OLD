<?php  

include("includes/header.php");
include("includes/forms_handler/settings_handler.php");

?>

<div class="main_column column">
	
	<h4>Account Settings</h4>
	<?php  
	echo "<img src='" . $data['profile_pic'] . "' id='small_profile_pic'";
	?>
	<br><br>
	<a href="upload.php">Upload new profile picture</a>
	<br><br><br>

	<h4>Update Details</h4>

	<form action="settings.php" method="POST">
		
		First Name: <input type="text" name="first_name" value="<?php echo $data['first_name'] ?>" class="settings_input"><br>
		Last Name: <input type="text" name="last_name" value="<?php echo $data['last_name'] ?>" class="settings_input"><br>
		Email: <input type="text" name="email" value="<?php echo $data['email'] ?>" class="settings_input"><br>

		<?php echo $message; ?>

		<input type="submit" name="update_details" id="save_details" value="Update Details" class="info settings_submit">

	</form><br>

	<h4>Change Password</h4>

	<form action="settings.php" method="POST">
		
		Old Password: <input type="password" name="old_password" class="settings_input"><br>
		New Password: <input type="password" name="new_password_1" class="settings_input"><br>
		New Password Again: <input type="password" name="new_password_2" class="settings_input"><br>

		<?php echo $password_message; ?>

		<input type="submit" name="update_password" id="save_details" value="Update Password" class="info settings_submit">

	</form><br>

	<h4>Close Account</h4>
	<form action="settings.php" method="POST">
		<input type="submit" name="close_account" id="close_account" value="Close Account" class="danger settings_submit">
	</form>

</div>