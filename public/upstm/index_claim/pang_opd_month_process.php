<?php

include("../connect/connect.php");
set_time_limit(0);

@session_start();
//$pang_stamp_user_stamp = $_SESSION["UserID_BN"];
// function tab2nbsp($str){
//   return str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $str); 
// }
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

#ช่วงระยะเวลาปีงบ
$start_year_ngob=($y_s-1)."-10-01";
$end_year_ngob=$y_s."-09-30";
#ช่วงระยะเวลาปีงบ

$pang_type=$_REQUEST["pang_type"];
          // if($pang_type=='OPD'){
          //   $pang_sql = "pang_opd_sql.php";
          //   $s_date = "o.vstdate";
          //   $s_pst_date = "ps.pang_stamp_vstdate";
          //   $having_s =' HAVING uc_moneyx >0 ';
          // }elseif($pang_type=='IPD'){
          //   $pang_sql = "pang_ipd_sql.php";
          //   $s_date = "o.vstdate"; # vstdate=dchdate
          //   $s_pst_date = "ps.pang_stamp_dchdate";
          //   $having_s =' HAVING uc_moneyx >0 ';
          // }else{
          // }
if($pang_type=='OPD'){
  $pang_sql = "pang_opd_sql.php";
  $s_date = "o.vstdate";
  $s_ipd_an = ',null AS an';
  $show_adjrw = '1 AS rw'; #สำหรับ opd ใส่ 1 ไปเลย เพื่อให้มีค่า checkbox ขึ้น
  $s_vn_or_an = 'vn';
  $pttype_from_ovst_o_iptpttype = 'o.pttype';
  $colum_show_vst_or_dch = 'วันที่รับบริการ';
  $where_vn_anisnull = " AND ps.pang_stamp_vn IS NULL ";
  $having_s =' HAVING uc_money >0 ';
  
}elseif($pang_type=='IPD'){
  $pang_sql = "pang_ipd_sql.php";
  $s_date = "o.vstdate";
  $s_ipd_an = ',o.an ';
  $show_adjrw = 'o.rw ';
  $s_vn_or_an = 'an';
  $pttype_from_ovst_o_iptpttype = 'o.pttype';
  $colum_show_vst_or_dch = 'วันที่จำหน่าย';
  $where_vn_anisnull = " AND ps.pang_stamp_an IS NULL ";
  $having_s =' HAVING uc_money >0 ';
}

          
include("$pang_sql");
          $s_in_psm = "INSERT INTO $database_ii.pang_stamp_month_temp
            SELECT a.pang_stamp_month_id, a.pang_stamp, a.year_check , a.pang_stamp_month_check,COUNT(a.no_stamp) AS no_stamp
            ,COUNT(a.stamp) AS stamp,COUNT(a.stamp_send) AS stamp_send, COUNT(a.stamp_stm) AS stamp_stm 
            , SUM(a.uc_moneyx) AS uc_money, SUM(a.stm_money) AS stm_money 
            ,a.year_mon, a.mon
            FROM
            (
            \t  SELECT * FROM (
            \t\t  (SELECT
            \t\t  '' AS pang_stamp_month_id
            \t\t  ,'$pang' AS pang_stamp
            \t\t  ,'$y_s' AS year_check
            \t\t  ,'$date_now' AS pang_stamp_month_check
            \t\t  ,if(ps.pang_stamp_vn IS NULL OR ps.pang_stamp_vn='',o.vn,null) AS no_stamp
            \t\t  ,if(ps.pang_stamp_uc_money!=0 AND ps.pang_stamp_send IS NULL,o.vn,null) AS stamp
				    \t\t  ,if(ps.pang_stamp_uc_money!=0 AND ps.pang_stamp_send IS NOT NULL,o.vn,null) AS stamp_send
            \t\t  #old,if(ps.pang_stamp_id IS NOT NULL OR ps.pang_stamp_id!='',o.vn,null) AS stamp
            \t\t  ,if(ps.pang_stamp_stm_money IS NOT NULL OR ps.pang_stamp_stm_money!='',o.vn,null) AS stamp_stm

            \t\t  ,uc_money AS uc_moneyx
            \t\t  ,'' AS stm_money

            \t\t  ,DATE_FORMAT($s_date,'%Y-%m') AS year_mon
            \t\t  ,DATE_FORMAT($s_date,'%m') AS mon 
            \t\t  ,o.vn
            \t\t  ".$s_pang_opd." 
            \t\t  GROUP BY o.vn $having_s LIMIT 500000 

            \t\t  )
            \t\t  UNION
            \t\t  (
            
            \t\t  SELECT
            \t\t  '' AS pang_stamp_month_id
            \t\t  ,'$pang' AS pang_stamp
            \t\t  ,'$y_s' AS year_check
            \t\t  ,'$date_now' AS pang_stamp_month_check
            \t\t  ,null AS no_stamp
            \t\t  ,IF(pss.pang_stamp_send IS NULL ,pss.pang_stamp_vn,null) AS stamp
            \t\t  ,IF(pss.pang_stamp_send IS NOT NULL ,pss.pang_stamp_vn,null) AS stamp_send

            \t\t  ,if(pss.pang_stamp_stm_money IS NOT NULL OR pss.pang_stamp_stm_money!='',pss.pang_stamp_vn,null) AS stamp_stm

            \t\t  ,SUM(pss.pang_stamp_uc_money) AS uc_money
            \t\t  ,SUM(pss.pang_stamp_stm_money) AS stm_money

            \t\t  ,DATE_FORMAT(pss.pang_stamp_vstdate,'%Y-%m') AS year_mon
            \t\t  ,DATE_FORMAT(pss.pang_stamp_vstdate,'%m') AS mon
            \t\t  ,pss.pang_stamp_vn AS vn
            \t\t  FROM $database_ii.pang_stamp pss
            \t\t  WHERE pss.pang_stamp_vstdate BETWEEN '$start_year' AND '$end_year'               
            \t\t  AND pss.pang_stamp = '$pang'           
            \t\t  GROUP BY pss.pang_stamp_vn HAVING uc_money >0 LIMIT 500000
            \t\t  )

            \t  )b GROUP BY b.vn   


            ) a GROUP BY a.year_mon
          ";
          #echo nl2br ($s_in_psm);

