<?php

// Otan to dropdown exei none epilogi den trexei to drilldown
// Otan to save apotixanei na min leei to message tis mysql alla apla ena error


// Ajax method call, specified in calling funtion
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'execute' : execute();break;
        case 'executeDrill' : executeDrill();break;
        case 'saveGraph' : saveGraph();break;
    }
}

function execute(){
	// Needed vars for not fetching data from other files
	$uid = $_POST['first'];
	$filename = $_POST['second'];

	// Convert json to assosiative array
	$fieldPickerObjJson = json_decode($_POST['third'],true);

	$query = generator($fieldPickerObjJson, $uid, $filename);
																																						//print_r($query);
	runQuery($query);
}

function executeDrill(){
	$uid = $_POST['first'];
	$filename = $_POST['second'];
	$objJson = json_decode($_POST['third'], true);
																																						//print_r($objJson);
	$query = drillDownGenerator($objJson, $uid, $filename);
																																						//print_r($query);
	runQuery($query);

}

function saveGraph(){
	// Connect to db
 	require('../../lib/connectdb.php');

	$uid = $_POST['first'];
	$filename = $_POST['second'];
	$graphName = $_POST['third'];
	$graphComments = $_POST['forth'];
	//$objJson = json_decode($_POST['fifth'], true);
	$objJson = $_POST['fifth'];
	// For storing fid and inserting filename to user_graphs
	$fid = null;
																																						//print_r($objJson);
	// Get now date
	$graphCreationDate = getDatetimeNow();

	if($graphComments == null){
		$graphComments = 'NULL';
	}

	if($objJson['xAxis'] == ''){
		$objJson['xAxis'] = 'NULL';
	}else {
	  $objJson['xAxis'] = mysqli_real_escape_string($con, $objJson['xAxis']);
	}

	if(isset($objJson['y1Axis'])){
		$objJson['y1Axis'] = mysqli_real_escape_string($con, $objJson['y1Axis']);
	}else {
	  $objJson['y1Axis'] = 'NULL';
	}

	if(isset($objJson['y2Axis'])){
		$objJson['y2Axis'] = mysqli_real_escape_string($con, $objJson['y2Axis']);
	}else {
	  $objJson['y2Axis'] = 'NULL';
	}

	if(isset($objJson['startDate'])){
		$objJson['startDate'] = "'" . $objJson['startDate'] . "'";
	}else {
	  $objJson['startDate'] = 'NULL';
	}

	if(isset($objJson['endDate'])){
		$objJson['endDate'] = "'" . $objJson['endDate'] . "'";
	}else {
	  $objJson['endDate'] = 'NULL';
	}

	if(isset($objJson['timeStarts'])){
		$objJson['timeStarts'] = "'" . $objJson['timeStarts'] . "'";
	}else {
	  $objJson['timeStarts'] = 'NULL';
	}

	if(isset($objJson['timeEnds'])){
		$objJson['timeEnds'] = "'" . $objJson['timeEnds'] . "'";
	}else {
	  $objJson['timeEnds'] = 'NULL';
	}

	if(isset($objJson['selectedDate'])){
		$objJson['selectedDate'] = "'" . $objJson['selectedDate'] . "'";
	}else {
	  $objJson['selectedDate'] = 'NULL';
	}

	if(isset($objJson['whereY1'])){
		$objJson['whereY1'] = "'". mysqli_real_escape_string($con, $objJson['whereY1']) . "'";
	}else {
	  $objJson['whereY1'] = 'NULL';
	}

	if(isset($objJson['whereY2'])){
		$objJson['whereY2'] = "'" . mysqli_real_escape_string($con, $objJson['whereY2']) . "'";
	}else {
	  $objJson['whereY2'] = 'NULL';
	}

  if(isset($objJson['JSONwhereY1'])){
		$objJson['JSONwhereY1'] = "'" . mysqli_real_escape_string($con, $objJson['JSONwhereY1']) . "'";
	}else {
	  $objJson['JSONwhereY1'] = 'NULL';
	}

  if(isset($objJson['JSONwhereY2'])){
		$objJson['JSONwhereY2'] = "'" . mysqli_real_escape_string($con, $objJson['JSONwhereY2']) . "'";
	}else {
	  $objJson['JSONwhereY2'] = 'NULL';
	}

	if(isset($objJson['chartypeY1'])){
		$objJson['chartypeY1'] =  mysqli_real_escape_string($con, $objJson['chartypeY1']);
	}else {
	  $objJson['chartypeY1'] = 'line';
	}

	if(isset($objJson['chartypeY2'])){
		$objJson['chartypeY2'] =  mysqli_real_escape_string($con, $objJson['chartypeY2']);
	}else {
	  $objJson['chartypeY2'] = 'line';
	}

	if(isset($objJson['y1LineColor'])){
		$objJson['y1LineColor'] =  mysqli_real_escape_string($con, $objJson['y1LineColor']);
	}else {
	  $objJson['y1LineColor'] = 'NULL';
	}

	if(isset($objJson['y2LineColor'])){
		$objJson['y2LineColor'] = mysqli_real_escape_string($con, $objJson['y2LineColor']);
	}else {
	  $objJson['y2LineColor'] = 'NULL';
	}

	if($objJson['showLabels'] === 'true'){
		$objJson['showLabels'] = 'true';
	}else {
	  $objJson['showLabels'] = 'false';
	}

	if(isset($objJson['dashStyleY1'])){
		$objJson['dashStyleY1'] = mysqli_real_escape_string($con, $objJson['dashStyleY1']);
	}else {
	  $objJson['dashStyleY1'] = 'solid';
	}

	if(isset($objJson['dashStyleY2'])){
		$objJson['dashStyleY2'] = mysqli_real_escape_string($con, $objJson['dashStyleY2']);
	}else {
	  $objJson['dashStyleY2'] = 'solid';
	}

	if(isset($objJson['backColor'])){
		$objJson['backColor'] = "'" . mysqli_real_escape_string($con, $objJson['backColor']) . "'";
	}else {
	  $objJson['backColor'] = 'false';
	}

																																							//print_r($objJson);
 	$selectFidQuery = "SELECT fid FROM user_files WHERE file_name = '$filename'";

 	$result = mysqli_query($con, $selectFidQuery);
 	$fid = mysqli_fetch_array($result);

 	// Save the graph as image on loganal/savedImageGraphs
 	$imageName = $uid . "_" . $graphName . "_" . date('ymd').'.png';
 	$imagePath = "../../savedImageGraphs/";
 	$imageNamePath = $imagePath . $imageName;

 	// Get image data
 	$imagedata = str_replace(' ', '+', substr($_POST['image'],9));
	$imagedata = base64_decode($imagedata);
	$im = imagecreatefromstring($imagedata);
	if ($im !== false) {
		// Save image in the specified location last arg is quality
		imagepng($im, $imageNamePath, 9);
		imagedestroy($im);
		//echo "Saved successfully";
	}
	else {
		echo 'An error occurred saving graph image.';
    exit();
	}

	// Insert file name to file db
	$insertQuery = "INSERT INTO user_graphs (uid, fid, graphCreationDate, graphName, graphComments,
    						termX, termY1, termY2, StartDate, EndDate, StartTime, EndTime, DrillDate,
     						  whereY1, whereY2, JSONwhereY1, JSONwhereY2, chartypeY1, chartypeY2, y1LineColor, y2LineColor, ShowLabels, dashStyleY1, dashStyleY2, BackColor, imageName)
                 VALUES ('$uid', '$fid[0]' ,'$graphCreationDate', '$graphName', '$graphComments',
                 	'$objJson[xAxis]', '$objJson[y1Axis]', '$objJson[y2Axis]', $objJson[startDate], $objJson[endDate], $objJson[timeStarts], $objJson[timeEnds], $objJson[selectedDate],
                 				$objJson[whereY1], $objJson[whereY2], $objJson[JSONwhereY1], $objJson[JSONwhereY2], '$objJson[chartypeY1]', '$objJson[chartypeY2]', '$objJson[y1LineColor]', '$objJson[y2LineColor]', $objJson[showLabels],
                 				 '$objJson[dashStyleY1]', '$objJson[dashStyleY2]', $objJson[backColor], '$imageName')";


    // Run query
    if(mysqli_query($con, $insertQuery)) {
        //echo "File name: " . $filename . " inserted to db for user:" . $uid;
        //echo "<br>";
        $con->close();
        echo 'Graph saved.';
    }else{
        echo "<font color='red'>Error: " . $insertQuery . mysqli_error($con) . "</font><br>";
        echo "<br>";
    }

}

