<?php

	$userfound = loginuser($_POST['uname'],$_POST['passwd']);

	if($userfound){
		//echo "Welcome ";
		//echo $_SESSION['userID'];
		// Redirect back
		$_SESSION['JustLoggedIn'] = true;
		echo "<script> window.location.assign('index.php?o=home'); </script>";

	} else {
	   	  echo '<script> alert("Wrong usename or password"); </script>';
	}

?>
