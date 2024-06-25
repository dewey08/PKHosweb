<?php

include("../connect/connect.php");
@include('../session/session.php');

set_time_limit(0);
// some code

@session_start();

@$pang=$_GET['pang'];
#$m_s=$_GET["m_s"];

#เงื่อนไขผัง
if(isset($_GET["pang"])){
    $pang = $_SESSION["pang"] = $_GET["pang"];
}else{
    $pang = $_SESSION["pang"];
}


?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <!--modal-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables_themeroller.css">
    <link rel="stylesheet" type="text/css"
        href="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8"
        src="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
    <link href="https://cdn.datatables.net/select/1.1.2/css/select.dataTables.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/input_datatable.css" />
    <!-- css สำหรับเปลี่ยน search ให้เห็นกรอบ -->


</head>

<body>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2>สรุปส่งลูกหนี้</h2>
                    <?php 
                    

                    #เช็คยอดที่เคยส่งล่าสุด
                    $s_c_lastest = "SELECT pang_stamp_send
                                    ,MAX(pang_stamp_latest_date_send) AS max_check_pang_stamp_latest_date_send
                                    ,DATE_ADD(MAX(pang_stamp_latest_date_send),INTERVAL 1 DAY) AS max_pang_stamp_latest_date_send_intday
                                    FROM pang_stamp_send WHERE pang_stamp_send_year = '$y_s' ";
                    $q_c_lastest = mysqli_query($con_money, $s_c_lastest) or die(nl2br($s_c_lastest));
                    $r_c_lastest = mysqli_fetch_array($q_c_lastest);
                    if($r_c_lastest['pang_stamp_send']==''){ #กรณีเป็นครั้งแรกที่เริ่มส่ง
                        $s_check_min_vstdate = "SELECT MIN(pang_stamp_vstdate) AS min_pang_stamp_vstdate
                                                ,MIN(pang_stamp_vstdate) AS pang_stamp_latest_date_send_intday
                                                FROM pang_stamp WHERE pang_year = '$y_s' ";
                        $q_check_min_vstdate = mysqli_query($con_money, $s_check_min_vstdate) or die(nl2br($s_check_min_vstdate));
                        $r_check_min_vstdate = mysqli_fetch_array($q_check_min_vstdate);
                        $max_pang_stamp_latest_date_send = $r_check_min_vstdate["min_pang_stamp_vstdate"];
                        $pang_stamp_latest_date_send_intday = $r_check_min_vstdate['pang_stamp_latest_date_send_intday'];
                        #กรณีครั้งแรกจะไม่บวก
                    }elseif($r_c_lastest['pang_stamp_send']!='' && $r_c_lastest['max_check_pang_stamp_latest_date_send']==''){
                        $s_check_min_vstdate = "SELECT MAX(pang_stamp_vstdate) AS max_pang_stamp_vstdate
                                                ,DATE_ADD(MAX(pang_stamp_vstdate),INTERVAL 1 DAY) AS pang_stamp_latest_date_send_intday
                                                FROM pang_stamp WHERE pang_year = '$y_s' AND pang_stamp_send <>'' ";
                        $q_check_min_vstdate = mysqli_query($con_money, $s_check_min_vstdate) or die(nl2br($s_check_min_vstdate));
                        $r_check_min_vstdate = mysqli_fetch_array($q_check_min_vstdate);
                        $max_pang_stamp_latest_date_send = $r_check_min_vstdate["max_pang_stamp_vstdate"];
                        $pang_stamp_latest_date_send_intday = $r_check_min_vstdate['pang_stamp_latest_date_send_intday'];
                    }else{
                        $max_pang_stamp_latest_date_send = $r_c_lastest["max_check_pang_stamp_latest_date_send"];
                        $pang_stamp_latest_date_send_intday = $r_c_lastest['max_pang_stamp_latest_date_send_intday'];
                    }
                    #กรณีเป็นการส่งครั้งแรก จะยังไม่มีค่าล่าสุด จะใช้วันที่เริ่มปีงบก่อน
                    // if($r_c_latest['max_pang_stamp_latest_date_send']!=''){
                    //     $max_pang_stamp_latest_date_send = $r_c_latest['max_pang_stamp_latest_date_send'];
                    // }else{
                    //     $max_pang_stamp_latest_date_send = $start_year_ngob=($y_s-1)."-10-01";
                    // }
                    #กรณีเป็นการส่งครั้งแรก จะยังไม่มีค่าล่าสุด จะใช้วันที่เริ่มปีงบก่อน

                    // $s_c_latest = "SELECT MAX(pang_stamp_latest_date_send) AS max_pang_stamp_latest_date_send 
                    //                 ,DATE_ADD(MAX(pang_stamp_latest_date_send),INTERVAL 1 DAY) AS pang_stamp_latest_date_send_intday
                    //                 FROM pang_stamp_send WHERE pang_stamp_send_year = '$y_s' ";
                    // $q_c_latest = mysqli_query($con_money, $s_c_latest) or die(nl2br($s_c_latest));
                    // $r_c_latest = mysqli_fetch_array($q_c_latest);
                    
                    // $pang_stamp_latest_date_send_intday = $r_c_latest['pang_stamp_latest_date_send_intday'];
                    #เช็คยอดที่เคยส่งล่าสุด
                    #echo DateThaisubmonth($max_pang_stamp_latest_date_send);
                    ?>
                    <h3 style="color:red">วันที่สรุปส่งการเงินล่าสุด <?= DateThaisubmonth($max_pang_stamp_latest_date_send)?> </h3>
                    <div>

                        <div class="row">
                            <?php
                            #ตรวจสอบว่าเป็ฯการส่งครั้งแรก หรือการแก้ไขฝบสรุปส่ง
                            if(isset($_REQUEST['pang_stamp_send'])){
                            }else{                            
                            ?>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <form method="post" action="<?php echo $backto;?>">
                                    สรุปส่งลูกหนี้ จนถึง

                                    <input class="" type="text" name="date_sir_f" id="date_sir_f"
                                        value="<?php echo $date_sir_f?>" onkeydown="return false" autocomplete="off"
                                        required="yes">

                                    <input type="submit" name="" value="Preview" class="btn btn-primary">
                                </form>
                            </div>

                            <?php
                            }
                            #ตรวจสอบว่าเป็ฯการส่งครั้งแรก หรือการแก้ไขใบสรุปส่ง
                            if(isset($_REQUEST['pang_stamp_send'])){
                              $pang_stamp_send = $_REQUEST['pang_stamp_send'];
                              $where_s ="WHERE ps.pang_stamp_send = '$pang_stamp_send' AND p.pang_year='$y_s' ";
                              $show_button = 'แก้ไขใบสรุปส่ง';
                              $show_button_color ='btn-warning';
                              @$sql_pang_sub=" SELECT
                                if(ps.pang_stamp_send_status='a'
                                \t   ,CONCAT(p.pang_id,'a',(DATE_FORMAT(ps.pang_stamp_vstdate,'%m') ) )
                                \t    ,p.pang_id
                                )AS con_pang_id
                                ,if(ps.pang_stamp_send_status='a'
                                \t    ,'a'
                                \t    ,''
                                ) AS pang_stamp_status_send
                                ,p.pang_fullname, p.pang_id
                                ,(COUNT(DISTINCT ps.pang_stamp_vn)) AS total_visit

                                ,'' AS visit_no_stamp

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
                                AND ps.pang_year='$y_s'
                                GROUP BY p.pang_id, ps.pang_stamp_send_status 
                                ORDER BY pang_stamp_status_send ASC
                                ";
                            }else{
                                
                                
                                if($pang_stamp_latest_date_send_intday!=''){
                                    @$where_s ="WHERE p.pang_year = '$y_s' AND ps.pang_stamp_vstdate between '$pang_stamp_latest_date_send_intday' AND '$date_sir_f' 
                                    AND (ps.pang_stamp_send IS NULL OR ps.pang_stamp_send ='' ) ";
                                    @$where_s_union ="WHERE p.pang_year = '$y_s' AND ps.pang_stamp_vstdate < '$pang_stamp_latest_date_send_intday' AND (ps.pang_stamp_send IS NULL OR ps.pang_stamp_send ='' ) ";         
                                }else{
                                    @$where_s ="WHERE p.pang_year = '$y_s' AND ps.pang_stamp_vstdate <= '$date_sir_f' 
                                    AND (ps.pang_stamp_send IS NULL OR ps.pang_stamp_send ='' ) "; 
                                    @$where_s_union ="WHERE p.pang_year = '$y_s' AND ps.pang_stamp_vstdate < '$pang_stamp_latest_date_send_intday' AND (ps.pang_stamp_send IS NULL OR ps.pang_stamp_send ='' ) ";
                                }                                
                                $show_button = 'ส่งการเงิน';
                                $show_button_color ='btn-primary';
                                @$sql_pang_sub=" SELECT
                                p.pang_id AS con_pang_id
                                ,'' AS pang_stamp_status_send
                                ,p.pang_fullname, p.pang_id
                                ,(COUNT(DISTINCT ps.pang_stamp_vn)) AS total_visit

                                ,(SELECT visit_no_stamp FROM temp_count_visit_no_stamp
                                WHERE pang_stamp=ps.pang_stamp AND year_check ='$y_s') AS visit_no_stamp

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
                                AND ps.pang_year='$y_s'
                                GROUP BY p.pang_id 

                                UNION

                                SELECT 
                                CONCAT(p.pang_id,'a',(DATE_FORMAT(ps.pang_stamp_vstdate,'%m') ) ) AS con_pang_id
                                ,'a' AS pang_stamp_status_send
                                ,p.pang_fullname, p.pang_id
                                ,(COUNT(DISTINCT ps.pang_stamp_vn)) AS total_visit

                                ,'' AS visit_no_stamp

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
                                $where_s_union
                                AND ps.pang_stamp_uc_money <>0 #ดักกรณี ประกันสังคม rw>=2 จะมี 2 reccord ผัง 302.uc=0,310.uc>0
                                AND ps.pang_year='$y_s'
                                GROUP BY p.pang_id, DATE_FORMAT(ps.pang_stamp_vstdate,'%m')
            
                                LIMIT 100";
                            }
                            #ตรวจสอบว่าเป็ฯการส่งครั้งแรก หรือการแก้ไขใบสรุปส่ง

                            #สร้าง_temp_สำหรับนับจำนวน_visit_ที่ยังไม่ได้ทำการ_stamp_จะสร้างเมื่อมีการเลือกช่วงวันที่มาก่อน
                            $s_drop_t_tcvns = "DROP TABLE IF EXISTS temp_count_visit_no_stamp ";
                            $s_create_tcvns = "CREATE TABLE temp_count_visit_no_stamp
                                                SELECT pang_stamp,COUNT(pang_stamp_id) AS visit_no_stamp ,year_check
                                                FROM pang_stamp_temp 
                                                WHERE vstdate < '$date_sir_f' AND year_check = '$y_s'
                                                GROUP BY pang_stamp";
                            if($date_sir_f!=''){                                
                                $q_drop_t_tcvns = mysqli_query($con_money, $s_drop_t_tcvns) or die(nl2br($s_drop_t_tcvns));
                                if($q_drop_t_tcvns){                                         
                                    $q_create_tpsi = mysqli_query($con_money, $s_create_tcvns) or die(nl2br($s_create_tcvns));
                                }
                            }
                            #สร้าง_temp_สำหรับนับจำนวน_visit_ที่ยังไม่ได้ทำการ_stamp_จะสร้างเมื่อมีการเลือกช่วงวันที่มาก่อน

                            
                            #AND ps.pang_stamp_edit_olddata !='sit' AND (ps.pang_stamp_edit !='sit' OR ps.pang_stamp_edit IS NULL)

                            if($date_sir_f!='' || isset($_REQUEST['pang_stamp_send'])){
                                $result_pang_sub = mysqli_query($con_money, $sql_pang_sub) or die(mysqli_error($con_money));
                            }

                            #หาช่วงข้อมูล pang_stamp_vstdate ที่เลือก และสรุปว่าจะเป็นการส่งการเงินในงวดเดือนที่เท่าไหร่
                            @$s_min_max_vstdate=" SELECT MAX(ps.pang_stamp_vstdate) AS max_pang_stamp_vstdate
                              ,MIN(ps.pang_stamp_vstdate) AS min_pang_stamp_vstdate
                              ,DATE_FORMAT(MAX(ps.pang_stamp_vstdate),'%m') AS month_send
                              FROM pang p 
                              LEFT OUTER JOIN pang_stamp ps ON p.pang_id=ps.pang_stamp
                              $where_s
                              AND ps.pang_year='$y_s'
                              AND ps.pang_stamp_uc_money <>0 
                              LIMIT 100";
                              #AND ps.pang_stamp_edit_olddata !='sit' AND (ps.pang_stamp_edit !='sit' OR ps.pang_stamp_edit IS NULL)
                            $q_min_max_vstdate = mysqli_query($con_money, $s_min_max_vstdate) or die(mysqli_error($con_money));
                            $r_min_max_vstdate = mysqli_fetch_array($q_min_max_vstdate);
                            $max_pang_stamp_vstdate = $r_min_max_vstdate["max_pang_stamp_vstdate"];
                            $min_pang_stamp_vstdate = $r_min_max_vstdate["min_pang_stamp_vstdate"];
                            $month_send = $r_min_max_vstdate["month_send"];
                            #หาช่วงข้อมูล pang_stamp_vstdate ที่เลือก และสรุปว่าจะเป็นการส่งการเงินในงวดเดือนที่เท่าไหร่
                            
                            ?>

                            <!-- Modal sql -->
                            <div class="col-sm-12 col-md-12 col-lg-2">
                                <button class="btn btn-primary" data-toggle="modal"
                                    data-target=".bd-example-modal-lg">SQL</button>
                            </div>
                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modal SQL</h5>
                                            <button type="button" class="close"
                                                data-dismiss="modal"><span>&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body"><?= "index_claim_stamp"?></div>
                                        
                                        <div class="modal-body"><?= "<HR>"?></div>
                                        <div class="modal-body"><?php echo nl2br (tab2nbsp($s_drop_t_tcvns));?></div>
                                        <div class="modal-body"><?php echo nl2br (tab2nbsp($s_create_tcvns));?></div>
                                        <div class="modal-body"><?= "<HR>"?></div>

                                        <div class="modal-body"><?php echo nl2br (tab2nbsp($sql_pang_sub));?></div>
                                        <div class="modal-body"><?= "<HR>"?></div>
                                        <div class="modal-body"><?= "หาค่าช่วงวันที่ vstdate และงวดที่ส่ง"?></div>
                                        <div class="modal-body"><?php echo nl2br (tab2nbsp($s_min_max_vstdate));?></div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal sql -->
                            <form method="post" action="index_claim_stamp_update_send.php">
                                <?php 
                                if($max_pang_stamp_vstdate!=''){
                                ?>
                                <div class="col-sm-12 col-md-12 col-lg-2">
                                    <button type="submit" class="btn <?php echo $show_button_color;?>"
                                        onclick="return confirm('ยืนยันการส่งลูกหนี้ให้การเงิน ?')"><?php echo $show_button;?></button>
                                </div>
                                <?php 
                                }
                                ?>
                                <input type="hidden" name="backto" value="<?php echo $backto?>">
                                <input type="hidden" name="dateuntil" value="<?php echo $date_sir_f?>">
                                <input type="hidden" name="max_pang_stamp_latest_date_send" value="<?php echo $max_pang_stamp_latest_date_send?>">
                                



                        </div>
                        <BR>
                        <?php
                            if($date_sir_f!=''){
                                #$pang_stamp_latest_date_send_intday
                                #date_sir_f
                                if($max_pang_stamp_vstdate==''){
                                    $show_text_vstdate = "ไม่พบข้อมูลการ Stamp ในรอบส่งปกติ";
                                    ?>
                                    <input type="hidden" name="do_not_insert" value="y"><!-- ถ้าส่งค่านี้ไปแสดงว่าไม่มีข้อมูล stamp ในรอบส่งปกติ ถึงจะมีข้อมูล stamp ย้อนหลัง ก็ห้าม insert -->
                                    <?php
                                }elseif($pang_stamp_latest_date_send_intday!=''){
                                    $show_text_vstdate = "ช่วงข้อมูลวันที่รับบริการ ". DateThaisubmonth($pang_stamp_latest_date_send_intday)." ถึง ".DateThaisubmonth($max_pang_stamp_vstdate);
                                }else{
                                    $show_text_vstdate = "ช่วงข้อมูลวันที่รับบริการต้นปีงบ จนถึง ".DateThaisubmonth($max_pang_stamp_vstdate);
                                }
                            }
                            ?>
                        <h4 style="color:red"><?= @$show_text_vstdate?></h4>
                        
                        <table class="table table-bordered table-striped table-hover table-responsive">
                            
                            <tbody>

                                <?php
                                $no=0;
                                while(@$row_show = mysqli_fetch_array($result_pang_sub)){
                                @$pang_stamp_edit = $row_show['pang_stamp_edit'];
                                @$gc_pang_stamp_edit_olddata = $row_show['gc_pang_stamp_edit_olddata'];
                                @$pang_stamp_status_send = $row_show['pang_stamp_status_send'];
                                @$min_pang_stamp_vstdate = $row_show['min_pang_stamp_vstdate'];
                                @$max_pang_stamp_vstdate = $row_show['max_pang_stamp_vstdate'];
                                
                                $array_sum_visit_no_stamp[] = $row_show["visit_no_stamp"];
                                $array_sum_total_visit[] = $row_show["total_visit"];
                                $array_sum_sum_uc_money[] = $row_show["sum_uc_money"];  
                                

                                $no++;

                                ?>
                                <tr>

                                    <!-- No -->
                                    <td>
                                        <?= $no;?>
                                    </td>
                                    <!-- No -->

                                    <!-- ผัง -->
                                    <td class="text-nowrap"><?php
                                          if($row_show["pang_stamp_edit"]!=''){
                                            echo "<font color='red'>แก้ไข </font> ".$row_show["pang_fullname"];
                                          }else{
                                            echo $row_show["pang_fullname"].$row_show["pang_stamp_edit_olddata"];
                                          }
                                        ?>

                                        <input type=hidden value='<?php echo $row_show["con_pang_id"] ?>'
                                            name='pang_stamp_send_pang[]'>

                                                
                                        <input type=hidden value='<?= @$date_sir_f ?>'
                                            name='pang_stamp_latest_date_send'>
                                        <input type=hidden value='<?= @$month_send ?>'
                                            name='month_send'>
                                        <input type=hidden value='<?php echo @$pang_stamp_send ?>'
                                            name='pang_stamp_send'>
                                        <input type=hidden value='<?php echo @$pang_stamp_edit ?>'
                                            name='pang_stamp_edit_pang[]'>
                                        <input type=hidden value='<?php echo @$gc_pang_stamp_edit_olddata ?>'
                                            name='pang_stamp_edit_olddata[]'>
                                        <input type=hidden value='<?php echo @$pang_stamp_status_send ?>'
                                            name='pang_stamp_status_send[]'>  

                                        <input type=hidden value='<?php echo @$min_pang_stamp_vstdate ?>'
                                            name='min_pang_stamp_vstdate[]'> 
                                        <input type=hidden value='<?php echo @$max_pang_stamp_vstdate ?>'
                                            name='max_pang_stamp_vstdate[]'> 
                                            
                                            
                                            
                                    </td>
                                    <!-- ผัง -->

                                    <!-- ยังไม่_stamp -->
                                    <td align="right" style="color:red">
                                        <?= @number_format($row_show["visit_no_stamp"]) ?>
                                    </td>
                                    <!-- ยังไม่_stamp -->

                                    <!-- จำนวน -->
                                    <td align="right"><input type=hidden value='<?php echo $row_show["total_visit"] ?>'
                                            name='pang_stamp_send_visit[]'>
                                        <?= number_format($row_show["total_visit"]) ?>
                                    </td>
                                    <!-- จำนวน -->

                                    <!-- ลูกหนี้ทั้งหมด -->
                                    <td align="right"><input type=hidden value='<?php echo $row_show["sum_uc_money"] ?>'
                                            name='pang_stamp_send_money[]'>
                                        <?= number_format($row_show["sum_uc_money"],2) ?>
                                    </td>
                                    <!-- ลูกหนี้ทั้งหมด -->

                                    <!-- เบิกตามข้อตกลง -->
                                    <td align="right">
                                        <?php
                                        if(isset($row_show["pang_kor_tok"])){
                                          $show_input ='hidden';
                                          $show_kor_tok = number_format($row_show["sum_pang_kor_tok"],2);
                                        }else{
                                          $show_input ='hidden';
                                          $show_kor_tok = null;
                                        }
                                        ?>
                                        <input type="<?= $show_input?>" style='width:100%;text-align: right;'
                                            value='<?php echo $row_show["sum_pang_kor_tok"] ?>'
                                            name='pang_stamp_send_money_kor_tok[]' readonly>
                                        <?= $show_kor_tok ?>
                                    </td>
                                    <!-- เบิกตามข้อตกลง -->

                                    <!-- ผู้รับผิดชอบ -->
                                    <td class="text-nowrap">
                                        <input type=hidden style='width:100%'
                                            value='<?php echo $row_show["doctor_respond"] ?>'
                                            name='pang_stamp_send_responsible[]' readonly>
                                        <?= $row_show["doctor_respond"] ?>
                                    </td>
                                    <!-- ผู้รับผิดชอบ -->

                                    <!-- รายละเอียดการแก้ไข -->
                                    <td>
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
                                    </td>
                                    <!-- รายละเอียดการแก้ไข -->

                                    <!-- ส่งลูกหนี้เพิ่มเติม -->
                                    <td>
                                        <?php
                                        if($row_show["pang_stamp_status_send"]=='a'){
                                        ?>
                                        <font color='red'><?= DateThaisubmonth($row_show["min_pang_stamp_vstdate"]).' ถึง '.DateThaisubmonth($row_show["max_pang_stamp_vstdate"])?></font>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <!-- ส่งลูกหนี้เพิ่มเติม -->





                                </tr>
                                <?php
                                }

                                ?>


                            </tbody>

                            <thead>
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2" class="text-nowrap">
                                        <div align="center">ผัง</div>
                                    </th>
                                    <th class="text-nowrap">
                                        <div align="center">ยังไม่ stamp</div>
                                    </th>
                                    <th class="text-nowrap">
                                        <div align="center">จำนวน</div>
                                    </th>
                                    <th class="text-nowrap">
                                        <div align="center">ลูกหนี้ทั้งหมด</div>
                                    </th>
                                    <th class="text-nowrap">
                                        <div align="center">เบิกตามข้อตกลง</div>
                                    </th>
                                    <th rowspan="2" class="text-nowrap">
                                        <div align="center">ผู้รับผิดชอบ</div>
                                    </th>
                                    <th rowspan="2" class="text-nowrap">
                                        <div align="center">รายละเอียดการแก้ไข</div>
                                    </th>
                                    <th rowspan="2" class="text-nowrap">
                                        <div align="center">ส่งลูกหนี้เพิ่มเติม</div>
                                    </th>
                                </tr>

                                <tr>
                                    <th>
                                        <div align="right">
                                            <?= @number_format(array_sum($array_sum_visit_no_stamp)) ?>
                                        </div>
                                    </th>
                                    <th>
                                        <div align="right">
                                            <?= @number_format(array_sum($array_sum_total_visit)) ?>
                                        </div>
                                    </th>
                                    <th class="text-nowrap">
                                        <div align="right">
                                            <?= @number_format(array_sum($array_sum_sum_uc_money), 2) ?>
                                        </div>
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>

                        </table>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>




    <script type="text/javascript">
    $(document).ready(function() {

        /** Responsive table with colreorder, fixed header;footer, sortable teble*/
        var table = $('#example').DataTable({
            dom: '<"top"lipf<"clear">> rt <"bottom"ip<"clear">>',
            "pageLength": 100,
            "lengthMenu": [10, 100],
            "scrollX": true,
            responsive: {
                details: {
                    type: 'column'
                }
            },
            order: [1, 'asc'],
            colReorder: {
                fixedColumnsLeft: 1,
                fixedColumnsLeft: 2
            },
            fixedHeader: {
                header: true,
                footer: true
            },
            'columnDefs': [{
                'targets': 0,
                'searchable': false,
                'orderable': false,
                'width': '1%',
                'className': 'dt-body-center'
            }, {
                'className': 'control',
                'orderable': false,
                targets: 0
            }, {
                'className': 'dt-body-right',
                targets: 2
            }, {
                'className': 'dt-body-right',
                targets: 3
            }, {
                'className': 'dt-body-right',
                targets: 4
            }],
            'order': [
                [1, 'asc']
            ],

        });

        /** mark single checkboxes */

        table.on('order.dt search.dt', function() {
            let i = 1;

            table.cells(null, 0, {
                search: 'applied',
                order: 'applied'
            }).every(function(cell) {
                this.data(i++);
            });
        }).draw();


    });
    </script>










</body>

</html>