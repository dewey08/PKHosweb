<?php

include("../connect/connect.php");
@include('../session/session_claim.php');

set_time_limit(0);
// some code

@session_start();

#เงื่อนไขผัง
if(isset($_GET["pang"])){
    $pang = $_SESSION["pang"] = $_GET["pang"];
}else{
    $pang = $_SESSION["pang"];
}

$sql_pang_preview=" SELECT p.pang_id, p.pang_fullname, p.pang_instument, p.pang_stm, p.pang_kor_tok
                  , p.pang_kor_tok_icd, p.pang_cancer  , p.pang_type
                  FROM pang p LEFT OUTER JOIN pang_sub ps ON p.pang_id=ps.pang_id
                  WHERE p.pang_id='$pang' AND p.pang_year='$y_s'
                  LIMIT 100";
$result_pang_preview = mysqli_query($con_money, $sql_pang_preview) or die(mysqli_error($con_money));
$row_pang_preview = mysqli_fetch_array($result_pang_preview);
$pang_type = $row_pang_preview["pang_type"];##ตรวจว่าเป็นคนไข้ในหรือคนไข้นอก

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
  $where_pttype=" AND ptt.hipdata_code = 'UCS' AND ptt.paidst='02' ";
}
# pang_pttype #########################################

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
  $where_hospcode_notin=" AND o.hospmain NOT IN (".$concat_hospcode_notin.") ";
}else{
  $where_hospcode_notin="  ";
}
# pang_hospcode_notin #########################################


# pang_kor_tok check ข้อตกลง #########################################
$pang_kor_tok = $row_pang_preview["pang_kor_tok"];
$pang_kor_tok_icd = $row_pang_preview["pang_kor_tok_icd"];
# pang_kor_tok check ข้อตกลง #########################################


# pang_cancer ###########
/*
if(isset($row_pang_preview["pang_cancer"])){
  $where_pang_cancer = " AND v.pdx LIKE 'C%' ";
}else{
  $where_pang_cancer = " AND v.pdx NOT LIKE 'C%' ";
}
*/
# pang_cancer ###########

