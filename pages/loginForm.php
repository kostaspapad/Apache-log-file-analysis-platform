<!-- <link rel="stylesheet" href="./css/loginregister.css"> <!-- Main css --> 

<div class="container">
    	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="#" class="active" id="login-form-link">Login</a>
							</div>
							<div class="col-xs-6">
								<a href="#" id="register-form-link">Register</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="login-form" action="index.php?o=loginuser" method="post" role="form" style="display: block;">
									<div class="form-group">
										<input type="text" name="uname" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
									</div>
									<div class="form-group">
										<input type="password" name="passwd" id="password" tabindex="2" class="form-control" placeholder="Password">
									</div>
									<div class="form-group text-center">
										<!-- <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
										<label for="remember"> Remember Me</label> -->
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
											</div>
										</div>
									</div>
									<!-- <div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<div class="text-center">
													<a href="http://phpoll.com/recover" tabindex="5" class="forgot-password">Forgot Password?</a>
												</div>
											</div>
										</div>
									</div> -->
								</form>
								<form id="register-form" action="index.php?o=register" method="post" role="form" style="display: none;">
									<div class="form-group">
										<input type="text" name="firstname" id="firstname" tabindex="1" class="form-control" placeholder="First name" value="">
									</div>
									<div class="form-group">
										<input type="text" name="lastname" id="lastname" tabindex="1" class="form-control" placeholder="Last name" value="">
									</div>
									<div class="form-group">
										<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
									</div>
									<div class="form-group">
										<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
									</div>
									<div class="form-group">
										<select type="text" name="timezone" id="timezone" class="form-control"></select>
									</div>
									<div class="form-group">
										<input type="password" name="password" id="mainpassword" tabindex="2" class="form-control" placeholder="Password">
									</div>
									<div class="form-group">
										<input type="password" name="confirmPassword" id="confirmPassword" tabindex="2" class="form-control" placeholder="Confirm password">
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<style>

</style>

<script type="text/javascript">
	$(function() {

    $('#login-form-link').click(function(e) {
		$("#login-form").delay(100).fadeIn(100);
 		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
	$('#register-form-link').click(function(e) {
		$("#register-form").delay(100).fadeIn(100);
 		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

	$('select').timezones();
});

// Register form validation
// Info if not working http://stackoverflow.com/questions/14703374/confirm-password-with-jquery-validate
$("#register-form").validate({
	rules: {
		firstname: {
			required: true,
			minlength: 3,
			maxlength: 20,
		},
		lastname: {
			required: true,
			minlength: 3,
			maxlength: 20,
		},
		username: {
			required: true,
			minlength: 3,
			maxlength: 20,
		},
		email: {
			required: true,
			email: true,
			minlength: 11,
			maxlength: 45,
		},
		password: {
				required: true,
				minlength: 6,
				maxlength: 10,
				ContainsAtLeastOneDigit: true,
			},
			confirmPassword: {
				equalTo: "#mainpassword",
				minlength: 6,
				maxlength: 10,
			},
	},
	messages:{
		firstname: {
			required:"First name is required",
		},
		lastname: {
			required:"Last name is required",
		},
	username: {
			required:"Username is required",
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

$('#register-submit').click(function(){
	// Get only timezone not location
	$('#timezone option:selected').val($('#timezone option:selected').text().substring(4, 11).replace(':', '').replace(/ /g,''));
});
</script>
