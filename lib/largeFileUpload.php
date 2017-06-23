<?php
session_start();
$uname = $_SESSION['userID'];
if (isset($_SESSION['userID'])) {
	$uid = $_SESSION['userID'];
}

$start = microtime(true);

define("UPLOAD_DIR", "C:/wamp/www/loganal/uploads/");

$name = "kpapadop_2017-01-22_aetos.log";
$fileNameAndPath = UPLOAD_DIR . $name;

if(file_exists(UPLOAD_DIR . $name)){

  chmod(UPLOAD_DIR . $name, 0644);
  $filesize = filesize($fileNameAndPath);
} else {

  echo "<br>File not found<br>";

}

$conn = mysqli_connect('localhost', 'root', '', 'loganalysis');
// $filename = $name;
// // Parsing the log read line by line
// $handle = fopen($fileNameAndPath, "r");
// if ($handle) {
//   while (($line = fgets($handle)) !== false) {
//       $log = array();
//       $n = sscanf(trim($line), '%s %s %s [%[^]]] "%s %s %[^"]" %d %s "%[^"]" "%[^"]"',
//         $log['ip'],
//         $log['client'],
//         $log['user'],
//         $log['time'],
//         $log['method'],
//         $log['uri'],
//         $log['prot'],
//         $log['code'],
//         $log['bytes'],
//         $log['ref'],
//         $log['agent']
//       );
//   //echo $log['ip'] . " " .$log['client'] . " " .$log['user'] . " " .$log['time'] . " " .$log['method'] . " " .$log['uri'] . " " .$log['prot'] . " " . $log['code'] . " " .$log['bytes'] . " " .$log['ref'] . " " .$log['agent'] . "<br>";
//
//     // Explode parts of datetime & timezone
//     $timeparts = explode(" ", $log['time']);
//     $tz = $timeparts[1];
//
//     preg_match("/([0-9]{2}\/...\/[0-9]{4}):([0-9]{2}:[0-9]{2}:[0-9]{2})/", $timeparts[0], $match);
//
//     // Change format dd/mm/yyyy -> yyyy-mm-dd
//     $date = str_replace('/', '-', $match[1]);
//     $date = date('Y-m-d', strtotime($date));
//
//     // Time
//     $time = $match[2];
//     $datetime = $date . " " . $time;
//
//     // Holds an int with the number of the dash position
//     $lastDashPos = strrpos($log['uri'], "/");
//
//     // Request string length
//     $strLength = strlen($log['uri']);
//
//     // To get the resource I use *strrpos — Find the position of the last occurrence of a substring in a string
//     // If the index of the last / is e.x 20 and the length of the string is 25 then we have a resource
//     if ($lastDashPos < $strLength) {
//
//       // Cut from dash to end keep the first part
//       $request = substr($log['uri'], 0, $lastDashPos);
//
//       // Cut from start till dash, get the remaining string
//       $resource = mysqli_real_escape_string($conn, substr($log['uri'], $lastDashPos));
//
//     } else {
//       // Cut from dash to end keep the first part
//       $request = substr($log['uri'], 0, $lastDashPos);
//
//       // Because of this the resource column to the db must accept null values
//       $resource = "-";
//
//     }
//
//     //e.x 1000 (bytes) or "-" that is converted to 0,
//     // is_numeric used to find if value is numeric string or int
//     if ($log['bytes'] == '-') {
//       $objsize = 0;
//     }
//     else {
//       $objsize = $log['bytes'];
//     }
//
//     //echo $log['ip'] . " " .$log['client'] . " " .$log['user'] . " " . $datetime . " " . $date . " " . $time . " " . $log['method'] . " " . $request . " " . $resource . " " . $log['code'] . " " . $objsize . " " . $log['ref'] . " " . $log['agent'] . "<br>";
//
//     $host = $log['ip'];
//     $user_identifier = $log['client'];
//     $user_id = $log['user'];
//     $timezone = $tz;
//     $method = $log['method'];
//     $request = $request;
//     $resource = $resource;
//     $protocol_type = $log['prot'];
//     $status_code = $log['code'];
//     $object_size = $objsize;
//
//     //logid is AUTO INCREMENT
//     $query = "INSERT INTO access_log(accfname, uid, HOST, user_identifier,
//                       user_id, date, time, datetime, timezone, method, request, resource,
//                       protocol_type, status_code, obj_size)
//                       VALUES ('$filename', '$uid', '$host', '$user_identifier', '$user_id', '$date',
//                                             '$time', '$datetime', '$timezone', '$method', '$request', '$resource', '$protocol_type',
//                                              '$status_code', '$object_size')";
//     //echo $query . "; <br>";
//
//     // Run query
//     if (mysqli_query($conn, $query)) {
//       // echo "New record created successfully";
//       // echo "<br />";
//     }
//     else {
//       echo "<font color='red'>Error: " . $query . mysqli_error($conn) . "</font><br />";
//       echo "<br />";
//     }
//   }
//
//   // End parsing the log
//   fclose($handle);
// }	else {
//   echo ("Error in opening/reading file");
//   //echo "<script> window.location.assign('../index.php?mainmenu=importFile'); </script>";
//   exit();
// }

