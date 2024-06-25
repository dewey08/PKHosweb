<?php

include("../connect/connect.php");
@include('../session/session.php');
set_time_limit(0);
// some code

@session_start();

@$pang=$_GET['pang'];
$pang_type=$_GET["pang_type"];

$m_s=$_GET["m_s"];

#เงื่อนไขผัง
if(isset($_GET["pang"])){
    $pang = $_SESSION["pang"] = $_GET["pang"];
}else{
    $pang = $_SESSION["pang"];
}

#ประกาศคิวรี่ข้อมูลผังอีกครั้ง เพราะค่า $end_year ใน pang_opd_sql.php มีผลกระทบต่อ ค่า max date_sir_pang_opd
$sql_pang_preview=" SELECT p.pang_id, p.pang_fullname, p.pang_instument
                  , p.pang_stm, p.pang_kor_tok, p.pang_kor_tok_icd, p.pang_cancer
                  
                  FROM pang p 
                  WHERE p.pang_id='$pang' AND p.pang_year='$y_s'
                  LIMIT 100";
    #echo nl2br (tab2nbsp($sql_pang_preview));
$result_pang_preview = mysqli_query($con_money, $sql_pang_preview) or die(mysqli_error($con_money));
$row_pang_preview = mysqli_fetch_array($result_pang_preview);

$pang_id = $row_pang_preview["pang_id"];
$pang_fullname = $row_pang_preview["pang_fullname"];

  #,(SELECT pang_id FROM pang_icd WHERE pang_id=p.pang_id LIMIT 1)check_pang_icd
  #$check_pang_icd = $row_pang_preview["check_pang_icd"];

#ประกาศคิวรี่ข้อมูลผังอีกครั้ง เพราะค่า $end_year ใน pang_opd_sql.php มีผลกระทบต่อ ค่า max date_sir_pang_opd


#เช็คว่ามีการ insert ข้อมูลเข้า pang_stamp_temp ไปหรือยัง และเช็คการประมวลผลประจำวัน ว่าเป็นวันปัจจุบันแล้วหรือยัง
$date_now=date("Y-m-d");
$s_check_pst = "SELECT MIN(pang_stamp_check_date) AS pang_stamp_check_date FROM pang_stamp_temp 
                WHERE pang_stamp_check_date<='$date_now' 
                AND pang_stamp='$pang'
                AND vstdate BETWEEN '$start_year' AND '$end_year'
                 LIMIT 1 ";
$q_check_pst = mysqli_query($con_money, $s_check_pst) or die(mysqli_error($con_money));
$r_check_pst = mysqli_fetch_array($q_check_pst);
@$pang_stamp_check_date = $r_check_pst["pang_stamp_check_date"];
if($pang_stamp_check_date!='' && $pang_stamp_check_date<$date_now){
  ?>
    <script>
      window.location.href= 'pang_opd_process.php?pang=<?= $pang?>&pang_type=<?= $pang_type?>&m_s=<?= $m_s?>';
    </script>
  <?php
}
#เช็คว่ามีการ insert ข้อมูลเข้า pang_stamp_temp ไปหรือยัง และเช็คการประมวลผลประจำวัน ว่าเป็นวันปัจจุบันแล้วหรือยัง



# pang_cancer ###########
/*
if(isset($row_pang_preview["pang_cancer"])){
  $where_pang_cancer = " AND v.pdx LIKE 'C%' ";
}else{
  $where_pang_cancer = " AND v.pdx NOT LIKE 'C%' ";
}
*/
# pang_cancer ###########


