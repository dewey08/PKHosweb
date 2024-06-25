<?php
@session_start();
include("session/session_money.php");
include("connect/connect.php");
?>
       
<div class="row" style="width: 95%">
<?php
include("index_claim/index_claim_receipt_number.php");
?>
 
  <div class="col-md-12 col-lg-12">

    <div class="row mb-1">

          <div class="col-3">
            <form method="post" action="<?php echo $backto ?>">
              
              <?php

              @$sir_year = $_SESSION["sir_year"];
      $s_doc_count_stm = "SELECT rn.receipt_number_stm_file_name FROM pang_stamp ps
                LEFT OUTER JOIN pang p ON ps.pang_stamp = p.pang_id
                LEFT OUTER JOIN receipt_number rn ON ps.pang_stamp_stm_file_name=rn.receipt_number_stm_file_name
                WHERE p.pang_year='$sir_year' AND p.pang_stm='doc' 
                AND ( ps.pang_stamp_stm_money IS NULL OR ps.pang_stamp_stm_money ='' )
                AND rn.receipt_number IS NOT NULL
                GROUP BY rn.receipt_number_stm_file_name
                LIMIT 5000 ";
      $q_doc_count_stm = mysqli_query($con_money,$s_doc_count_stm);
      $r_doc_count_stm = mysqli_fetch_array($q_doc_count_stm);
      #$count_pang_stamp_id_stm = $r_doc_count_stm["count_pang_stamp_id"];
            # กรณี ยังไม่ได้ตัดรายตัว
      $sum_notifi_receipt = $count_pang_stamp_id+$count_pang_stamp_id_stm;

              
              $q_pss = mysqli_query($con_money,$s_doc_count_stm);
                ?>
              <input class="form-control form-control-lg mb-3" type="text" id="receipt_number_stm_file_name" name="receipt_number_stm_file_name" list="pang_stamp_send-list" autocomplete="off" placeholder="เลือกไฟล์ STM หรือ เลขที่หนังสือ" required="" onkeydown="return false">  

              <datalist id="pang_stamp_send-list">

              <?php
              while($r_pss = mysqli_fetch_array($q_pss)){
              ?>
                <option><?php echo $r_pss['receipt_number_stm_file_name']?></option>
              <?php
              }//loop while row_concat_pttype
              ?>
              
              

            </datalist>

              
          </div>
          <div class="col-1">
              <button class="btn btn-primary" type="submit">เลือก</button>
            </form>
          </div>
          <div class="col-3" align="left">
            <form method="post" action="<?php echo $backto ?>">
              <input type="hidden" name="reset_stm" value="Y">
              <button class="btn btn-danger" type="submit">ถอย</button>
            </form>
          </div>
          

    </div>

    <?php
      if(@$_POST["receipt_number_stm_file_name"]!=''){

        $receipt_number_stm_file_name = $_SESSION["receipt_number_stm_file_name"]=$_POST["receipt_number_stm_file_name"];

      }elseif(@$_POST["reset_stm"]=='Y'){

        unset($_SESSION["receipt_number_stm_file_name"]);
        $receipt_number_stm_file_name ="";

      }elseif(@$_SESSION["receipt_number_stm_file_name"]!=''){

        $receipt_number_stm_file_name = $_SESSION["receipt_number_stm_file_name"];
       
      }

## กรณีมีการเลือกไฟล์ STM #################################################################################

          if(@$receipt_number_stm_file_name!=''){
          ?>
          <nav class="navbar navbar-light bg-light">
          <div class="container-fluid">
          
          <?php
          $s_receipt_n = "SELECT sum(ps.pang_stamp_stm_money) AS sum_pang_stamp_stm_money , rn.receipt_number_money
                    FROM pang_stamp ps
                    LEFT OUTER JOIN receipt_number rn ON rn.receipt_number_stm_file_name=ps.pang_stamp_stm_file_name
                    WHERE rn.receipt_number_stm_file_name = '$receipt_number_stm_file_name' LIMIT 1";
          $q_receipt_n = mysqli_query($con_money,$s_receipt_n);
          $r_receipt_n = mysqli_fetch_array($q_receipt_n);
          @$receipt_number_money = $r_receipt_n["receipt_number_money"];
          @$sum_pang_stamp_stm_money = $r_receipt_n["sum_pang_stamp_stm_money"];
          echo "ยอดเงินชดเชยทั้งหมด : ".$receipt_number_money;
          ?> 

          </div>
        </nav>
          <?php
          } # IF @$pang_stamp_stm_file_name!=''
## กรณีมีการเลือกไฟล์ STM #################################################################################
          ?>

     
 
    <?php
