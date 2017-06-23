<?php

session_start();
require_once ("./geolocation/geoip.inc");
require_once ("./geolocation/geoipcity.inc");
require_once ("./geolocation/geoipregionvars.php");
$gi = geoip_open("./geolocation/GeoLiteCity.dat", GEOIP_STANDARD);

// Set session user id to $user for naming files by uid



// Set file for storing uploads
define("UPLOAD_DIR", "C:/wamp/www/loganal/uploads/");

if (isset($_SESSION['userID'])) {
	$uid = $_SESSION['userID'];
}
else {
	echo "Error: Session id not set";
  exit();
  echo "<script> window.location.assign('index.php?mainmenu=importFile'); </script>";
}

// ======================================
// ======= Upload file to server  =======
// ======================================

$start = microtime(true);

if (!empty($_FILES["myFile"])) {
	$myFile = $_FILES["myFile"];

	// Check if file is plain text

	//checkFileType();
	
	if ($myFile["error"] !== UPLOAD_ERR_OK) {
		echo "<p>An error occurred.</p>";
    	echo "<script> window.location.assign('../index.php?mainmenu=importFile'); </script>";
    	exit();
	}

	// Ensure a safe filename
	$name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);

	// Append uid,date,time to filename
	$name = $uid . "_" . date("Y-m-d") . "_" . $name;

	// Don't overwrite an existing file insert numeric id instead
	$i = 0;
	$parts = pathinfo($name);
	while (file_exists(UPLOAD_DIR . $name)) {
		$i++;
		$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
	}

	// Preserve file from temporary directory
	$success = move_uploaded_file($myFile["tmp_name"], UPLOAD_DIR . $name);
	if ($success) {
		echo "<p>File uploaded. Inserting data.</p>";
	}
	else {
		echo "<p>Unable to save file.</p>";
    echo "<script> window.location.assign('../index.php?mainmenu=importFile'); </script>";
    exit();
	}

	// Set proper permissions on the new file
	chmod(UPLOAD_DIR . $name, 0644);

	// ==========================================
	// ======= Parse file and insert to db=======
	// ==========================================
	$filename = $name;
	$filepath = "C:/wamp/www/loganal/uploads/";
	$fileNameAndPath = $filepath . $filename;

	// See if file is readable
	if (file_exists($fileNameAndPath)) {

		$file = fopen($fileNameAndPath, "r");

		// See if it's an access log using regex to match http methods GET/POST/etc
		$firstLine = fgets($file);

		if (preg_match("/GET|POST|PUT|DELETE|HTTP/", $firstLine)) {
			$log_type = 'access_log';
		}
		else {
			echo "ERROR: Could't detect log type.";
		}
	}
	else {
		echo "ERROR: The file $fname does not exist.";
    echo "<script> window.location.assign('../index.php?mainmenu=importFile'); </script>";
    exit();
	}

	// Get file size
	$filesize = filesize($fileNameAndPath);
	$filetext = fread($file, $filesize);

	$conn = mysqli_connect('localhost', 'root', '', 'loganalysis');

	// Insert file record to user_files
	insert_user_files_db($log_type, $uid, $filename, $conn, $filesize);

	// Get fid to use it in insert query
	$sqlFid = "SELECT fid
			   FROM user_files
			   WHERE file_name = '$filename'
			   LIMIT 1";

	$result = mysqli_query($conn, $sqlFid);
    $row = mysqli_fetch_array($result);
	$user_filesFid = $row['fid'];

	// Parsing the log read line by line
	$handle = fopen($fileNameAndPath, "r");
	if ($handle && $log_type === 'access_log') {
		while (($line = fgets($handle)) !== false) {
				$log = array();
				$n = sscanf(trim($line), '%s %s %s [%[^]]] "%s %s %s %d %s "%[^"]" "%[^"]"',
			    $log['ip'],
			    $log['client'],
			    $log['user'],
			    $log['time'],
			    $log['method'],
			    $log['uri'],
			    $log['prot'],
			    $log['code'],
			    $log['bytes'],
			    $log['ref'],
			    $log['agent']
				);
		
			// Explode parts of datetime & timezone
			$timeparts = explode(" ", $log['time']);
			$tz = $timeparts[1];

			preg_match("/([0-9]{2}\/...\/[0-9]{4}):([0-9]{2}:[0-9]{2}:[0-9]{2})/", $timeparts[0], $match);

			// Change format dd/mm/yyyy -> yyyy-mm-dd
			$date = str_replace('/', '-', $match[1]);
			$date = date('Y-m-d', strtotime($date));

			// Time
			$time = $match[2];
			$datetime = $date . " " . $time;

			// Holds an int with the number of the dash position
			$lastDashPos = strrpos($log['uri'], "/");

			// Request string length
			$strLength = strlen($log['uri']);

			// To get the resource I use *strrpos — Find the position of the last occurrence of a substring in a string
			// If the index of the last / is e.x 20 and the length of the string is 25 then we have a resource
			if ($lastDashPos < $strLength) {

				// Cut from dash to end keep the first part
				$request = substr($log['uri'], 0, $lastDashPos);

				// Cut from start till dash, get the remaining string
				$resource = mysqli_real_escape_string($conn, substr($log['uri'], $lastDashPos));

				if (substr($request, -1) === '"') {
					$request = rtrim($request, '"');
				}

			} else {
				// Cut from dash to end keep the first part
				$request = substr($log['uri'], 0, $lastDashPos);

				// Because of this the resource column to the db must accept null values
				$resource = "-";

			}

			//e.x 1000 (bytes) or "-" that is converted to 0,
			// is_numeric used to find if value is numeric string or int
			if ($log['bytes'] == '-') {
				$objsize = 0;
			}
			else {
				$objsize = $log['bytes'];
			}

			// Geolocate
			if ($log['ip'] != '127.0.0.1' AND strpos($log['ip'], '192.168.') === false) { 
				$rsGeoData = geoip_record_by_addr($gi, $log['ip']);
				// If geo data found 
				if (isset($rsGeoData->country_name)) {
					$country = $rsGeoData->country_name;
				}
			} else {
				$country = '-';
			}
			// echo $resource;

			// // If protocol type not exists shift last fields BUGGY LINES
			if (is_numeric($log['prot'])) { echo "isNumeric";
				$objsize = $log['code'];
				$log['code'] = $log['prot']; 
				$log['prot'] = 'HTTP/1.0';
			}
			// if (!preg_match("/HTTP./", $log['prot'])) { echo "EXEIprot";
			// 	$objsize = $log['code'];
			// 	$log['code'] = $log['prot']; 
			// 	$log['prot'] = 'HTTP/1.0';
			// }
	
			echo $user_filesFid . ' '
			. 'uid' . $uid . ' '
			. 'country' . $country . ' '
			. 'ip' . $log['ip'] . ' '
			. 'client' . $log['client'] . ' '
			. 'user' . $log['user'] . ' '
			. 'date' . $date . ' '
			. 'time' . $time . ' '
			. 'datetime' . $datetime . ' '
			. 'tz' . $tz . ' '
			. 'method' . $log['method'] . ' '
			. 'request' . $request . ' '
			. 'resource' . $resource . ' '
			. 'prot' . $log['prot'] . ' '
			. 'code' . $log['code'] . ' '
			. 'objsize' . $objsize;
			 echo "<br>";
			//logid is AUTO INCREMENT
			$query = "INSERT INTO access_log(fid, uid, country, HOST, user_identifier, user_id, date, time, datetime, timezone, method, request, resource, protocol_type, status_code, obj_size)
					  VALUES ('$user_filesFid', '$uid', '$country', '$log[ip]', '$log[client]', '$log[user]', '$date', '$time', '$datetime', '$tz', '$log[method]', '$request', '$resource', '$log[prot]',
						'$log[code]', '$objsize')";
//echo $query;
			if (mysqli_query($conn, $query)) {
				// echo "New record created successfully";
				// echo "<br />";
			}
			else {
				echo "<font color='red'>Error: " . $query . mysqli_error($conn) . "</font><br />";
				echo "<br />";
			}
		}

		// End parsing the log
		fclose($handle);
	} else {
		echo ("Error in opening/reading file");
    	echo "<script> window.location.assign('../index.php?mainmenu=importFile'); </script>";
    	exit();
	}

	//echo "<script> window.location.assign('../index.php?mainmenu=importFile'); </script>";
}


