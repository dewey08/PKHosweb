<?php

include("../connect/connect.php");
include('../session/session_claim.php');
set_time_limit(0);
// some code

@session_start();
$pang_stamp_edit_user = $_SESSION["UserID"];

?>
<html>
<head>
<title>ThaiCreate.Com Tutorial</title>
</head>
<body>
<?php
#@$date_now=date("Y-m-d");
@$pang_stamp_id=$_POST["pang_stamp_id"]; #pang_stamp_id##ที่จะแก้
@$backto=$_POST["backto"]; #link_redirect
@$edit_type=$_POST["edit_type"];#edit_money_send edit_pttype_send edit_money edit_pttype
@$pt_type=$_POST["pt_type"]; #OPD_or_IPD
@$vn=$_POST["vn"]; #OPD_or_IPD
if($pt_type=='OPD'){
  $from_table_wher=" vn_stat WHERE vn= ";
}elseif($pt_type=='IPD'){
  $from_table_wher=" an_stat WHERE an= ";
}

if($edit_type=="edit_money_send"){
  #ค่าเงินเก่าใน pang_stamp
  $s_old_ucm="SELECT pang_stamp_uc_money FROM pang_stamp WHERE pang_stamp_id='585' ";
  $q_old_ucm = mysqli_query($con_money,$s_old_ucm) or die(mysqli_error($con_money));
  $r_old_ucm = mysqli_fetch_array($q_old_ucm);
  $old_ucmoney = $r_old_ucm["pang_stamp_uc_money"];
  #ค่าเงินเก่าใน pang_stamp

  $s_chk_money = "SELECT income,paid_money,uc_money FROM $from_table_wher '$vn' LIMIT 1 ";
  $q_chk_money = mysqli_query($con_hos,$s_chk_money) or die(mysqli_error($con_hos));
  $r_chk_money = mysqli_fetch_array($q_chk_money);
  $income = $r_chk_money["income"];
  $paid_money = $r_chk_money["paid_money"];
  $uc_money = $r_chk_money["uc_money"];
  $s_update_pstm="UPDATE pang_stamp SET pang_stamp_uc_money = '$uc_money'
                ,pang_stamp_paid_money = '$paid_money' 
                ,pang_stamp_income = '$income'
                , pang_stamp_edit = '$old_ucmoney'
                , pang_stamp_edit_user = '$pang_stamp_edit_user' 
                WHERE pang_stamp_id='$pang_stamp_id'";

}elseif($edit_type=="edit_pttype_send"){
  $s_update_pstm="UPDATE pang_stamp SET 
                pang_stamp_edit = 'sit'
                ,pang_stamp_edit_user = '$pang_stamp_edit_user' 
                WHERE pang_stamp_id='$pang_stamp_id'";
                
}elseif($edit_type=="edit_money"){
  $s_chk_money = "SELECT income,paid_money,uc_money FROM $from_table_wher '$vn' LIMIT 1 ";
  $q_chk_money = mysqli_query($con_hos,$s_chk_money) or die(mysqli_error($con_hos));
  $r_chk_money = mysqli_fetch_array($q_chk_money);
  $income = $r_chk_money["income"];
  $paid_money = $r_chk_money["paid_money"];
  $uc_money = $r_chk_money["uc_money"];
  $s_update_pstm="UPDATE pang_stamp SET pang_stamp_uc_money = '$uc_money'
                  ,pang_stamp_paid_money = '$paid_money'
                  ,pang_stamp_income = '$income'
                  ,pang_stamp_edit_user = '$pang_stamp_edit_user' 
                  ,pang_stamp_stm_money = null
                  WHERE pang_stamp_id='$pang_stamp_id'";
                
}elseif($edit_type=="edit_pttype"){
  $s_update_pstm="DELETE FROM pang_stamp WHERE pang_stamp_id='$pang_stamp_id'";
}


mysqli_query($con_money, $s_update_pstm) or die(mysqli_error($con_money));
  

?>
<script>
//Using setTimeout to execute a function after 5 seconds.
  setTimeout(function () {
  //Redirect with JavaScript
    window.location.href= '<?php echo $backto?>';
  }, 0);
</script>

</body>
</html>