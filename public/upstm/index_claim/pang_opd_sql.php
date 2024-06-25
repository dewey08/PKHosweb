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
$result_pang_preview = mysqli_query($con_money, $sql_pang_preview) or die($sql_pang_preview);
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

#คิวรี่_กรณีตรวจพบว่าเป็นผังที่มีการกำหนดข้อตกลง
if(isset($pang_kor_tok)){
  include('pang_opd_kor_tok.php');
}
#คิวรี่_กรณีตรวจพบว่าเป็นผังที่มีการกำหนดข้อตกลง

# pang_instument CR check && pang_kor_tok check ข้อตกลง #########################################
if($row_pang_preview["pang_instument"]=="N" && isset($pang_kor_tok) ){ # N=ไม่สนใจ CR และหักค่า CR ออก, pang_kor_tok=กำหนดยอดเงินข้อตกลงหรือไม่

  $select_uc_money = " ROUND(uc_money-((IFNULL((SUM(om.sum_price)),0))+(IFNULL((SUM(omk.sum_price)),0))) ,2) ";
  $left_outer_join = " LEFT OUTER JOIN $database_ii.opitemrece_money om ON o.vn=om.vn
                        LEFT OUTER JOIN $database_ii.opitemrece_kor_tok omk ON o.vn=omk.vn
                        LEFT JOIN $temp_pang_stamp_chronic tpsc ON o.vn=tpsc.vn ";
  $select_kor_tok = " IF( (uc_money-((IFNULL((SUM(om.sum_price)),0))+(IFNULL((SUM(omk.sum_price)),0))))<=$pang_kor_tok
                      \t  ,((uc_money-((IFNULL((SUM(om.sum_price)),0))+(IFNULL((SUM(omk.sum_price)),0))))+(IFNULL((SUM(omk.sum_price)),0)))
                      \t  ,IF((uc_money-((IFNULL((SUM(om.sum_price)),0))+(IFNULL((SUM(omk.sum_price)),0))))>$pang_kor_tok
                      \t\t    ,IF(tpsc.vn!=''
                      \t\t\t      ,$pang_kor_tok_icd+(IFNULL((SUM(omk.sum_price)),0))
                      \t\t\t      ,$pang_kor_tok+(IFNULL((SUM(omk.sum_price)),0))
                      \t\t     )
                      \t\t    ,$pang_kor_tok+(IFNULL((SUM(omk.sum_price)),0))	
                      \t  )
                      ) ";

}elseif($row_pang_preview["pang_instument"]=="N"){ # N=ไม่สนใจ CR และหักค่า CR ออก

  $select_uc_money = " ROUND(uc_money-IFNULL((SUM(om.sum_price)),0),2) ";
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
}elseif(isset($pang_kor_tok)){ #pang_kor_tok=กำหนดยอดเงินข้อตกลงหรือไม่
  $select_uc_money = " ROUND(uc_money-IFNULL((SUM(omk.sum_price)),0),2) ";
  $left_outer_join = " LEFT OUTER JOIN $database_ii.opitemrece_kor_tok omk ON o.vn=omk.vn 
                        LEFT JOIN $temp_pang_stamp_chronic tpsc ON o.vn=tpsc.vn   ";
  $select_kor_tok = " IF( (uc_money-((IFNULL((SUM(omk.sum_price)),0))))<=$pang_kor_tok
                      \t  ,((uc_money-((IFNULL((SUM(omk.sum_price)),0))))+(IFNULL((SUM(omk.sum_price)),0)))
                      \t  ,IF((uc_money-((IFNULL((SUM(omk.sum_price)),0))))>$pang_kor_tok
                      \t\t    ,IF(tpsc.vn!=''
                      \t\t\t      ,$pang_kor_tok_icd+(IFNULL((SUM(omk.sum_price)),0))
                      \t\t\t      ,$pang_kor_tok+(IFNULL((SUM(omk.sum_price)),0))
                      \t\t     )
                      \t\t    ,$pang_kor_tok+(IFNULL((SUM(omk.sum_price)),0))	
                      \t  )
                      ) ";
}else{
  $select_uc_money = " ROUND(uc_money,2) ";
  $left_outer_join = " ";
  $select_kor_tok = " null ";	
}
# pang_instument CR check && pang_kor_tok check ข้อตกลง #########################################

# pang_icd #########################################
$pang_str_replace = "temp_pang_stamp_icd".str_replace(".","_",$pang); # ชื่อตารางเก็บ icd
$pang_stamp_hos_str_replace = "temp_pang_stamp_hos".str_replace(".","_",$pang);
$pang_stamp_str_replace = "temp_pang_stamp".str_replace(".","_",$pang);
# pang_icd #########################################

