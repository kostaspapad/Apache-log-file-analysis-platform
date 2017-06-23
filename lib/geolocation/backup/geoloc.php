<?php

include("geoipcity.inc");
include("geoipregionvars.php");

//require('../lib/connectdb.php'); 

//if(isset($_SESSION['userID'])){
//  $uid = $_SESSION['userID'];
//}else{
//	echo 'uid not set.';
//}

// Get distinct ip addresses from accesslog
$sql = mysqli_query($conn, "SELECT DISTINCT host FROM access_log acc, user_files uf WHERE acc.accfname = uf.file_name  AND acc.uid = '$uid' AND uf.file_name = '$filename'");
if(mysqli_num_rows($sql)){
	
	$gi = geoip_open("GeoLiteCity.dat", GEOIP_STANDARD);
	while($rs = mysqli_fetch_array($sql)){
		$ip = $rs['host'];
		$record= geoip_record_by_addr($gi,$ip);
		echo $rs['host'];
		echo $record->city . "\n";
		echo "<br>";
	}
}
?>

