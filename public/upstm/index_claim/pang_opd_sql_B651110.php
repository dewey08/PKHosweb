<?php 
@session_start();
@include('../session/session.php');

#กำหนดช่วงข้อมูล
#if(@$_SESSION["sir_year_book"]!=''){
#	$sir_year_book = $_SESSION["sir_year_book"];
#}else{
#	$sir_year_book = $now_date = (date("Y"));
#}
#$sql_sir_year_book = " '".$sir_year_book."-01-01' AND '".$sir_year_book."-12-31' ";
#กำหนดช่วงข้อมูล

#$doctorcode = $_SESSION["doctorcode"];

$sql_pang_preview=" SELECT p.pang_id, p.pang_fullname, p.pang_instument, p.pang_stm, p.pang_kor_tok, p.pang_kor_tok_icd, p.pang_cancer
      FROM pang p LEFT OUTER JOIN pang_sub ps ON p.pang_id=ps.pang_id
                  WHERE p.pang_id='$pang' AND p.pang_year='$y_s'
                  LIMIT 100";
$result_pang_preview = mysqli_query($con_money, $sql_pang_preview) or die(mysqli_error($con_money));
$row_pang_preview = mysqli_fetch_array($result_pang_preview);

$pang_id = $row_pang_preview["pang_id"];
$pang_fullname = $row_pang_preview["pang_fullname"];

# pang_hospcode #########################################
$concat_hospcode="";
$s_concat_hospcode=" SELECT ph.pang_hospcode FROM pang_hospcode ph WHERE ph.pang_id='$pang' LIMIT 500";
$q_concat_hospcode = mysqli_query($con_money, $s_concat_hospcode) or die(mysqli_error($con_money));
while($r_concat_hospcode = mysqli_fetch_array($q_concat_hospcode)){
  $concat_hospcode.="'".$r_concat_hospcode['pang_hospcode']."',";
}//loop while row_concat_hospcode
$concat_hospcode=substr($concat_hospcode,0,strlen($concat_hospcode)-1);


if($concat_hospcode!=""){
  $where_hospcode_in=" AND o.hospmain IN (".$concat_hospcode.") ";
}else{
  $where_hospcode_in=" ";
}
# pang_hospcode #########################################


# pang_hospcode_notin #########################################
$concat_hospcode_notin="";
$s_concat_hospcode_notin=" SELECT phn.pang_hospcode FROM pang_hospcode_notin phn WHERE phn.pang_id='$pang' LIMIT 500";
$q_concat_hospcode_notin = mysqli_query($con_money, $s_concat_hospcode_notin) or die(mysqli_error($con_money));
while($r_concat_hospcode_notin = mysqli_fetch_array($q_concat_hospcode_notin)){
  $concat_hospcode_notin.="'".$r_concat_hospcode_notin['pang_hospcode']."',";
}//loop while row_concat_hospcode
$concat_hospcode_notin=substr($concat_hospcode_notin,0,strlen($concat_hospcode_notin)-1);


if($concat_hospcode_notin!=""){
  $where_hospcode_notin=" AND o.hospmain NOT IN (".$concat_hospcode_notin.") ";
}else{
  $where_hospcode_notin=" ";
}
# pang_hospcode_notin #########################################


# pang_kor_tok check ข้อตกลง #########################################
@$pang_kor_tok = $row_pang_preview["pang_kor_tok"];
@$pang_kor_tok_icd = $row_pang_preview["pang_kor_tok_icd"];
# pang_kor_tok check ข้อตกลง #########################################

