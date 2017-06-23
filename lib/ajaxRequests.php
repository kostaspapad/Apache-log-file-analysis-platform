<?php
// Ajax method call, specified in calling funtion
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
  		// My details
  		case 'editInfo' : editInfo();break;

  		// My files
  		case 'downloadFile' : downloadFile();break;
      case 'deleteFile' : deleteFile();break;

  		// My graphs
      case 'previewGraph' : previewGraph();break;
      case 'downloadGraph' : downloadGraph();break;
      case 'editGraph' : editGraph();break;
      case 'deleteGraph' : deleteGraph();break;
    }
}

// Request from mydetails.php
function editInfo(){
	require('./connectdb.php');

	$fname = $_POST['first'];
	$lname = $_POST['last'];
	$email = $_POST['email'];
	$timeZone = $_POST['tz'];
	$pass  = $_POST['pass'];
	$cPass  = $_POST['cPass'];
	$uid = $_POST['user'];

	// First look if user exists then update row
	$selectQuery = "SELECT *
					        FROM users u
					        WHERE u.uname = '" . $uid . "' LIMIT 1";

 // 	echo $selectQuery;

  $updateQuery = "UPDATE users
                  SET fname='" . $fname . "', lname='" . $lname . "', email='" . $email . "', timezone='" . $timeZone . "', passwd='" . $pass . "'
                  WHERE uname='" . $uid . "';";

	if($result = mysqli_query($con, $selectQuery)){
		// Fetch one row
		$row = mysqli_fetch_assoc($result);

		//print_r($row);

    // Run update query
    if (mysqli_query($con, $updateQuery)) {
      echo 'Update successfull';
    } else {
      echo 'Update error';
    }
	  // Free result set
	  mysqli_free_result($result);
	}

	mysqli_close($con);
}

// Request from myfiles.php
function deleteFile(){
	// Connect to db
 	require('./connectdb.php');

 	// Get fid of file
 	$getFidQuery = "SELECT fid FROM user_files WHERE file_name = '" . $_POST['name'] . "' LIMIT 1";
 	if ($resultFid = mysqli_query($con, $getFidQuery)){
		$rowFid = mysqli_fetch_array($resultFid);
		$fid = $rowFid['fid'];
		echo 'FID = ' . $fid;
	} else {
		echo "Fid not found in database";
	}

 	$deleteDataFromDbQuery = "DELETE FROM access_log WHERE uid = '" . $_POST['user'] . "' AND fid = " . $fid;
 	if (mysqli_query($con, $deleteDataFromDbQuery)) {
 		echo 'Data deleted successfully';
 	} else {
 		echo 'Error deleting data';
 	}

	// Find if file exists in db
	$findFilenameQuery = "SELECT uf.file_name FROM user_files uf WHERE uid = '" . $_POST['user'] . "' AND file_name = '" . $_POST['name'] . "' LIMIT 1";

    if ($result = mysqli_query($con, $findFilenameQuery)){
		$row = mysqli_fetch_array($result);
		$fileName[] = $row['file_name'];
	} else {
		echo "File not found in database";
	}

	$deleteFilenameOnDbQuery = "DELETE FROM user_files WHERE uid = '" . $_POST['user'] . "' AND file_name = '" . $_POST['name'] . "'";

	// Delete graph image
	$file = '../uploads/' . $fileName[0];
	if (unlink($file)) {
		// Run delete query
		if (mysqli_query($con, $deleteFilenameOnDbQuery)) {
			echo "File deleted successfully";
		} else {
			echo "Can't delete file from database";
		}
	} else {
		echo "File not found or can't be deleted";
	}

	// Delete data


    mysqli_close($con);
}

// Request from mygraphs.php
function previewGraph(){
	// get uid and name for finding the file
	$fname = $_POST['user'] . "_" . $_POST['name'] . "_" . date('ymd',strtotime($_POST['date'])) . '.png';
//echo $fname;
	// Send image data as base64
	echo base64_encode(file_get_contents('../savedImageGraphs/'.$fname));
}

// Request from graphEngine.php
function editGraph(){
	require('./connectdb.php');

	$graphname = $_POST['name'];
	$uid = $_POST['user'];
	$filename = $_POST['filename'];

	// $xAxis = null;
	// $y1Axis = null;
	// $y2Axis = null;
	// $StartDate = null;
	// $EndDate = null;
	// $StartTime = null;
	// $EndTime = null;
	// $DrillDate = null;
	// $WhereY1 = null;
	// $WhereY2 = null;
	// $y1LineColor = null;
	// $y2LineColor = null;
	// $ShowLabels = null;
	// $BackColor = null;
	// $filetype = null;
	// $filename = null;

  // str_replace is used for replacing %20 char with space
	$selectQuery = "SELECT ug.termX, ug.termY1, ug.termY2, ug.StartDate, ug.EndDate, ug.StartTime, ug.EndTime, ug.DrillDate, ug.WhereY1, ug.WhereY2,
							 	         ug.JSONwhereY1, ug.JSONwhereY2, ug.chartypeY1, ug.chartypeY2, ug.y1LineColor, ug.y2LineColor, ug.ShowLabels, ug.dashStyleY1,
                         ug.dashStyleY2, ug.BackColor, uf.file_log_type, uf.file_name
					        FROM user_graphs ug, user_files uf
				        	WHERE ug.fid = uf.fid
				        	AND ug.uid = '" . $uid . "' AND ug.graphName = '" . str_replace('%20', ' ', $graphname) . "'";

	$result = mysqli_query($con, $selectQuery) or die("Error in Selecting " . mysqli_error($con));
																																								 //echo $selectQuery;
                                                                                 //print_r($result);
	$graphDataArray = array();
  while($row =mysqli_fetch_assoc($result))
  {
      $graphDataArray[] = $row;
  }
																																								//echo 'STO AJAX LOAD';print_r($graphDataArray);
	//Free result set
	mysqli_free_result($result);

	mysqli_close($con);

	echo json_encode($graphDataArray);
}

function deleteGraph(){
	// Connect to db
 	require('./connectdb.php');

	$deleteQuery = "DELETE FROM user_graphs WHERE uid = '" . $_POST['user'] . "' AND graphName = '" . $_POST['name'] . "'";
	$findNameQuery = "SELECT ug.imageName FROM user_graphs ug WHERE uid = '" . $_POST['user'] . "' AND graphName = '" . $_POST['name'] . "' limit 1";

  $result = mysqli_query($con, $findNameQuery);
	$row = mysqli_fetch_array($result);
	$imageName[] = $row['imageName'];


	// Delete graph image
	$image = '../savedImageGraphs/' . $imageName[0];


	if (unlink($image)) {
		// Run delete query
		if (mysqli_query($con, $deleteQuery)) {
			echo "Graph deleted successfully";
		} else {
			echo "Error deleting graph from database";
		}
	} else {
		echo "Error deleting graph image";
	}
    mysqli_close($con);
}
?>
