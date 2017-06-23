<div>
<?php
	if(isset($_SESSION['userID'])){
		$user = $_SESSION['userID'];
	}

	$table = "<div class='table-responsive' id='userInfo' style='margin-top:10px'>
			  <table class='table'>
			  <thead>
			  	<tr>
			  	  <th>File name</th>
			  	  <th>Log type</th>
			  	  <th>Size</th>
			  	</tr>
			  </thead>
			  <tbody>";

	$result = mysqli_query($con,"SELECT * FROM user_files
								 WHERE uid = '$user'");
	while($row = mysqli_fetch_array($result)) {
		$table .= "<tr>
					<td>".$row['file_name']."</td>
					<td>".$row['file_log_type']."</td>
					<td>".$row['file_size']."</td>
				    <td><a href = './lib/userfunctions.php?file=".$row['file_name']."' class = 'btn btn-success btn-xs' role = 'button' data-toggle='tooltip' title='download'><span class='glyphicon glyphicon-download' aria-hidden='true'></span></a>
				    <button class='btn btn-danger btn-xs btndelete' data-toggle='tooltip' title='Delete'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></td>
				</tr>";
	}

	$table .= "</tbody>
			</table>
			</div>";

	echo $table;
	mysqli_close($con);
?>
</div>

<script type="text/javascript">
var uid = '<?php echo $user; ?>';

// Delete file and table row
$('.btndelete').click(function(){
	// Show confirm window
	var r = confirm("Delete file?");
	if (r === true) {

		var $row = $(this).closest("tr"), // Finds the closest row <tr>
		$tdname = $row.find("td:nth-child(1)"); // Finds name

		$.each($tdname, function() { // Visits every single <td> element
			nameField = $(this).text(); // Prints out the text within the <td>
		});
		
		$.ajax({
		  type: "POST",
		  url: "/loganal/lib/ajaxRequests.php",
		  data: {action:'deleteFile', name:nameField, user:uid},
		});
		
		$(this).parents('tr').remove(); // Delete row
	}
});

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