if((@$_POST["date_sir_f"])!=''&&(@$_POST["date_sir_s"])!='' ){
  $date_sir_f= $_SESSION["date_sir_f"] = $_POST['date_sir_f'];
  $date_sir_s= $_SESSION["date_sir_s"] = $_POST['date_sir_s'];
  $where_vstdate=" AND o.vstdate BETWEEN '$date_sir_f' AND '$date_sir_s' ";
}elseif(isset($_POST['date_sir_f'])){
  $date_sir_f= $_SESSION["date_sir_f"] = $_POST['date_sir_f'];
  $where_vstdate=" AND o.vstdate='$date_sir_f' ";
  unset($_SESSION["date_sir_s"]);
}elseif(isset($_SESSION["date_sir_f"])&&isset($_SESSION["date_sir_s"])){
  $date_sir_f= $_SESSION["date_sir_f"];
  $date_sir_s= $_SESSION["date_sir_s"];
  $where_vstdate=" AND o.vstdate BETWEEN '$date_sir_f' AND '$date_sir_s' ";
}elseif(isset($_SESSION["date_sir_f"])){
  $date_sir_f= $_SESSION["date_sir_f"];
  $where_vstdate=" AND o.vstdate='$date_sir_f' ";
}

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
      
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script><!--modal-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables_themeroller.css">
    <link rel="stylesheet" type="text/css" href="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
    <link href="https://cdn.datatables.net/select/1.1.2/css/select.dataTables.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>     
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/input_datatable.css"/><!-- css สำหรับเปลี่ยน search ให้เห็นกรอบ -->

  </head>
      
  <body>





  <?php 
  
  if(@$_REQUEST['date_sir_pang_opd']){
    $date_sir_pang_opd = $_SESSION['date_sir_pang_opd'] = $_REQUEST['date_sir_pang_opd'];
    #echo "ONE";
  }elseif( @$_SESSION['date_sir_pang_opd']<$start_year || @$_SESSION['date_sir_pang_opd']>$end_year ){
    $date_sir_pang_opd = $_SESSION['date_sir_pang_opd'] = $end_year;
    #echo "THREE";
  }elseif($_SESSION['date_sir_pang_opd'] != ''){
    $date_sir_pang_opd = $_SESSION['date_sir_pang_opd'];
    #echo "TWO";
  }
  #$date_sir_pang_opd = $_REQUEST['date_sir_pang_opd'];
  

  ?>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">  
            <h2>ผังบัญชี<?php echo $pang_id." - ".$pang_fullname; #echo $start_year.'|'.$end_year;?> </h2>  
              <div class="table-responsive">

                <div class="form-row align-items-center">
                  <div class="col-auto">
                    <form method="post" action="<?php echo $backto;?>">
                        กำหนด Visit จนถึง
                        <input class=""  type="text" name="date_sir_pang_opd" id="date_sir_pang_opd" value="<?php echo $date_sir_pang_opd?>" readonly="">

                        <button class="btn btn-primary" type="submit">Preview</button>
                    </form>
                  </div>

                  
                    
                  <?php
                  if($pang_type=='OPD'){
                    $pang_sql = "pang_opd_sql.php";
                    $s_date = "o.vstdate";
                    $s_ipd_an = ',null AS an';
                    $show_adjrw = '1 AS rw'; #สำหรับ opd ใส่ 1 ไปเลย เพื่อให้มีค่า checkbox ขึ้น
                    $s_vn_or_an = 'vn';
                    $pttype_from_ovst_o_iptpttype = 'o.pttype';
                    $colum_show_vst_or_dch = 'วันที่รับบริการ';
                    $having_s =' HAVING uc_money >0 ';

                    

                    
                  }elseif($pang_type=='IPD'){
                    $pang_sql = "pang_ipd_sql.php";
                    $s_date = "v.dchdate AS vstdate";
                    $s_ipd_an = ',v.an AS an';
                    $show_adjrw = 'o.rw AS rw';
                    $s_vn_or_an = 'an';
                    $pttype_from_ovst_o_iptpttype = 'ip.pttype';
                    $colum_show_vst_or_dch = 'วันที่จำหน่าย';
                    $having_s =' HAVING SUM(uc_money) <>0 ';
                  }else{
                  }
                  include("$pang_sql");

                  $s_drop_t_pssr = "DROP TABLE IF EXISTS $pang_stamp_hos_str_replace";
                  $q_drop_t_pssr = mysqli_query($con_money, $s_drop_t_pssr);

                  if($q_drop_t_pssr){                  
                  echo $s_create_in_pst = "CREATE TABLE $database_ii.$pang_stamp_hos_str_replace
                              SELECT '' AS pang_stamp_id,o.vn,o.hn $s_ipd_an
                              , if(p.cid like '0%', v.pttypeno, p.cid) AS cid
                              ,$s_date
                              ,'$pang' AS pang_stamp
                              ,$pttype_from_ovst_o_iptpttype

                              ,v.pdx AS icd
                              ,$show_adjrw
                              ,v.income AS 'income'
                              ,v.uc_money AS 'uc_money'
                              ,v.paid_money AS 'paid_money'
                              ,$select_kor_tok AS uc_money_kor_tok
                              ,'$date_now' AS pang_stamp_check_date
                              ".$s_pang_opd_temp."
                              
                              GROUP BY o.$s_vn_or_an 
                              $having_s
                              LIMIT 10000 ";
                  $q_create_in_pst = mysqli_query($con_hos, $s_create_in_pst);
                  }

                  $s_in_pst = "INSERT INTO $database_ii.pang_stamp_temp
                              SELECT o.pang_stamp_id,o.vn,o.hn ,o.an
                              ,o.cid
                              ,o.vstdate
                              ,o.pang_stamp
                              ,o.pttype
                              
                              ,cs.check_sit_subinscl

                              ,IF(cs.check_sit_status='003'
                            \t  ,'จำหน่าย/เสียชีวิต'
                            \t  ,CONCAT(cs.check_sit_subinscl,' (',IFNULL(cs.check_sit_hmain,''),') ',cs.check_sit_date ) 
                              ) AS 'pttype_stamp'

                              ,o.icd
                              ,o.rw
                              ,o.income
                              ,o.uc_money
                              ,o.paid_money
                              ,o.uc_money_kor_tok
                              ,o.pang_stamp_check_date
                              ".$s_pang_opd."

                              
                              GROUP BY o.$s_vn_or_an 
                              $having_s
                              LIMIT 10000 ";
                              #echo nl2br (tab2nbsp($s_in_pst));

                  $date_now=date("Y-m-d");

                  #กรณีมีการ ระบุวันที่ preview
                  if(@$date_sir_pang_opd!=''){
                    $end_year=$date_sir_pang_opd;
                  }
                  #กรณีมีการ ระบุวันที่ preview

                  if($pang_stamp_check_date==''){ 
                                    
                    
                    #คิวรี่เดิม เพื่อ insert เข้า pang_stamp_temp ก่อน
                    $q_in_pst = mysqli_query($con_money, $s_in_pst) or die(mysqli_error($con_money));
                    #คิวรี่เดิม เพื่อ insert เข้า pang_stamp_temp ก่อน

                    if($q_in_pst){
                      $sqlshow="SELECT *
                                FROM pang_stamp_temp pst 
                                WHERE pst.pang_stamp = '$pang' AND pst.pang_stamp_check_date ='$date_now'
                                AND pst.vstdate BETWEEN '$start_year' AND '$end_year'
                                LIMIT 10000
                      ";
                    }
                    
                  }else{
                      $sqlshow="SELECT *
                                FROM pang_stamp_temp pst 
                                WHERE pst.pang_stamp = '$pang' AND pst.pang_stamp_check_date ='$date_now'
                                AND pst.vstdate BETWEEN '$start_year' AND '$end_year'
                                LIMIT 10000
                      ";
                  }
                
                  $result_show = mysqli_query($con_money, $sqlshow) or die(mysqli_error($con_money));
                  ?>

                  <!-- Modal sql -->    
                  <div class="col-auto">
                    <button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">SQL</button>
                  </div>
                  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Modal SQL</h5>
                          <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                          </button>
                        </div>
                        
                        <div class="modal-body"><?php echo nl2br (tab2nbsp($s_in_pst));?></div>
                        
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <!--
                          <button type="button" class="btn btn-primary">Save changes</button>
                          -->
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Modal sql -->                                   



                  <?php 
                  #include("index_claim/pang_opd_stamped.php");
                  

                  #หาค่า VN และ Cid เพื่อไปเก็บไว้ที่ตาราง check_sit เพื่อรอเช็คสิทธิต่อไป
                  $concat_vn_cid="";
                  $q_for_checksit = mysqli_query($con_money, $sqlshow) or die(mysqli_error($con_money));
                  while($r_for_checksit = mysqli_fetch_array($q_for_checksit)){
                    $concat_vn_cid.=$r_for_checksit['vn'].'_'.$r_for_checksit['cid'].'_'.$r_for_checksit['vstdate'].","; // สำหรับส่งออกทั้งหมด
                  }
                  $concat_vn_cid=substr($concat_vn_cid,0,strlen($concat_vn_cid)-1);//ตัดคอมม่าตัวสุดท้ายออก
                  #หาค่า VN และ Cid เพื่อไปเก็บไว้ที่ตาราง check_sit เพื่อรอเช็คสิทธิต่อไป
                  ?>

                  <div class="col-auto">
                    <form method="post" action="../check_sit/get_vn_cid.php" target="_blank">
                      <input type="hidden" name="pang" value="<?php echo $pang; ?>">
                      <input type="hidden" name="pang_type" value="<?php echo $pang_type; ?>">
                      <input type="hidden" name="m_s" value="<?php echo $m_s; ?>">
                      <input type="hidden" name="concat_vn_cid" value="<?php echo $concat_vn_cid; ?>">
                      <button class="btn btn-primary" type="submit">ตรวจสอบสิทธิ</button>
                    </form>
                  </div>

                  <div class="col-auto">
                    <!-- <a class="btn btn-info" href="pang_opd_process.php?pang=<?= $pang?>&pang_type=<?= $pang_type?>&m_s=<?= $m_s?>" >
                      ประมวลผลใหม่
                    </a> -->
                    <form name="form" id="form"  method="post" action="pang_opd_process.php" enctype="multipart/form-data" onsubmit="document.getElementById('btnSubmit').disabled=true;document.getElementById('btnSubmit').value='ประมวลผลใหม่, กรุณารอสักครู่...';">
                      <input type="hidden" name="pang" value="<?php echo $pang?>">
                      <input type="hidden" name="pang_type" value="<?php echo $pang_type?>">
                      <input type="hidden" name="m_s" value="<?php echo $m_s?>">
                      
                        <!-- <button id='btnSubmit' class="btn btn-info" type="submit">ประมวลผลใหม่</button> -->
                        <input class="btn btn-info" id='btnSubmit' type="submit" value="ประมวลผลใหม่" >
                      
                        
                    </form>

                  </div>
                  
                  <div class="col-auto">
                    <button class="btn btn-success view_pang_setting_detail" id="<?php echo $pang;?>" data-target=".bd-example-modal-lg">เงื่อนไขผัง</button>
                  </div>
                    
                  
                </div>
        
                <div class="">
                  <form method="post" action="pang_opd_stamp.php" onsubmit="document.getElementById('btnSubmitStamp').disabled=true;document.getElementById('btnSubmitStamp').value='กำลัง Stamp, กรุณารอสักครู่...';" >
                      
                    <!-- <button class="btn btn-primary" type="submit">Stamp</button> -->
                    <input class="btn btn-primary" id='btnSubmitStamp' type="submit" value="Stamp" >

                    <input type="hidden" name="backto" value="<?php echo $backto?>" >
                    <input type="hidden" name="pang_type" value="<?php echo $pang_type?>" >


                    <table id="example" class="table table-striped table-hover"   >
                      <thead>
                        <tr>
                          <th><input  name="select_all" value="1" type="checkbox" autocomplete="off"></th>

                          <th><div align="center">ลำดับ</div></th>
                        
                          <th class="text-nowrap"><div align="center">HN(การรักษา)</div></th>
                          <th class="text-nowrap"><div align="center"><?=$colum_show_vst_or_dch?></div></th>

                          <th class="text-nowrap"><div align="center">สิทธิส่งตรวจ</div></th>

                          <th class="text-nowrap"><div align="center">สิทธิตาม สปสช</div></th>

                          <th class="text-nowrap"><div align="center">icd</div></th>
                          
                          <?php
                          if($pang_type=='IPD'){
                          ?>
                          <th class="text-nowrap"><div align="center">rw</div></th>
                          <?php
                          }
                          ?>

                          <th class="text-nowrap"><div align="center">ค่าใช้จ่ายทั้งหมด</div></th>

                          <th class="text-nowrap"><div align="center">ค่าลูกหนี้ทั้งหมด</div></th>

                          <th class="text-nowrap"><div align="center">ยอดที่ชำระเอง</div></th>
                                             
                        </tr>
                      </thead>

                      <tbody>


                      <?php                  

                      $no=0;
                      while($row_show = mysqli_fetch_array($result_show)){
                      $vn = $row_show["vn"];
                      $view_income_vn_or_an = $row_show["$s_vn_or_an"];
                      $no++;
                        ?>

                        <tr>
                          <?php
                          if(isset($pang_kor_tok)){ ## if ตรวจสอบว่ามีการกำหนดข้อตกลงหรือไม่
                          ?>
                          <?php 
                          ############# ข้อตกลง ########################## กรณีข้อตกลง จะดึงยอดเงินตามที่กำหนดไว้ในข้อตกลงไปบันทึกแทน
                            $uc_money = $row_show['uc_money'];
                            $sum_price_kor_tok = $row_show['uc_money_kor_tok'];
                            
                            #เงือนไขเงิน US, Refer

                            #เงือนไขเงิน US, Refer

                            if($uc_money>$pang_kor_tok){
                              @include("pang_opd_kor_tok.php");

                            }elseif($uc_money<=$pang_kor_tok){
                              $uc_money_kor_tok = $uc_money+$sum_price_kor_tok;
                            }
                          ############# ข้อตกลง ########################## กรณีข้อตกลง จะดึงยอดเงินตามที่กำหนดไว้ในข้อตกลงไปบันทึกแทน             
                          ?>

                          <?php  
                          }
                          ?>

                          <?php
                          # ดักจับ ต้องมี rw ก่อน ถึงจะสแตมป์ได้ เฉพาผัง 1102050101.302 และต่างด้าว(รอเพิ่มต่างด้าว)
                          if($pang=='1102050101.302'){
                            $if_rw ="rw";
                          }else{
                            $if_rw ="hn";
                          }
                          
                          if($row_show["pttype_stamp"]!='' && $row_show['uc_money']!='' && $row_show['uc_money']>0 ){
                          ?>
                          <!--0-->
                          <td>
                            <input type="checkbox" name="vn[]" value="<?php echo $view_income_vn_or_an.$row_show['uc_money'].'|'.@$uc_money_kor_tok.'|'.@$row_show['rw']?>" >
                            <!-- $view_income_vn_or_an ตัวแปรสำหรับ opd=vn ipd=an -->
                          </td>
                          <input type="hidden" name="pang" value="<?php echo $pang?>">
                          <?php
                          }else{
                          ?>
                          <td></td>
                          <?php
                          }
                          ?>


                          <td class="text-nowrap">
                            <?php
                            //echo $no;
                            ?>
                          </td>
                          


                          <td class="text-nowrap">
                            <button type="button" name="view_patient" class="btn mb-1 btn-secondary view_patient" id="<?php echo $vn;?>"  >
                              <?php echo $row_show["hn"]; ?>
                            </button>
                          </td>


                          <td class="text-nowrap">
                            <?php
                            echo DateThaisubmonth($row_show["vstdate"]);
                            ?>
                          </td> 


                          <td class="text-nowrap">
                            <?php
                            if($row_show['pttype']!=$row_show['check_sit_subinscl']){
                            ?>
                              <button type="button" name="view_pttype" class="btn mb-1 btn-danger view_pttype" id="<?php echo $vn;?>"  >
                              <?php echo "z-".$row_show["pttype"]; ?>
                              </button>
                            <?php
                            }else{
                              ?>
                              <button type="button" name="view_pttype" class="btn mb-1 btn-success view_pttype" id="<?php echo $vn;?>"  >
                              <?php echo $row_show["pttype"]; ?>
                              </button>
                            <?php
                            }
                            ?>

                            <?php 
                            #กรณีผัง 401 ให้แสดงข้อมูล EDC
                            if($pang=='1102050101.401'){
                              $s_edc="SELECT sss_approval_code FROM rcpt_debt WHERE vn='$view_income_vn_or_an ' LIMIT 1";
                              $q_edc = mysqli_query($con_hos, $s_edc) or die(mysqli_error($con_hos));
                              $r_edc = mysqli_fetch_array($q_edc);
                              echo " (EDC:".$r_edc['sss_approval_code'].")";
                            }
                            #กรณีผัง 401 ให้แสดงข้อมูล EDC
                            ?>
                          </td>

                          <td class="text-nowrap">
                            <?php
                            echo $row_show["pttype_stamp"];
                            ?>
                          </td>


                          <td class="text-nowrap" align="left">
                            <button type="button" name="view_choose_icd" class="btn btn-info view_choose_icd" id="<?php echo $vn;?>"  >
                              <?php echo $row_show["icd"]; ?>
                            </button>
                          </td>



                          <!-- RW -->
                          <?php
                          if($pang_type=='IPD'){
                          ?>
                          <td class="text-nowrap" align="right">
                            <?php
                            if($row_show["rw"]==0){
                            ?>
                              <button type="button" class="btn btn-danger ">
                              <?php echo $row_show["rw"]; ?>
                              </button>
                            <?php
                            }elseif($row_show["rw"]>=2){
                              ?>
                                <button type="button" class="btn btn-success ">
                                <?php echo $row_show["rw"]; ?>
                                </button>
                              <?php
                            }else{
                              echo $row_show["rw"]; 
                            }
                            ?>
                          </td>
                          <?php
                          }
                          ?>
                          <!-- RW -->
                            
                          
                          <td class="text-nowrap" align="right">
                              
                              <!--
                              <a tabindex="0" onclick="showCustomer(this.id)" class="btn btn-md btn-primary" data-bs-placement="left" role="button" data-bs-toggle="popover" data-bs-html="true"  title="รายการค่ารักษา" 
                              data-bs-content="<div id='txtHint'></div>" id="<?php echo $vn; ?>"><?php echo number_format($row_show["income"],2); ?>
                              </a>
                              -->

                              <button type="button" name="view_income" class="btn btn-primary view_income" id="<?php echo $view_income_vn_or_an;?>"  >
                              <?php echo number_format($row_show["income"],2); ?>
                            </button>
                          </td>
                          <?php

                          

                          ############# ข้อตกลง ##########################

                          #ตรวจสอบว่าเงินลูกหนี้เป็นค่าว่างหรือไม่ ถ้าเป็นแสดงว่าไม่ได้กำหนดวงเงิน ในสิทธิ ipt_pttype เกิน 2 สิทธิ
                          if($row_show["uc_money"]=='')
                          {
                            $uc_money_show='<span class="label label-pill label-danger text-white">ตรวจสอบวงเงิน</span>';
                          }elseif($row_show["uc_money"]<0)
                          {
                            $uc_money_show='<span class="label label-pill label-warning ">'.number_format($row_show["uc_money"],2).'</span>';
                          }
                          else
                          {
                            $uc_money_show=number_format($row_show["uc_money"],2);
                          }
                          #ตรวจสอบว่าเงินลูกหนี้เป็นค่าว่างหรือไม่ ถ้าเป็นแสดงว่าไม่ได้กำหนดวงเงิน ในสิทธิ ipt_pttype เกิน 2 สิทธิ
                          
                          if(isset($pang_kor_tok)){ ## if ตรวจสอบว่ามีการกำหนดข้อตกลงหรือไม่
                          ?>
                          <td class="text-nowrap" align="right">
                            <?php 
                            echo $uc_money_show."<span style='color:red;'>(".number_format($uc_money_kor_tok,2).")</span>";;
                            ?>
                          </td>
                          <?php  
                          }else{ ## if ตรวจสอบว่ามีการกำหนดข้อตกลงหรือไม่
                            ?>
                          <td class="text-nowrap" align="right">
                            <?php echo $uc_money_show; ?>
                          </td>
                            <?php 
                          } ## else ตรวจสอบว่ามีการกำหนดข้อตกลงหรือไม่

                          ############# ข้อตกลง ##########################

                          ?>


                          <td class="text-nowrap" align="left">
                            <?php echo number_format($row_show["paid_money"],2); ?>
                          </td>

                          

                            
                        </tr>
                      <?php
                        
                      }// loop while
                      ?>
                    

                      </tbody>
                    </table>
                  </form>
                </div>

            </div>
          </div>
        </div>
      </div>
    </div>

  <script>
  var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
  var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl)
  })

  $('body').on('click', function (e) {
      $('[data-bs-toggle=popover]').each(function () {
          // hide any open popovers when the anywhere else in the body is clicked
          if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
              $(this).popover('hide');
          }
      });
  });

  </script>

  <script>
  function showCustomer(str) {
    var xhttp;    
    if (str == "") {
      document.getElementById("txtHint").innerHTML = "";
      return;
    }
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "getcustomer.php?q="+str, true);
    xhttp.send();
  }
  </script>

  <script>
  function showCus(str) {
    var xhttp;    
    if (str == "") {
      document.getElementById("txtHin").innerHTML = "";
      return;
    }
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHin").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "getcustomers.php?q="+str, true);
    xhttp.send();
  }
  </script>


  <script>
  function showicd(str) {
    var xhttp;    
    if (str == "") {
      document.getElementById("txtHin").innerHTML = "";
      return;
    }
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("show_icd").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "index_claim/get_icd.php?q="+str, true);
    xhttp.send();
  }
  </script>

  <script>
  function show_person(str) {
    
    var xhttp;    
    if (str == "") {
      document.getElementById("txtHin").innerHTML = "";
      return;
    }
    xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
       
        document.getElementById("show_person").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "index_claim/get_person.php?q="+str, true);
    xhttp.send();
  }

  </script>


  <script type="text/javascript">
  $(document).ready(function (){
       
    /** Handling checboxes selection*/
       
    function updateDataTableSelectAllCtrl(table){
      var $table             = table.table().node();
      var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
      var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
      var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

      // If none of the checkboxes are checked
      if($chkbox_checked.length === 0){
          chkbox_select_all.checked = false;
          
        if('indeterminate' in chkbox_select_all){
          chkbox_select_all.indeterminate = false;
        }

      // If all of the checkboxes are checked
      }else if($chkbox_checked.length === $chkbox_all.length){
        chkbox_select_all.checked = true;
        if('indeterminate' in chkbox_select_all){
           chkbox_select_all.indeterminate = false;
        }

      // If some of the checkboxes are checked
      }else{
        chkbox_select_all.checked = true;
        if('indeterminate' in chkbox_select_all){
          chkbox_select_all.indeterminate = true;
        }
      }
    }
   
  /** Responsive table with colreorder, fixed header;footer, sortable teble*/
  var table = $('#example').DataTable({
    "pageLength": 500,
    "lengthMenu": [ 10, 100, 500, 5000 ],
    dom: '<"top"lipf<"clear">> rt <"bottom"ip<"clear">>',
    responsive: {
      details: {
        type: 'column'
      }
    },
    order: [1, 'asc'],

    colReorder: {
      fixedColumnsLeft: 1,
      fixedColumnsLeft: 2
    },
          
    fixedHeader: {
      header: true,
      footer: true
    }, 
    
    'columnDefs': [{
        'targets': 1,
        'searchable': false,
        'orderable': false,
        'width': '1%',
        'className': 'dt-body-center'
      },
        {
        'className': 'control',
        'orderable': false,
        targets: 0
      }, 
    ],
        
    'order': [[1, 'asc']],

    'rowCallback': function(row, data, dataIndex){
      // Get row ID
      var rowId = data[6];

      // If row ID is in the list of selected row IDs
      if($.inArray(rowId, /**rows_selected */) !== -1){
        $(row).find('input[type="checkbox"]').prop('checked', true);
        $(row).addClass('selected');
      }
    }

  });
     
  /** mark single checkboxes */

  table.on('order.dt search.dt', function () {
    let i = 1;
   
    table.cells(null, 1, { search: 'applied', order: 'applied' }).every(function (cell) {
      this.data(i++);
    });

  }).draw();

     
  $(document).ready(function (){
     // Array holding selected row IDs
     var rows_selected = [];
   

     // Handle click on checkbox
     $('#example tbody').on('click', 'input[type="checkbox"]', function(e){
        var $row = $(this).closest('tr');

        // Get row data
        var data = table.row($row).data();

        // Get row ID
        var rowId = data[6];

        // Determine whether row ID is in the list of selected row IDs
        var index = $.inArray(rowId, rows_selected);

        // If checkbox is checked and row ID is not in list of selected row IDs
        if(this.checked && index === -1){
           rows_selected.push(rowId);

        // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
        } else if (!this.checked && index !== -1){
           rows_selected.splice(index, 1);
        }

        if(this.checked){
          $row.addClass('selected');
        } else {
          $row.removeClass('selected');
        }

        // Update state of "Select all" control
        updateDataTableSelectAllCtrl(table);

        // Prevent click event from propagating to parent
        e.stopPropagation();
     });

     // Handle click on table cells with checkboxes
    $('#example').on('click', 'tbody td, thead th:first-child', function(e){
      //$(this).parent().find('input[type="checkbox"]').trigger('click'); //88ลิ๊ก ที่ td cละ้ว checkbox
    });

     // Handle click on "Select all" control
     $('thead input[name="select_all"]', table.table().container()).on('click', function(e){
        if(this.checked){
           $('#example tbody input[type="checkbox"]:not(:checked)').trigger('click');
        } else {
           $('#example tbody input[type="checkbox"]:checked').trigger('click');
        }

        // Prevent click event from propagating to parent
        e.stopPropagation();
     });

     // Handle table draw event
     table.on('draw', function(){
        // Update state of "Select all" control
        updateDataTableSelectAllCtrl(table);
     });

     // Handle form submission event

     

  });
     
     
     
      /** Handling responsive expand collapse all*/
     
      // Handle click on "Expand All" button
      $('#btn-show-all-children').on('click', function(){
          // Expand row details
          table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
      });

      // Handle click on "Collapse All" button
      $('#btn-hide-all-children').on('click', function(){
          // Collapse row details
          table.rows('.parent').nodes().to$().find('td:first-child').trigger('click');
      });
  });
  </script>

  <!-- Modal_icd-->
  <script>
          $(document).ready(function(){
           
           function fetch_post_data_lab(vn)
           {
            $.ajax({
             url:"modal_icd.php",
             method:"POST",
             data:{vn:vn},
             success:function(data)
             {
              $('#post_modal_choose_car').modal('show');
              $('#post_detail_choose_car').html(data);
             }
            });
           }

           $(document).on('click', '.view_choose_icd', function(){
            var vn = $(this).attr("id");
            fetch_post_data_lab(vn);
           });
           
          });
  </script>

  <div id="post_modal_choose_car" class="modal fade">
      <div class="modal-dialog modal-lg">
          <div class="modal-content"> 
              <div class="modal-header">
                  <h1 class="modal-title">ICD</h1>
                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                      </button>
              </div>
              <div class="modal-body" id="post_detail_choose_car">
              </div>
          </div>
      </div>
  </div>
  <!-- Modal_icd-->


  <!-- Modal_pang_setting_detail-->
  <script>
          $(document).ready(function(){
           
           function fetch_post_data_lab(pang)
           {
            $.ajax({
             url:"modal_pang_setting_detail.php",
             method:"POST",
             data:{pang:pang},
             success:function(data)
             {
              $('#post_pang_setting_detail').modal('show');
              $('#post_detail_pang_setting_detail').html(data);
             }
            });
           }

           $(document).on('click', '.view_pang_setting_detail', function(){
            var pang = $(this).attr("id");
            fetch_post_data_lab(pang);
           });
           
          });
  </script>

  <div id="post_pang_setting_detail" class="modal fade">
      <div class="modal-dialog modal-lg">
          <div class="modal-content"> 
              <div class="modal-header">
                  <h1 class="modal-title">รายละเอียดการตั้งค่าผัง</h1>
                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                      </button>
              </div>
              <div class="modal-body" id="post_detail_pang_setting_detail">
              </div>
          </div>
      </div>
  </div>
  <!-- Modal_pang_setting_detail-->


  <!-- Modal_patient-->
  <script>
          $(document).ready(function(){
           
           function fetch_post_data_lab(vn)
           {
            $.ajax({
             url:"modal_patient.php",
             method:"POST",
             data:{vn:vn},
             success:function(data)
             {
              $('#post_modal_patient').modal('show');
              $('#post_detail_patient').html(data);
             }
            });
           }

           $(document).on('click', '.view_patient', function(){
            var vn = $(this).attr("id");
            fetch_post_data_lab(vn);
           });
           
          });
  </script>

  <div id="post_modal_patient" class="modal fade">
      <div class="modal-dialog modal-lg">
          <div class="modal-content"> 
              <div class="modal-header">
                  <h1 class="modal-title">การรักษา</h1>
                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                      </button>
              </div>
              <div class="modal-body" id="post_detail_patient">
              </div>
          </div>
      </div>
  </div>
  <!-- Modal_patient-->



  <!-- Modal_income-->
  <script>
          $(document).ready(function(){
           
           function fetch_post_data_lab(vn)
           {
            $.ajax({
             url:"modal_income.php",
             method:"POST",
             data:{vn:vn},
             success:function(data)
             {
              $('#post_modal_income').modal('show');
              $('#post_detail_income').html(data);
             }
            });
           }

           $(document).on('click', '.view_income', function(){
            var vn = $(this).attr("id");
            fetch_post_data_lab(vn);
           });
           
          });
  </script>

  <div id="post_modal_income" class="modal fade">
      <div class="modal-dialog modal-lg">
          <div class="modal-content"> 
              <div class="modal-header">
                  <h1 class="modal-title">ค่าใช้จ่ายทั้งหมด</h1>
                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                      </button>
              </div>
              <div class="modal-body" id="post_detail_income">
              </div>
          </div>
      </div>
  </div>
  <!-- Modal_income-->
    


  </body>
</html>







