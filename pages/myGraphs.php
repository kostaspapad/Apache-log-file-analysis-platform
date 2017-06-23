<div>

<?php
	// Loop through results and create table
	if(isset($_SESSION['userID'])){
		$user = $_SESSION['userID'];
	}

	$query = "SELECT ug.graphCreationDate, ug.graphName, ug.graphComments, uf.file_name
		      FROM user_graphs ug, user_files uf
		      WHERE uf.fid = ug.fid and ug.uid = '$user'";
	$result = mysqli_query($con,$query);

	$table="<div class='table-responsive' id='graphTable'>
			<table class='table table-responsive'>
			<thead>
			  <tr>
			    <th>Graph name</th>
			    <th>Date created</th>
			    <th>Comments</th>
			    <th>File name</th>
			    <th></th>
			  </tr>
			</thead>
			<tbody>";

	while($row = mysqli_fetch_array($result)) {
		if($row){

			//Date of graph creation
			$creationDate = $row['graphCreationDate'];

			// Name of graph
			$name = $row['graphName'];

			// Graph comments
			if($row['graphComments'] != 'NULL'){
				$comments = $row['graphComments'];
			}else{
				$comments = 'No comment';
			}

			//Name of file used for graph generation
			$filename = $row['file_name'];
			$imageName = getImageName($user, $name, $creationDate);

		$table .= "<tr>
				    <td>".$name."</td>
				    <td>".$creationDate."</td>
				    <td>".$comments."</td>
				    <td>".substr($filename, strlen($user) + 12)."</td>
				    <td><button class='btn btn-success btn-xs viewbtn' data-toggle='modal' data-target='#imageModal' title='View'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button>
				    <a href = './lib/userfunctions.php?imageFile=".$imageName."' class = 'btn btn-success btn-xs' role = 'button' data-toggle='tooltip' title='download'><span class='glyphicon glyphicon-download' aria-hidden='true'></span></a>
				    <button class='btn btn-primary btn-xs editbtn' data-toggle='tooltip' title='edit'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></button>
				    <button class='btn btn-danger btn-xs deletebtn' data-toggle='tooltip' title='Delete'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></td></button>

				  </tr>";

		}else{
			echo "<p>No graphs saved.</p>";
		}
	}

	$table .= "</tbody>
				</table>
				</div>";

	echo $table;
	mysqli_close($con);


function getImageName($user, $name, $creationDate){
	return '../savedImageGraphs/' . $user . '_' . $name . '_' . substr(str_replace("-","",date($creationDate)),2,6) . '.png';
}

?>
<style type="text/css">
.modal-dialog {
  width: 70%;
  height: 70%;
  margin: 0;
  padding: 0;
  /*margin-left: 15%;*/
}

.modal-content {
  height: auto;
  min-height: 70%;
  border-radius: 0;
}
</style>
<div id="imageModal" class="modal" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<img id="div_imagetranscrits">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
</div>




<script type="text/javascript">

	var nameField;
	var graphDate;
	var uid = '<?php echo $user; ?>';
	var databasefileName = '<?php echo $filename; ?>';

	$(".viewbtn").click(function(){
		$row = $(this).closest("tr"),            // Finds the closest row <tr>
		$tdname = $row.find("td:nth-child(1)");  // Finds name
		$tdate = $row.find("td:nth-child(2)");	 // Get date

		$.each($tdname, function() {            // Visits every single <td> element
	    	nameField = $(this).text();         // Prints out the text within the <td>
		});

		$.each($tdate, function() {             // Visits every single <td> element
	    	graphDate = $(this).text();         // Prints out the text within the <td>
		});
		console.debug(nameField + " " + graphDate + " " + databasefileName);
		$.ajax({
		  type: "POST",
		  url: "/loganal/lib/ajaxRequests.php",
		  data: {action:'previewGraph', name:nameField, user:uid, date:graphDate},
			  success: function(data){
			    $('#div_imagetranscrits').html('<img class="img-responsive" src="data:image/png;base64,' + data + '" />');
			  }
		});
	});

	// Get selected table values change page
	// and run function to load the values saved for
	// the graph the user want's to edit
	$('.editbtn').click(function() {
		var $row = $(this).closest("tr"),        // Finds the closest row <tr>
	    $tdname = $row.find("td:nth-child(1)");     // Finds name
	    //$tdate = $row.find("td:nth-child(2)");	 // Get date
	    $tFname = $row.find("td:nth-child(4)");		 // Get filename

		$.each($tdname, function() {                // Visits every single <td> element
	    	graphName = $(this).text();         // Prints out the text within the <td>
		});

		// $.each($tdate, function() {                // Visits every single <td> element
	 	//graphDate = $(this).text();         // Prints out the text within the <td>
		// });

		$.each($tFname, function() {                // Visits every single <td> element
	    	filename = $(this).text();         // Prints out the text within the <td>
		});

		var conf = "&action=edit" + "&name=" + graphName + "&user=" + uid + "&fname=" + filename;
		window.location.href = "/loganal/index.php?mainmenu=statistics/activity_stats&filename=" + databasefileName + "&filetype=access_log" + conf;
	});

	// Delete graph and table row
	$(".deletebtn").click(function(){

		// Show confirm window
		var r = confirm("Delete graph?");
		if (r === true) {

			var $row = $(this).closest("tr"),        // Finds the closest row <tr>
			$tdname = $row.find("td:nth-child(1)");     // Finds name

			$.each($tdname, function() {                // Visits every single <td> element
				nameField = $(this).text();         // Prints out the text within the <td>
			});

			$.ajax({
			  type: "POST",
			  url: "/loganal/lib/ajaxRequests.php",
			  data: {action:'deleteGraph', name:nameField, user:uid},
			});

			// Delete row
			$(this).parents('tr').remove();
		}
	});

	$(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip();
	});
</script>
