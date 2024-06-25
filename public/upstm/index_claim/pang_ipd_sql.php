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
  $where_hospcode_in=" AND ip.hospmain IN (".$concat_hospcode.") ";
}else{
  $where_hospcode_in="  ";
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
  $where_hospcode_notin=" AND ip.hospmain NOT IN (".$concat_hospcode_notin.") ";
}else{
  $where_hospcode_notin="  ";
}
# pang_hospcode_notin #########################################


# pang_kor_tok check ข้อตกลง #########################################
@$pang_kor_tok = $row_pang_preview["pang_kor_tok"];
@$pang_kor_tok_icd = $row_pang_preview["pang_kor_tok_icd"];
# pang_kor_tok check ข้อตกลง #########################################



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
  $where_pttype_notin=" AND pttype NOT IN (".$concat_pttype_all.") "; #สำหรับใช้หาค่า max_debt_amount
}else{
  $where_pttype=" AND o.pttype IN ('sit_not_set') #AND ptt.paidst='02' ";
  #$where_pttype=" AND ptt.hipdata_code = 'UCS' AND ptt.paidst='02' ";
  $where_pttype_notin=" AND pttype NOT IN ('sit_not_set') "; #สำหรับใช้หาค่า max_debt_amount
}
# pang_pttype #########################################



# pang_instument CR check && pang_kor_tok check ข้อตกลง #########################################
# เงื่อนไขการดึงยอดเงินคนไข้ใน
  // 1สิทธิ ดึง จาก an_stat.uc_money โดยตรง
  // 2สิทธิขึ้นไป จะต้องมีการตรวจ วงเงินสูงสุด
