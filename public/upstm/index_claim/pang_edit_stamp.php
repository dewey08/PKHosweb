<?php

include("../connect/connect.php");
include('../session/session_claim.php');
set_time_limit(0);
// some code

@session_start();
$pang_stamp_edit_user = $_SESSION["UserID_BN"];
$date_now=date("Y-m-d");
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

@$pang_id_full=$_POST['pang_id'];
@$pang_id_pieces = explode(" ", $pang_id_full);
@$pang_id = $pang_id_pieces[0]; 

if($pt_type=='OPD'){
  $from_table_wher=" vn_stat WHERE vn= ";
}elseif($pt_type=='IPD'){
  $from_table_wher=" an_stat WHERE an= ";
}

if($edit_type=="edit_money_send"){ # แก้ไขยอดเงิน visit ที่เคยส่งการเงินไปแล้ว
  #ค่าเงินเก่าใน pang_stamp
  $s_old_ucm="SELECT pang_stamp_uc_money, pang_stamp_vn FROM pang_stamp WHERE pang_stamp_id='$pang_stamp_id' ";
  $q_old_ucm = mysqli_query($con_money,$s_old_ucm) or die(mysqli_error($con_money));
  $r_old_ucm = mysqli_fetch_array($q_old_ucm);
  $old_ucmoney = $r_old_ucm["pang_stamp_uc_money"];
  $vn = $r_old_ucm["pang_stamp_vn"];
  #ค่าเงินเก่าใน pang_stamp

  ##เช็ค id pang_stamp_edit_send_id
  $s_c_psesi="SELECT MAX(pang_stamp_edit_send_id)+1 AS max_pang_stamp_edit_send_id FROM pang_stamp_edit_send LIMIT 1 ";
  $q_c_psesi = mysqli_query($con_money,$s_c_psesi) or die(mysqli_error($con_money));
  $r_c_psesi = mysqli_fetch_array($q_c_psesi);
    
  if($r_c_psesi["max_pang_stamp_edit_send_id"]==''){
    $max_pang_stamp_edit_send_id=1;
  }else{
    $max_pang_stamp_edit_send_id=$r_c_psesi["max_pang_stamp_edit_send_id"];
  }
  ##เช็ค id pang_stamp_edit_send_id

  $s_chk_money = "SELECT income,paid_money,uc_money FROM $from_table_wher '$vn' LIMIT 1 ";
  $q_chk_money = mysqli_query($con_hos,$s_chk_money) or die(mysqli_error($con_hos));
  $r_chk_money = mysqli_fetch_array($q_chk_money);
  $income = $r_chk_money["income"];
  $paid_money = $r_chk_money["paid_money"];
  $uc_money = $r_chk_money["uc_money"];
  $s_update_pstm="UPDATE pang_stamp SET pang_stamp_uc_money = '$uc_money'
                ,pang_stamp_paid_money = '$paid_money' 
                ,pang_stamp_income = '$income'
                , pang_stamp_edit = 'money'
                , pang_stamp_edit_olddata = '$old_ucmoney'
                , pang_stamp_edit_user = '$pang_stamp_edit_user' 
                , pang_stamp_edit_send_id = '$max_pang_stamp_edit_send_id'
                WHERE pang_stamp_id='$pang_stamp_id'";
  $q_update_pstm = mysqli_query($con_money, $s_update_pstm) or die(mysqli_error($con_money));

    #เมื่ออัพเดตค่าใหม่แล้ว insert ข้อมูลเข้า pang_stamp_edit_send_id
    // if($q_update_pstm){
    //   $s_in_psesi="INSERT INTO pang_stamp_edit_send 
    //             (pang_stamp_edit_send_id,       edit_type,  edit_vn,  edit_user
    //             ,edit_date,   edit_old_money,   edit_new_money)
    //             VALUES 
    //             ('$max_pang_stamp_edit_send_id','money',    '$vn',     '$pang_stamp_edit_user'     
    //             ,'$date_now', '$old_ucmoney',   '$uc_money'   )
    //             ";
    //   $q_in_psesi = mysqli_query($con_money, $s_in_psesi) or die(mysqli_error($con_money));          
    // }          
    #เมื่ออัพเดตค่าใหม่แล้ว insert ข้อมูลเข้า pang_stamp_edit_send_id

}elseif($edit_type=="edit_pttype_send"){ #แก้ไข วิสิทนี้ ไปผังอื่นๆ ตามที่เลือก
  $s_update_pstm="UPDATE pang_stamp SET 
                pang_stamp_edit_olddata = pang_stamp
                ,pang_stamp = '$pang_id'
                ,pang_stamp_edit = 'sit'                
                ,pang_stamp_edit_user = '$pang_stamp_edit_user' 
                WHERE pang_stamp_id='$pang_stamp_id'";
  mysqli_query($con_money, $s_update_pstm) or die(mysqli_error($con_money));
                
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
  mysqli_query($con_money, $s_update_pstm) or die(mysqli_error($con_money));                
                
}elseif($edit_type=="edit_pttype"){
  $s_update_pstm="DELETE FROM pang_stamp WHERE pang_stamp_id='$pang_stamp_id'";
  mysqli_query($con_money, $s_update_pstm) or die(mysqli_error($con_money));
}



  

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