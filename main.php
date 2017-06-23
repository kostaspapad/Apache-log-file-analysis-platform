<nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 10px;  position: fixed; width: 100%">
    <div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle navbar-toggle-sidebar collapsed"></button>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">
				<b>Analytics</b>
			</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
			<li><a href="index.php?o=home" id="home"><span class="glyphicon glyphicon-home" data-toggle='tooltip' data-placement="bottom" title='Home'></span></a></li>
			<li><a href="index.php?mainmenu=logStats" id="logStas"><span class="glyphicon glyphicon-plus" data-toggle='tooltip' data-placement="bottom" title='Create graph'></span></a></li>
			<li><a href="index.php?mainmenu=mydetails" id="details"><span class="glyphicon glyphicon-user" data-toggle='tooltip' data-placement="bottom" title='My details'></span></a></li>
			<li><a href="index.php?mainmenu=myfiles"><span class="glyphicon glyphicon-folder-open" data-toggle='tooltip' data-placement="bottom" title='My files'></span></a></li>
			<li><a href="index.php?mainmenu=myGraphs"><span class="glyphicon glyphicon-stats" data-toggle='tooltip' data-placement="bottom" title='My graphs'></span></a></li>
			<li><a href="index.php?mainmenu=importFile"><span class="glyphicon glyphicon-upload" data-toggle='tooltip' data-placement="bottom" title='Import file'></span></a></li>
			<?php if (isset($_SESSION["userID"])){ ?>
					<li><a href="index.php?o=logout"><span class="glyphicon glyphicon-off" data-toggle='tooltip' data-placement="bottom" title='Logout' onclick="logout()"></span></a></li>
			<?php } ?>
			</ul>
		</div>
	</div>
</nav>
<div class="container-fluid main-container">
<?php
if(isset($_GET['mainmenu'])) {
	require('pages/'.$_GET['mainmenu'].'.php');
}
?>
</div>
</body>
</html>


<script type="text/javascript">

$(function () {
  	$('.navbar-toggle-sidebar').click(function () {
  		$('.navbar-nav').toggleClass('slide-in');
  		$('.side-body').toggleClass('body-slide-in');
  		$('#search').removeClass('in').addClass('collapse').slideUp(200);
  	});

  	$('#search-trigger').click(function () {
  		$('.navbar-nav').removeClass('slide-in');
  		$('.side-body').removeClass('body-slide-in');
  		$('.search-input').focus();
  	});

	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});
});

</script>
