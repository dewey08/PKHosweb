<style type="text/css">
    html,body {   
        padding: 0;   
        margin: 0;   
        width: 100%;   
        height: 100%;             
    }   
    #overlay {   
        position: absolute;  
        top: 0px;   
        left: 0px;  
        background: #ccc;   
        width: 100%;   
        height: 100%;   
        opacity: .75;   
        filter: alpha(opacity=75);   
        -moz-opacity: .75;  
        z-index: 999;  
        background: #fff url(Includes/success_icon.gif) 50% 50% no-repeat;
    }   
    .main-contain{
        position: absolute;  
        top: 0px;   
        left: 0px;  
        width: 100%;   
        height: 100%;   
        overflow: hidden;
    }
</style>

<?php
include('../connect/connect.php');
include('../session/session_claim.php');
@session_start();
$pang_stamp_user_send=$_SESSION["UserID"];
$sir_year= $_SESSION["sir_year"]; //ปีงบ

$backto = $_POST["backto"];
$pang_stamp_stm_money = $_POST["pang_stamp_stm_money"];
$pang_stamp_id = $_POST["pang_stamp_id"];


$date_now = date("YmdHis");
$date_update = date("Y-m-d");

$sir_year= $_SESSION["sir_year"]; //ปีงบ
$s_ps_uc = "SELECT ps.pang_stamp_uc_money FROM pang_stamp ps WHERE pang_stamp_id = '$pang_stamp_id' LIMIT 1";
$q_ps_uc = mysqli_query($con_money, $s_ps_uc) or die(mysqli_error($con_money));
$r_ps_uc = mysqli_fetch_array($q_ps_uc);
$pang_stamp_uc_money = $r_ps_uc["pang_stamp_uc_money"];
$pang_stamp_uc_money_minut_stm_money=$pang_stamp_stm_money-$pang_stamp_uc_money; #ส่วนต่าง

if(isset($_POST['pang_stamp_stm_money'])){     // กรณีเป็นการเพิ่มทีละสิทธิ
	
  $s_up_file="UPDATE pang_stamp
              SET pang_stamp_stm_money = '$pang_stamp_stm_money'
              ,pang_stamp_uc_money_minut_stm_money = '$pang_stamp_uc_money_minut_stm_money'
              WHERE pang_stamp_id = '$pang_stamp_id'
              ";
}else{ 
?>
  <script type="text/javascript">
    window.location.href = "<?php echo $backto?>";
  </script>
<?php
  
}


$Result1 = mysqli_query($con_money,$s_up_file);

if($Result1){

    ?>
    <div id="overlay"></div>
    <script>
      setTimeout(function () {
        window.location.href= '<?php echo $backto?>';
      }, 0);
    </script>
    <?php
    

}

?>