insert_user_files_db('access_log', $uid, $filename, $conn, $filesize);
geolocate_hosts($uid, $filename, 'access_log', $conn);
echo getSuccessInsertRate($conn, $fileNameAndPath, $uid, $filename);


$execTime = microtime(true) - $start;
echo $execTime;

function geolocate_hosts($uid, $filename, $log_type, $conn){

	$arr = array();

		// Get distinct ip addresses from accesslog

		$sql = mysqli_query($conn, "SELECT DISTINCT acc.host FROM access_log acc, user_files uf WHERE acc.accfname = uf.file_name  AND acc.uid = '$uid' AND uf.file_name = '$filename'");
		require_once ("./geolocation/geoip.inc");

		require_once ("./geolocation/geoipcity.inc");

		require_once ("./geolocation/geoipregionvars.php");

		while ($rs = mysqli_fetch_array($sql)) {
			$arrSort = array();

			// Exclude localhost and 192.168.x.x adresses

			if (strpos($rs['host'], '127.0.0.1') !== false OR strpos($rs['host'], '192.168.') !== false) {
				continue;
			} else {
				$ipaddress = $rs['host'];
			}

			$gi = geoip_open("./geolocation/GeoLiteCity.dat", GEOIP_STANDARD);
			$rsGeoData = geoip_record_by_addr($gi, $ipaddress);
			$lat = $rsGeoData->latitude;
			$long = $rsGeoData->longitude;

			// $city = $rsGeoData->city;

			$country = $rsGeoData->country_name;
			$arrSort[] = $country;
			$arrSort[] = $ipaddress;
			$arrSort[] = $filename;
			$arrSort[] = $lat;
			$arrSort[] = $long;
			$arr[] = $arrSort;
    }
		// Sort by country
  		asort($arr);
  		foreach($arr as $arrkey => $arrvalue) {
  			$query = "INSERT INTO geoloc_access_log(acc_log_fname, host, country, latitude, longitude) VALUES ('$arrvalue[2]', '$arrvalue[1]', '$arrvalue[0]', '$arrvalue[3]', '$arrvalue[4]')";
  			//echo $query . ";";
  			if (mysqli_query($conn, $query)) {
  				// echo "File name: " . $filename . " inserted to db for user:" . $uid;
  				// echo "<br />";
  			} else {
  				echo "<font color='red'>Error: " . $query . mysqli_error($conn) . "</font><br />";
  				echo "<br />";
  			}
  		}

		// var_dump($arr);
		// asort($arr);
		// var_dump($arr);

		echo "Geolocation successfull";

		// geoip_close($gi);
		// mysqli_close($conn);
}

// Insert to file db

function insert_user_files_db($log_type, $uid, $filename, $conn, $filesize){

		$query = "INSERT INTO user_files (uid, file_log_type, file_name, file_size)
                    VALUES ('$uid','$log_type', '$filename', '$filesize')";
		// echo $query . ";";

		if (mysqli_query($conn, $query)) {
			echo "File name: " . $filename . " inserted to db for user:" . $uid;
			echo "<br />";
		}
		else {
			echo "<font color='red'>Error: " . $query . mysqli_error($conn) . "</font><br />";
			echo "<br />";
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

		if ($mime == 'text/plain') {
			echo "File is valid. MIME type:plain/text";
		} else {
			echo "File is invalid";

			// Redirect back
      //echo "<script> window.location.assign('../index.php?mainmenu=importFile'); </script>";
      exit();
		}

		finfo_close($finfo);
	}
}

function getSuccessInsertRate($conn, $localFile, $uid, $dbFname){
		// Open file and count lines
		$linecount = 0;
		$handle = fopen($localFile, "r");
		while(!feof($handle)){
			$line = fgets($handle);
			$linecount++;
		}

		fclose($handle);

		// Query db for row count
		$query = "SELECT count(HOST)
							FROM access_log acc, user_files uf
							WHERE uf.file_name = acc.accfname
							AND uf.uid = '" . $uid . "' AND uf.file_name = '" . $dbFname . "'";

		$result = mysqli_query($conn, $query);
		$rows   = mysqli_num_rows($result);
		if ($rows == 1) {
				$rows = mysqli_fetch_array($result);
				$dbRows = $rows['count(HOST)'];

				mysqli_close($conn);
				return "Insertion to db success rate: " . calculatePercentage($linecount, $dbRows) . ' ' . calculatePercentage($dbRows, $linecount); //(($linecount - $dbRows) / (($linecount + $dbRows) / 2)) * 100;
		} else {
			  mysqli_close($conn);
				return 'Error';
		}

}
function calculatePercentage($oldFigure, $newFigure) {
        if (($oldFigure != 0) && ($newFigure != 0)) {
            $percentChange = (1 - $oldFigure / $newFigure) * 100;
        }
        else {
            $percentChange = null;
        }
        return $percentChange;
}

?>