if($row_pang_preview["pang_instument"]=="N" && isset($pang_kor_tok) ){

  $select_uc_money_ipt = " (
                          (
                            IF(	(SELECT COUNT(an) FROM $database.ipt_pttype WHERE an=v.an)>1
                              ,IF(ip.max_debt_amount IS NOT NULL OR ip.max_debt_amount <>''
                                ,IF( ( (v.uc_money+ (IFNULL(v.paid_money,0)) )-((IFNULL((SUM(om.sum_price)),0))+(IFNULL((SUM(omk.sum_price)),0))) ) <=ip.max_debt_amount
                                  ,(v.uc_money+ (IFNULL(v.paid_money,0)) )-((IFNULL((SUM(om.sum_price)),0))+(IFNULL((SUM(omk.sum_price)),0))) 
                                  ,ip.max_debt_amount
                                )
                                ,(v.uc_money+ (IFNULL(v.paid_money,0)) )-(SELECT SUM(max_debt_amount) FROM $database.ipt_pttype WHERE an=v.an $where_pttype_notin  )-((IFNULL((SUM(om.sum_price)),0))+(IFNULL((SUM(omk.sum_price)),0))) 
                              )
                              ,v.uc_money-((IFNULL((SUM(om.sum_price)),0))+(IFNULL((SUM(omk.sum_price)),0))) 
                            )
                          ) 
                        ) ";
  $left_outer_join = " LEFT OUTER JOIN $database_ii.opitemrece_money om ON o.an=om.an
                        LEFT OUTER JOIN $database_ii.opitemrece_kor_tok omk ON o.an=omk.an ";
  $select_kor_tok = " ,ROUND(IFNULL(SUM(omk.sum_price),0),2) AS sum_price_kor_tok ";

}elseif($row_pang_preview["pang_instument"]=="N"){

  $select_uc_money_ipt = "(
                      \t(
                      \t\tIF(	(SELECT COUNT(an) FROM $database.ipt_pttype WHERE an=v.an)>1
                      \t\t\t,IF(ip.max_debt_amount IS NOT NULL OR ip.max_debt_amount <>''
                      \t\t\t\t,IF( ( (v.uc_money+ (IFNULL(v.paid_money,0)) )-IFNULL((SUM(om.sum_price)),0) ) <=ip.max_debt_amount
                      \t\t\t\t\t,(v.uc_money+ (IFNULL(v.paid_money,0)) )-IFNULL((SUM(om.sum_price)),0) 
                      \t\t\t\t\t,ip.max_debt_amount
                      \t\t\t\t)
                      \t\t\t\t,(v.uc_money+ (IFNULL(v.paid_money,0)) )-(SELECT SUM(max_debt_amount) FROM $database.ipt_pttype WHERE an=v.an $where_pttype_notin  )-IFNULL((SUM(om.sum_price)),0) 
                      \t\t\t)
                      \t\t\t,v.uc_money-IFNULL((SUM(om.sum_price)),0) 
                      \t\t)
                      \t )
                      ) ";
  $left_outer_join = " LEFT OUTER JOIN $database_ii.opitemrece_money om ON o.an=om.an ";
  $select_kor_tok = " null ";

}elseif($row_pang_preview["pang_instument"]=="Y"){
  $select_uc_money_ipt = " SUM(om.sum_price) ";
  $left_outer_join = " INNER JOIN $database_ii.opitemrece_money om ON o.an=om.an AND om.icode NOT IN 
                        (SELECT pang_icode FROM $database_ii.pang_icode WHERE pang_id IN ('1102050101.223','1102050101.224') )";
  $select_kor_tok = " null ";

}elseif($row_pang_preview["pang_instument"]=="I"){
  $select_uc_money_ipt = " SUM(om.sum_price) ";
  $left_outer_join = " INNER JOIN $database_ii.opitemrece_money om ON o.an=om.an 
                        AND om.icode IN (SELECT pang_icode FROM $database_ii.pang_icode WHERE pang_id = '".$row_pang_preview["pang_id"]."') ";
  $select_kor_tok = " null ";
}elseif($row_pang_preview["pang_instument"]=="NI"){
  $select_uc_money_ipt = " SUM(om.sum_price) ";
  $left_outer_join = " INNER JOIN $database_ii.opitemrece_money om ON o.an=om.an 
                        AND om.icode NOT IN (SELECT pang_icode FROM $database_ii.pang_icode WHERE pang_id = '".$row_pang_preview["pang_id"]."') ";
  $select_kor_tok = " null ";
}elseif($row_pang_preview["pang_instument"]==""){
  $select_uc_money_ipt = " (
                  \t\t    IF(	(SELECT COUNT(an) FROM $database.ipt_pttype WHERE an=o.an)>1
                  \t\t\t    ,IF(ip.max_debt_amount IS NOT NULL OR ip.max_debt_amount <>''
                  \t\t\t\t    ,IF( (v.uc_money+ (IFNULL(v.paid_money,0)) )<=ip.max_debt_amount
                  \t\t\t\t\t    ,(v.uc_money+ (IFNULL(v.paid_money,0)) )
                  \t\t\t\t\t    ,ip.max_debt_amount
                  \t\t\t\t    )
                  \t\t\t\t    ,(v.uc_money+ (IFNULL(v.paid_money,0)) )-(SELECT SUM(max_debt_amount) FROM $database.ipt_pttype WHERE an=o.an $where_pttype_notin  )
                  \t\t\t    )
                  \t\t\t    ,v.uc_money
                  \t\t    )
                  \t    ) ";
  $left_outer_join = " ";
  $select_kor_tok = " null ";
}elseif(isset($pang_kor_tok)){
  $select_uc_money_ipt = "( 
                  \t\t  (
                  \t\t\t  IF(	(SELECT COUNT(an) FROM $database.ipt_pttype WHERE an=o.an)>1
                  \t\t\t\t  ,IF(ip.max_debt_amount IS NOT NULL OR ip.max_debt_amount <>''
                  \t\t\t\t\t  ,IF( ( (v.uc_money+ (IFNULL(v.paid_money,0)) )-IFNULL((SUM(om.sum_price)),0)) <=ip.max_debt_amount
                  \t\t\t\t\t\t  ,(v.uc_money+ (IFNULL(v.paid_money,0)) )-IFNULL((SUM(om.sum_price)),0)
                  \t\t\t\t\t\t  ,ip.max_debt_amount
                  \t\t\t\t\t  )
                  \t\t\t\t\t  ,(v.uc_money+ (IFNULL(v.paid_money,0)) )-(SELECT SUM(max_debt_amount) FROM $database.ipt_pttype WHERE an=o.an $where_pttype_notin  )-IFNULL((SUM(om.sum_price)),0)
                  \t\t\t\t  )
                  \t\t\t\t  ,v.uc_money-IFNULL((SUM(om.sum_price)),0)
                  \t\t\t  )
                  \t\t  )
                  \t  ) ";
  $left_outer_join = " LEFT OUTER JOIN $database_ii.opitemrece_kor_tok om ON o.an=om.an ";
  $select_kor_tok = " null ";
}else{
  $select_uc_money_ipt = "(
                  \t\t  IF(	(SELECT COUNT(an) FROM $database.ipt_pttype WHERE an=o.an)>1
                  \t\t\t  ,IF(ip.max_debt_amount IS NOT NULL OR ip.max_debt_amount <>''
                  \t\t\t\t  ,IF( (v.uc_money+ (IFNULL(v.paid_money,0)) ) <=ip.max_debt_amount
                  \t\t\t\t\t  ,(v.uc_money+ (IFNULL(v.paid_money,0)) )
                  \t\t\t\t\t  ,ip.max_debt_amount
                  \t\t\t\t  )
                  \t\t\t\t  ,(v.uc_money+ (IFNULL(v.paid_money,0)) )-(SELECT SUM(max_debt_amount) FROM $database.ipt_pttype WHERE an=o.an $where_pttype_notin  )
                  \t\t\t  )
                  \t\t\t  ,v.uc_money
                  \t\t  )
                  \t  )";
  $left_outer_join = " ";
  $select_kor_tok = " null ";	
}
# pang_instument CR check && pang_kor_tok check ข้อตกลง #########################################

