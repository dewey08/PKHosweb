<?php

include("../connect/connect.php");
set_time_limit(0);
// some code

@session_start();
$pang_stamp_user_stamp = $_SESSION["UserID_BN"];

?>
<html>

    <head>
        <title></title>
    </head>

    <body>
    <?php
    @$date_now=date("Y-m-d");
    @$pang=$_POST["pang"];
    @$backto=$_POST["backto"];
    @$pang_type=$_POST["pang_type"];

    #y_s#######################################
    if( isset($_SESSION["y_s"]) ){
        $y_s= $_SESSION["y_s"];
    }else{
        $y_s = date("Y");
    } 
    #y_s#######################################



    #m_s#######################################
    if( isset($_REQUEST["m_s"]) ){
        $m_s= $_SESSION["m_s"] = $_REQUEST['m_s'];
    }elseif( isset($_SESSION["m_s"]) ){
        $m_s= $_SESSION["m_s"];
    }else{
        $m_s = date("m")+0;
    } 
    #m_s#######################################

    //echo "จำนวนที่ Stamp ".count($_POST["vn"]);
    for($i=0;$i<count($_POST["vn"]);$i++){ #loop จำนวน VN ที่ส่งมา
      

        if(trim($_POST["vn"][$i]) != ""){
            $vn=$_POST["vn"][$i];

            @$vn_con_uc_money=$_POST['vn'][$i]; // รับค่า

            #ตรวจสอบว่าเป็นคนไข้ในหรือนอก 
            if($pang_type=='OPD'){
                $vn=substr($vn_con_uc_money,0,12); // ตัดเอา VN 12 หลัก
                $uc_money_kortok=substr($vn_con_uc_money,12); // ตัดเอา uc_money
                $s_date = "o.vstdate";
                $s_dateo = "vstdate";
                $s_vn_or_an = 'o.vn';
                $s_vn_o_an_stat = 'vn_stat';
                $s_select_an =',o.vstdate, null AS an, null AS dchdate ';
                $s_match_hos = 'match_hos';
                $vn_o_an = 'vn';
                $ovst_o_ipt = 'ovst';
                $ovstdiag_o_iptdiag = 'ovstdiag';
                $make_match_hos = " ,CONCAT(o.hn,DATE_FORMAT(o.vstdate, '%d%m%Y'),DATE_FORMAT(o.vsttime, '%H%i00'))match_hos ";
            }elseif($pang_type=='IPD'){
                $vn=substr($vn_con_uc_money,0,9); // ตัดเอา AN 9 หลัก
                $uc_money_kortok=substr($vn_con_uc_money,9); // ตัดเอา uc_money
                $s_date = "v.dchdate";
                $s_dateo = "dchdate";
                $s_vn_or_an = 'v.an';
                $s_vn_o_an_stat = 'an_stat';
                $s_select_an =', null AS vstdate , v.an, v.regdate, v.dchdate';
                $s_match_hos = 'an';
                $vn_o_an = 'an';
                $ovst_o_ipt = 'ipt';
                $ovstdiag_o_iptdiag = 'iptdiag';
                $make_match_hos = " , null AS match_hos ";
            }else{
            }
            #ตรวจสอบว่าเป็นคนไข้ในหรือนอก 

            
            $explode_uc_money_kortok = explode("|", $uc_money_kortok);
            
            $uc_money=$explode_uc_money_kortok[0]; // ตัดเอา uc_money
            
            $pang_stamp_uc_money_kor_tok=$explode_uc_money_kortok[1]; // เงินตามข้อตกลง

            $pang_stamp_rw=$explode_uc_money_kortok[2]; // rw
            
            //$vn=$_POST["vn"][$i];

            //"vn $i = ".$_POST["vn"][$i]."<br>";
            $sql_vn="SELECT  
                      o.vn,o.hn $s_select_an
                      ,p.cid ,p.pname, p.fname, p.lname
                      ,o.pttype 
                      ,cs.check_sit_subinscl, cs.check_sit_startdate
                      ,GROUP_CONCAT(DISTINCT od.icd10 ORDER BY od.diagtype)icd
                      ,ROUND(v.income,2)AS 'income',ROUND(v.paid_money,2) AS 'paid_money' ,ROUND(v.uc_money,2) AS 'uc_money'
                      $make_match_hos
                      FROM $ovst_o_ipt o
                      LEFT OUTER JOIN patient p ON o.hn=p.hn
                      LEFT OUTER JOIN $database_ii.check_sit cs ON o.vn=cs.check_sit_vn 
                      LEFT OUTER JOIN $ovstdiag_o_iptdiag od ON o.$vn_o_an=od.$vn_o_an
                      LEFT OUTER JOIN $s_vn_o_an_stat v ON o.$vn_o_an=v.$vn_o_an
                      WHERE $s_vn_or_an='$vn'
                      GROUP BY o.$vn_o_an
                      LIMIT 10";
            $result_vn = mysqli_query($con_hos, $sql_vn) or die(mysqli_error($con_hos));
            $row_vn = mysqli_fetch_array($result_vn);

            #กรณีเป็นผัง 302 และ rw>=2 จะเขียน 2 reccord โดย 302.uc_money =0 แต่ 310.uc_money คือตามจริงทั้งหมด
            if($pang=='1102050101.302' && $pang_stamp_rw>=2){
                $stamp_rw="INSERT INTO pang_stamp
                                (pang_stamp_vn          ,pang_stamp_vstdate         ,pang_stamp           ,pang_stamp_hn
                                ,pang_stamp_dchdate         ,pang_stamp_an

                                ,pang_stamp_pname, pang_stamp_fname, pang_stamp_lname

                                ,pang_stamp_uc_money  ,pang_stamp_rw       ,pang_stamp_user_stamp         ,pang_year)
                              VALUES 
                                ('".$row_vn["vn"]."'    ,'".$row_vn["$s_dateo"]."'  ,'$pang'              ,'".$row_vn["hn"]."'
                                ,'".$row_vn["dchdate"]."'   ,'".$row_vn["an"]."'

                                ,'".$row_vn["pname"]."','".$row_vn["fname"]."','".$row_vn["lname"]."'

                                ,'0'      ,'$pang_stamp_rw'    ,'".$pang_stamp_user_stamp."'  ,'".$y_s."'
                                );
                                  ";
                $q_stamp_rw = mysqli_query($con_money, $stamp_rw) or die(mysqli_error($con_money));  
                
                $pang_insert='1102050101.310'; #นำค่า pang นี้ ไปบันทึกค่าใช้จ่ายจริงลงผังนี้แทน
                $do_not_count = 'y'; #ถ้ามีการทำงานส่วนนี้ ไม่ต้องเพิ่มจำนวนนับ รายการที่ stampแล้ว
            }else{
                $pang_insert=$pang;
                $do_not_count = 'n';
            }
            #กรณีเป็นผัง 302 และ rw>=2 จะเขียน 2 reccord โดย 302.uc_money =0 แต่ 310.uc_money คือตามจริงทั้งหมด
            
            #ดักกรณีที่มีการ stamp ไปแล้ว กันกรณี record ซ้ำ
            $s_check_stamp="SELECT pang_stamp_id
                        FROM pang_stamp
                        WHERE pang_stamp = '$pang_insert'
                        AND pang_stamp_vn = '".$row_vn["vn"]."'
                        LIMIT 1";
            $q_check_stamp = mysqli_query($con_money, $s_check_stamp) or die(nl2br($s_check_stamp));
            $r_check_stamp = mysqli_fetch_array($q_check_stamp);
            @$check_pang_stamp_id = $r_check_stamp['pang_stamp_id'];
            #ดักกรณีที่มีการ stamp ไปแล้ว กันกรณี record ซ้ำ

            if($check_pang_stamp_id==''){

            $stamp_insert="INSERT INTO pang_stamp
                                (pang_stamp_vn          ,pang_stamp_vstdate         ,pang_stamp           ,pang_stamp_hn
                                ,pang_stamp_dchdate         ,pang_stamp_an

                                ,pang_stamp_pname, pang_stamp_fname, pang_stamp_lname

                                ,pang_stamp_nhso                      ,pang_stamp_nhso_startdate  
                                ,pang_stamp_income        ,pang_stamp_paid_money        ,pang_stamp_uc_money  ,pang_stamp_uc_money_kor_tok
                                ,pang_stamp_icd         ,pang_stamp_rw       ,match_hos                    ,pang_stamp_user_stamp          
                                ,pang_year)
                              VALUES 
                                ('".$row_vn["vn"]."'    ,'".$row_vn["$s_dateo"]."'  ,'$pang_insert'              ,'".$row_vn["hn"]."'
                                ,'".$row_vn["dchdate"]."'   ,'".$row_vn["an"]."'

                                ,'".$row_vn["pname"]."','".$row_vn["fname"]."','".$row_vn["lname"]."'

                                ,'".$row_vn["check_sit_subinscl"]."'  ,'".$row_vn["check_sit_startdate"]."'
                                ,'".$row_vn["income"]."'  ,'".$row_vn["paid_money"]."'  ,'".$uc_money."'      ,'".$pang_stamp_uc_money_kor_tok."'
                                ,'".$row_vn["icd"]."'   ,'$pang_stamp_rw'           ,'".$row_vn["$s_match_hos"]."'   ,'".$pang_stamp_user_stamp."'
                                ,'".$y_s."'
                                );
                                  ";
            $q_stamp_insert = mysqli_query($con_money, $stamp_insert) or die(mysqli_error($con_money));
            }

            #เมื่อนำเข้าแล้ว ให้ไปลบใน pang_stamp_temp                      
            if(@$q_stamp_insert){
                $s_del_pst="DELETE FROM pang_stamp_temp WHERE pang_stamp='$pang' AND $vn_o_an='$vn' ";
                $q_del_pst = mysqli_query($con_money, $s_del_pst) or die(mysqli_error($con_money));
            }
            #เมื่อนำเข้าแล้ว ให้ไปลบใน pang_stamp_temp 


            #update ยอดใน pang_stamp_month_temp
            if(@$q_stamp_insert){
                #select ค่าเก่ามาก่อน แล้วบวก/ลบ ยอดเดิม
                $s_select_psmt="SELECT no_stamp, stamp, pang_stamp_month_id FROM pang_stamp_month_temp 
                                WHERE pang_stamp = '$pang' AND year_check = '$y_s' AND mon = '$m_s' LIMIT 1 ";
                $q_select_psmt = mysqli_query($con_money, $s_select_psmt) or die(mysqli_error($con_money));
                $r_select_psmt = mysqli_fetch_array($q_select_psmt);
                $no_stamp = ($r_select_psmt["no_stamp"])-(1);
                
                if($do_not_count=='y'){$num_count=0;}else{$num_count=1;}
                $stamp = ($r_select_psmt["stamp"])+($num_count);

                $pang_stamp_month_id = $r_select_psmt["pang_stamp_month_id"];
                #select ค่าเก่ามาก่อน แล้วบวก/ลบ ยอดเดิม
                if($no_stamp!=''){#กรณีเป็นค่าว่าง แสดงว่ายังไม่ได้เข้าหน้า pang_stamp_month ซึ่งยังไม่มีค่า ก็ไม่ต้อง Update
                    $u_psmt="UPDATE pang_stamp_month_temp SET no_stamp='$no_stamp', stamp='$stamp' WHERE pang_stamp_month_id='$pang_stamp_month_id' ";
                    $q_psmt = mysqli_query($con_money, $u_psmt);
                }else{ #กรณีค่าเหลือ 1 จะเข้าเงื่อนไขนี้ เพื่อปรับให้ ืno_stamp=0
                    $u_psmt="UPDATE pang_stamp_month_temp SET no_stamp='0', stamp='$stamp' WHERE pang_stamp_month_id='$pang_stamp_month_id' ";
                    $q_psmt = mysqli_query($con_money, $u_psmt);
                }
            }  
            #update ยอดใน pang_stamp_month_temp


        }#if
    }


    echo "<h1>จำนวนที่ Stamp ".$i." </h1>";
    ?>

        <script>
            //Using setTimeout to execute a function after 5 seconds.
            setTimeout(function () {
                //Redirect with JavaScript
                window.location.href= '<?php echo $backto?>';
            }, 2000);
        </script>

    </body>
</html>