<style>
.myDiv {
	width: 1200px;
	height: auto;
  border: 1px;
  margin: 0 auto;
  background-color: lightblue;    
  text-align: center;
  font-size:36;
}
</style>

<?php

/** PHPExcel */
require_once 'Classes/PHPExcel.php';

/** PHPExcel_IOFactory - Reader */
include 'Classes/PHPExcel/IOFactory.php';

$stm = $_GET["stm"];
#$inputFileName = "myData.xls";
$backto=$_POST["backto"];
$inputFileName = $_FILES["fileToUpload"]["tmp_name"]; 
$target_file = basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
@$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if($imageFileType != "xls" ) {
	//echo $imageFileType;
  	echo "<div class='myDiv'>เฉพาะไฟล์ excel เท่านั้น";
  	$uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  	echo " อัพโหลดไฟล์ไม่สำเร็จ</div>";
  	header( "Refresh:3; url=$backto", true, 303);
// if everything is ok, try to upload file
} else {
	$inputFileType = PHPExcel_IOFactory::identify($inputFileName);  
	$objReader = PHPExcel_IOFactory::createReader($inputFileType);  
	$objReader->setReadDataOnly(true);  
	$objPHPExcel = $objReader->load($inputFileName);  

	$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
	$highestRow = $objWorksheet->getHighestRow();
	$highestColumn = $objWorksheet->getHighestColumn();

	$headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
	$headingsArray = $headingsArray[1];

	$r = -1;
	$namedDataArray = array();
	for ($row = 2; $row <= $highestRow; ++$row) {
	    $dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
	    if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '') && (is_numeric($dataRow[$row]['A'])) && ( ($dataRow[$row]['J'])=='UCS' )
		) 
	    { //ตรวจคอลัมน์ Excel
	        ++$r;
	        foreach($headingsArray as $columnKey => $columnHeading) {
	            //$namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
	            foreach (range('A', 'Z') as $column){ // column A-Z
			        $namedDataArray[$r][$column] = $dataRow[$row][$column];
			    } 
			    foreach (range('J', 'M') as $column){ // column AJ-AM
			        @$namedDataArray[$r]["A".$column] = $dataRow[$row]["A".$column];
			    } 
	        }
	    }elseif( ($dataRow[$row]['J'])!='UCS' ){
	    	$show_error = "<font style='background-color: red'>ไม่ใช่ STM สิทธิบัตรทอง</font>";
	    }
	}

	//echo '<pre>';
	//var_dump($namedDataArray);
	//echo '</pre><hr />';

	//*** Connect to MySQL Database ***//
	$host     = "192.168.1.254";// Server database
	$username = "sa";     // Username database
	$password = "sa";     // Password database
	$database = "stm";     // Nama database

	// Koneksi ke database.
	$con_n = new mysqli($host, $username, $password, $database);
	mysqli_set_charset($con_n,"utf8");


	$i = 0;
	$fail_up=0;
	$fail_count=array();
	$success_up=0;

	foreach ($namedDataArray as $result) {
		$i++;
		//สำหรับเช็ค ว่าอัพโหลดหรือยัง และ สำหรับจับกับ Visit
		$match_stm=$result["D"].(str_replace(" ","",str_replace("/","",str_replace(":","",$result["H"]))));
		//สำหรับเช็ค ว่าอัพโหลดหรือยัง และ สำหรับจับกับ Visit
		
		$check_rep = "SELECT match_stm FROM stm_ucs WHERE match_stm='".$match_stm."' LIMIT 1";
		$check_rep_r = mysqli_query($con_n, $check_rep) or die(mysqli_error());
		$check_rep_r_s = mysqli_fetch_array($check_rep_r);
		@$check_rep_r_s_f = $check_rep_r_s["match_stm"];
		if( isset($check_rep_r_s_f) ){
			$fail_up++; //นับจำนวนที่อัพไม่สำเร็จ
			$fail_count[$i]="Row $i ".$result["D"]." ".$result["H"]." <font style='background-color: red'>นำเข้าแล้ว </font> <br>";
			//echo "Row $i ".$result["C"]." ".$result["G"]." นำเข้าแล้ว <br>";
		}elseif( empty($result["AK"]) ){
			$fail_up++; //นับจำนวนที่อัพไม่สำเร็จ
			$fail_count[$i]="Row $i ".$result["D"]." ".$result["H"]." <font style='background-color: red'>ไม่มีข้อมูล <font style='background-color: #FF8C00'>เลขที่</font> ใบเสร็จ ตรวจสอบ </font> <br>";
			//echo "Row $i ".$result["C"]." ".$result["G"]." นำเข้าแล้ว <br>";
		}elseif( empty($result["AL"]) ){
			$fail_up++; //นับจำนวนที่อัพไม่สำเร็จ
			$fail_count[$i]="Row $i ".$result["D"]." ".$result["H"]." <font style='background-color: red'>ไม่มีข้อมูล <font style='background-color: #FFFF00'>เล่ม</font> ใบเสร็จ ตรวจสอบ </font> <br>";
			//echo "Row $i ".$result["C"]." ".$result["G"]." นำเข้าแล้ว <br>";
		}elseif( empty($result["AM"]) ){
			$fail_up++; //นับจำนวนที่อัพไม่สำเร็จ
			$fail_count[$i]="Row $i ".$result["D"]." ".$result["H"]." <font style='background-color: red'>ไม่มีข้อมูล <font style='background-color: #FF1493'>วันที่</font> ใบเสร็จ ตรวจสอบ </font> <br>";
			//echo "Row $i ".$result["C"]." ".$result["G"]." นำเข้าแล้ว <br>";
		}else{

			
			$strSQL = "INSERT INTO stm_ucs (match_stm,A,B,C,D,E,F,G,T,stm_book,stm_no,stm_date) VALUES ('".$match_stm."','".$result["A"]."','".$result["C"]."','".$result["D"]."','".$result["E"]."','".$result["F"]."','".$result["G"]."','".$result["H"]."','".$result["AJ"]."','".$result["AK"]."','".$result["AL"]."','".$result["AM"]."' ) ";
			mysqli_query($con_n, $strSQL) or die(mysqli_error());
			//mysql_query($strSQL) or die(mysql_error());
			$success_up++; //นับจำนวนที่ up สำเร็จ
			//echo "Row $i Inserted...<br>";
		}
	}
	?>
	<div class='myDiv'>
	<button style="margin: 0 auto;font-size: 30px" onclick="window.location.href='index.php?stm=<?php echo $stm;?>' ">Continue</button><BR><?php
	echo @$show_error. "</BR>";
	echo " จำนวนทั้งหมด ".$i." visit</BR>";
	echo "นำเข้าได้จำนวน ".$success_up." visit</BR>";
	echo "นำเข้าไม่ได้จำนวน ".$fail_up." visit</BR>";
	foreach($fail_count as $key) {
	  print $key."\n";
	}
	echo "</div>";

	mysqli_close($con_n);
}
?>