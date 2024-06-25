<?php
include('../connect/connect.php');
include('../session/session.php');
@session_start();

$y_s = $_SESSION["y_s"];
$pang=$_REQUEST['pang'];

$s_pang = "SELECT 
    p.*
    ,(SELECT GROUP_CONCAT(pang_pttype) FROM pang_pttype WHERE pang_id=p.pang_id ) pttype_in
    ,(SELECT pang_stm_name FROM pang_stm WHERE pang_stm_table=p.pang_stm) show_pang_stm
    ,(SELECT pang_icode FROM pang_icode WHERE pang_id=p.pang_id LIMIT 1)check_pang_icode
    ,(SELECT pang_hospcode FROM pang_hospcode WHERE pang_id=p.pang_id LIMIT 1)check_pang_hospcode
    ,(SELECT pang_hospcode FROM pang_hospcode_notin WHERE pang_id=p.pang_id LIMIT 1)check_pang_hospcode_notin
    ,(SELECT pang_icd_id FROM pang_icd WHERE pang_id=p.pang_id LIMIT 1)check_pang_icd
    ,(SELECT pang_icd_id FROM pang_icd9 WHERE pang_id=p.pang_id LIMIT 1)check_pang_icd9
    FROM pang p
    WHERE p.pang_year = '$y_s'
    AND p.pang_id = '$pang'
    limit 1 ";  
    #echo nl2br($s_pang);
$q_pang = mysqli_query($con_money, $s_pang);
$r_pang = mysqli_fetch_array($q_pang);



#สคริปสร้าง temp_pttype_hos
$s_drop_t_tph = "DROP TABLE IF EXISTS temp_pttype_hos";
$q_drop_t_tph = mysqli_query($con_money, $s_drop_t_tph) or die(nl2br($s_drop_t_tph));

if($q_drop_t_tph){
    $s_create_tph="  CREATE TABLE temp_pttype_hos
                        SELECT pttype,name FROM $database.pttype";
    $q_create_tph = mysqli_query($con_money, $s_create_tph) or die(nl2br($s_create_tph));
    // $s_add_pk_tpsi = " ALTER TABLE $pang_str_replace ADD PRIMARY KEY(vn)";
    // $q_add_pk_tpsi = mysqli_query($con_money, $s_add_pk_tpsi) or die(nl2br($s_add_pk_tpsi));
}   
#สคริปสร้าง temp_pttype_hos


$s_pttype = "SELECT pang_pttype, name FROM pang_pttype p 
            LEFT JOIN temp_pttype_hos ph ON p.pang_pttype=ph.pttype
            WHERE p.pang_id='$pang' LIMIT 200 ";  
    #echo nl2br($s_pang);
$q_pttype = mysqli_query($con_money, $s_pttype) or die (nl2br($s_pttype));
#$r_pttype = mysqli_fetch_array($q_pttype);

