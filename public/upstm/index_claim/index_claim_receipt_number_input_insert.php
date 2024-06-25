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
$pang_stamp_stm_file_name = $_POST["pang_stamp_stm_file_name"];
$pang_stamp_id = $_POST["pang_stamp_id"];


$date_now = date("YmdHis");
$date_update = date("Y-m-d");

#$pang_stamp_send_pang = $_POST["pang_stamp_send_pang"];
#$pang_stamp_send_visit = $_POST["pang_stamp_send_visit"];
#$pang_stamp_send_money = $_POST["pang_stamp_send_money"];
#$pang_stamp_send_responsible = $_POST["pang_stamp_send_responsible"];

if(isset($_POST['pang_stamp_stm_file_name'])){     // กรณีเป็นการเพิ่มทีละสิทธิ
	
  $s_up_file="UPDATE pang_stamp
              SET pang_stamp_stm_file_name = '$pang_stamp_stm_file_name'
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
