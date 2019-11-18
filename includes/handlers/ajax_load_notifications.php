<?php  

include("../../config/config.php");
include("../classes/User.php");
include("../classes/Notification.php");

// number of messages to load
$limit = 7;

$notification = new Notification($con, $_REQUEST['userLoggedIn']);
echo $notification->getNotifications($_REQUEST, $limit);

?>