# pang_instument CR check && pang_kor_tok check ข้อตกลง #########################################
if($row_pang_preview["pang_instument"]=="N" && isset($pang_kor_tok) ){ # N=ไม่สนใจ CR และหักค่า CR ออก, pang_kor_tok=กำหนดยอดเงินข้อตกลงหรือไม่

  $select_uc_money = " ROUND(v.uc_money-((IFNULL((SUM(om.sum_price)),0))+(IFNULL((SUM(omk.sum_price)),0))) ,2) ";
  $left_outer_join = " LEFT OUTER JOIN $database_ii.opitemrece_money om ON o.vn=om.vn
                        LEFT OUTER JOIN $database_ii.opitemrece_kor_tok omk ON o.vn=omk.vn ";
  $select_kor_tok = " IFNULL(SUM(omk.sum_price),0) ";

}elseif($row_pang_preview["pang_instument"]=="N"){ # N=ไม่สนใจ CR และหักค่า CR ออก

  $select_uc_money = " ROUND(v.uc_money-IFNULL((SUM(om.sum_price)),0),2) ";
  $left_outer_join = " LEFT OUTER JOIN $database_ii.opitemrece_money om ON o.vn=om.vn ";
  $select_kor_tok = " null ";

}elseif($row_pang_preview["pang_instument"]=="Y"){ # Y = สนใจเฉพาะ CR

  $select_uc_money = " SUM(om.sum_price) ";
  $left_outer_join = " INNER JOIN $database_ii.opitemrece_money om ON o.vn=om.vn AND om.icode NOT IN 
                        (SELECT pang_icode FROM $database_ii.pang_icode WHERE pang_id IN ('1102050101.223','1102050101.224') )";
  $select_kor_tok = " null ";

}elseif($row_pang_preview["pang_instument"]=="I"){ # I = สนใจเฉพาะ icode ที่เลือก
  $select_uc_money = " SUM(om.sum_price) ";
  $left_outer_join = " INNER JOIN $database_ii.opitemrece_money om ON o.vn=om.vn 
                        AND om.icode IN (SELECT pang_icode FROM $database_ii.pang_icode WHERE pang_id = '".$row_pang_preview["pang_id"]."') ";
  $select_kor_tok = " null ";
}elseif($row_pang_preview["pang_instument"]=="NI"){ # NI = ไม่สนใจ icode ที่เลือก
  $select_uc_money = " SUM(om.sum_price) ";
  $left_outer_join = " INNER JOIN $database_ii.opitemrece_money om ON o.vn=om.vn 
                        AND om.icode NOT IN (SELECT pang_icode FROM $database_ii.pang_icode WHERE pang_id = '".$row_pang_preview["pang_id"]."') ";
  $select_kor_tok = " null ";
}elseif($row_pang_preview["pang_instument"]==""){
  $select_uc_money = " ROUND(v.uc_money,2) ";
  $left_outer_join = " ";
  $select_kor_tok = " null ";
}elseif(isset($pang_kor_tok)){ #pang_kor_tok=กำหนดยอดเงินข้อตกลงหรือไม่
  $select_uc_money = " ROUND(v.uc_money-IFNULL((SUM(om.sum_price)),0),2) ";
  $left_outer_join = " LEFT OUTER JOIN $database_ii.opitemrece_kor_tok om ON o.vn=om.vn ";
  $select_kor_tok = " null ";
}else{
  $select_uc_money = " ROUND(v.uc_money,2) ";
  $left_outer_join = " ";
  $select_kor_tok = " null ";	
}
# pang_instument CR check && pang_kor_tok check ข้อตกลง #########################################

# pang_pttype #########################################
$concat_pttype_all="";
$sql_concat_pttype=" SELECT pp.pang_pttype FROM pang_pttype pp WHERE pp.pang_id='$pang' LIMIT 500";
$result_concat_pttype = mysqli_query($con_money, $sql_concat_pttype) or die(mysqli_error($con_money));
while($row_concat_pttype = mysqli_fetch_array($result_concat_pttype)){
  $concat_pttype_all.="'".$row_concat_pttype['pang_pttype']."',";
}//loop while row_concat_pttype
$concat_pttype_all=substr($concat_pttype_all,0,strlen($concat_pttype_all)-1);


if($concat_pttype_all!=""){
  $where_pttype=" AND o.pttype IN (".$concat_pttype_all.") ";
}else{
  $where_pttype=" AND o.pttype IN ('sit_not_set') AND ptt.paidst='02' ";
  #$where_pttype=" AND ptt.hipdata_code = 'UCS' AND ptt.paidst='02' ";
}
# pang_pttype #########################################







#echo $i;
#echo $c_m;
if(@$start_year_ngob!=''){
  	$start_year=$start_year_ngob; 
  	$end_year=$end_year_ngob;
  	$where_pang_stamp_isnull=" ";
}else{ #ดักจับ กรณีไว้นับ จะไม่ใส่เงื่อนไขนี้
	$where_pang_stamp_isnull=" AND (ps.pang_stamp_vn IS NULL OR ps.pang_stamp_vn='' )";
}

#กรณีเลือกข้อมูลจนถึงวันที่ต้องการstamp เพราะถ้าเอาทั้งเดือน มีโอกาสดึงvisitที่เปิดล่วงหน้า หรือ visit วันปัจุบันที่ยังรักษาไม่แล้วเสร็จ

#กรณีเลือกข้อมูลจนถึงวันที่ต้องการstamp เพราะถ้าเอาทั้งเดือน มีโอกาสดึงvisitที่เปิดล่วงหน้า หรือ visit วันปัจุบันที่ยังรักษาไม่แล้วเสร็จ