if(@$start_year_ngob!=''){
  $start_year=$start_year_ngob; 
  $end_year=$end_year_ngob;
  $where_pang_stamp_isnull=" ";
}else{ #ดักจับ กรณีไว้นับ จะไม่ใส่เงื่อนไขนี้
$where_pang_stamp_isnull=" AND (ps.pang_stamp_vn IS NULL OR ps.pang_stamp_vn='' )";
}


#สคริปสร้าง temp_ipt ตามด้วยรหัสผัง
$pang_ipt_str_replace = "temp_ipt".str_replace(".","_",$pang); # ชื่อตารางเก็บ 
$s_c_tempovst = "CREATE TABLE $pang_ipt_str_replace
                  SELECT
                  o.vn,o.hn,o.an,o.dchdate AS vstdate,o.pttype,'' AS hospmain,o.rw
                  ,v.pttypeno ,v.pdx ,v.income ,v.paid_money
                  ,p.cid
                  ,ip.max_debt_amount
                  ,$select_uc_money_ipt AS uc_money
                  FROM $database.ipt o 
                  LEFT JOIN $database.an_stat v ON o.an=v.an
                  LEFT JOIN $database.patient p ON o.hn=p.hn
                  LEFT JOIN $database.ipt_pttype ip ON ip.an=v.an
                  $left_outer_join
                  WHERE o.hn!='999999999'                
                  AND o.dchdate BETWEEN '$start_year' AND '$end_year'
                  $where_pttype
                  
                  $where_hospcode_in
                  $where_hospcode_notin
                  AND (o.an IS NOT NULL OR o.an !='')    
                  GROUP BY o.an                      
                  LIMIT 500000 ";
#สคริปสร้าง temp_ipt ตามด้วยรหัสผัง

#สคริปสร้าง temp_pang_stamp ตามด้วยรหัสผัง
$temp_pang_stamp_str_replace = "temp_pang_stamp".str_replace(".","_",$pang); # ชื่อตารางเก็บ 
$s_c_temp_ps = "CREATE TABLE $temp_pang_stamp_str_replace
                  SELECT 
                  pang_stamp_vn
                  ,IFNULL(pang_stamp_an,null) AS pang_stamp_an
                  ,pang_stamp_send
                  ,pang_stamp_uc_money 
                  ,pang_stamp_stm_money
                  FROM pang_stamp
                  where pang_year = '$y_s' AND pang_stamp='$pang'
                  LIMIT 500000 ";
#สคริปสร้าง temp_pang_stamp ตามด้วยรหัสผัง


#คิวรี่ insert เข้า pang_stamp_temp
$s_del_pst="DELETE FROM pang_stamp_temp WHERE pang_stamp='$pang' AND pang_stamp_check_date<='$date_now' 
            AND vstdate BETWEEN '$start_year' AND '$end_year' ";
            
$s_pang_opd =" FROM $pang_ipt_str_replace o 
              \t  LEFT OUTER JOIN $database_ii.check_sit cs ON o.vn=cs.check_sit_vn 
              \t  LEFT OUTER JOIN $database_ii.$temp_pang_stamp_str_replace ps ON o.an=ps.pang_stamp_an
              \t  $left_outer_join
              \t  WHERE o.hn!='999999999'                
              \t  AND o.vstdate BETWEEN '$start_year' AND '$end_year'
              \t  AND (o.an IS NOT NULL OR o.an !='')
					
				";
$select_uc_money= " o.uc_money ";

