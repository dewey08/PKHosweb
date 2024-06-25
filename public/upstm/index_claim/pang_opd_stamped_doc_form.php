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
$value_request = $_REQUEST["pang_stamp_id"];

//$pang_stamp_id.'|'.$pang_stamp."|".$pang_type."|".$m_s

$pieces = explode("|", $value_request);
$pang_stamp_id=$pieces[0];
$pang_stamp=$pieces[1];
$pang_type=$pieces[2];
$m_s=$pieces[3];
?>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">    
        <div class="basic-form">
          <h2>ลงเลขที่หนังสือใหม่</h2>
          <form  method="post" action="pang_opd_stamped_doc_form_insert.php" enctype="multipart/form-data">

            <input type="hidden" name="pang_stamp_id[]"   value="<?php echo $pang_stamp_id?>">
            <input type="hidden" name="pang_stamp"      value="<?php echo $pang_stamp?>">
            <input type="hidden" name="pang_type"       value="<?php echo $pang_type?>">
            <input type="hidden" name="m_s"             value="<?php echo $m_s?>">

            <div class="form-group">
              <input class="form-control form-control-lg input-default" type="text" value="<?php echo $pang_stamp_id?>" disabled>
            </div>  

            <div class="form-group">
              <input class="form-control form-control-lg input-default" name="pang_stamp_stm_file_name" type="text" placeholder="เลขที่เอกสารเบิก" required="yes" autocomplete="off" maxlength="40">
            </div>

            <div class="form-group">
              <input required="yes" type="file" accept="image/*" name="file" id="file"  onchange="loadFile(event)" style="display: none;" required="" capture>
              <label for="file" style="cursor: pointer;border: 3px solid green;">คลิ๊กที่นี่เพื่อเลือกรูป</label>
              <img id="output" width="300" />

              <script>
              var loadFile = function(event) {
                var image = document.getElementById('output');
                image.src = URL.createObjectURL(event.target.files[0]);
              };
              </script>
            </div>

            <div class="form-group">
              <button class="btn btn-primary btn-lg" type="submit">บันทึก</button>
            </div>
              
          </form> 
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">    
        <div class="basic-form">
          <h2>เลขที่หนังสือที่ลงแล้ว</h2> 
          <form  method="post" action="pang_opd_stamped_doc_form_insert.php" enctype="multipart/form-data">

            <input type="hidden" name="pang_stamp_id[]"   value="<?php echo $pang_stamp_id?>">
            <input type="hidden" name="pang_stamp"      value="<?php echo $pang_stamp?>">
            <input type="hidden" name="pang_type"       value="<?php echo $pang_type?>">
            <input type="hidden" name="m_s"             value="<?php echo $m_s?>">
            <input type="hidden" name="pang_stamp_stm_file_name_already"  value="y">

            <input  type="hidden" value="<?php echo $pang_stamp_id?>" disabled>
            

            <div class="form-group">
              <input class="form-control form-control-lg input-default" name="pang_stamp_stm_file_name" type="text" placeholder="ค้นหา และเลือกตาม list รายการ" required="yes" autocomplete="off" maxlength="30" list="doc_stm_list">
              <datalist id="doc_stm_list">
                <?php
                $y_s= $_SESSION["y_s"];
                $s_ps_stm_doc=" 
                  SELECT 
                  ps.pang_stamp_stm_file_name 
                  ,ps.pang_stamp_stm_rep
                  ,ps.pang_stamp_vstdate
                  FROM pang_stamp ps
                  WHERE ps.pang_stamp_stm_file_name like 'doc_%'
                  AND ps.pang_year='$y_s'
                  GROUP BY ps.pang_stamp_stm_file_name
                  ORDER BY MAX(ps.pang_stamp_vstdate) DESC
                  LIMIT 1000 ";
                $q_ps_stm_doc = mysqli_query($con_money, $s_ps_stm_doc);
                while($r_ps_stm_doc = mysqli_fetch_array($q_ps_stm_doc)){
                ?>
                  <option><?php echo $r_ps_stm_doc['pang_stamp_stm_file_name']." ".$r_ps_stm_doc['pang_stamp_stm_rep']?></option>
                <?php
                }//loop while row_concat_pttype
                ?>
              </datalist>
            </div>

            <div class="form-group">
              <button class="btn btn-primary btn-lg" type="submit">บันทึก</button>
            </div>
              
          </form> 
        </div>
      </div>
    </div>


  </div>        
</div>


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