function getDatetimeNow() {
    $tz_object = new DateTimeZone('Europe/Athens');
    //date_default_timezone_set('Brazil/East');

    $datetime = new DateTime();
    $datetime->setTimezone($tz_object);
    return $datetime->format('Y\-m\-d\ h:i:s');
}

function removeNulls($ObjJson){
  foreach ($ObjJson as $key => $value) {
    if($ObjJson[$key] == 'NULL'){
      unset($ObjJson[$key]);
    }
  }
                                                                                //print_r($ObjJson);
  return $ObjJson;
}
// generator will run two times one for each query
// function generator($ObjJson, $select, $where, $date, $time, $axis, $uid, $filename){
function generator($ObjJson, $uid, $filename){
	$selectY1 = array();
	$whereY1 = array();

	$selectY2 = array();
	$whereY2 = array();

	$time_start = null;
	$time_end = null;
	$date_start = null;
	$date_end = null;
																																						//print_r($ObjJson);
  $ObjJson = removeNulls($ObjJson);
	// Prepares query arrays $select & $where
	foreach ($ObjJson as $key => $value) {
 		if($key == 'xAxis'){
 			$selectY1[] = $value;
 		}

 		if($key == 'xAxis'){
 			$selectY2[] = $value;
 		}

 		if($key == 'y1Axis' && $value !== 'null'){
 			$selectY1[] = $value;
 		}

 		if($key == 'y2Axis' && $value !== 'null'){
 			$selectY2[] = $value;
 		}

 		if($key == 'whereY1'){
 			$whereY1[] = $value;
 		}

 		if($key == 'whereY2'){
 			$whereY2[] = $value;
 		}

 		// date must have start and end
 		if($key == 'startDate'){
 			$date_start = $value;
 		}

 		if($key == 'endDate'){
 			$date_end = $value;
 		}

 		if($key == 'timeStarts'){
 			$time_start = $value;
 		}

 		if($key == 'timeEnds'){
 			$time_end = $value;
 		}
	}

	// Insert alias to select values(acc., geo.)
	//print_r( $selectY2);
	$selectY1 = insertAlias($selectY1);
	$selectY2 = insertAlias($selectY2);
	//print_r( $selectY2);
	//Implode $select array and create select in query
 	//Insert FROM. Join table user_files
 	// Look for country in select and insert JOIN
 	
 	$queryY1 = "SELECT " . implode(', ', $selectY1) . "
					FROM access_log acc, user_files uf
					WHERE acc.fid = uf.fid
					AND uf.file_name = '" . $filename . "'
					AND acc.uid = '" . $uid . "'";

	$queryY2 = "SELECT " . implode(', ', $selectY2) . "
					FROM access_log acc, user_files uf
					WHERE acc.fid = uf.fid
					AND uf.file_name = '" . $filename . "'
					AND acc.uid = '" . $uid . "'";

	if ($date_start && $date_end) {
		$queryY1 .= " AND acc.date >= '" . $date_start . "' AND acc.date <= '" . $date_end . "'";
	}

	if ($date_start && $date_end) {
		$queryY2 .= " AND acc.date BETWEEN '" . $date_start . "'
					  AND '" . $date_end . "'";
	}

	// If has time insert between acc.time
	if ($time_start && $time_end) {
		$queryY1 .= " AND acc.time BETWEEN '" . $time_start . "'
					  AND '" . $time_end . "'";
	}
	if ($time_start && $time_end) {
		$queryY2 .= " AND acc.time BETWEEN '" . $time_start . "'
					  AND '" . $time_end . "'";
	}

	// Insert where options
	if ($whereY1) {
		foreach ($whereY1 as $key => $value) {
			$queryY1 .= " AND " . $value;
		}
	}
	if ($whereY2) {
		foreach ($whereY2 as $key => $value) {
			$queryY2 .= " AND " . $value;
		}
	}

	// GROUP BY temporal ORDER BY acc.datetime ASC
	// $selectY [ 0 ] is the first field in select
	$queryY1 .= " GROUP BY " . $selectY1[0];
	$queryY2 .= " GROUP BY " . $selectY2[0];

	$query[] = $queryY1;
	$query[] = $queryY2;
                                                                                //print_r($query);
	return $query;


}


