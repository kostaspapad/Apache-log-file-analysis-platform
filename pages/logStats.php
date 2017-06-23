<?php

if(isset($_SESSION['userID'])){
  $uid = $_SESSION['userID'];
}


// isos tha eprepe na to omorfino ligo...
//Fetching list of files that the user uploaded and creating links with arguments that are passed to a php script to generate the statistics.
$sql = mysqli_query($con,"SELECT file_name  FROM user_files WHERE uid = '$uid'");
echo "<div style='margin-top: 10px; padding:10px;  background-color:#f5f5f5; border: 1px solid #e7e7e7;'>";
echo "<h3>Select file</h3>";


$table="<div class='table-responsive' id='graphTable'>
    <table class='table table-responsive'>
    <thead>
      <tr>
        <th>File name</th>
      </tr>
    </thead>
    <tbody>";

    while($row = mysqli_fetch_array($sql)) {
      if($row){


      $table .= "<tr>
      				  <td>" . substr($row['file_name'], strlen($uid) + 12) . "</td>
      				  <td><a href='index.php?mainmenu=statistics/activity_stats&filename=" . $row['file_name'] . "'class='btn btn-success btn-xs insertbtn glyphicon glyphicon-plus' role='button'></a></td>
      				  </tr>";
      }else{
  			echo "<p>No files available.</p>";
  		}
    }
    $table .= "</tbody>
  				</table>
  				</div>";
echo '</div';
    echo $table;
   	mysqli_close($con);
?>
