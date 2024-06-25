<?php

include("../connect/connect.php");
@include('../session/session.php');
$s_pang_chronic = "SELECT pang_chronic FROM pang_chronic 
			WHERE pang_id ='$pang' 
			 
			LIMIT 1234";
			#AND pang_chronic_year='$y_s'

$q_pang_chronic = mysqli_query($con_money, $s_pang_chronic) or die(mysqli_error($con_money));

$concat_pang_chronic = "";

while($r_pang_chronic=mysqli_fetch_array($q_pang_chronic)){
	$concat_pang_chronic.="'".$r_pang_chronic['pang_chronic']."',";
}
$concat_pang_chronic=substr($concat_pang_chronic,0,strlen($concat_pang_chronic)-1);

#####################################################################
#if($concat_pang_chronic!=''){
	$sqlshow = "SELECT chronic_sql FROM chronic 
					WHERE chronic_code IN ($concat_pang_chronic) LIMIT 1235";

	$resultshow = mysqli_query($con_money, $sqlshow) or die($sqlshow."|pang_opd_kor_tok|sqlshow");

	$concat_code = "";

	while($row=mysqli_fetch_array($resultshow)){

	$chronic_sql=$row['chronic_sql'];
	$sqlshow2 = "SELECT code FROM $database.icd101 WHERE $chronic_sql LIMIT 1236";
	$resultshow2 = mysqli_query($con_hos, $sqlshow2) or die(mysqli_error($con_hos));
	while($row2=mysqli_fetch_array($resultshow2)){

		$concat_code.="'".$row2['code']."',";

	}

	}

	$concat_code=substr($concat_code,0,strlen($concat_code)-1);

	$temp_pang_stamp_ovst = "temp_ovst".str_replace(".","_",$pang); # ชื่อตารางเก็บ_temp_ovst
	$temp_pang_stamp_chronic = "temp_pang_stamp_chronic".str_replace(".","_",$pang); # ชื่อตารางเก็บ_temp_pang_stamp_chronic

	$s_drop_t_tpsc = "DROP TABLE IF EXISTS $temp_pang_stamp_chronic";
	$q_drop_t_tpsc = mysqli_query($con_money, $s_drop_t_tpsc) or die(nl2br($s_drop_t_tpsc));

	$s_c_t_tpsc = "CREATE TABLE $temp_pang_stamp_chronic
					SELECT vn, icd10, hn ,vstdate
					FROM $database.ovstdiag
					WHERE VN IN (					
						SELECT vn FROM $temp_pang_stamp_ovst					
					)
					AND icd10 IN ($concat_code)
					GROUP BY vn	";
	$q_c_t_tpsc = mysqli_query($con_money, $s_c_t_tpsc) or die(nl2br($s_c_t_tpsc).'|pang_opd_kor_tok|$s_c_t_tpsc');
	

	// $sqlshow3 = "SELECT COUNT(vn) AS count_vn FROM $database.ovstdiag WHERE vn='$vn' AND icd10 IN ($concat_code) LIMIT 10";
	// $resultshow3 = mysqli_query($con_hos, $sqlshow3) or die(mysqli_error($con_hos));

	// $row3=mysqli_fetch_array($resultshow3);
	#$pang_kor_tok;
	#$pang_kor_tok_icd;
	#echo " เช็คจำนวน Diag".$row3['count_vn'];
	// if($uc_money>$pang_kor_tok_icd && $row3['count_vn']>0){
	// 	$uc_money_kor_tok = $pang_kor_tok_icd+$sum_price_kor_tok;	
	// }elseif($uc_money>$pang_kor_tok_icd && $row3['count_vn']==0){
	// 	$uc_money_kor_tok = $pang_kor_tok+$sum_price_kor_tok;
	// }elseif($uc_money>$pang_kor_tok && $row3['count_vn']>0){
	// 	$uc_money_kor_tok = $uc_money+$sum_price_kor_tok;
	// }elseif($uc_money>$pang_kor_tok && $row3['count_vn']==0){
	// 	$uc_money_kor_tok = $pang_kor_tok+$sum_price_kor_tok;
	// }
#}
?>
