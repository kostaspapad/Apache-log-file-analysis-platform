<?php

// Create connection
$con=mysqli_connect('localhost','root','','loganalysis'); 

// Check connection
if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

// function database_connection() {
// 	//http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers
//     $db_host = "localhost";
//     $db_name = "loganalysis";
//     $db_user = "root";
//     $db_pass = "";
  
//     $pdo = new PDO('mysql:host=localhost;dbname=loganalysis;charset=utf8mb4', 'root', '');
    
//     return $pdo;
// }
?>