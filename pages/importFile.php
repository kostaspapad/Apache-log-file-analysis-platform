<?php if(isset($_SESSION['userID'])) : ?> <!--Propably not necessary -->
<form action="lib/import.php" method="post" enctype="multipart/form-data" style="padding-left: 40%; padding-top:10px">
	<div class="form-group">
		<label for="exampleInputFile">File input</label>
	    <input id="fileInput" type="file" name="myFile" class="btn btn-default">
	    <p class="help-block" style="padding-left: 2.5%">Only text files with common log format</p>
	</div>
	<div style="padding-left: 12.5%">
   		<button id="uploadbtn" type="submit" class="btn btn-default" disabled>Submit</button>
   	</div>
</form>
<?php else :
		echo "<p>You must be logged in to upload log files.</p>";
		header("window.location='index.php?os=loginuser'");
	endif;
?>
<script type="text/javascript">
// Check if user has selected file then enable submit btn
$("input[type=file]").on('change',function(){
    if(this.files[0].name){
			$('#uploadbtn').prop('disabled', false);
		}else{
			$('#uploadbtn').prop('disabled', true);
		}
});
</script>