##สร้าง temp_pang_stamp_icd
  # pang_icd #########################################
    $pang_str_replace = "temp_pang_stamp_icd".str_replace(".","_",$pang); # ชื่อตารางเก็บ icd
    $pang_stamp_hos_str_replace = "temp_pang_stamp_hos".str_replace(".","_",$pang);
    $pang_stamp_str_replace = "temp_pang_stamp".str_replace(".","_",$pang);
    $concat_icd_temp_all="";
    $s_pi=" SELECT pang_icd_start, pang_icd_end FROM pang_icd LIMIT 100";
    $q_pi = mysqli_query($con_money, $s_pi) or die(mysqli_error($con_money));
    while($r_pi = mysqli_fetch_array($q_pi)){
      $concat_icd_temp_all.=" ( pdx BETWEEN '".$r_pi['pang_icd_start']."' AND "."'".$r_pi['pang_icd_start']."') OR";
    }//loop while row_concat_pttype
    $concat_icd_temp_all=substr($concat_icd_temp_all,0,strlen($concat_icd_temp_all)-2); #ตัด OR 2ลำดับท้าย

    $s_drop_t_tpsi = "DROP TABLE IF EXISTS $pang_str_replace";
    $q_drop_t_tpsi = mysqli_query($con_money, $s_drop_t_tpsi);

    if($q_drop_t_tpsi){
      #ช่วงระยะเวลาปีงบ
      $start_year_ngob=($y_s-1)."-10-01";
      $end_year_ngob=$y_s."-09-30";
      #ช่วงระยะเวลาปีงบ
      $s_create_tpsi="CREATE TABLE $pang_str_replace
                    SELECT vn, pdx 
                    FROM $database.vn_stat
                    WHERE vstdate BETWEEN '$start_year_ngob' AND '$end_year_ngob'                      
                    AND (".$concat_icd_temp_all.")
                    LIMIT 50000 ";
      $q_create_tpsi = mysqli_query($con_money, $s_create_tpsi) or die(mysqli_error($con_money));
    }    
  # pang_icd #########################################

  # pang_icd #########################################
  $concat_icd_all="";
  $s_pi=" SELECT pang_icd_start, pang_icd_end FROM pang_icd WHERE pang_id='$pang' LIMIT 100";
  $q_pi = mysqli_query($con_money, $s_pi) or die(mysqli_error($con_money));
  while($r_pi = mysqli_fetch_array($q_pi)){
    $concat_icd_all.=" ( tpsi.pdx BETWEEN '".$r_pi['pang_icd_start']."' AND "."'".$r_pi['pang_icd_start']."') OR";
  }//loop while row_concat_pttype
  $concat_icd_all=substr($concat_icd_all,0,strlen($concat_icd_all)-2); #ตัด OR 2ลำดับท้าย

  if($concat_icd_all!=""){
    $left_join_icd=" LEFT JOIN $database_ii.$pang_str_replace tpsi ON o.vn=tpsi.vn ";
    $where_icd=" AND (".$concat_icd_all.") ";
  }else{
    $left_join_icd=" ";
    $where_icd=" AND o.vn NOT IN (select vn FROM $database_ii.$pang_str_replace ) ";
  }
  # pang_icd #########################################

##สร้าง temp_pang_stamp_icd

$s_pang_opd_temp ="FROM ovst o 
              \t  LEFT OUTER JOIN patient p ON o.hn=p.hn
              \t  LEFT OUTER JOIN vn_stat v ON o.vn=v.vn
              \t  WHERE o.hn!='999999999'                
              \t  AND o.vstdate BETWEEN '$start_year' AND '$end_year'
              \t  $where_pttype
              \t  $where_hospcode_in
              \t  $where_hospcode_notin
              \t  AND (o.an IS NULL OR o.an ='')
					
				";

  #AND cs.check_sit_date>='$start_year'
$s_pang_opd ="FROM $pang_stamp_hos_str_replace o 
              \t  LEFT OUTER JOIN $database_ii.check_sit cs ON o.vn=cs.check_sit_vn 
              \t  LEFT OUTER JOIN $database_ii.pang_stamp ps ON $pang=ps.pang_stamp AND o.vn=ps.pang_stamp_vn
              \t  LEFT OUTER JOIN $database.pttype ptt ON o.pttype=ptt.pttype
              \t  $left_outer_join
              \t  $left_join_icd
              \t  WHERE o.hn!='999999999'                
              \t  $where_icd
              \t  $where_pang_stamp_isnull
					
				";
?>