if(@$start_year_ngob!=''){
  $start_year=$start_year_ngob; 
  $end_year=$end_year_ngob;
  $where_pang_stamp_isnull=" ";
}else{ #ดักจับ กรณีไว้นับ จะไม่ใส่เงื่อนไขนี้
$where_pang_stamp_isnull=" AND (ps.pang_stamp_vn IS NULL OR ps.pang_stamp_vn='' )";
}

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
  $where_pttype=" AND o.pttype IN ('sit_not_set') #AND ptt.paidst='02' ";
  #$where_pttype=" AND ptt.hipdata_code = 'UCS' AND ptt.paidst='02' ";
}
# pang_pttype #########################################

#หาค่าicd10
$s_pi=" SELECT pang_icd_start, pang_icd_end FROM pang_icd LIMIT 100";
$concat_icd_temp_all="";    
$q_pi = mysqli_query($con_money, $s_pi) or die(mysqli_error($con_money));
while($r_pi = mysqli_fetch_array($q_pi)){
  $concat_icd_temp_all.=" OR ( pdx BETWEEN '".$r_pi['pang_icd_start']."' AND "."'".$r_pi['pang_icd_start']."') ";
}//loop while row_concat_pttype
#$concat_icd_temp_all=substr($concat_icd_temp_all,0,strlen($concat_icd_temp_all)-2); #ตัด OR 2ลำดับท้าย
#หาค่าicd10

#หาค่าicd9
$s_pi9=" SELECT pang_icd FROM pang_icd9 LIMIT 100";
$concat_icd9_temp_all="";    
$q_pi9 = mysqli_query($con_money, $s_pi9) or die(mysqli_error($con_money));
while($r_pi9 = mysqli_fetch_array($q_pi9)){
  $concat_icd9_temp_all.=" OR ( icd9 = '".$r_pi9['pang_icd']."') ";
}
#หาค่าicd9


# pang_icd ######################################### กรณีเป็นผังที่สนใจ icd
      
      #icd10ที่สนใจ
      $concat_icd_all="";
      $s_pi_use=" SELECT pang_icd_start, pang_icd_end FROM pang_icd WHERE pang_id='$pang' LIMIT 100";
      $q_pi_use = mysqli_query($con_money, $s_pi_use) or die(mysqli_error('$s_pi_use'));
      while($r_pi_use = mysqli_fetch_array($q_pi_use)){
        $concat_icd_all.=" ( tpsi.pdx BETWEEN '".$r_pi_use['pang_icd_start']."' AND "."'".$r_pi_use['pang_icd_start']."') OR";
      }//loop while row_concat_pttype
      $concat_icd_all=substr($concat_icd_all,0,strlen($concat_icd_all)-2); #ตัด OR 2ลำดับท้าย
      #icd10ที่สนใจ

      #icd9ที่สนใจ
      $concat_icd9_all="";
      $s_pi9_use=" SELECT pang_icd FROM pang_icd9 WHERE pang_id='$pang' LIMIT 100";
      $q_pi9_use = mysqli_query($con_money, $s_pi9_use) or die(mysqli_error('$s_pi9_use'));
      while($r_pi9_use = mysqli_fetch_array($q_pi9_use)){
        $concat_icd9_all.=" ( tpsi.pdx = '".$r_pi9_use['pang_icd']."' ) OR";
      }//loop while row_concat_pttype
      $concat_icd9_all=substr($concat_icd9_all,0,strlen($concat_icd9_all)-2); #ตัด OR 2ลำดับท้าย
      #icd9ที่สนใจ

    if($concat_icd_all!="" || $concat_icd9_all!="" ){
      $left_join_icd=" LEFT JOIN $database_ii.$pang_str_replace tpsi ON o.vn=tpsi.vn ";
      if($concat_icd_all!=""){
        $where_icd=" AND (".$concat_icd_all.") ";
      }else{
        $where_icd=" ";  
      }

      if($concat_icd9_all!=""){
        if($concat_icd_all!=""){ $use_and_or="OR"; }else{ $use_and_or="AND"; }
        $where_icd9=" $use_and_or (".$concat_icd9_all.") ";
      }else{
        $where_icd9=" ";  
      }
      
    }else{
      $left_join_icd=" ";
      $where_icd=" AND o.vn NOT IN (select vn FROM $database_ii.$pang_str_replace ) ";
      $where_icd9=" ";
    }
# pang_icd ######################################### กรณีเป็นผังที่สนใจ icd

#ช่วงระยะเวลาปีงบ
$start_year_ngob=($y_s-1)."-10-01";
$end_year_ngob=$y_s."-09-30";
#ช่วงระยะเวลาปีงบ  


