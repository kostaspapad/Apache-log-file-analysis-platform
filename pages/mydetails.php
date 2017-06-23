<div>
<?php

	if(isset($_SESSION['userID'])){
		$user = $_SESSION['userID'];
	}

	$result = mysqli_query($con,"SELECT * FROM users
								 WHERE uname = '$user'");

	$table = "<div class='table-responsive' id='userInfo'>
			  <table class='table'>
			  <thead>
			  	<tr>
			  	  <th>First name</th>
			  	  <th>Last name</th>
			  	  <th>Email</th>
			  	  <th>Time zone</th>
			  	  <th>User name</th>
			  	  <th>Change</th>
			  	</tr>
			  </thead>
			  <tbody>";

	 while($row = mysqli_fetch_array($result)) {
		$table .= "<tr>
					<td>".$row['fname']."</td>
					<td>".$row['lname']."</td>
					<td>".$row['email']."</td>
					<td>".$row['timezone']."</td>
					<td>".$row['uname']."</td>
					<td><button class='btn btn-primary btn-xs editUserInfoBtn' data-toggle='modal' data-target='#editUserInfoModal' title='Change user infomartion'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></td>
				</tr>";
	}

	$table .= "</tbody>
				</table>
				</div>";

	echo $table;
	mysqli_close($con);

?>
<style type="text/css">
.modal-dialog {
  /*width: 70%;
  height: 70%;
  margin: 0;
  padding: 0;
  margin-left: 15%;*/
}
.form-control {
    margin-top: 5%;
}
.modal-content {
  height: auto;
  min-height: 70%;
  border-radius: 0;
}
</style>
<div id="editUserInfoModal" class="modal" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-sm-6"><p><b>Change user information</b></p></div>
					<div class="col-sm-6"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
				</div>
			</div>
			<div class="modal-body">
				<form id="formValidation">
					<input type="text" class="form-control" id="first" name="first" maxlength="20"  placeholder="First name">
					<input type="text" class="form-control" id="last" name="last" maxlength="20" placeholder="Last name">
					<input type="text" class="form-control" id="email" name="email" maxlength="45" placeholder="Email">
					<select type="text" name="timezone" id="timeZone" class="form-control"></select>
					<input type="password" class="form-control" id="password" name="password" maxlength="25" placeholder="New password">
					<input type="password" class="form-control" id="confirmPassword" name="confirmPassword" maxlength="25" placeholder="Confirm Password">
				<form>
			</div>
			<div class="modal-footer">
				<button id='submitBtn' type="button" class="btn btn-success modal-btn-saveInfo">Submit</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div> <!-- modal -->

<script type="text/javascript">

$(function(){
	$('select').timezones();
});

$('#submitBtn').click(function(){
	// If form is valid
	if ($('#formValidation').valid()) {
		var uid = '<?php echo $user; ?>';
		var firstname = $('#first').val();
		var lastname = $('#last').val();
		var userEmail = $('#email').val();
		// Get only timezone not location
		var timeZone = $('#timeZone').text().substring(4, 11).replace(':', '').replace(/ /g,'');
		var password = $('#password').val();
		var confPassword = $('#confirmPassword').val();

		//console.log(firstname+ " " + lastname+ " " + userEmail+ " " + timeZone+ " " + password+ " " + confPassword+ " " + uid);

		if (firstname !== null || lastname !== null || userEmail !== null || timeZone !== null || password !== null || confPassword !== null || uid !== null) {
			$.ajax({
			  type: "POST",
			  url: "/loganal/lib/ajaxRequests.php",
			  data: {action:'editInfo', first:firstname, last:lastname, email:userEmail, tz:timeZone, pass:calcMD5(password), cPass:calcMD5(confPassword), user:uid},
			});

			// Close modal
			$('#editUserInfoModal').modal('hide');
			$('body').removeClass('modal-open');
			$('.modal-backdrop').remove();

		} else {
			alert("Error");
		}
	} else {
		alert("Form not valid");
	}
	setTimeout(function () {
	  window.location.href = "/loganal/index.php?mainmenu=mydetails";
	}, 2500);
});

// Field validation
$("#formValidation").validate({
	rules: {
		first: {
			required: true,
			minlength: 3,
			maxlength: 20,
		},
		last: {
			required: true,
			minlength: 3,
			maxlength: 20,
		},
		password: {
			required: true,
			minlength: 6,
			maxlength: 10,
			ContainsAtLeastOneDigit: true,
		},
		confirmPassword: {
			equalTo: "#password",
			minlength: 6,
			maxlength: 10,
		},
		email: {
			required: true,
			email: true,
			minlength: 11,
			maxlength: 45,
		}
	},
	messages:{
		first: {
			required:"First name is required",
		},
		last: {
			required:"Last name is required",
		},
		password: {
			required:"The password is required"
		},
		confirmPassword: {
				required:"The password is required"
		},
		email:{
			required:"Email is required"
		},
	}
});

// Create custom method for validating passwords
jQuery.validator.addMethod("ContainsAtLeastOneDigit", function (value,password) {
        return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,10}$/i.test(value);
}, ' Password must be at least 6 characters, no more than 10 characters, and must include at least one upper case letter, one lower case letter, and one numeric digit.');

</script>
