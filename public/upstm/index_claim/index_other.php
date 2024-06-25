<?php 
@session_start();
include('../connect/connect.php');
@include('../session/session_claim.php');
#$_SESSION["UserID"]='sm';
$backto="http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']; //ลิงค์สำหรับกลับมาหน้าเดิม

#$y_s = $_REQUEST['y_s'];

$strMonthFull = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

function DateThaisubmonth($strDate){
   $strYear = date("Y",strtotime($strDate))+543;
   $strMonth= date("n",strtotime($strDate));
   $strDay= date("j",strtotime($strDate));
   $strMonthCut = Array("","มค","กพ","มีค","มย","พค","มิย","กค","สค","กย","ตค","พย","ธค");
   $strMonthThai=$strMonthCut[$strMonth];
   return "$strDay $strMonthThai $strYear";
}
function tab2nbsp($str){
    return str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $str); 
}

#$y_s= $_SESSION["y_s"]='2021';
if( isset($_REQUEST['y_s']) ){
    $y_s= $_SESSION["y_s"] = $_REQUEST['y_s'];
}elseif( isset($_SESSION["y_s"]) ){
    $y_s= $_SESSION["y_s"];
}else{
    $y_s = $_SESSION["y_s"] = date("Y");
} 
if( isset($_REQUEST["m_s"]) ){
    $m_s= $_SESSION["m_s"] = $_REQUEST['m_s'];
}elseif( isset($_SESSION["m_s"]) ){
    $m_s= $_SESSION["m_s"];
}else{
    $m_s = date("m")+0;
}  
//@$month=$_GET['month'];
  if($m_s==1){$start_year=$y_s."-01-01"; $end_year=$y_s."-01-31";       $end_year_picker=$y_s."-01-31";}
  elseif($m_s==2){$start_year=$y_s."-02-01"; $end_year=$y_s."-02-29";   $end_year_picker=$y_s."-02-29";}
  elseif($m_s==3){$start_year=$y_s."-03-01"; $end_year=$y_s."-03-31";   $end_year_picker=$y_s."-03-31";}
  elseif($m_s==4){$start_year=$y_s."-04-01"; $end_year=$y_s."-04-30";   $end_year_picker=$y_s."-04-30";}
  elseif($m_s==5){$start_year=$y_s."-05-01"; $end_year=$y_s."-05-31";   $end_year_picker=$y_s."-05-31";}
  elseif($m_s==6){$start_year=$y_s."-06-01"; $end_year=$y_s."-06-30";   $end_year_picker=$y_s."-06-30";}
  elseif($m_s==7){$start_year=$y_s."-07-01"; $end_year=$y_s."-07-31";   $end_year_picker=$y_s."-07-31";}
  elseif($m_s==8){$start_year=$y_s."-08-01"; $end_year=$y_s."-08-31";   $end_year_picker=$y_s."-08-31";}
  elseif($m_s==9){$start_year=$y_s."-09-01"; $end_year=$y_s."-09-30";   $end_year_picker=$y_s."-09-30";}
  elseif($m_s==10){$start_year=($y_s-1)."-10-01"; $end_year=($y_s-1)."-10-31";  $end_year_picker=($y_s-1)."-10-31";}
  elseif($m_s==11){$start_year=($y_s-1)."-11-01"; $end_year=($y_s-1)."-11-30";  $end_year_picker=($y_s-1)."-11-30";}
  elseif($m_s==12){$start_year=($y_s-1)."-12-01"; $end_year=($y_s-1)."-12-31";  $end_year_picker=($y_s-1)."-12-31";}