#สคริปสร้าง temp_ovst ตามด้วยรหัสผัง
  if($pang_kor_tok!=''){

  }else{

  }
  $pang_ovst_str_replace = "temp_ovst".str_replace(".","_",$pang); # ชื่อตารางเก็บ 
  $s_c_tempovst = "CREATE TABLE $pang_ovst_str_replace
                    SELECT
                    o.vn,o.hn,o.an,o.vstdate,o.pttype,o.hospmain
                    ,$select_uc_money AS uc_money
                    ,$select_kor_tok AS uc_money_kor_tok
                    ,v.pttypeno ,v.pdx ,v.income ,v.paid_money
                    ,p.cid
                    FROM $database.ovst o
                    LEFT JOIN $database.vn_stat v ON o.vn=v.vn
                    LEFT JOIN $database.patient p ON o.hn=p.hn
                    $left_outer_join
                    $left_join_icd
                    WHERE o.hn!='999999999'                
                    AND o.vstdate BETWEEN '$start_year_ngob' AND '$end_year_ngob'
                    $where_pttype
                    
                    $where_hospcode_in
                    $where_hospcode_notin
                    $where_icd
                    $where_icd9
                    AND (o.an IS NULL OR o.an ='')  
                    GROUP BY o.vn                          
                    LIMIT 500000 ";
#สคริปสร้าง temp_ovst ตามด้วยรหัสผัง

#สคริปสร้าง temp_pang_stamp ตามด้วยรหัสผัง
$temp_pang_stamp_str_replace = "temp_pang_stamp".substr(str_replace(".","_",$pang),0,14); # ชื่อตารางเก็บ 
$s_c_temp_ps = "CREATE TABLE $temp_pang_stamp_str_replace
                  SELECT 
                  pang_stamp_vn
                  ,pang_stamp_send
                  ,pang_stamp_uc_money 
                  ,pang_stamp_stm_money
                  ,pang_stamp
                  FROM pang_stamp
                  where pang_year = '$y_s' AND pang_stamp LIKE '".substr($pang,0,14)."%'
                  GROUP BY pang_stamp_vn
                  LIMIT 500000 ";
#สคริปสร้าง temp_pang_stamp ตามด้วยรหัสผัง

#สคริปสร้าง temp_stamp_icd ตามด้วยรหัสผัง
$s_create_tpsi_q="CREATE TABLE $pang_str_replace
                  SELECT * FROM (
                    SELECT vn, pdx, 'icd10' AS icd_type
                    FROM $database.vn_stat
                    WHERE vstdate BETWEEN '$start_year_ngob' AND '$end_year_ngob'                      
                    AND ( (pdx='99999') ".$concat_icd_temp_all.")
                    UNION
                    SELECT vn, icd9, 'icd9' AS icd_type
                    FROM $database.doctor_operation
                    WHERE begin_date_time BETWEEN '$start_year_ngob' AND '$end_year_ngob'
                    AND ( (icd9='99999') ".$concat_icd9_temp_all." )
                    LIMIT 500000
                  ) a
                  GROUP BY vn "; 
  #echo nl2br($s_create_tpsi_q);
#สคริปสร้าง temp_stamp_icd ตามด้วยรหัสผัง

#คิวรี่ insert เข้า pang_stamp_temp 
$s_del_pst="DELETE FROM pang_stamp_temp WHERE pang_stamp='$pang' AND pang_stamp_check_date<='$date_now' 
            AND vstdate BETWEEN '$start_year' AND '$end_year' ";


$s_pang_opd ="FROM $pang_ovst_str_replace o 
              \t\t  LEFT OUTER JOIN $database_ii.check_sit cs ON o.vn=cs.check_sit_vn 
              \t\t  LEFT OUTER JOIN $database_ii.$temp_pang_stamp_str_replace ps ON o.vn=ps.pang_stamp_vn              
              \t\t  $left_outer_join
              \t\t  $left_join_icd
              \t\t  WHERE o.hn!='999999999'                
              \t\t  AND o.vstdate BETWEEN '$start_year' AND '$end_year'
              \t\t  $where_pttype
              \t\t  $where_pang_stamp_isnull
              \t\t  $where_hospcode_in
              \t\t  $where_hospcode_notin
              \t\t  $where_icd
              \t\t  $where_icd9
              \t\t  AND (o.an IS NULL OR o.an ='')
					
				";
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
        ,uc_money AS 'uc_moneyx'
        ,ROUND(o.paid_money,2) AS 'paid_money'
        ,uc_money_kor_tok
        ,'$date_now' AS pang_stamp_check_date
        ,'$y_s' AS year_check
        ".$s_pang_opd."
        $where_vn_anisnull
        
        GROUP BY o.$s_vn_or_an 
        $having_s
        LIMIT 100000 ";