function drillDownGenerator($objJson, $uid, $filename){
	$selectY1 = array();
	$whereY1 = array();

	$selectY2 = array();
	$whereY2 = array();

	$selectedDate = null;
	$selectedPoint = null;
	// Prepares query arrays $select & $where
	foreach ($objJson as $key => $value) {

 		if($key == 'xAxis'){
 			$selectY1[] = $value;
 		}

 		if($key == 'xAxis'){
			$selectY2[] = $value;
 		}

 		if($key == 'y1Axis'){
 			$selectY1[] = $value;
 		}

 		if($key == 'y2Axis'){
			if($value !== 'NULL'){
				$selectY2[] = $value;
			}
 		}

 		if($key == 'whereY1'){
 			$whereY1[] = $value;
 		}

 		if($key == 'whereY2'){
 			$whereY2[] = $value;
 		}

 		// date must have start and end
 		if($key == 'selectedDate'){
 			// Convert timestamp to date
 			$selectedDate = date('Y-m-d', $value/1000);
 		}
 													// prepi na figi epeidi den xrisimopoiei drill an den einai date
 		if($key == 'selectedPoint'){
 			// Get point
 			$selectedPoint = $value;echo 'point '.$selectedPoint;
 		}
	}

	// Insert alias to select values(acc., geo.)
	$selectY1 = insertAlias($selectY1);
	$selectY2 = insertAlias($selectY2);

	//Implode $select array and create select in query
 	//Insert FROM. Join table user_files
 	// Look for country in select and insert JOIN

 	$queryY1 = "SELECT " . implode(', ', $selectY1) . "
					FROM access_log acc, user_files uf
					WHERE acc.fid = uf.fid
					AND uf.file_name = '" . $filename . "'
					AND acc.uid = '" . $uid . "'";

	$queryY2 = "SELECT " . implode(', ', $selectY2) . "
					FROM access_log acc, user_files uf
					WHERE acc.fid = uf.fid
					AND uf.file_name = '" . $filename . "'
					AND acc.uid = '" . $uid . "'";
										
	if ($selectedDate) {
		$queryY1 .= " AND acc.date = '" . $selectedDate . "'";
		$queryY2 .= " AND acc.date = '" . $selectedDate . "'";
	} else if ($selectedPoint){
		$queryY1 .= " AND " . $selectY1[0] . " = '" . $selectedPoint . "'";
		$queryY2 .= " AND " . $selectY2[1] . " = '" . $selectedPoint . "'";
	}

	// Insert where options
	if ($whereY1) {
		foreach ($whereY1 as $key => $value) {
			$queryY1 .= " AND " . $value;
		}
	}

	if ($whereY2) {
		foreach ($whereY2 as $key => $value) {
			$queryY2 .= " AND " . $value;
		}
	}

	$queryY1 .= " GROUP BY " . $selectY1[0]; // na to kanw selectY1??
	$queryY2 .= " GROUP BY " . $selectY2[0]; // na to kanw selectY2??

	$query[] = $queryY1;
	$query[] = $queryY2;

	return $query;
}