// Insert to file db

function insert_user_files_db($log_type, $uid, $filename, $conn, $filesize){

	if ($log_type == 'access_log') {
		$query = "INSERT INTO user_files (uid, file_log_type, file_name, file_size)
                    VALUES ('$uid','$log_type', '$filename', '$filesize')";

		if (mysqli_query($conn, $query)) {
			echo "File name: " . $filename . " inserted to db for user:" . $uid;
			echo "<br />";
		} else {
			echo "<font color='red'>Error: " . $query . mysqli_error($conn) . "</font><br />";
			echo "<br />";
		}
	} else {
    	echo 'Error';
    	echo "<script> window.location.assign('../index.php?mainmenu=importFile'); </script>";
    	exit();
    }
}

/**
 *  Validating if file is plain text
 *  using finfo_file. If file is invalid
 *  returns to import file page.
 */
function checkFileType(){

	if (isset($_FILES['myFile']['tmp_name'])) {

		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime = finfo_file($finfo, $_FILES['myFile']['tmp_name']);
echo $mime;
		if ($mime == 'text/plain') {
			echo "File is valid. MIME type:plain/text";
		} else {
			echo "File is invalid";

			// Redirect back
      echo "<script> window.location.assign('../index.php?mainmenu=importFile'); </script>";
      exit();
		}

		finfo_close($finfo);
	}
}
