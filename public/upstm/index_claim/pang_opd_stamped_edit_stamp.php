<?php
include('../connect/connect.php');
@include('../session/session_claim.php');
@session_start();

function DateThai($strDate){
   $strYear = date("Y",strtotime($strDate))+543;
   $strMonth= date("n",strtotime($strDate));
   $strDay= date("j",strtotime($strDate));
   $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
   $strMonthThai=$strMonthCut[$strMonth];
   return "$strDay $strMonthThai $strYear";
}
?>

<meta name="viewport" content="width=device-width, initial-scale=1">


<body>

  <div>
    
    
<?php
$vnpang_re = $_REQUEST['vnpang'];

#ช่วงระยะเวลาปีงบ
#$y_s= $_SESSION["y_s"];
$pieces = explode("|", $vnpang_re);
$pang_stamp_vn=$pieces[0];
$pang_stamp=$pieces[1];
$backto=$pieces[2];
if(@$pang_stamp_vn!=''){
//ifpang_stamp_hn_sir_edit
?>

    <div class="">
      <div class="">
        <?php
 
        $sql_pang_sub="SELECT
                      IF(p.pang_stamp_an='' OR p.pang_stamp_an IS NULL,'OPD','IPD')pt_type
                      ,IF(p.pang_stamp_vn<>'',p.pang_stamp_vn,p.pang_stamp_an)'VN/AN'
                      ,p.pang_stamp_income
                      ,p.pang_stamp_paid_money
                      ,p.pang_stamp_uc_money
                      ,p.pang_stamp_send AS 'เลขที่ส่งการเงิน'
                      ,p.pang_stamp_user_stamp AS 'user_stamp'
                      ,p.pang_stamp_edit
                      ,p.pang_stamp_id
                      ,p.pang_stamp_hn,p.pang_stamp_vn,p.pang_stamp_vstdate
                      ,p.pang_stamp_edit_send_id
                      FROM pang_stamp p
                      WHERE pang_stamp_vn = '$pang_stamp_vn'
                      AND pang_stamp = '$pang_stamp'

                      LIMIT 123";
        $result_pang_sub = mysqli_query($con_money, $sql_pang_sub) or die(mysqli_error($con_money));

        $no=0;
        $field_c = mysqli_num_fields($result_pang_sub);
        while($row_show = mysqli_fetch_array($result_pang_sub)){
        $no++;
        $pang_stamp_id=$row_show["pang_stamp_id"];
        $pang_stamp_edit_send_id=$row_show["pang_stamp_edit_send_id"];
        
        $pt_type=$row_show["pt_type"]; #เป็นคนไข้ในหรือคนไข้นอก
        $vn=$row_show["VN/AN"];
        ?>
        
            <div class="row">
              <?php
              if($row_show["เลขที่ส่งการเงิน"]!=""){
              ?>

              <div class="form-validation">
              <div class="form-group row">
                <div class="col-lg-12">
                  <form method="post" action="pang_edit_stamp.php">
                    <input type="hidden" name="backto" value="<?php echo $backto ?>">
                    <input type="hidden" name="pang_stamp_id" value="<?php echo $pang_stamp_id ?>">
                    <input type="hidden" name="pt_type" value="<?php echo $pt_type ?>">
                    <input type="hidden" name="vn" value="<?php echo $vn ?>">
                    <input type="hidden" name="edit_type" value="edit_money_send">
                    <!--
                    <button class="btn btn-md btn-danger" type="submit" onclick="return confirm('ยืนยันการแก้ไขเงิน STAMP รายนี้ได้เคยทำการส่งการเงินไปแล้ว ?')">เงิน(ยังไม่เสร็จ)</button> -->
                    <button class="btn mb-1 btn-danger btn-lg" type="submit" onclick="return confirm('ยืนยันการแก้ไขเงิน STAMP รายนี้ได้เคยทำการส่งการเงินไปแล้ว ?')">แก้ไขเงิน<span class="btn-icon-right"><i class="fa fa-money"></i></span></button>             
                  </form>
                </div>
              </div>

              <form method="post" action="pang_edit_stamp.php">
              <div class="form-group row">
                
                <div class="col-lg-6">

                    <input type="hidden" name="backto" value="<?php echo $backto ?>">
                    <input type="hidden" name="pang_stamp_id" value="<?php echo $pang_stamp_id ?>">
                    <input type="hidden" name="pt_type" value="<?php echo $pt_type ?>">
                    <input type="hidden" name="vn" value="<?php echo $vn ?>">
                    <input type="hidden" name="edit_type" value="edit_pttype_send">
                    <?php
          
                    $sql_concat_pttype=" 
                      SELECT p.pang_id, pang_fullname FROM pang p
                      WHERE pang_type ='$pt_type'
                      GROUP BY p.pang_id
                      LIMIT 200 ";
                    $result_concat_pttype = mysqli_query($con_money, $sql_concat_pttype);
                 
                    ?>                 

                     
                      <input  class="form-control form-control-lg" type="text" id="pang_id" name="pang_id" list="icode-list" autocomplete="off" placeholder="ระบุผังที่จะย้าย" required> 
                    

                      <datalist id="icode-list">

                      <?php
                      while($row_concat_pttype = mysqli_fetch_array($result_concat_pttype)){
                      ?>
                        <option><?php echo $row_concat_pttype['pang_id']." ".$row_concat_pttype['pang_fullname']?></option>
                      <?php
                      }//loop while row_concat_pttype
                      ?>
                      </datalist>
                    <!--
                    <button class="btn btn-md btn-danger" type="submit" onclick="return confirm('ยืนยันการแก้ไขสิทธิ STAMP รายนี้ได้เคยทำการส่งการเงินไปแล้ว ?')" >สิทธิ</button> -->
                </div>
                <div class="col-lg-6">
                    <button class="btn mb-1 btn-secondary btn-lg" type="submit" onclick="return confirm('ยืนยันการแก้ไขสิทธิ STAMP รายนี้ได้เคยทำการส่งการเงินไปแล้ว ?')">แก้ไขผัง<span class="btn-icon-right"><i class="fa fa-user-o"></i></span>
                    </button>
                </div>                  
                  
              </div>
              </form>

            </div>


              <?php
              }elseif($row_show["เลขที่ส่งการเงิน"]==""){
              ?>
                <form method="post" action="pang_edit_stamp.php">
                  <input type="hidden" name="backto" value="<?php echo $backto ?>">
                  <input type="hidden" name="pang_stamp_id" value="<?php echo $pang_stamp_id ?>">
                  <input type="hidden" name="pt_type" value="<?php echo $pt_type ?>">
                  <input type="hidden" name="vn" value="<?php echo $vn ?>">
                  <input type="hidden" name="edit_type" value="edit_money">
                  <button class="btn mb-1 btn-secondary btn-lg" type="submit" onclick="return confirm('ยืนยันการแก้ไขเงิน ? ระบบจะดึงยอดเงินจาก HosXP มาอัพเดต IPD:an_atat, OPD:vn_stat')">แก้ไขเงิน<span class="btn-icon-right"><i class="fa fa-money"></i></span></button>
                </form>
                &nbsp
                <form method="post" action="pang_edit_stamp.php">
                  <input type="hidden" name="backto" value="<?php echo $backto ?>">
                  <input type="hidden" name="pang_stamp_id" value="<?php echo $pang_stamp_id ?>">
                  <input type="hidden" name="pt_type" value="<?php echo $pt_type ?>">
                  <input type="hidden" name="vn" value="<?php echo $vn ?>">
                  <input type="hidden" name="edit_type" value="edit_pttype">
                  <button class="btn mb-1 btn-primary btn-lg" type="submit" onclick="return confirm('ยืนยันการแก้ไขสิทธิ การแก้ไขสิทธิที่ยังไม่ได้ส่งการเงิน จะเป็นการลบรายการ Stamp นี้ออก ?')" >นำออกจากผัง<span class="btn-icon-right"><i class="fa fa-user-o"></i></span></button>
                </form>
              <?php
              }
              ?>
                
            
              <?php
              if(isset($row_show["pang_stamp_edit_send_id"])){
                echo '<a class="btn btn-info " target="_blank" href="report/edit_stamp.php?pang_stamp_id='.$pang_stamp_edit_send_id.'">บันทึกข้อความ</a>';
              }
              ?>
              <!-- <a class="btn btn-info" target="_blank" href="report/debt.php?vn=<?=$vn?>&hn=<?=$hn?>" role="button">ใบทวงค้าง</a> -->
            </div>
        <?php

              echo "<h2>HN : ".$row_show["pang_stamp_hn"]."</h2><BR>";
              echo "<h2>VN : ".$row_show["pang_stamp_vn"]."</h2><BR>";
              echo "<h2>วันที่รับบริการ : ".DateThai($row_show["pang_stamp_vstdate"])."</h2><BR>";
              echo "<h2>ค่าใช้จ่ายทั้งหมด : ".number_format($row_show["pang_stamp_income"],2)."</h2><BR>";
              echo "<h2>ลูกหนี้ : ".number_format($row_show["pang_stamp_uc_money"],2)."</h2><BR>";
              echo "<h2>ชำระเอง : ".number_format($row_show["pang_stamp_paid_money"],2)."</h2><BR>";

             
             
          }// loop for
          ?>
            
        
        <?php
        
        ?>  
        
<?php
} //ifpang_stamp_hn_sir_edit
?>          
      </div>
    </div>
  </div>
</body>