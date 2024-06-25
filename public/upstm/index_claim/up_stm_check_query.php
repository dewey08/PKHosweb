<?php

@session_start();
include("../connect/connect.php");

$y_s = $_SESSION["y_s"];

$s_d_st = " DROP TABLE IF EXISTS stm_temp";
$q_d_st = mysqli_query($con_money, $s_d_st) or die(mysqli_error($con_money));


$s_c_st = "    CREATE TABLE stm_temp
                    SELECT s.stm_id,s.stm_rep,s.stm_claim,s.match_stm, ps.pang_stamp_id, s.stm_file_name FROM stm s 
                    LEFT JOIN pang_stamp ps ON ps.match_hos=s.match_stm
                    WHERE stm_check_pang_stamp_id IS NULL AND stm_check_pang_stamp_id=''
                    AND s.stm_claim <>0
                    AND ps.pang_stamp IN (SELECT pang_id FROM pang WHERE pang_stm='stm' GROUP BY pang_id)
                ";
$q_c_st = mysqli_query($con_money, $s_c_st) or die(mysqli_error($con_money));


$s_u_st =" UPDATE pang_stamp ps
                    INNER JOIN stm_temp st ON ps.match_hos=st.match_stm
                    LEFT JOIN stm s ON st.match_stm=s.match_stm
                    SET ps.pang_stamp_stm_file_name=st.stm_file_name
                    ,ps.pang_stamp_stm_rep=st.stm_rep
                    ,ps.pang_stamp_stm_money=st.stm_claim
                    ,ps.pang_stamp_uc_money_minut_stm_money=(ps.pang_stamp_uc_money-st.stm_claim)
                    ,s.stm_check_pang_stamp_id=st.pang_stamp_id
                    WHERE ps.pang_stamp_stm_file_name IS NULL
                    AND ps.pang_stamp IN (SELECT pang_id FROM pang WHERE pang_stm='stm' AND pang_year='$y_s' GROUP BY pang_id)
                    ";  
$q_u_st = mysqli_query($con_money, $s_u_st) or die(mysqli_error($con_money));


#ส่วนของ CR
$s_d_st_cr = " DROP TABLE IF EXISTS stm_temp_cr";
$q_d_st_cr = mysqli_query($con_money, $s_d_st_cr) or die(mysqli_error($con_money));


$s_c_st_cr = "    CREATE TABLE stm_temp_cr
                    SELECT s.stm_id,s.stm_rep,s.stm_sum_cr,s.match_stm, ps.pang_stamp_id, s.stm_file_name FROM stm s 
                    LEFT JOIN pang_stamp ps ON ps.match_hos=s.match_stm
                    WHERE stm_check_cr_pang_stamp_id IS NULL AND stm_check_cr_pang_stamp_id=''
                    AND s.stm_sum_cr <>0
                    AND ps.pang_stamp IN (SELECT pang_id FROM pang WHERE pang_stm='stm_cr' GROUP BY pang_id)
                ";
$q_c_st_cr = mysqli_query($con_money, $s_c_st_cr) or die(mysqli_error($con_money));


$s_u_st_cr =" UPDATE pang_stamp ps
                    INNER JOIN stm_temp_cr st ON ps.match_hos=st.match_stm
                    LEFT JOIN stm s ON st.match_stm=s.match_stm
                    SET ps.pang_stamp_stm_file_name=st.stm_file_name
                    ,ps.pang_stamp_stm_rep=st.stm_rep
                    ,ps.pang_stamp_stm_money=st.stm_sum_cr
                    ,ps.pang_stamp_uc_money_minut_stm_money=(ps.pang_stamp_uc_money-st.stm_sum_cr)
                    ,s.stm_check_cr_pang_stamp_id=st.pang_stamp_id
                    WHERE ps.pang_stamp_stm_file_name IS NULL
                    AND ps.pang_stamp IN (SELECT pang_id FROM pang WHERE pang_stm='stm_cr' AND pang_year='$y_s' GROUP BY pang_id)
                    ";  
$q_u_st_cr = mysqli_query($con_money, $s_u_st_cr) or die(mysqli_error($con_money));
      
?>