## กรณีมีการเลือกไฟล์ STM #################################################################################
    if(@$receipt_number_stm_file_name!=''){
    echo "<h4> Visit ตาม ".$receipt_number_stm_file_name." ที่เลือก</h4>";
    ?>

    <?php


    $sir_year= $_SESSION["sir_year"]; //ปีงบ
        @$sql_pang_sub="SELECT 
          ps.pang_stamp_hn AS 'HN'
          , ps.pang_stamp_vstdate AS 'วันรับบริการ'
          , ps.pang_stamp_uc_money AS 'ลูกหนี้'
          , ps.pang_stamp_stm_money AS 'เงินชดเชย'
          ,ps.pang_stamp_uc_money_minut_stm_money AS 'ส่วนต่าง'
          ,oc.name AS 'งานประกัน'
          ,rn.receipt_number_id AS 'เลขที่ใบเสร็จรับเงิน'
          ,d.name AS 'การเงิน'
          ,ps.pang_stamp_id

          FROM pang p 
          LEFT OUTER JOIN pang_stamp ps ON p.pang_id=ps.pang_stamp
          LEFT OUTER JOIN receipt_number rn ON ps.pang_stamp_stm_file_name=rn.receipt_number_stm_file_name
          LEFT OUTER JOIN $database.opduser o ON rn.receipt_number_user_reccord=o.loginname
          LEFT OUTER JOIN $database.doctor d ON o.doctorcode=d.code
          LEFT OUTER JOIN $database.opduser oc ON ps.pang_stamp_user_stamp=oc.loginname
          LEFT OUTER JOIN $database.doctor dc ON oc.doctorcode=dc.code
          
          WHERE p.pang_year='$sir_year'
          AND ps.pang_stamp_stm_file_name='$receipt_number_stm_file_name'
          ORDER BY ps.pang_stamp_stm_money ASC
          LIMIT 1000";
        $result_pang_sub = mysqli_query($con_money, $sql_pang_sub) or die(mysqli_error($con_money));



?>
        
    <table border="1" class="table table-striped table-hover">

      <tr class="table-dark">
      <?php
      $field_c = mysqli_num_fields($result_pang_sub); // จำนวน field
      
      while($property=mysqli_fetch_field($result_pang_sub)){
    ?>
        <td><?php echo $property->name; ?></td>
    <?php

      }

    ?>
      
      </tr>
          
    <?php
      #$no=1;

      while($rowshow = mysqli_fetch_array($result_pang_sub)){
    ?>
      <tr>
        <td>
          <?php $row_pang_id=$rowshow[0];?>
          <a class="btn btn-info" href="index_money.php?show=row_pang&pang_id=<?=$row_pang_id?>">
          <?php
          echo $rowshow[0];
          ?>
          </a>
        </td>

        
    <?php
        for($i=1;$i<3;$i++){
    ?>
      
        <td>
          <?php
          echo $rowshow["$i"];
          ?>
        </td>
      
    <?php
        } // Loop for
    ?>

        <td>
          <?php
          
          if($rowshow[2]<($receipt_number_money-$sum_pang_stamp_stm_money)){
            $max_uc_money = $rowshow[2];
            $receipt_number_money_showplace = $receipt_number_money-$sum_pang_stamp_stm_money;
          }else{
            $max_uc_money = $receipt_number_money-$sum_pang_stamp_stm_money;
            $receipt_number_money_showplace = $receipt_number_money-$sum_pang_stamp_stm_money;
          }
          
          
          if($rowshow[3]==""){
          $pang_stamp_id=$rowshow["pang_stamp_id"];
          ?>
          <div class="row">
            <div class="col-8">
              <form method="post" action="index_claim/index_claim_receipt_number_receipt_insert.php">
                <input type="hidden" name="pang_stamp_id" value="<?php echo $pang_stamp_id;?>">
                <input type="hidden" name="backto" value="<?php echo $backto;?>">
                <input step="any" max="<?php echo $max_uc_money?>" autofocus class="form-control" type="number" autocomplete="off" name="pang_stamp_stm_money" maxlength="30" placeholder="ลงจำนวนเงิน คงเหลือ : <?php echo $receipt_number_money_showplace?>" required="yes"><!--รับค่าเลขที่เอกสาร-->
              
            </div>
            <div class="col-4">
                <input type="submit" value="บันทึก">
              </form>

            </div>
          </div>
          <?php
          }else{
            echo $rowshow[3];  
          }
          ?>
        </td>

    <?php
        for($i=4;$i<$field_c;$i++){
    ?>
      
        <td>
          <?php
          echo $rowshow["$i"];
          ?>
        </td>
      
    <?php
        } // Loop for
    ?>
      </tr>
    <?php
      } # while loop $rowshow
    ?>  
    </table>   

<?php
  } # @$receipt_number_stm_file_name!=''
## กรณีมีการเลือกไฟล์ STM #################################################################################
?>


  </div>
    
</div>


    