if(@$_REQUEST["process"] == "y"){

  $s_del_pst="DELETE FROM pang_stamp_month_temp WHERE pang_stamp='$pang' AND pang_stamp_month_check<='$date_now' 
                      AND year_check ='$y_s' ";
  $q_del_pst = mysqli_query($con_money, $s_del_pst) or die(mysqli_error($con_money));

  if($q_del_pst){
          
    $q_in_psm = mysqli_query($con_money, $s_in_psm) or die(nl2br($s_in_psm));

    #เช็คกรณีไม่เจอ visit เลย ป้องกันลูบ โดยให้ insert ข้อมูลเดือน 0 ลงไป
    $s_c_null=" SELECT pang_stamp_month_id
                FROM pang_stamp_month_temp psm 
                WHERE psm.pang_stamp = '$pang' AND psm.year_check ='$y_s'
                AND psm.pang_stamp_month_check = '$date_now'
                LIMIT 10";
    $q_c_null = mysqli_query($con_money, $s_c_null) or die(mysqli_error($con_money));
    $r_c_null=mysqli_fetch_array($q_c_null);
    @$pang_stamp_month_id = $r_c_null["pang_stamp_month_id"];
      #insert เดือน 0 
      if($pang_stamp_month_id==''){
        $s_in_psm_null = "INSERT INTO pang_stamp_month_temp VALUES
                          ('','$pang','$y_s','$date_now','0','0','0','0','0','0','0','0') ";  
        $q_in_psm_null = mysqli_query($con_money, $s_in_psm_null) or die(mysqli_error($con_money));
      }
      #insert เดือน 0 
    #เช็คกรณีไม่เจอ visit เลย ป้องกันลูบ โดยให้ insert ข้อมูลเดือน 0 ลงไป
  ?>
    <script>
      window.location.href= 'index.php?pang=<?= $pang?>&pang_type=<?= $pang_type?>';
    </script>
  <?php
  }
   
}
?>
</body>
</html>