#คิวรี่ insert เข้า pang_stamp_temp 



if(@$_REQUEST["process"] == "y"){
  ##สร้าง temp_pang_stamp_icd    

  $s_drop_t_tpsi = "DROP TABLE IF EXISTS $pang_str_replace";
  $q_drop_t_tpsi = mysqli_query($con_money, $s_drop_t_tpsi) or die(nl2br($s_drop_t_tpsi));

  if($q_drop_t_tpsi){        
    $q_create_tpsi = mysqli_query($con_money, $s_create_tpsi_q) or die(nl2br($s_create_tpsi_q));
    $s_add_pk_tpsi = " ALTER TABLE $pang_str_replace ADD PRIMARY KEY(vn)";
    $q_add_pk_tpsi = mysqli_query($con_money, $s_add_pk_tpsi) or die(nl2br($s_add_pk_tpsi."|pang_opd_sql|s_add_pk_tpsi"));
  }    
  # pang_icd #########################################



  ##สร้าง temp_pang_stamp_icd

  #temp_ovst
  $s_drop_t_tovst = "DROP TABLE IF EXISTS $pang_ovst_str_replace";
  $q_drop_t_tovst = mysqli_query($con_money, $s_drop_t_tovst) or die(nl2br($s_drop_t_tovst));
  if($q_drop_t_tovst){
    $q_c_tempovst = mysqli_query($con_money, $s_c_tempovst) or die(nl2br($s_c_tempovst));
    $s_add_pk_tovst = " ALTER TABLE $pang_ovst_str_replace ADD PRIMARY KEY(vn)";
    $q_add_pk_tovst = mysqli_query($con_money, $s_add_pk_tovst) or die(nl2br($s_add_pk_tovst));
  }
  #temp_ovst

  

  #temp_pang_stamp
  $s_drop_t_tpang_stamp = "DROP TABLE IF EXISTS $temp_pang_stamp_str_replace";
  $q_drop_t_tpang_stamp = mysqli_query($con_money, $s_drop_t_tpang_stamp) or die(nl2br($s_drop_t_tpang_stamp));
  if($q_drop_t_tpang_stamp){
    $q_c_temp_ps = mysqli_query($con_money, $s_c_temp_ps) or die($s_c_temp_ps);
    $s_add_pk_tpang_stamp = " ALTER TABLE $temp_pang_stamp_str_replace ADD PRIMARY KEY(pang_stamp_vn)";
    $q_add_pk_tpang_stamp = mysqli_query($con_money, $s_add_pk_tpang_stamp) or die(nl2br($s_add_pk_tpang_stamp));
  }
  #temp_pang_stamp

  #คิวรี่สร้าง_temp_vn_ที่เป็นโรคเรื้อรัง_ต้องสร้างหลังจาก_temp_ovst_(เลขผัง)_ และต้องสร้างก่อน pang_stamp_tem
  // if(isset($pang_kor_tok)){
  //   $q_c_t_tpsc = mysqli_query($con_money, $s_c_t_tpsc) or die(nl2br($s_c_t_tpsc).'|pang_opd_kor_tok|$s_c_t_tpsc|query_in_pang_opd_sql');
  //   //$q_c_t_tpsc = mysqli_query($con_money, $s_c_t_tpsc) or die(nl2br($s_c_t_tpsc).'|pang_opd_kor_tok|$s_c_t_tpsc');
  // }
  #คิวรี่สร้าง_temp_vn_ที่เป็นโรคเรื้อรัง_ต้องสร้างหลังจาก_temp_ovst_(เลขผัง)_ และต้องสร้างก่อน pang_stamp_tem

  #pang_stamp_temp 
  $q_del_pst = mysqli_query($con_money, $s_del_pst) or die(mysqli_error($con_money)); #ลบ record เก่าก่อน
  $q_in_pst = mysqli_query($con_money, $s_in_pst) or die(nl2br ($s_in_pst));
  #pang_stamp_temp 

  
  
}

#กรณีเลือกข้อมูลจนถึงวันที่ต้องการstamp เพราะถ้าเอาทั้งเดือน มีโอกาสดึงvisitที่เปิดล่วงหน้า หรือ visit วันปัจุบันที่ยังรักษาไม่แล้วเสร็จ

#กรณีเลือกข้อมูลจนถึงวันที่ต้องการstamp เพราะถ้าเอาทั้งเดือน มีโอกาสดึงvisitที่เปิดล่วงหน้า หรือ visit วันปัจุบันที่ยังรักษาไม่แล้วเสร็จ
  #AND cs.check_sit_date>='$start_year'

?>