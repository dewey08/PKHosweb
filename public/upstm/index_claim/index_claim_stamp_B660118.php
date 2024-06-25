<?php
@session_start();
include("../session/session_claim.php");
include("../connect/connect.php");
#ช่วงระยะเวลาปีงบ
$start_year_ngob=($y_s-1)."-10-01";
$end_year_ngob=$y_s."-09-30";
#ช่วงระยะเวลาปีงบ


?>
       
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        

        <?php
        #ตรวจสอบว่าเป็ฯการส่งครั้งแรก หรือการแก้ไขฝบสรุปส่ง
        if(isset($_REQUEST['pang_stamp_send'])){
        }else{
        
         
        ?>
        <div class="row mb-1">
          <div class="col-4">
            <form method="post" action="<?php echo $backto;?>">
              ส่งลูกหนี้ทั้งหมด จนถึง
              
              <input class=""  type="text" name="date_sir_f" id="date_sir_f" value="<?php echo $date_sir_f?>" onkeydown="return false" autocomplete="off"  required="yes">

              <input type="submit" name="" value="Preview" class="btn btn-primary">
            </form>
          </div>                
        </div>
        <?php
        }
        #ตรวจสอบว่าเป็ฯการส่งครั้งแรก หรือการแก้ไขฝบสรุปส่ง 
        ?>

        <div class="col-md-12 col-lg-12">
        <?php
        #ตรวจสอบว่าเป็ฯการส่งครั้งแรก หรือการแก้ไขฝบสรุปส่ง
        if(isset($_REQUEST['pang_stamp_send'])){
          $pang_stamp_send = $_REQUEST['pang_stamp_send'];
          $where_s ="WHERE ps.pang_stamp_send = '$pang_stamp_send' AND p.pang_year='$y_s' ";
          $show_button = 'แก้ไขใบสรุปส่ง';
          $show_button_color ='btn-warning';
        }else{
          @$where_s ="WHERE p.pang_year = '$y_s' AND ps.pang_stamp_vstdate <='$date_sir_f' 
            AND (ps.pang_stamp_send IS NULL OR ps.pang_stamp_send ='' ) ";
          $show_button = 'ส่งการเงิน';
          $show_button_color ='btn-primary';
        }
        #ตรวจสอบว่าเป็ฯการส่งครั้งแรก หรือการแก้ไขฝบสรุปส่ง

        #,(COUNT(ps.pang_stamp_id))-(COUNT(ps.pang_stamp_edit)) AS 'จำนวน Visit'
        @$sql_pang_sub=" SELECT p.pang_fullname, p.pang_id
          ,(COUNT(DISTINCT ps.pang_stamp_vn)) AS total_visit 

          ,(IFNULL( SUM(ps.pang_stamp_uc_money),0))
          -(round(sum(if(ps.pang_stamp_edit='del',ps.pang_stamp_uc_money,0)),2))  AS sum_uc_money 

          ,GROUP_CONCAT(DISTINCT d.name)AS doctor_respond 
          ,IF(p.pang_kor_tok>0,
            (IFNULL(SUM(ps.pang_stamp_uc_money_kor_tok),0))
            -(round(sum(if(ps.pang_stamp_edit='del',ps.pang_stamp_uc_money,0)),2)) 
            ,(IFNULL(SUM(ps.pang_stamp_uc_money_kor_tok),0))
          ) AS sum_pang_kor_tok 
          ,p.pang_kor_tok
          ,ps.pang_stamp_edit_olddata
          ,GROUP_CONCAT(ps.pang_stamp_edit) AS pang_stamp_edit
          ,GROUP_CONCAT(DISTINCT
            if(ps.pang_stamp_edit='sit' OR ps.pang_stamp_edit='money',ps.pang_stamp_edit_olddata,null)
          ) AS gc_pang_stamp_edit_olddata
          ,MAX(ps.pang_stamp_vstdate) AS max_pang_stamp_vstdate
          ,MIN(ps.pang_stamp_vstdate) AS min_pang_stamp_vstdate
          ,DATE_FORMAT(ps.pang_stamp_vstdate,'%m') AS month_send
          FROM pang p 
          LEFT OUTER JOIN pang_stamp ps ON p.pang_id=ps.pang_stamp
          LEFT OUTER JOIN $database.opduser o ON ps.pang_stamp_user_stamp=o.loginname
          LEFT OUTER JOIN $database.doctor d ON o.doctorcode=d.code
          $where_s
          AND ps.pang_stamp_uc_money <>0 #ดักกรณี ประกันสังคม rw>=2 จะมี 2 reccord ผัง 302.uc=0,310.uc>0
          GROUP BY p.pang_id 
          ORDER BY ps.pang_stamp_edit        
          LIMIT 100";
          #AND ps.pang_stamp_edit_olddata !='sit' AND (ps.pang_stamp_edit !='sit' OR ps.pang_stamp_edit IS NULL)
        $result_pang_sub = mysqli_query($con_money, $sql_pang_sub) or die(mysqli_error($con_money));


        #หาช่วงข้อมูล pang_stamp_vstdate ที่เลือก และสรุปว่าจะเป็นการส่งการเงินในงวดเดือนที่เท่าไหร่
        @$s_min_max_vstdate=" SELECT MAX(ps.pang_stamp_vstdate) AS max_pang_stamp_vstdate
          ,MIN(ps.pang_stamp_vstdate) AS min_pang_stamp_vstdate
          ,DATE_FORMAT(ps.pang_stamp_vstdate,'%m') AS month_send
          FROM pang p 
          LEFT OUTER JOIN pang_stamp ps ON p.pang_id=ps.pang_stamp
          $where_s
          AND ps.pang_stamp_uc_money <>0 #ดักกรณี ประกันสังคม rw>=2 จะมี 2 reccord ผัง 302.uc=0,310.uc>0
          LIMIT 100";
          #AND ps.pang_stamp_edit_olddata !='sit' AND (ps.pang_stamp_edit !='sit' OR ps.pang_stamp_edit IS NULL)
        $q_min_max_vstdate = mysqli_query($con_money, $s_min_max_vstdate) or die(mysqli_error($con_money));
        $r_min_max_vstdate = mysqli_fetch_array($q_min_max_vstdate);
        $max_pang_stamp_vstdate = $r_min_max_vstdate["max_pang_stamp_vstdate"];
        $min_pang_stamp_vstdate = $r_min_max_vstdate["min_pang_stamp_vstdate"];
        $month_send = $r_min_max_vstdate["month_send"];
        #หาช่วงข้อมูล pang_stamp_vstdate ที่เลือก และสรุปว่าจะเป็นการส่งการเงินในงวดเดือนที่เท่าไหร่

        if($min_pang_stamp_vstdate!=''){
      ?>          
          <h5>
            ช่วงข้อมูลวันที่รับบริการ
            <?= DateThaisubmonth($min_pang_stamp_vstdate)?>
            ถึง
            <?= DateThaisubmonth($max_pang_stamp_vstdate)?>
            เป็นสรุปส่งการเงินของเดือน
            <?= $strMonthFull[$month_send]." ".$month_send?>
          </h5>
        <?php 
        }
        ?>

          <div class="form-row align-items-center">
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
                    
                    <div class="modal-body"><?= "index_claim_stamp"?></div>
                    <div class="modal-body"><?php echo nl2br (tab2nbsp($sql_pang_sub));?></div>
                    <div class="modal-body"><?= "<HR>"?></div>
                    <div class="modal-body"><?= "หาค่าช่วงวันที่ vstdate และงวดที่ส่ง"?></div>
                    <div class="modal-body"><?php echo nl2br (tab2nbsp($s_min_max_vstdate));?></div>
                    
                    
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

          <form method="post" action="index_claim_stamp_update_send.php">
            <div class="col-auto">
              <button type="submit" class="btn <?php echo $show_button_color;?>" onclick="return confirm('ยืนยันการส่งลูกหนี้ให้การเงิน ?')"><?php echo $show_button;?></button>

            </div>

            

          </div> <!-- div class row -->

              <input type="hidden" name="backto" value="<?php echo $backto?>">  
              <input type="hidden" name="dateuntil" value="<?php echo $date_sir_f?>">
              <hr> 
                <?php
                


                $no=1;
                $field_c = mysqli_num_fields($result_pang_sub);

                ?>

                <div class="row" style="padding-left: 10px;">
                  <div class="col-3">ผัง</div>
                  <div class="col-1">จำนวน</div>
                  <div class="col-1">ลูกหนี้ทั้งหมด</div>
                
                  <div class="col-1">เบิกตามข้อตกลง</div>
                  

                  <div class="col-2">ผู้รับผิดชอบ</div>
                  <div class="col-2">รายละเอียดการแก้ไข</div>

                  
                  
                  
                </div>

                <?php

                while($row_show = mysqli_fetch_array($result_pang_sub)){
                @$pang_stamp_edit = $row_show['pang_stamp_edit'];
                @$gc_pang_stamp_edit_olddata = $row_show['gc_pang_stamp_edit_olddata'];
                $no++;
                
                ?>
                <div class="row" style="padding-left: 10px;">
                  <div class="col-3">
                  <?php
                    if($row_show["pang_stamp_edit"]!=''){
                      echo "<font color='red'>แก้ไข </font> ".$row_show["pang_fullname"];
                    }else{
                      echo $row_show["pang_fullname"].$row_show["pang_stamp_edit_olddata"];
                    }
                  ?>
                  
                    <input type=hidden style='width:100%' value='<?php echo $row_show["pang_id"] ?>' name='pang_stamp_send_pang[]' readonly>

                    <input type=hidden value='<?php echo @$pang_stamp_send ?>' name='pang_stamp_send' >
                    <input type=hidden value='<?php echo @$pang_stamp_edit ?>' name='pang_stamp_edit_pang[]' >
                    <input type=hidden value='<?php echo @$gc_pang_stamp_edit_olddata ?>' name='pang_stamp_edit_olddata[]' >
                  </div>

                  <div class="col-1"> 
                    <input type=hidden value='<?php echo $row_show["total_visit"] ?>' name='pang_stamp_send_visit[]' >
                    <input type=text style='width:100%' value='<?php echo number_format($row_show["total_visit"]) ?>' readonly>
                  </div>
                  <div class="col-1"> 
                    <input type=hidden value='<?php echo $row_show["sum_uc_money"] ?>' name='pang_stamp_send_money[]' >
                    <input type=text style='width:100%;text-align: right;'  value='<?php echo number_format($row_show["sum_uc_money"],2) ?>' readonly>
                  </div>

                  <?php
                  if(isset($row_show["pang_kor_tok"])){
                    $show_input ='text';
                  }else{
                    $show_input ='hidden';
                  }
                  ?>
                  <div class="col-1"> 
                    <input type="<?= $show_input?>" style='width:100%;text-align: right;' value='<?php echo $row_show["sum_pang_kor_tok"] ?>' 
                    name='pang_stamp_send_money_kor_tok[]' readonly>
                  </div>
                  
                  

                  <div class="col-2"> 
                    <input type=text style='width:100%' value='<?php echo $row_show["doctor_respond"] ?>' name='pang_stamp_send_responsible[]' readonly>
                  </div>


                  <div class="col-2">
                    <?php
                    if($row_show["pang_stamp_edit"]=='money'){
                    ?>
                      <font color='red'>แก้ไขยอดเงิน</font>
                    <?php
                    }elseif($row_show["pang_stamp_edit"]!=''){
                    ?>
                      <font color='red'><?php echo $row_show["gc_pang_stamp_edit_olddata"];?></font>
                    <?php
                    }
                    ?> 
                    
                  </div>

                  
                  
                  
                </div>
              <hr>
                <?php
                }

                ?>  
          </form>      

        </div>

      </div>
    </div>
  </div>
</div>
    



    
