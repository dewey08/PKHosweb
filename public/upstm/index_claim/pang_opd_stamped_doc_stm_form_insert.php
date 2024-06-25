<?php
@session_start();
include("../session/session_claim.php");
include("../connect/connect.php");

$receipt_number_user_reccord=$_SESSION["UserID_BN"];

$pang_stamp_id = $_POST["pang_stamp_id"];
$pang_stamp_uc_money = $_POST["pang_stamp_uc_money"];
$pang_stamp_stm_money = $_POST["pang_stamp_stm_money"];
$pang_stamp = $_POST["pang_stamp"];
$pang_type = $_POST["pang_type"];
$m_s= $_SESSION["m_s"];

$pang_stamp_uc_money_minut_stm_money = ($pang_stamp_stm_money-$pang_stamp_uc_money);

if(isset($_POST["pang_stamp_id"])){

    $s_up_ps_stm = "UPDATE pang_stamp
      SET pang_stamp_stm_money = '$pang_stamp_stm_money', pang_stamp_uc_money_minut_stm_money = '$pang_stamp_uc_money_minut_stm_money'
      WHERE pang_stamp_id = '$pang_stamp_id'
    ";
    $q_up_ps_stm = mysqli_query($con_money,$s_up_ps_stm);


  if($q_up_ps_stm){
    ?>
    <div id="overlay"></div>
    <script>
      setTimeout(function () {
        //window.location.href= '../index_money';
        window.location.href= 'index.php?pang=<?=$pang_stamp?>&pang_type=<?=$pang_type?>&m_s=<?=$m_s?>&stm=n';
      }, 0);
    </script>
    <?php
    }

}

?>