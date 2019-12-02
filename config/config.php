<?php  

// turns on output buffering
ob_start();
session_start();

$timezone = date_default_timezone_set("Asia/Kuala_Lumpur");

$con = mysqli_connect("localhost", "root", "wnq1061", "social");

if(mysqli_connect_errno()) {
	echo "Failed to connect: " . mysqli_connect_errno();
}

?>