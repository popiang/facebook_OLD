<?php  

require "config/config.php";

// check if user is logged in
if (isset($_SESSION['username'])) { 

	// get logged in user details
	$data = $_SESSION['logged_in_user'];
	$userLoggedIn = $data['username'];
	$first_name = $data['first_name'];

} else { 							

	// direct user to register page if not logged in
	header("Location: register.php");
}

?>

<!DOCTYPE html>
<html>
<head>

	<title>Welcome to My Facebook</title>

	<!-- Font Awesome -->
	<script src="https://kit.fontawesome.com/c814600906.js" crossorigin="anonymous"></script>

	 <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> 

	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<!-- Custom Javascript -->
	<script src="assets/js/facebook.js"></script>

	<!-- Bootbox js -->
	<script src="assets/js/bootbox.min.js"></script>

	<script src="assets/js/jquery.jcrop.js"></script>
	<script src="assets/js/jcrop_bits.js"></script>
	<link rel="stylesheet" href="assets/css/jquery.Jcrop.css" type="text/css" />

</head>
<body>

	<header class="top_bar">

		<section class="logo">
			<a href="index.php">My Facebook</a>
		</section>

		<nav>
			<a href=" <?php echo $data['username'] ?> ">
				<?php echo $first_name; ?>
			</a>
			<a href="index.php">
				<i class="fas fa-home"></i>
			</a>
			<a href="javascript:void(0)" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'message')">
				<i class="fas fa-envelope"></i>
			</a>
			<a href="#">
				<i class="far fa-bell"></i>
			</a>
			<a href="requests.php">
				<i class="fas fa-users"></i>
			</a>
			<a href="#">
				<i class="fas fa-cog"></i>
			</a>
			<a href="includes/handlers/logout.php">
				<i class="fas fa-sign-out-alt"></i>
			</a>
		</nav>

		<div class="dropdown_data_window">

		</div>
		<input type="hidden" id="dropdown_data_type" value="">

	</header>

	<div class="wrapper">