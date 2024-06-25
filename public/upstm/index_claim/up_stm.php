<html>
<body style="padding-top: 280px;">

<style>
.center {
	padding-top: 380px;	
  margin: auto;
  width: 50%;
  /*border: 3px solid #73AD21;*/
  padding: 10px;
}
</style>

<div class="container-fluid center" >
	<form action="up_stm_check.php" method="post" enctype="multipart/form-data">
	  
	  	<input type="hidden" name="backto" value="<?php echo $backto?>">
	  <!-- <input size="50" type="file" name="fileToUpload" id="fileToUpload" required> -->
		<div>
			<input class="form-control form-control-lg" id="fileToUpload" type="file" name="fileToUpload" required>
		</div>
		<div>
	  		<input class="btn btn-success btn-lg " type="submit" value="นำเข้า" name="submit">
	  	</div>
	</form>
</div>
</body>
</html>