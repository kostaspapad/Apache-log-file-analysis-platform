<?php
	require('./lib/connectdb.php');

	// if there is no error, then process further
	if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['timezone']) && isset($_POST['password']) && isset($_POST['confirmPassword'])) {

		// hashing the password and sanitize data
		$_POST['password'] = md5($_POST['password']);

		$fname = $_POST['firstname'];
		$lname = $_POST['lastname'];
		$uname = $_POST['username'];
		$email = $_POST['email'];
		$timezone = $_POST['timezone'];
		$passwd = $_POST['password'];

		// Insert data to database
		$query = "INSERT INTO users (fname, lname, email, timezone, uname, passwd)
					VALUES ('$fname', '$lname', '$email', '$timezone', '$uname', '$passwd')";

		// Run query
		$result = mysqli_query($con,$query);

		// If error exists
		if (!$result) {
			echo(mysqli_error($con));
			exit();
		}


		echo "<div align='center' style='background-color:#f5f5f5;border:1px solid #e7e7e7; margin-top:10px'><h1>You have registered sucessfully</h1></div>";
	} else {
		echo "<div align='center' style='background-color:#f5f5f5;border:1px solid #e7e7e7; margin-top:10px'><h1>Registration error...</h1></div>";
	}

?>
