<?php 
@session_start();

include('../connect/connect.php');
@include("../session/session_claim.php");

function DateThai($strDate){
   $strYear = date("Y",strtotime($strDate))+543;
   $strMonth= date("n",strtotime($strDate));
   $strDay= date("j",strtotime($strDate));
   $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
   $strMonthThai=$strMonthCut[$strMonth];
   return "$strMonthThai $strYear";
}

function MoThai($strDate){
  $strMonth= $strDate;
  $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
  $strMonthThai=$strMonthCut[$strMonth];
  return "$strMonthThai";
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


@$pang_id=$_GET['pang'];
$pang_type=$_GET["pang_type"];


#ช่วงระยะเวลาปีงบ
$start_year_ngob=($y_s-1)."-10-01";
$end_year_ngob=$y_s."-09-30";
#ช่วงระยะเวลาปีงบ


#เช็คว่ามีการ insert ข้อมูลเข้า pang_stamp_temp ไปหรือยัง และเช็คการประมวลผลประจำวัน ว่าเป็นวันปัจจุบันแล้วหรือยัง
$date_now=date("Y-m-d");
$s_check_psm = "SELECT MIN(pang_stamp_month_check) AS pang_stamp_month_check FROM pang_stamp_month_temp 
                WHERE pang_stamp_month_check<='$date_now' 
                AND pang_stamp='$pang'
                AND year_check ='$y_s'
                 LIMIT 1 ";
$q_check_psm = mysqli_query($con_money, $s_check_psm) or die(mysqli_error($con_money));
$r_check_psm = mysqli_fetch_array($q_check_psm);
@$pang_stamp_month_check = $r_check_psm["pang_stamp_month_check"];
if($pang_stamp_month_check!='' && $pang_stamp_month_check<$date_now){
  ?>
    <script>
      window.location.href= 'pang_opd_month_process.php?pang=<?= $pang?>&pang_type=<?= $pang_type?>&process=y';
    </script>
  <?php
}elseif($pang_stamp_month_check==''){
  ?>
    <script>
      window.location.href= 'pang_opd_month_process.php?pang=<?= $pang?>&pang_type=<?= $pang_type?>&process=y';
    </script>
  <?php
}
#เช็คว่ามีการ insert ข้อมูลเข้า pang_stamp_temp ไปหรือยัง และเช็คการประมวลผลประจำวัน ว่าเป็นวันปัจจุบันแล้วหรือยัง

#ย้ายการ query ไปไว้ที่ pang_opd_month_process.php
#include("$pang_sql");
include("pang_opd_month_process.php"); # สำหรับดึงมา show คำสั่ง sql

?>
<!DOCTYPE html>
<html>

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
    <style>.modal { overflow: auto !important; }</style> <!-- css แก้ปัญหา modal ซ้อนแล้ว สกอไม่ได้ -->
  </head>
  
<script src="../js/Chart.min.js"></script>
<body>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">  
        <h2>ผังบัญชี<?php echo $pang_id;?> </h2>

        <div class="form-row align-items-center">
          
          <!-- <a id='aaaa' class="btn btn-info" onclick="document.getElementById('aaaa').disabled=true;document.getElementById('aaaa').value='ประมวลผลใหม่, กรุณารอสักครู่...';"
            href="pang_opd_month_process.php?pang=<?= $pang?>&pang_type=<?= $pang_type?>" >ประมวลผลใหม่
          </a> -->
          <div class="col-auto">
            <form name="form" id="form"  method="post" action="pang_opd_month_process.php" enctype="multipart/form-data" onsubmit="document.getElementById('btnSubmit').disabled=true;document.getElementById('btnSubmit').value='ประมวลผลใหม่, กรุณารอสักครู่...';">
              <input type="hidden" name="pang" value="<?php echo $pang?>">
              <input type="hidden" name="pang_type" value="<?php echo $pang_type?>">
              <input type="hidden" name="process" value="y">
              
                <!-- <button id='btnSubmit' class="btn btn-info" type="submit">ประมวลผลใหม่</button> -->
                <input class="btn btn-info" id='btnSubmit' type="submit" value="ประมวลผลใหม่" >
              
                
            </form>
          </div>
        

          <?php 
          #ย้ายการประมวลผลไปไว้ที่ pang_opd_month_process.php ติดปัญหาการแสดงผล badge จำนวนที่เมนู
          // $pang_type=$_GET["pang_type"];
          // if($pang_type=='OPD'){
          //   $pang_sql = "pang_opd_sql.php";
          //   $s_date = "o.vstdate";
          //   $s_pst_date = "ps.pang_stamp_vstdate";
          // }elseif($pang_type=='IPD'){
          //   $pang_sql = "pang_ipd_sql.php";
          //   $s_date = "v.dchdate";
          //   $s_pst_date = "ps.pang_stamp_dchdate";
          // }else{
          // }

          
          
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
                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                    
                <div class="modal-body"><?= "pang_opd_month"?></div>
                <div class="modal-body"><?= "<hr>#ไม่สนใน VN ตาม icd ที่กำหนด"?></div>

                <div class="modal-body"><?= "<hr>#temp_ovst"?></div>
                <div class="modal-body"><?= nl2br (tab2nbsp($s_c_tempovst));?></div>

                <div class="modal-body"><?= "<hr>#temp_pang_stamp"?></div>
                <div class="modal-body"><?php echo nl2br (tab2nbsp($s_c_temp_ps));?></div>

                <div class="modal-body"><?= "<hr>#temp_pang_stamp_chronic"?></div>
                <div class="modal-body"><?php echo nl2br (tab2nbsp($s_pang_chronic));?></div>
                <div class="modal-body"><?php echo nl2br (tab2nbsp($sqlshow));?></div>
                <div class="modal-body"><?php echo nl2br (tab2nbsp($s_c_t_tpsc));?></div>


                <div class="modal-body"><?= "<hr>#temp_stamp_icd"?></div>
                <div class="modal-body"><?php echo nl2br (tab2nbsp(@$s_create_tpsi_q));?></div>

                <div class="modal-body"><?php echo nl2br (tab2nbsp(@$s_pi9));?></div>
                <div class="modal-body"><?= "<hr>#ตรวจสอบว่าเป็นผังที่สนใจ VN ตาม icd ที่กำหนด"?></div>
                <div class="modal-body"><?php echo nl2br (tab2nbsp(@$s_pi_use));?></div>
                <div class="modal-body"><?= "<hr>"?></div>
                <div class="modal-body"><?php echo nl2br (tab2nbsp($s_in_psm));?></div>
                    
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal sql -->

          <div class="col-auto">
              <button class="btn btn-success view_pang_setting_detail" id="<?php echo $pang;?>" data-target=".bd-example-modal-lg">เงื่อนไขผัง</button>
          </div>
        </div> 
        <BR>

        <?php
        if($pang_stamp_month_check==''){
          

          //$q_in_psm = mysqli_query($con_hos, $s_in_psm) or die(mysqli_error($con_hos));

          if($q_in_psm){
            $s_psm="SELECT *
                    FROM pang_stamp_month_temp psm 
                    WHERE psm.pang_stamp = '$pang' AND psm.year_check ='$y_s'
                    AND psm.pang_stamp_month_check = '$date_now'
                    LIMIT 1000
                  ";
          }

        }else{
            $s_psm="SELECT *
                    FROM pang_stamp_month_temp psm 
                    WHERE psm.pang_stamp = '$pang' AND psm.year_check ='$y_s'
                    AND psm.pang_stamp_month_check = '$date_now'
                    LIMIT 1000
                  ";
        }

        $q_count_nostamp = mysqli_query($con_money, $s_psm) or die(mysqli_error($con_money));

        ?>

  
    <div class="row">
<?php

#ตรวจสอบว่าเจอ visit ในผัง หรือไม่ ถ้าไม่เจอ จะแสดงอีกรูปแบบหนึ่ง
$s_c_null_visit="SELECT pang_stamp_month_id
FROM pang_stamp_month_temp psm 
WHERE psm.pang_stamp = '$pang' AND psm.year_check ='$y_s'
AND psm.pang_stamp_month_check = '$date_now'
AND psm.mon='0'
LIMIT 1000 ";
$q_c_null_visit = mysqli_query($con_money, $s_c_null_visit) or die(mysqli_error($con_money));
$r_c_null_visit=mysqli_fetch_array($q_c_null_visit);
@$pang_stamp_month_id = $r_c_null_visit['pang_stamp_month_id'];
#ตรวจสอบว่าเจอ visit ในผัง หรือไม่ ถ้าไม่เจอ จะแสดงอีกรูปแบบหนึ่ง 

if($pang_stamp_month_id!=''){ #ถ้ามีค่าแสดงว่า ผังนี้ไม่พบ Visit เลย
?>
              <div class="col-lg-3 col-sm-6">
                <div class="card gradient-2">
                  
                    <div class="card-body">

                      <h5 class="card-title text-white">ไม่พบ Visit ในผังนี้<span class="float-right display-15 opacity-15"></h5>                  
                    </div>
                  
                </div>
              </div> 
<?php
}else{

  
            while($r_count_nostamp=mysqli_fetch_array($q_count_nostamp)){
            $year_mon = $r_count_nostamp["year_mon"];
            $month = $r_count_nostamp["mon"];
            $month_int = ($r_count_nostamp["mon"])+1;
            $no_stamp = $r_count_nostamp["no_stamp"];    
            $stamp = $r_count_nostamp["stamp"];  
            $stamp_send = $r_count_nostamp["stamp_send"];    
            $stamp_stm = $r_count_nostamp["stamp_stm"];          
            ?>
            <div class="col-lg-4 col-sm-6">
                <div class="card gradient-1">
                  
                    <div class="card-body">

                      <h5 class="card-title text-white"><?php echo DateThai($year_mon);?><span class="float-right display-15 opacity-15">

                        <a class="label label-danger" href="index.php?pang=<?= $pang_id?>&pang_type=<?= $pang_type?>&m_s=<?= $month?>"
                        data-toggle="tooltip" title="จำนวน Visit ที่ยังไม่ได้ stamp">
                          <?php echo number_format($no_stamp);?>
                        </a>

                        <a class="label label-warning" href="index.php?pang=<?= $pang_id?>&pang_type=<?= $pang_type?>&m_s=<?= $month?>&stamp=y" data-toggle="tooltip" title="จำนวน Visit ที่ stamp แต่ยังไม่ได้สรุปส่งการเงิน">
                          <?php echo number_format($stamp);?>
                        </a>

                        <a class="label" style="background-color:yellow;" href="index.php?pang=<?= $pang_id?>&pang_type=<?= $pang_type?>&m_s=<?= $month?>&stamp=y" data-toggle="tooltip" title="จำนวน Visit ที่ stamp และสรุปส่งการเงินแล้ว">
                          <?php echo number_format($stamp_send);?>
                        </a>

                        <a class="label label-success" href="#" data-toggle="tooltip" title="จำนวน Visit stamp ที่มีการตัด stm">
                          <?php echo number_format($stamp_stm);?>
                        </a>

                      </h5>                  
                    </div>
                  
                </div>
            </div> 
          <?php 
          }
          ?>
    
  
<?php 
}
?>
    </div>


         


      </div>
    </div>
  </div>
</div>


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
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
  <!-- Modal_pang_setting_detail-->

  <!-- Modal_pttype-->
  <script>
          $(document).ready(function(){
           
           function fetch_post_data_lab(pttype)
           {
            $.ajax({
             url:"modal_pttype.php",
             method:"POST",
             data:{pttype:pttype},
             success:function(data)
             {
              $('#post_modal_view_pttype').modal('show');
              $('#post_detail_view_pttype').html(data);
             }
            });
           }

           $(document).on('click', '.view_pttype', function(){
            var pttype = $(this).attr("id");
            fetch_post_data_lab(pttype);
           });
           
          });
  </script>

  <div id="post_modal_view_pttype" class="modal fade">
      <div class="modal-dialog modal-lg">
          <div class="modal-content"> 
              <div class="modal-header">
                  <h1 class="modal-title">สิทธิส่งตรวจ</h1>
                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                      </button>
              </div>
              <div class="modal-body" id="post_detail_view_pttype">
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
          
          </div>
          
      </div>
  </div>
  <!-- Modal_pttype-->


</body>
</html>
