<?php

/** PHPExcel */
require_once '../upstm/Classes/PHPExcel.php';

/** PHPExcel_IOFactory - Reader */
include '../upstm/Classes/PHPExcel/IOFactory.php';

$target_file = $_GET["target_file"];
$file_name = $_GET["file_name"];
 
$uploadOk = 1;

	$inputFileType = PHPExcel_IOFactory::identify($target_file);  
	$objReader = PHPExcel_IOFactory::createReader($inputFileType);  
	$objReader->setReadDataOnly(true);  
	$objPHPExcel = $objReader->load($target_file);  

	$objWorksheet = $objPHPExcel->setActiveSheetIndex(0); // sheet 0 = 1
	$highestRow = $objWorksheet->getHighestRow();
	$highestColumn = $objWorksheet->getHighestColumn();

	$headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
	$headingsArray = $headingsArray[1];

	$r = -1;
	$namedDataArray = array();
	for ($row = 2; $row <= $highestRow; ++$row) {
	    $dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
	    if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '') && (is_numeric($dataRow[$row]['A'])) && (empty($dataRow[$row]['X'])) ) { //ตรวจคอลัมน์ Excel
	        ++$r;
	        foreach($headingsArray as $columnKey => $columnHeading) {
	            //$namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
	            foreach (range('A', 'T') as $column){
			        $namedDataArray[$r][$column] = $dataRow[$row][$column];
			    }  
	        }
	    }elseif( isset($dataRow[$row]['X']) ){
	    	$show_error = "<font style='background-color: red'>ไม่ใช่ STM ข้าราชการ</font>";
	    }
	}




	$i = 0;
	$fail_up=0;
	$fail_count=array();
	$success_up=0;

	foreach ($namedDataArray as $result) {
		$i++;
		//สำหรับเช็ค ว่าอัพโหลดหรือยัง และ สำหรับจับกับ Visit
		$match_stm=$result["C"].(str_replace(" ","",str_replace("/","",str_replace(":","",$result["G"]))));
		$stm_claim_check = $result["T"];
		//สำหรับเช็ค ว่าอัพโหลดหรือยัง และ สำหรับจับกับ Visit
		
		$check_rep = "SELECT match_stm FROM stm WHERE match_stm='".$match_stm."' AND stm_claim ='$stm_claim_check' LIMIT 1";
		$check_rep_r = mysqli_query($con_money, $check_rep) or die(mysqli_error());
		$check_rep_r_s = mysqli_fetch_array($check_rep_r);
		@$check_rep_r_s_f = $check_rep_r_s["match_stm"];
		if( isset($check_rep_r_s_f) ){
			$fail_up++; //นับจำนวนที่อัพไม่สำเร็จ
			$fail_count[$i]="Row $i ".$result["C"]." ".$result["G"]." <font style='background-color: red'>นำเข้าแล้ว </font> <br>";
			//echo "Row $i ".$result["C"]." ".$result["G"]." นำเข้าแล้ว <br>";
		}else{

			
			$strSQL = "INSERT INTO stm (match_stm,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,stm_claim,stm_file_name,stm_user_reccord
			,stm_type,stm_rep,stm_hn) 
			VALUES ('".$match_stm."','".$result["A"]."','".$result["B"]."','".$result["C"]."','".$result["D"]."','".$result["E"]."','".$result["F"]."','".$result["G"]."','".$result["H"]."','".$result["I"]."','".$result["J"]."','".$result["K"]."','".$result["L"]."','".$result["M"]."','".$result["N"]."','".$result["O"]."','".$result["P"]."','".$result["Q"]."','".$result["R"]."','".$result["S"]."','".$result["T"]."','".$file_name."','".$stm_user_reccord."' 
			,'stm_ofc','".$result["A"]."','".$result["C"]."'
			) ";
			mysqli_query($con_money, $strSQL) or die(mysqli_error());
			//mysql_query($strSQL) or die(mysql_error());
			$success_up++; //นับจำนวนที่ up สำเร็จ
			//echo "Row $i Inserted...<br>";
		}
	}
 