$s_in_pst = "INSERT INTO $database_ii.pang_stamp_temp
        SELECT '' AS pang_stamp_id,o.vn,o.hn $s_ipd_an
        , if(o.cid like '0%', o.pttypeno, o.cid) AS cid
        ,$s_date
        ,'$pang' AS pang_stamp
        ,$pttype_from_ovst_o_iptpttype
        
        ,cs.check_sit_subinscl

        ,IF(cs.check_sit_status='003'
      \t  ,'จำหน่าย/เสียชีวิต'
      \t  ,CONCAT(cs.check_sit_subinscl,' (',IFNULL(cs.check_sit_hmain,''),') ',cs.check_sit_startdate ) 
        ) AS 'pttype_stamp'

        ,o.pdx AS icd
        ,$show_adjrw
        ,ROUND(o.income,2) AS 'income'
        ,$select_uc_money AS 'uc_money'
        ,ROUND(o.paid_money,2) AS 'paid_money'
        ,$select_kor_tok AS uc_money_kor_tok
        ,'$date_now' AS pang_stamp_check_date
        ,'$y_s' AS year_check
        ".$s_pang_opd."
        $where_vn_anisnull
        
        GROUP BY o.$s_vn_or_an 
        $having_s
        LIMIT 100000 ";
#คิวรี่ insert เข้า pang_stamp_temp


if(@$_REQUEST["process"] == "y"){
  #temp_ipt
  $s_drop_t_tovst = "DROP TABLE IF EXISTS $pang_ipt_str_replace";
  $q_drop_t_tovst = mysqli_query($con_money, $s_drop_t_tovst) or die(nl2br($s_drop_t_tovst));
  if($q_drop_t_tovst){
    $q_c_tempovst = mysqli_query($con_money, $s_c_tempovst) or die(nl2br($s_c_tempovst));
    $s_add_pk_tovst = " ALTER TABLE $pang_ipt_str_replace ADD PRIMARY KEY(vn)";
    $q_add_pk_tovst = mysqli_query($con_money, $s_add_pk_tovst) or die(nl2br($s_add_pk_tovst));
  }
  #temp_ipt

  #temp_pang_stamp
  $s_drop_t_tpang_stamp = "DROP TABLE IF EXISTS $temp_pang_stamp_str_replace";
  $q_drop_t_tpang_stamp = mysqli_query($con_money, $s_drop_t_tpang_stamp) or die(nl2br ($s_drop_t_tpang_stamp));
  if($q_drop_t_tpang_stamp){
    $q_c_temp_ps = mysqli_query($con_money, $s_c_temp_ps) or die(mysqli_error('$s_c_temp_ps'));
    $s_add_pk_tpang_stamp = " ALTER TABLE $temp_pang_stamp_str_replace ADD PRIMARY KEY(pang_stamp_vn)";
    $q_add_pk_tpang_stamp = mysqli_query($con_money, $s_add_pk_tpang_stamp) or die(nl2br ($s_add_pk_tpang_stamp));

    $s_add_index_tpang_stamp = " CREATE INDEX idx_pang_stamp_an ON $temp_pang_stamp_str_replace (pang_stamp_an)";
    $q_add_index_tpang_stamp = mysqli_query($con_money, $s_add_index_tpang_stamp) or die(nl2br ($s_add_index_tpang_stamp));
  }
  #temp_pang_stamp

  #pang_stamp_temp 
  $q_del_pst = mysqli_query($con_money, $s_del_pst) or die(nl2br ($s_del_pst)); #ลบ record เก่าก่อน
  $q_in_pst = mysqli_query($con_money, $s_in_pst) or die(nl2br ($s_in_pst));
  #pang_stamp_temp 

}



#กรณีเลือกข้อมูลจนถึงวันที่ต้องการstamp เพราะถ้าเอาทั้งเดือน มีโอกาสดึงvisitที่เปิดล่วงหน้า หรือ visit วันปัจุบันที่ยังรักษาไม่แล้วเสร็จ
// if(@$date_sir_pang_opd!=''){
//   $end_year=$date_sir_pang_opd;
// }
#กรณีเลือกข้อมูลจนถึงวันที่ต้องการstamp เพราะถ้าเอาทั้งเดือน มีโอกาสดึงvisitที่เปิดล่วงหน้า หรือ visit วันปัจุบันที่ยังรักษาไม่แล้วเสร็จ
  #AND cs.check_sit_date>='$start_year'

?>