?>
<div class="row">
    <div class="col-lg-12">
    
        <div class="card bg-success">
            <div class="card-body">  
                <?php
                echo "<h3>ผัง : ".$r_pang['pang_fullname'];   
                echo "<h3>ประเภทผู้ป่วย : ".$r_pang['pang_type']." ".$r_pang['pang_pttype']."<BR>";
                ?>
            </div>
        </div>

        <div class="card bg-light">
            <div class="card-body row">  
            <style>
            .tooltip {
            position: relative;
            display: inline-block;
            border-bottom: 1px dotted black;
            }

            .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: black;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            
            /* Position the tooltip */
            position: absolute;
            z-index: 1;
            bottom: 100%;
            left: 50%;
            margin-left: -60px;
            }

            .tooltip:hover .tooltiptext {
            visibility: visible;
            }
            </style>
                <?php
                while($r_pttype = mysqli_fetch_array($q_pttype)){
                if($r_pang['pttype_in']==''){
                    echo "ยังไม่ได้กำหนดสิทธิ";
                }else{
                    #$show_pttype_in=$r_pang['pttype_in'];
                ?><h3>
                    <!-- <a class="label label-success "  href="#" data-toggle="tooltip" title="<?= $r_pttype['name']?>" >
                        <?php echo $r_pttype['pang_pttype'];?>
                    </a>&nbsp -->
                    <button type="button" name="view_pttype" data-toggle="tooltip" title="<?= $r_pttype["name"]?>" class="btn mb-1 btn-success view_pttype" id="<?= $r_pttype["pang_pttype"]?>" ><?= $r_pttype['pang_pttype']?></button>&nbsp
                </h3>
                <?php
                }
                #echo "<h3>สิทธิ : ".$show_pttype_in."<BR>";
                ?>
                
                <?php 
                }
                ?>
            </div>
        </div>


        <?php 
        if($r_pang['check_pang_hospcode']!=''){
        ?>
        <div class="card bg-info">
            <div class="card-body"> 
                <h3>รหัส รพ.ที่เลือก
                <?php
                $s_phcode = "SELECT pang_hospcode_full FROM pang_hospcode WHERE pang_id = '".$r_pang['pang_id']."' LIMIT 200 "; 
                #echo nl2br($s_phcode); 
                $q_phcode = mysqli_query($con_money, $s_phcode);
                while($r_phcode = mysqli_fetch_array($q_phcode)){
                    echo "<h3>".$r_phcode['pang_hospcode_full']."<BR>";    
                }                
                ?>
            </div>
        </div>
        <?php 
        }
        ?>


        <?php 
        if($r_pang['check_pang_hospcode_notin']!=''){
        ?>
        <div class="card bg-warning">
            <div class="card-body">  
                <h3>รหัส รพ.ที่ละเว้น
                <?php
                $s_phnotincode = "SELECT pang_hospcode_full FROM pang_hospcode_notin WHERE pang_id = '".$r_pang['pang_id']."' LIMIT 200 "; 
                #echo nl2br($s_phcode); 
                $q_phnotincode = mysqli_query($con_money, $s_phnotincode);
                while($r_phnotincode = mysqli_fetch_array($q_phnotincode)){
                    echo "<h3>".$r_phnotincode['pang_hospcode_full']."<BR>";    
                }                
                ?>
            </div>
        </div>
        <?php 
        }
        ?>


        <?php 
        if($r_pang['pang_stm']!=''){
        ?>
        <div class="card bg-light">
            <div class="card-body">  
                <?php
                echo "<h3>การตัด STM : ".$r_pang['show_pang_stm']."<BR>";
                ?>
            </div>
        </div>
        <?php 
        }
        ?>
        
        <div class="card bg-success">
            <div class="card-body">  
                <?php
                $pang_instument = $r_pang['pang_instument'];
                if($pang_instument==''){ $show_pang_instument='ดึงเงินลูกหนี้ทั้งหมด';
                }elseif($pang_instument=='N'){  $show_pang_instument='ไม่สนใจ CR และหักค่า CR ออก';                    
                }elseif($pang_instument=='Y'){  $show_pang_instument='สนใจเฉพาะ CR';                   
                }elseif($pang_instument=='I'){  $show_pang_instument='สนใจเฉพาะ icode ที่เลือก';                    
                }elseif($pang_instument=='NI'){ $show_pang_instument='ไม่สนใจ icode ที่เลือก';                    
                }
                echo "<h3>การดึงค่าใช้จ่าย : ".$show_pang_instument."<BR>";

                if($r_pang['check_pang_icode']!=''){
                    $s_picode = "SELECT pang_icode_full FROM pang_icode WHERE pang_id = '".$r_pang['pang_id']."' LIMIT 200 "; 
                    #echo nl2br($s_picode); 
                    $q_picode = mysqli_query($con_money, $s_picode);
                    while($r_picode = mysqli_fetch_array($q_picode)){
                        echo "<h4>".$r_picode['pang_icode_full']."<BR>";    
                    }
                }
                ?>
            </div>
        </div>

        <?php 
        if($r_pang['check_pang_icd']!=''){
        ?>
        <div class="card bg-light">
            <div class="card-body"> <h3>ICD10</h3> 
                <?php
                $s_icd = "SELECT pang_icd_start, pang_icd_end 
                        FROM pang_icd WHERE pang_id = '".$r_pang['pang_id']."' LIMIT 50 "; 
                #echo nl2br($s_picode); 
                $q_icd = mysqli_query($con_money, $s_icd);
                while($r_icd = mysqli_fetch_array($q_icd)){
                    echo "<h4>".$r_icd['pang_icd_start']." - ".$r_icd['pang_icd_end']."<BR>";    
                }
                ?>
            </div>
        </div>
        <?php 
        }
        ?>

        <?php 
        if($r_pang['check_pang_icd9']!=''){
        ?>
        <div class="card bg-light">
            <div class="card-body"> <h3>ICD9</h3> 
                <?php
                $s_icd9 = "SELECT pang_icd
                        FROM pang_icd9 WHERE pang_id = '".$r_pang['pang_id']."' LIMIT 50 "; 
                #echo nl2br($s_picode); 
                $q_icd9 = mysqli_query($con_money, $s_icd9);
                while($r_icd9 = mysqli_fetch_array($q_icd9)){
                    echo "<h4>".$r_icd9['pang_icd']."<BR>";    
                }
                ?>
            </div>
        </div>
        <?php 
        }
        ?>

    modal_pang_setting_detail
    </div>        
</div>

