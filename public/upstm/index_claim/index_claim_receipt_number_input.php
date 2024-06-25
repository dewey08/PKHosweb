<?php
@session_start();
include("session/session_money.php");
include("connect/connect.php");
?>
       
<div class="row" style="width: 95%">
<?php
include("index_claim/index_claim_receipt_number.php");
?>
  <!--     
  <div class="row mb-1">
    <div class="col-4">
      <form method="post" action="<?php echo $backto;?>">
        ส่งลูกหนี้ทั้งหมด จนถึง
        <input type="date" min="<?php echo $start_year?>" value="<?php echo $date_sir_f ?>" max="<?php echo $end_year?>" name="date_sir_f" required="yes">
        <button class="btn btn-primary" type="submit">Preview</button>
      </form>
    </div>
          
  </div>
  -->
  <div class="col-md-12 col-lg-12">

    <div class="row mb-1">

          <div class="col-12">
            <!-- <form method="post" action="<?php echo $backto ?>"> -->
              
              <?php
              
              $sir_year = $_SESSION["sir_year"];
              $s_pang = "SELECT * FROM pang p
                        WHERE p.pang_year='$sir_year' AND p.pang_stm='doc'
                        GROUP BY p.pang_id LIMIT 100 ";
              $q_pang = mysqli_query($con_money,$s_pang);


              
              
              while($r_pang = mysqli_fetch_array($q_pang)){
                $pang_id = $r_pang['pang_id'];
                # Notifi รายผัง #######################################
                $s_doc_count_pang = "SELECT COUNT(ps.pang_stamp_id) AS count_pang_stamp_id_pang FROM pang_stamp ps
                          LEFT OUTER JOIN pang p ON ps.pang_stamp = p.pang_id
                          WHERE p.pang_year='$sir_year' AND p.pang_stm='doc' AND ps.pang_stamp='$pang_id' AND ( ps.pang_stamp_stm_file_name IS NULL OR ps.pang_stamp_stm_file_name ='' )
                          LIMIT 5000 ";
                $q_doc_count_pang = mysqli_query($con_money,$s_doc_count_pang);
                $r_doc_count_pang = mysqli_fetch_array($q_doc_count_pang);
                $count_pang_stamp_id_pang = $r_doc_count_pang["count_pang_stamp_id_pang"];
                # Notifi รายผัง #######################################

              ?>
                <a class="nav-link notification_re" onclick="window.location.href='index_claim.php?sum=receipt_number&type_rn=input&pang_id_re=<?=$pang_id?>'"><?php echo $r_pang['pang_fullname']?>
                  <!-- Notification -->
                  <span class="badge"><?php if($count_pang_stamp_id_pang!=0){ echo $count_pang_stamp_id_pang; }?></span>
                  <!-- Notification -->
                </a>
              <?php
              }//while($r_pang = mysqli_fetch_array($q_pang)){
              ?>
              
              

            </datalist>

              
          </div>
          
          

    </div>

    <?php
      if(@$_GET["pang_id_re"]!=''){

        $pang_id_re = $_SESSION["pang_id_re"]=$_GET["pang_id_re"];

      }elseif(@$_GET["reset_stm"]=='Y'){

        unset($_SESSION["pang_id_re"]);
        $pang_id_re ="";

      }elseif(@$_SESSION["pang_id_re"]!=''){

        $pang_id_re = $_SESSION["pang_id_re"];
       
      }

## กรณีมีการเลือกไฟล์ STM #################################################################################

if(@$pang_id_re!=''){
?>
          
         

    <?php
    $sir_year= $_SESSION["sir_year"]; //ปีงบ
        @$sql_pang_sub="SELECT 
                ps.pang_stamp_hn AS HN
                ,ps.pang_stamp_uc_money AS 'ลูกหนี้ที่ตั้ง'
                ,ps.pang_stamp_vstdate AS 'วันที่รับบริการ'
                ,ps.pang_stamp_id
                ,ps.pang_stamp
                FROM pang_stamp ps
                LEFT OUTER JOIN pang p ON ps.pang_stamp = p.pang_id
                WHERE p.pang_year='$sir_year' AND p.pang_stm='doc' 
                AND ps.pang_stamp = '$pang_id_re'
                AND ( ps.pang_stamp_stm_file_name IS NULL OR ps.pang_stamp_stm_file_name ='' )
                LIMIT 5000 ";
        $result_pang_sub = mysqli_query($con_money, $sql_pang_sub) or die(mysqli_error($con_money));



?>
    <BR> 
    <h4><?php echo @$pang_id_re?></h4>
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
          <div class="row">

            <div class="col-2">
            <?php 
            echo $row_pang_id=$rowshow[0];
            $pang_stamp_id=$rowshow["pang_stamp_id"];
            $pang_stamp=$rowshow["pang_stamp"];
            ?>
            </div>
            <div class="col-4">
              <form method="post" action="index_claim/index_claim_receipt_number_input_insert.php">
                <input type="hidden" name="pang_stamp_id" value="<?php echo $pang_stamp_id;?>">
                <input type="hidden" name="pang_stamp" value="<?php echo $pang_stamp;?>">
                <input type="hidden" name="backto" value="<?php echo $backto;?>">
                <input autofocus class="form-control" type="text" autocomplete="off" name="pang_stamp_stm_file_name" maxlength="30" placeholder="ลงเลขที่หนังสือ" required="yes"><!--รับค่าเลขที่เอกสาร-->
              
            </div>
            <div class="col-2">
                <input type="submit" value="บันทึก">
              </form>

            </div>

          </div>    
        </td>
    <?php
        for($i=1;$i<$field_c;$i++){
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
  } # @$pang_id_re!=''
## กรณีมีการเลือกไฟล์ STM #################################################################################
?>


  </div>
    
</div>


    