@$date_sir_f = $_REQUEST['date_sir_f']; #รับค่าสำหรับใช้ในหน้า index_claim_stamp
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>ClaimHACC</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
    <!-- Pignose Calender -->
    <link href="../plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="../plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="../plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
    <!-- Custom Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <div class="brand-logo" style="background-color: white;">
                <a href="../index_claim">
                    <b class="logo-abbr"><img src="../images/favicon.png" alt=""> </b>
                    <span class="logo-compact"><img src="../images/favicon.png" alt=""></span>
                    <span class="brand-title">
                        <img src="../images/logo-text.png" alt="" style="height: 50px;">
                    </span>
                </a>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">    
            <div class="header-content clearfix">
                
                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>

                <div class="header-left">
                    <div class="input-group icons">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"></span>
                        </div>
                        <input type="search" class="form-control" placeholder="หน้า Claim" aria-label="Search Dashboard" disabled>
                        <div class="drop-down   d-md-none">
                            <form action="#">
                                <input type="text" class="form-control" placeholder="Search">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="header-right">
                    <ul class="clearfix">
                        
                        

                        <li class="icons dropdown">
                            
                            <div class="col">
                                <div class="dropdown">
                                    <button type="button " class="btn btn-primary btn-sm" data-toggle="dropdown">
                                        ปีงบ <?php echo ($y_s)+543;?> <i class="fa fa-angle-down m-l-5"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <?php 
                                        $y_min=(date("Y"))-4; 

                                        if(date("Y-m-d")>( date("Y")."-09-30" )){
                                            $y_max=(date("Y"))+1;
                                        }else{
                                            $y_max=date("Y");
                                        }
                                        
                                        for($yy=$y_max; $yy>$y_min; $yy--){
                                            if( $yy ==$y_s){
                                        ?>
                                        <form class="dropdown-item" >
                                            <input type="hidden" name="y_s" value="<?php echo $yy;?>">
                                            <input style=" width:100%" class="btn btn-primary" value="<?php echo ($yy)+543;?>">
                                        </form>    
                                        <?php
                                            }else{
                                        ?>
                                        <form class="dropdown-item" method="post" action="<?php echo $backto;?>">
                                            <input type="hidden" name="y_s" value="<?php echo $yy;?>">
                                            <input type="submit" style=" width:100%" class="btn btn-secondary" value="<?php echo ($yy)+543;?>">
                                        </form>
                                        <?php 
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="nk-sidebar">           
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">

                    <!--
                    <li class="nav-label">ทดสอบหัว1</li>
                    -->

                    <li>
                        <a href="../index_main.php" aria-expanded="false">
                            <i class="fa fa-home"></i><span class="nav-text">Home</span>
                        </a>
                    </li>

                    <hr>

                    <li>
                        <a href="index.php" aria-expanded="false">
                            <i class="fa fa-tasks"></i><span class="nav-text">ผังบัญชี</span>
                        </a>
                    </li>


                    <hr>

                    <li>
                        <a href="index_other.php?sum=stamp" aria-expanded="false">
                            <i class="fa fa-handshake-o"></i><span class="nav-text">สรุปส่งการเงิน</span>
                        </a>
                    </li>

                    <li>
                        <a href="index_other.php?sum=send" aria-expanded="false">
                            <i class="fa fa-send"></i><span class="nav-text">รายการที่ส่ง</span>
                        </a>
                    </li> 

                    <li>
                        <a href="index_other.php?sum=send_money_accept" aria-expanded="false">
                            <i class="fa fa-send"></i><span class="nav-text">รายการที่ส่ง การเงินลงรับแล้ว</span>
                        </a>
                    </li> 

                    <li>
                        <a href="index_other.php?sum=up_stm" aria-expanded="false">
                            <i class="fa fa-money"></i><span class="nav-text">UP STM</span>
                        </a>
                    </li> 

                    <!-- <li>
                        <a href="index_other.php?set=setting" aria-expanded="false">
                            <i class="fa fa-cog"></i><span class="nav-text">ตั้งค่าผัง</span>
                        </a>
                    </li>    -->
                    
                    <li>
                        <a href="../index_other" aria-expanded="false">
                            <i class="fa fa-file-text"></i><span class="nav-text">ไม่ได้ชำระเงิน</span>
                            <?php 
                            $s_c_scv = "SELECT SUM(count_vn) AS sum_count_vn
                                        FROM no_paid_month_temp psm 
                                        WHERE psm.year_check ='$y_s'
                                        LIMIT 1";                
                            $q_c_scv = mysqli_query($con_money, $s_c_scv) or die(mysqli_error($con_money));
                            $r_c_scv = mysqli_fetch_array($q_c_scv);
                            $sum_count_vn = $r_c_scv['sum_count_vn'];
                            ?>
                            <span class="label label-pill label-danger text-white"><?= $sum_count_vn;?></span>
                        </a>

                        <ul aria-expanded="true">
                            
                            <li>
                                <a href="index_other.php?s=npmm"><span class="fa fa-window-close">ข้อมูลทั้งปี</a>
                            </li>
                            <li>
                                <a href="index_other.php?s=npd&m_s=<?= $m_s?>"><span class="fa fa-window-close">
                                    <?php echo $strMonthFull[($m_s)+0]." ข้อมูล"?>
                                </a>
                            </li>

                        </ul>

                    </li>
                                        
                    
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4">    
                        <?php
                        @$pang=$_GET['pang'];
                        if(isset($pang)){
                        
                            #include($show);
                            if(isset($_GET["pang"])&&$_GET["pang"]!='setting'&&$_GET["pang"]!='up_stm'&&$_GET["pang"]!='stamp'){
                              $GET_pang_type=$_GET["pang_type"];
                                if($GET_pang_type=="OPD"){
                                    if(@$_GET["stamp"]=='y'){
                                        include('pang_opd_stamped.php');
                                    }elseif(@$_GET["stamp"]=='c'){
                                        include('index_claim/pang_opd_stamp_cancel.php');
                                    }elseif(@$_GET["m_s"]){
                                        include('pang_opd.php');
                                    }else{                        
                                        include('pang_opd_month.php');
                                    }
                                }elseif($GET_pang_type=="IPD"){
                                    if(@$_GET["stamp"]=='y'){
                                        include('pang_opd_stamped.php');
                                    }elseif(@$_GET["stamp"]=='c'){
                                        include('index_claim/pang_opd_stamp_cancel.php');
                                    }elseif(@$_GET["m_s"]){
                                        include('pang_opd.php');
                                    }else{                        
                                        include('pang_opd_month.php');
                                    }

                                }elseif($GET_pang_type=="PAID_OPD"){
                                    include('index_claim/index_money_paid.php');
                                }elseif($GET_pang_type=="PAID_IPD"){
                                    include('index_claim/index_money_paid.php');
                                }elseif($GET_pang_type=="ALL"){
                                    include('pang_all.php'); # ยังไม่ได้เพิ่ม
                                }

                                
                            ##  เงื่อนไขหน้า Setting  ###################################################################    
                            }elseif(@$_GET["set"]=='setting'){
                                if(@$_GET["edit"]=='y'){
                                    include('index_claim/setting_edit.php');
                                }elseif(@$_GET["edit"]=='insert'){
                                    include('index_claim/setting_edit_insert.php');
                                }else{
                                    include('index_claim/setting.php');
                                }
                            
                            ##  เงื่อนไขหน้า Setting  ###################################################################

                            ##  เงื่อนไขหน้า_edit_stamp_________________________________________________________________   
                            }elseif(@$_GET["edit_stamp"]=='index'){
                                include('index_claim/edit_stamp.php');
                              
                             
                            ##  เงื่อนไขหน้า_edit_stamp_________________________________________________________________


                            ##  เงื่อนไขหน้า up_stm  ###################################################################    
                            }elseif(@$_GET["sum"]=='up_stm'){
                                include('up_stm.php');
                            
                            ##  เงื่อนไขหน้า up_stm  ################################################################### 


                            }elseif(@$_GET["sum"]=='receipt_number'){
                                if(@$_GET["type_rn"]==''){
                                    include('index_claim/index_claim_receipt_number.php');
                                }elseif($_GET["type_rn"]=='input'){
                                    include('index_claim/index_claim_receipt_number_input.php');  
                                }elseif($_GET["type_rn"]=='receipt'){
                                    include('index_claim/index_claim_receipt_number_receipt.php');
                                }

                            } 
                        
                        }elseif(@$_GET["sum"]=='stamp'){
                            include('index_claim_stamp.php');

                        }elseif(@$_GET["sum"]=='send'){
                            include('index_claim_send.php'); 
                        }elseif(@$_GET["sum"]=='send_money_accept'){
                            include('index_claim_send_money_accept.php');
                        }elseif(@$_GET["sum"]=='up_stm'){
                            include('up_stm.php');
                        }elseif(@$_GET["edit_stamp"]=='index'){
                            include('index_claim/edit_stamp.php');
                        }elseif(@$_REQUEST["s"]=="npmm"){ #
                            include("../index_money/no_paid_month.php");
                        }elseif(@$_REQUEST["s"]=="npd"){ #
                            include("../index_money/no_paid_date.php");
                        }else{
                            include("index_claim_send.php");
                        }
                        ?>

                    </div>
                </div>
            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        
        
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p><a href="#">จังหวัดชัยภูมิ</a> </p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="../plugins/common/common.min.js"></script>
    <script src="../js/custom.min.js"></script>
    <script src="../js/settings.js"></script>
    <script src="../js/gleek.js"></script>
    <script src="../js/styleSwitcher.js"></script>

    <!-- Chartjs -->
    <script src="../plugins/chart.js/Chart.bundle.min.js"></script>
    <!-- Circle progress -->
    <script src="../plugins/circle-progress/circle-progress.min.js"></script>
    <!-- Datamap -->
    <script src="../plugins/d3v3/index.js"></script>
    <script src="../plugins/topojson/topojson.min.js"></script>
    <script src="../plugins/datamaps/datamaps.world.min.js"></script>
    <!-- Morrisjs -->
    <script src="../plugins/raphael/raphael.min.js"></script>
    <script src="../plugins/morris/morris.min.js"></script>
    <!-- Pignose Calender -->
    <script src="../plugins/moment/moment.min.js"></script>
    <script src="../plugins/pg-calendar/js/pignose.calendar.min.js"></script>
    <!-- ChartistJS -->
    <script src="../plugins/chartist/js/chartist.min.js"></script>
    <script src="../plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>



    <script src="../js/dashboard/dashboard-1.js"></script>

    <!-- <script src="./plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="./plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="./plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
 -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
  
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>


</body>

</html>



<!--
date_picker สำหรับหน้า pang_opd.php 
-->
<link rel="stylesheet" href="../js/jquery.datetimepicker.css">  
<!--
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>  
-->
<script src="../js/jquery.datetimepicker.full.js"></script>
<script type="text/javascript">   
$(function(){
    
    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
        
    // กรณีใช้แบบ input
    $("#date_sir_pang_opd").datetimepicker({
        timepicker:false,
        format:'Y-m-d',  // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000            
        lang:'th',  // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
        scrollInput : false,
        minDate:'<?php echo $start_year?>',
        maxDate:'<?php echo $end_year_picker?>',
        onSelectDate:function(dp,$input){
            var yearT=new Date(dp).getFullYear()-0;  
            var yearTH=yearT;
            var fulldate=$input.val();
            var fulldateTH=fulldate.replace(yearT,yearTH);
            $input.val(fulldateTH);
        },
    });       
    // กรณีใช้กับ input ต้องกำหนดส่วนนี้ด้วยเสมอ เพื่อปรับปีให้เป็น ค.ศ. ก่อนแสดงปฏิทิน
    $("#date_sir_pang_opd").on("mouseenter mouseleave",function(e){
        var dateValue=$(this).val();
        if(dateValue!=""){
                var arr_date=dateValue.split("-"); // ถ้าใช้ตัวแบ่งรูปแบบอื่น ให้เปลี่ยนเป็นตามรูปแบบนั้น
                // ในที่นี้อยู่ในรูปแบบ 00-00-0000 เป็น d-m-Y  แบ่งด่วย - ดังนั้น ตัวแปรที่เป็นปี จะอยู่ใน array
                //  ตัวที่สอง arr_date[2] โดยเริ่มนับจาก 0 
                if(e.type=="mouseenter"){
                    //var yearT=arr_date[2]-543;
                }       
                if(e.type=="mouseleave"){
                    //var yearT=parseInt(arr_date[2])+543;
                }   
                dateValue=dateValue.replace(arr_date[2],yearT);
                $(this).val(dateValue);                                                 
        }       
    });


<?php #ช่วงระยะเวลาปีงบ
$start_year_ngob=($y_s-1)."-10-01";
$end_year_ngob=$y_s."-09-30";

#เช็คยอดที่เคยส่งล่าสุด_เพื่อล็อคปุ่มวันที่ไม่ให้ถอยไปได้
$s_check_last = "SELECT pang_stamp_send,MAX(pang_stamp_latest_date_send) AS max_check_pang_stamp_latest_date_send
                FROM pang_stamp_send WHERE pang_stamp_send_year = '$y_s' ";
$q_check_last = mysqli_query($con_money, $s_check_last) or die(nl2br($s_check_last));
$r_check_last = mysqli_fetch_array($q_check_last);
if($r_check_last['pang_stamp_send']==''){ #กรณีเป็นครั้งแรกที่เริ่มส่ง
    $s_check_min_vstdate = "SELECT MIN(pang_stamp_vstdate) AS min_pang_stamp_vstdate
                            FROM pang_stamp WHERE pang_year = '$y_s' ";
    $q_check_min_vstdate = mysqli_query($con_money, $s_check_min_vstdate) or die(nl2br($s_check_min_vstdate));
    $r_check_min_vstdate = mysqli_fetch_array($q_check_min_vstdate);
    $v_date_use = $r_check_min_vstdate["min_pang_stamp_vstdate"];
    $s_max_pang_stamp_latest_date_send=" MAX('".$v_date_use."') ";
    $s_pang_stamp_latest_date_send_intday="'".$v_date_use."'";
    $s_pang_stamp_latest_last_day=" LAST_DAY(DATE_ADD('".$v_date_use."',INTERVAL 1 MONTH)) ";
}elseif($r_check_last['pang_stamp_send']!='' && $r_check_last['max_check_pang_stamp_latest_date_send']==''){
    $s_check_min_vstdate = "SELECT MAX(pang_stamp_vstdate) AS max_pang_stamp_vstdate
                            FROM pang_stamp WHERE pang_year = '$y_s' AND pang_stamp_send <>'' ";
    $q_check_min_vstdate = mysqli_query($con_money, $s_check_min_vstdate) or die(nl2br($s_check_min_vstdate));
    $r_check_min_vstdate = mysqli_fetch_array($q_check_min_vstdate);
    $v_date_use = $r_check_min_vstdate["max_pang_stamp_vstdate"];
    $s_max_pang_stamp_latest_date_send=" MAX('".$v_date_use."') ";
    $s_pang_stamp_latest_date_send_intday=" DATE_ADD('".$v_date_use."',INTERVAL 1 DAY)";
    $s_pang_stamp_latest_last_day=" LAST_DAY(DATE_ADD('".$v_date_use."',INTERVAL 1 MONTH)) ";
}else{
    $s_max_pang_stamp_latest_date_send=' MAX(pang_stamp_latest_date_send) ';
    $s_pang_stamp_latest_date_send_intday=' DATE_ADD(MAX(pang_stamp_latest_date_send),INTERVAL 1 DAY) ';
    $s_pang_stamp_latest_last_day=' LAST_DAY(DATE_ADD(MAX(pang_stamp_latest_date_send),INTERVAL 1 MONTH)) ';
}

$s_c_latest = "SELECT $s_max_pang_stamp_latest_date_send AS max_pang_stamp_latest_date_send 
,$s_pang_stamp_latest_date_send_intday AS pang_stamp_latest_date_send_intday
,$s_pang_stamp_latest_last_day AS pang_stamp_latest_last_day
FROM pang_stamp_send WHERE pang_stamp_send_year = '$y_s' ";
$q_c_latest = mysqli_query($con_money, $s_c_latest) or die(nl2br($s_c_latest));
$r_c_latest = mysqli_fetch_array($q_c_latest);
$pang_stamp_latest_date_send_intday = $r_c_latest['pang_stamp_latest_date_send_intday'];
$pang_stamp_latest_last_day = $r_c_latest['pang_stamp_latest_last_day'];

if($date_sir_f!=''){
    $show_value_default=$date_sir_f;
}else{
    $show_value_default=$pang_stamp_latest_date_send_intday;
}
#เช็คยอดที่เคยส่งล่าสุด_เพื่อล็อคปุ่มวันที่ไม่ให้ถอยไปได้

#ช่วงระยะเวลาปีงบ?>
    // สำหรับหน้า index_claim_stamp.php date_sir_f
    $("#date_sir_f").datetimepicker({
        value:'<?= $show_value_default?>',
        timepicker:false,
        format:'Y-m-d',  // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000            
        lang:'th',  // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
        scrollInput : false,
        minDate:'<?php echo $pang_stamp_latest_date_send_intday?>',
        maxDate:'<?php echo $pang_stamp_latest_last_day?>',
        onSelectDate:function(dp,$input){
            var yearT=new Date(dp).getFullYear()-0;  
            var yearTH=yearT;
            var fulldate=$input.val();
            var fulldateTH=fulldate.replace(yearT,yearTH);
            $input.val(fulldateTH);
        },
    });       
    // สำหรับหน้า index_claim_stamp.php date_sir_f กรณีใช้กับ input ต้องกำหนดส่วนนี้ด้วยเสมอ เพื่อปรับปีให้เป็น ค.ศ. ก่อนแสดงปฏิทิน
    $("#date_sir_f").on("mouseenter mouseleave",function(e){
        var dateValue=$(this).val();
        if(dateValue!=""){
                var arr_date=dateValue.split("-"); // ถ้าใช้ตัวแบ่งรูปแบบอื่น ให้เปลี่ยนเป็นตามรูปแบบนั้น
                // ในที่นี้อยู่ในรูปแบบ 00-00-0000 เป็น d-m-Y  แบ่งด่วย - ดังนั้น ตัวแปรที่เป็นปี จะอยู่ใน array
                //  ตัวที่สอง arr_date[2] โดยเริ่มนับจาก 0 
                if(e.type=="mouseenter"){
                    //var yearT=arr_date[2]-543;
                }       
                if(e.type=="mouseleave"){
                    //var yearT=parseInt(arr_date[2])+543;
                }   
                dateValue=dateValue.replace(arr_date[2],yearT);
                $(this).val(dateValue);                                                 
        }       
    });
    //สำหรับหน้า index_claim_stamp.php date_sir_f
   
    
});
</script>
<!--
date_picker สำหรับหน้า pang_opd.php 
-->