function runQuery($query){

	// Connect to db
 	require('../../lib/connectdb.php');

 	$arr = array();

	// the query has 2 keys one for series 1 and one for series 2
 	foreach ($query as $key => $value) {

 		//echo $query[$key];
 		// Reset it in each iteration because adds extra fields
		$columnNames = array();

		// Reset or problem data are the same
		$data = array();

	 	// Result of the query
	 	$result = mysqli_query($con, $query[$key]);

	 																																							//print_r($result);

		// Get column names
		while ($fieldinfo = mysqli_fetch_field($result))
	    {
		    //printf("Name: %s\n",$fieldinfo->name);
		    $columnNames[] = $fieldinfo->name;
		    //printf("Table: %s\n",$fieldinfo->table);
		    //printf("max. Len: %d\n",$fieldinfo->max_length);
	    }

		//Check if date exists in columns
		if (in_array("date", $columnNames)) {
			if(count($columnNames) == 2){
		    	while($row = mysqli_fetch_assoc($result)){
			    	$data[] = array(strtotime($row[$columnNames[0]]) * 1000, intval($row[$columnNames[1]]));
		    	}
			}
		} else if (in_array("datetime", $columnNames)){
			if (count($columnNames) == 2) {
				while ($row = mysqli_fetch_assoc($result)) {
				    $data[] = array(strtotime($row[$columnNames[0]]) * 1000, intval($row[$columnNames[1]]));
			    }
			}
		} else {
			if (count($columnNames) == 2) {
				while ($row = mysqli_fetch_assoc($result)) {
					$data[] = array(($row[$columnNames[0]]), intval($row[$columnNames[1]]));
				}
			}
		}
																																								//print_r($data);
		// Use isset because query can be empty.
		//  Use arr because data is getting reset after every iteration
		// appending data to out of loop array
		if (isset($data)) {
			$arr[] = $data;
		}
	}

	echo json_encode($arr);
																																							//print json_encode($data);
	mysqli_close($con);
}

function insertAlias($sel){
	foreach ($sel as $key => $value) {
		if ($pos = strrpos($value, '(')) {
			if ($pos = strpos($value, 'distinct')){
				$sel[$key] = substr_replace($value, 'acc.', strrpos($value, 'distinct') + 9, 0);
			} else {
				$sel[$key] = substr_replace($value, 'acc.', strrpos($value, '(') + 1, 0);	
			}			
		} else {
			// If no function.
			$sel[$key] = 'acc.' . $value;
		}
	}
	return $sel;
}

// Byte formating for preview
function formatBytes($size, $precision = 2) {
    $base = log($size, 1024);
    $suffixes = array('', 'K', 'M', 'G', 'T');

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}
?>
