<?php

include("../connect/connect.php");
set_time_limit(0);
// some code

@session_start();
#$pang_stamp_user_stamp = $_SESSION["UserID"];

?>
<html>
<head>
<title></title>
</head>
<body>
<?php
@$date_now=date("Y-m-d");

@$pang=$_REQUEST["pang"];
@$pang_type=$_REQUEST["pang_type"];
@$m_s=$_REQUEST["m_s"];

if( isset($_SESSION["y_s"]) ){
    $y_s= $_SESSION["y_s"];
}else{
    $y_s = date("Y");
} 

if($m_s==1){$start_year=$y_s."-01-01"; $end_year=$y_s."-01-31";}
elseif($m_s==2){$start_year=$y_s."-02-01"; $end_year=$y_s."-02-29";}
elseif($m_s==3){$start_year=$y_s."-03-01"; $end_year=$y_s."-03-31";}
elseif($m_s==4){$start_year=$y_s."-04-01"; $end_year=$y_s."-04-30";}
elseif($m_s==5){$start_year=$y_s."-05-01"; $end_year=$y_s."-05-31";}
elseif($m_s==6){$start_year=$y_s."-06-01"; $end_year=$y_s."-06-30";}
elseif($m_s==7){$start_year=$y_s."-07-01"; $end_year=$y_s."-07-31";}
elseif($m_s==8){$start_year=$y_s."-08-01"; $end_year=$y_s."-08-31";}
elseif($m_s==9){$start_year=$y_s."-09-01"; $end_year=$y_s."-09-30";}
elseif($m_s==10){$start_year=($y_s-1)."-10-01"; $end_year=($y_s-1)."-10-31";}
elseif($m_s==11){$start_year=($y_s-1)."-11-01"; $end_year=($y_s-1)."-11-30";}
elseif($m_s==12){$start_year=($y_s-1)."-12-01"; $end_year=($y_s-1)."-12-31";}

if($pang_type=='OPD'){
  $pang_sql = "pang_opd_sql.php";
  $s_date = "o.vstdate";
  $s_ipd_an = ',null AS an';
  $show_adjrw = '1 AS rw'; #สำหรับ opd ใส่ 1 ไปเลย เพื่อให้มีค่า checkbox ขึ้น
  $s_vn_or_an = 'vn';
  $pttype_from_ovst_o_iptpttype = 'o.pttype';
  $colum_show_vst_or_dch = 'วันที่รับบริการ';
  $where_vn_anisnull = " AND ps.pang_stamp_vn IS NULL ";
  $having_s =' HAVING uc_moneyx >0 ';
  
}elseif($pang_type=='IPD'){
  $pang_sql = "pang_ipd_sql.php";
  $s_date = "o.vstdate";
  $s_ipd_an = ',o.an ';
  $show_adjrw = 'o.rw ';
  $s_vn_or_an = 'an';
  $pttype_from_ovst_o_iptpttype = 'o.pttype';
  $colum_show_vst_or_dch = 'วันที่จำหน่าย';
  $where_vn_anisnull = " AND ps.pang_stamp_an IS NULL ";
  $having_s =' HAVING uc_moneyx >0 ';
}

if($pang != ""){

  $s_del_pst="DELETE FROM pang_stamp_temp WHERE pang_stamp='$pang' AND pang_stamp_check_date<='$date_now' 
                      AND vstdate BETWEEN '$start_year' AND '$end_year' ";
  $q_del_pst = mysqli_query($con_money, $s_del_pst) or die(mysqli_error($con_money));


  $sql_pang_preview=" SELECT p.pang_id, p.pang_fullname, p.pang_instument, p.pang_stm, p.pang_kor_tok, p.pang_kor_tok_icd, p.pang_cancer
        FROM pang p LEFT OUTER JOIN pang_sub ps ON p.pang_id=ps.pang_id
                    WHERE p.pang_id='$pang' AND p.pang_year='$y_s'
                    LIMIT 100";
  $result_pang_preview = mysqli_query($con_money, $sql_pang_preview) or die($sql_pang_preview);
  $row_pang_preview = mysqli_fetch_array($result_pang_preview);
  @$pang_kor_tok = $row_pang_preview["pang_kor_tok"];

  include("$pang_sql");   
  

  //$date_now=date("Y-m-d");
                  
    #คิวรี่เดิม เพื่อ insert เข้า pang_stamp_temp ก่อน
    //$q_in_pst = mysqli_query($con_money, $s_in_pst) or die(nl2br ($s_in_pst));
    #คิวรี่เดิม เพื่อ insert เข้า pang_stamp_temp ก่อน


    #เช็คกรณีไม่เจอ visit เลย ป้องกันลูบ โดยให้ insert ข้อมูลเดือน 0 ลงไป
    $s_c_null=" SELECT pang_stamp_id
                FROM pang_stamp_temp psm 
                WHERE psm.pang_stamp = '$pang' AND psm.year_check ='$y_s'
                AND vstdate BETWEEN '$start_year' AND '$end_year'
                AND psm.pang_stamp_check_date = '$date_now'
                LIMIT 10";
    $q_c_null = mysqli_query($con_money, $s_c_null) or die(mysqli_error($con_money));
    $r_c_null=mysqli_fetch_array($q_c_null);
    @$pang_stamp_id = $r_c_null["pang_stamp_id"];
      #insert เดือน 0 
      if($pang_stamp_id==''){
        $s_in_psm_null = "INSERT INTO pang_stamp_temp VALUES
                          ('','',null,'','','$start_year','$pang','','','','','','','','',''
                          ,'$date_now','$y_s') ";  
        $q_in_psm_null = mysqli_query($con_money, $s_in_psm_null) or die(mysqli_error($con_money));
      }
      #insert เดือน 0 
    #เช็คกรณีไม่เจอ visit เลย ป้องกันลูบ โดยให้ insert ข้อมูลเดือน 0 ลงไป
  


  if($q_in_pst){
?>
    <script>
      window.location.href= 'index.php?pang=<?= $pang?>&pang_type=<?= $pang_type?>&m_s=<?= $m_s?>';
    </script>
<?php
  }
   
}
?>
</body>
</html>