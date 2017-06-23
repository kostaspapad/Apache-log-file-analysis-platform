<?php

if(isset($_SESSION['userID'])){
  $uid = $_SESSION['userID'];
}else{
	echo 'uid not set.';
	break;
}

//Get vars from url.
if(isset($_GET['filename'])){
	$filename = $_GET['filename'];
}else{
	echo "Filename not set.";
	break;
}

?>


<div id='div-activity-stats-main'>
	<?php require('graphEngine.php'); ?>
</div>
