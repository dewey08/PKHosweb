<?php
@session_start();
include("../session/session_claim.php");
include("../connect/connect.php");
?>
 
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Quixlab - Bootstrap Admin Dashboard Template by Themefisher.com</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
    <!-- Custom Stylesheet -->
    <link href="../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <!-- Page plugins css -->
    <link href="../plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
    <!-- Color picker plugins css -->
    <link href="../plugins/jquery-asColorPicker-master/css/asColorPicker.css" rel="stylesheet">
    <!-- Date picker plugins css -->
    <link href="../plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
    <!-- Daterange picker plugins css -->
    <link href="../plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="../plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <link href="../css/style.css" rel="stylesheet">

</head>

<?php
$explode_psi_pt = explode("_", $_REQUEST["pang_stamp_id"]);
$pang_stamp_id=$explode_psi_pt[0]; // ตัดเอา pang_stamp_id
$pang_type=$explode_psi_pt[1]; // pang_type

$s_ps=" SELECT * 
        ,(SELECT SUM(pang_stamp_stm_money) FROM pang_stamp WHERE pang_stamp_stm_file_name=ps.pang_stamp_stm_file_name ) AS total_use_stm
        ,(SELECT SUM(receipt_number_money) FROM receipt_number WHERE receipt_number_stm_file_name=ps.pang_stamp_stm_file_name ) AS total_rn_money
        FROM pang_stamp ps
        WHERE ps.pang_stamp_id ='$pang_stamp_id' 
        LIMIT 1";
$q_ps = mysqli_query($con_money, $s_ps) or die(mysqli_error($con_money));
$r_ps = mysqli_fetch_array($q_ps);
$pang_stamp_uc_money_kor_tok = $r_ps['pang_stamp_uc_money_kor_tok'];
$pang_stamp_uc_money = $r_ps['pang_stamp_uc_money'];
$total_use_stm = $r_ps['total_use_stm'];
$total_rn_money = $r_ps['total_rn_money'];
$pang_stamp = $r_ps['pang_stamp'];
$total_money_remaining = $total_rn_money-$total_use_stm;

#เช็คยอดเงินกรณีว่า_เงินคงเหลือ_หรือเงินลูกหนี้มากกว่ากัน
if ($pang_stamp_uc_money_kor_tok!='' && $pang_stamp_uc_money_kor_tok!=0) {
  $uc_money_use=$pang_stamp_uc_money_kor_tok;
}else{
  $uc_money_use=$pang_stamp_uc_money;
}

// if($uc_money_use<=$total_money_remaining){
//   $max_uc_money_input = $uc_money_use;
// }else{
  $max_uc_money_input = $total_money_remaining;
// }
#เช็คยอดเงินกรณีว่า_เงินคงเหลือ_หรือเงินลูกหนี้มากกว่ากัน
?>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">    
        <div class="basic-form">

          <form  method="post" action="pang_opd_stamped_doc_stm_form_insert.php" enctype="multipart/form-data" onsubmit="document.getElementById('btnSubmit').disabled=true;document.getElementById('btnSubmit').value='บันทึก, กรุณารอสักครู่...';">

            

            <div class="form-group">
              <input type="hidden" name="pang_stamp_id" value="<?php echo $pang_stamp_id?>">
              <input type="hidden" name="pang_stamp_uc_money" value="<?php echo $pang_stamp_uc_money?>">
              <input type="hidden" name="pang_stamp" value="<?php echo $pang_stamp?>">
              <input type="hidden" name="pang_type" value="<?php echo $pang_type?>">

              <h1>ยอดลูกหนี้ :
              <?php
              if($pang_stamp_uc_money_kor_tok!=0){
                $show_kor_tok="<span style='color:red;'>(".number_format($pang_stamp_uc_money_kor_tok,2).")</span>";
              }else{$show_kor_tok='';}
                echo number_format($pang_stamp_uc_money,2).$show_kor_tok;
              ?></h1>
            </div>
            
            <div class="form-group">
              <h1>รับจริง :
                <?php
                 echo number_format($total_rn_money,2);
                ?>
              
              หักไปแล้ว :
                <?php
                 echo number_format($total_use_stm,2);
                ?>
              </h1>
            </div>
            
            <div class="form-group">
              <h1>คงเหลือ :
                <?php
                 echo number_format($total_money_remaining,2);
                ?>
              </h1>
            </div>



            <div class="form-group">
              <input style="font-size: 30px;" class="form-control form-control-lg input-default" name="pang_stamp_stm_money" type="number" step=".5" min="0" max="<?=$max_uc_money_input?>"  placeholder="ระบุยอดเงินชดเชย ไม่เกิน <?= number_format($max_uc_money_input,2)?>" required="yes" autocomplete="off">
            </div>

                      

            <div class="form-group">
              <!-- <button id='btnSubmit' class="btn btn-primary btn-lg" type="submit">บันทึก</button> -->
              <input class="btn btn-primary btn-lg" id='btnSubmit' type="submit" value="บันทึก" >
            </div>
              
          </form> 
        </div>
      </div>
    </div>
  </div>        
</div>

pang_opd_stamped_doc_stm_form
<script src="../plugins/common/common.min.js"></script>
    <script src="../js/custom.min.js"></script>
    <script src="../js/settings.js"></script>
    <script src="../js/gleek.js"></script>
    <script src="../js/styleSwitcher.js"></script>

    <script src="../plugins/moment/moment.js"></script>
    <script src="../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- Clock Plugin JavaScript -->
    <script src="../plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>
    <!-- Color Picker Plugin JavaScript -->
    <script src="../plugins/jquery-asColorPicker-master/libs/jquery-asColor.js"></script>
    <script src="../plugins/jquery-asColorPicker-master/libs/jquery-asGradient.js"></script>
    <script src="../plugins/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="../plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="../plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="../plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

    <script src="../js/plugins-init/form-pickers-init.js"></script>