<html>
<body>
<style>
.myDiv {
	width: 700px;
	height: 200px;
  border: 1px;
  margin: 0 auto;
  background-color: lightblue;    
  text-align: center;
  font-size:36;
}
</style>
<?php

$stm = $_GET["stm"];
if($stm=="ofc"){	$name_show="นำเข้า Excel OFC ข้าราชการ";	$form_action="upstm/PHPExcelReadToMySQL_ofc.php?stm=ofc";}
elseif($stm=="ucs"){$name_show="นำเข้า Excel UCS สิทธิบัตรทอง";	$form_action="upstm/PHPExcelReadToMySQL_ucs.php?stm=ucs";}

?>
<div class="myDiv">
	<form action=<?php echo '"'.$form_action.'"'; ?> method="post" enctype="multipart/form-data">
	  <?php echo $name_show ?><BR>
	  <input type="hidden" name="backto" value="<?php echo $backto?>">
	  <input size="50" type="file" name="fileToUpload" id="fileToUpload" required>
	  <input type="submit" value="นำเข้า" name="submit">
	</form>
</div>
</body>
</html>