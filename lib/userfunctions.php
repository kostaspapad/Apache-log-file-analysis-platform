<?php

// User functions

function loginuser($uname, $passwd) {
    require('connectdb.php');

    $uname  = $_POST['uname'];
    $passwd = md5($_POST['passwd']);

    // Checking the values are existing in the database or not
    $result = mysqli_query($con, "select * " . "from users " . "where uname = '$uname' and " . "passwd = '$passwd';");
    $rows   = mysqli_num_rows($result);
    if ($rows == 1) {
        $row = mysqli_fetch_array($result);
        $_SESSION['userID'] = $row['uname'];
        return true;
    } else {
        return false;
    }

    mysqli_close($con);
}

function logout() {
    unset($_SESSION['userID']);
    echo "<script> window.location.assign('index.php'); </script>";
}

// Download file from server
if(!empty($_GET['file']) || !empty($_GET['imageFile'])){
    if(!empty($_GET['file'])){
		// File is txt
		$fileName = basename($_GET['file']);
		$filePath = '../uploads/' . $fileName;
		downloadFile($fileName, $filePath);
	}
	if (!empty($_GET['imageFile'])){
		// File is image
		$fileName = basename($_GET['imageFile']);
		$filePath = '../savedImageGraphs/';
		downloadImage($fileName, $filePath);
	} else {
		header("HTTP/1.0 404 Not Found");
		return;
	}
}

function downloadImage($filename, $filePath) { 
	$mime = ($mime = getimagesize($filePath . $filename)) ? $mime['mime'] : $mime;
	$size = filesize($filePath . $filename);
	$fp   = fopen($filePath . $filename, "rb");
	if (!($mime && $size && $fp)) {
	  // Error.
	  return;
	}
	header("Content-type: " . $mime);
	header("Content-Length: " . $size);
	header("Content-Disposition: attachment; filename=" . $filename);
	header('Content-Transfer-Encoding: binary');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	fpassthru($fp);
}

function downloadFile($fileName, $filePath){
	if(!empty($fileName) && file_exists($filePath)){
        // Define headers
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$fileName");
		    header("Content-Type: image/png");
		    header("Content-type: application/octet-stream");
        header("Content-Transfer-Encoding: binary");

        // Read the file
        readfile($filePath);
        exit;
    }else{
        echo 'The file does not exist.';
    }
}
?>