/*
  if((@$_POST["date_sir_f"])!=''&&(@$_POST["date_sir_s"])!='' ){
    $date_sir_f= $_SESSION["date_sir_f"] = $_POST['date_sir_f'];
    $date_sir_s= $_SESSION["date_sir_s"] = $_POST['date_sir_s'];
    $where_vstdate=" AND ps.pang_stamp_vstdate BETWEEN '$date_sir_f' AND '$date_sir_s' ";
  }elseif(isset($_POST['date_sir_f'])){
    $date_sir_f= $_SESSION["date_sir_f"] = $_POST['date_sir_f'];
    $where_vstdate=" AND ps.pang_stamp_vstdate='$date_sir_f' ";
    unset($_SESSION["date_sir_s"]);
  }elseif(isset($_SESSION["date_sir_f"])&&isset($_SESSION["date_sir_s"])){
    $date_sir_f= $_SESSION["date_sir_f"];
    $date_sir_s= $_SESSION["date_sir_s"];
    $where_vstdate=" AND ps.pang_stamp_vstdate BETWEEN '$date_sir_f' AND '$date_sir_s' ";
  }elseif(isset($_SESSION["date_sir_f"])){
    $date_sir_f= $_SESSION["date_sir_f"];
    $where_vstdate=" AND ps.pang_stamp_vstdate='$date_sir_f' ";
  }
*/
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <!-- Custom Stylesheet -->
    <link href="./plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/input_datatable.css"/><!-- css สำหรับเปลี่ยน search ให้เห็นกรอบ -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script><!--modal-->

  </head>
      




  <body>

      

  <?php

  if($pang_type=='OPD'){
    $s_date = "ps.pang_stamp_vstdate";
  }elseif($pang_type=='IPD'){
    $s_date = "ps.pang_stamp_dchdate";
  }else{
  }

  $date_now=date("Y-m-d");
  $sqlshow = "SELECT IF(ps.pang_stamp_vn IS NULL,'','Y')AS Stamp
                  ,ps.pang_stamp_vn AS 'vn'
                  ,ps.pang_stamp_hn AS 'hn'
                  ,ps.pang_stamp_vstdate
                  ,ps.pang_stamp_nhso
                  ,ps.pang_stamp_uc_money
                  ,ps.pang_stamp_stm_money AS stm
                  ,ps.pang_stamp_uc_money_minut_stm_money
                  ,ps.pang_stamp_send
                  ,ps.pang_stamp_id
                  ,ps.pang_stamp
                  ,ps.pang_stamp_stm_file_name
                  FROM $database_ii.pang_stamp ps
                  WHERE ps.pang_stamp_edit_olddata = '$pang'
                  AND $s_date BETWEEN '$start_year' AND '$end_year'
                  ORDER BY ps.pang_stamp_hn
                  LIMIT 10000 ";
  $result_showed = mysqli_query($con_money, $sqlshow) or die(mysqli_error($con_money));
  $field_c = mysqli_num_fields($result_showed);
  ?>

   

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">  
          <h2>รายการที่ยกเลิก Stamp</h2>  
            <div class="table-responsive">
              <!-- Modal sql -->    
              <div class="col-md-1 col-lg-1 mb-1">
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
                        
                        <div class="modal-body"><?= "pang_opd_stamp_cancel"?></div>
                        <div class="modal-body"><?php echo nl2br (tab2nbsp($sqlshow));?></div>
                        
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

              <table class="table table-striped table-bordered zero-configuration">  
                <thead>
                  <tr>
                    
                    <th class=""><div align="center">Stamp</div></th>
                    <th class=""><div align="center">HN</div></th>
                    <th class=""><div align="center">วันที่รับบริการ</div></th>
                    <th class=""><div align="center">สิทธิ Stamp</div></th>
                    <th class=""><div align="center">Stamp_uc_money</div></th>
                    <th class=""><div align="center">ส่วนต่าง</div></th>
                    <th class=""><div align="center">STM</div></th>
                    
                    <th class=""><div align="center">เลขที่ส่งหนังสือ</div></th>
                    
                    
                  </tr>
                </thead>

                <tbody>
                  <?php                
                  $no=0;
                  while($row_show = mysqli_fetch_array($result_showed)){
                  $no++;   
                  $pang_stamp = $row_show["pang_stamp"]; 
                  $pang_stamp_vn = $row_show["vn"];  
                  $pang_stamp_id = $row_show["pang_stamp_id"];   
                  ?>
                  <tr>
            
                    <td>
                      <a class="btn btn-info " target="_blank" href="../report/edit_stamp_sit.php?pang_stamp_id=<?=$pang_stamp_id?>">บันทึกข้อความ</a>
                    </td>            

                    <td class="text-nowrap">
                      <button type="button" name="view_patient" class="btn mb-1 btn-secondary view_patient" id="<?php echo $pang_stamp_vn;?>"  >
                        <?php echo $row_show["hn"]; ?>
                      </button>


                    </td>

                    <td class="text-nowrap">
                      <?php
                      echo DateThaisubmonth($row_show["pang_stamp_vstdate"]);
                      ?>
                    </td>

                    <td class="text-nowrap">
                      <?php
                      echo $row_show["4"]."<BR>";
                      ?>
                    </td>

                    <td class="text-nowrap">
                      <?php
                      echo number_format($row_show["pang_stamp_uc_money"],2)."<BR>";
                      ?>
                    </td>

                    <td>
                      <?php echo $row_show["pang_stamp_uc_money_minut_stm_money"]; ?>
                    </td>

                    <td class="text-nowrap">
                      <?php
                      echo $row_show["pang_stamp_stm_file_name"];
                      ?>
                    </td>                  
            
                    <td>
                      <?php echo $row_show["pang_stamp_send"]; ?>
                    </td>
                    <!-- ############################################## -->
            
  
                  </tr>
                  <?php
                  }// loop while
                  ?>
                </tbody>
      <!-- </form> -->
              </table>

 

          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Modalstamp-->
  <script>
    $(document).ready(function(){
           
      function fetch_post_data_lab(vnpang)
      {
        $.ajax({
          url:"pang_opd_stamped_edit_stamp.php",
          method:"POST",
          data:{vnpang:vnpang},
          success:function(data)
          {
            $('#post_modal_claim_code').modal('show');
            $('#post_detail_claim_code').html(data);
          }
        });
      }

      $(document).on('click', '.view_edit_stamp', function(){
        var vnpang = $(this).attr("id");
        fetch_post_data_lab(vnpang);
      });
           
    });
  </script>

  <div id="post_modal_claim_code" class="modal fade">
    <div class="modal-dialog modal-lg">
      <div class="modal-content"> 
        <div class="modal-header">
          <h1 class="modal-title">แก้ไขรายการ Stamp</h1>
        </div>
        <div class="modal-body" id="post_detail_claim_code"></div>
      </div>
    </div>
  </div>
  <!-- Modalstamp-->

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
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body" id="post_detail_patient"></div>
      </div>
    </div>
  </div>
  <!-- Modal_patient-->

  </body>
</html>
