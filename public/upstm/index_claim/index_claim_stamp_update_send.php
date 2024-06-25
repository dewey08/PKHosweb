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
$pang_stamp_user_send=$_SESSION["UserID_BN"];

if( isset($_REQUEST['y_s']) ){
    $sir_year= $_SESSION["y_s"] = $_REQUEST['y_s'];
}elseif( isset($_SESSION["y_s"]) ){
    $sir_year= $_SESSION["y_s"];
}else{
    $sir_year = date("Y");
} 

$backto = $_POST["backto"];
@$month_send = $_POST["month_send"];
$max_pang_stamp_latest_date_send = $_POST["max_pang_stamp_latest_date_send"];

#กรณีกดปุ่มส่งมา แต่ไม่มีข้อมูลเลย และไม่พบข้อมูลในรอบการส่งปกติเลย
if(@$_POST["do_not_insert"]=='y'){
  ?>
  <div id="overlay"><h1 style="color:red;">ไม่พบข้อมูลการ Stamp ในรอบการส่งปกติ </h1></div>
  <script>
    setTimeout(function () {
      window.location.href= 'index_other.php?sum=stamp';
    }, 2000);
  </script>
  <?php
  exit();
}elseif(@$_POST["pang_stamp_send_pang"]==''){
  ?>
  <div id="overlay"><h1 style="color:red;">ไม่พบข้อมูลการ Stamp ในรอบการส่งปกติ </h1></div>
  <script>
    setTimeout(function () {
      window.location.href= 'index_other.php?sum=stamp';
    }, 2000);
  </script>
  <?php
  exit();
}


#กรณีกดปุ่มส่งมา แต่ไม่มีข้อมูลเลย และไม่พบข้อมูลในรอบการส่งปกติเลย

$date_now = date("YmdHis");
$date_update = date("Y-m-d");
$time_update = date("H:i:s");

#กำหนดรายการที่ส่งการเงินตามระยะเวลาที่ระบุ กรณีเป็นการส่งใบสรุปครั้งแรก
if(isset($_POST['dateuntil'])){  
  $s_up_send="UPDATE pang_stamp
              SET pang_stamp_send = '$date_now', pang_stamp_user_send = '$pang_stamp_user_send'
              WHERE (pang_stamp_send IS NULL OR pang_stamp_send ='') 
              AND pang_year = '$sir_year'
              AND pang_stamp_vstdate >= '$max_pang_stamp_latest_date_send'
              AND pang_stamp_vstdate <='".$_POST['dateuntil']."'
              ";
  $Result1 = mysqli_query($con_money,$s_up_send);

  $s_up_send_a="UPDATE pang_stamp
              SET pang_stamp_send = '$date_now', pang_stamp_user_send = '$pang_stamp_user_send'
              ,pang_stamp_send_status ='a'
              WHERE (pang_stamp_send IS NULL OR pang_stamp_send ='') 
              AND pang_year = '$sir_year'
              AND pang_stamp_vstdate < '$max_pang_stamp_latest_date_send'
              ";
  $q_up_send_a = mysqli_query($con_money,$s_up_send_a);

  $Result1 =1;
}else{ 
?>
  <script type="text/javascript">
    window.location.href = "<?php echo $backto?>";
  </script>
<?php
}
#กำหนดรายการที่ส่งการเงินตามระยะเวลาที่ระบุ กรณีเป็นการส่งใบสรุปครั้งแรก


#กรณี เป็นการแก้ไขใบสรุป ส่ง จะต้องมีค่า pang_stamp_send 
@$pang_stamp_send = $_POST["pang_stamp_send"];
if($pang_stamp_send!=''){
  

  $s_check_max_send="SELECT (IFNULL(MAX(pang_stamp_edit),0)+1) AS max_edit, pang_stamp_send_date,pang_stamp_send_time
                    FROM pang_stamp_send 
                    WHERE pang_stamp_send='$pang_stamp_send'";
  $q_check_max_send = mysqli_query($con_money, $s_check_max_send) or die(mysqli_error($con_money));
  $r_check_max_send = mysqli_fetch_array($q_check_max_send);
  #$r_check_max_send["max_edit"];

  # อัพเดตเลขที่ส่งหนังสืออันเก่า เพื่อให้รู้ว่าเป็ฯฉบับเก่า
  if(isset($r_check_max_send["max_edit"])){
    $s_update_no_edit=" UPDATE pang_stamp_send SET pang_stamp_edit = '".$r_check_max_send["max_edit"]."'
                        WHERE pang_stamp_send='$pang_stamp_send' AND (pang_stamp_edit='' OR pang_stamp_edit IS NULL)";
    $q_check_max_send = mysqli_query($con_money, $s_update_no_edit) or die(mysqli_error($con_money));
  }
  # อัพเดตเลขที่ส่งหนังสืออันเก่า เพื่อให้รู้ว่าเป็ฯฉบับเก่า

    # update pang_stamp pang_stamp_edit_olddata
    $s_update_p_edit=" UPDATE pang_stamp SET pang_stamp_edit = null
                        WHERE pang_stamp_send='$pang_stamp_send' 
                        AND (pang_stamp_edit!='' OR pang_stamp_edit IS NOT NULL) ";
    $q_update_p_edit = mysqli_query($con_money, $s_update_p_edit) or die(mysqli_error($con_money));
    # update pang_stamp pang_stamp_edit_olddata
    
  $pang_stamp_send_update = $pang_stamp_send;
  $pang_stamp_send_date = $r_check_max_send["pang_stamp_send_date"];
  $pang_stamp_send_time = $r_check_max_send["pang_stamp_send_time"];
}else{
  $pang_stamp_send_update = $date_now;
  $pang_stamp_send_date = $date_update;
  $pang_stamp_send_time = $time_update;
}
#กรณี เป็นการแก้ไขใบสรุป ส่ง จะต้องมีค่า pang_stamp_send 


if($Result1==1){

  #$count_rec = count($pang_stamp_send_pang);
  for($o=0;$o<count($_POST["pang_stamp_send_pang"]);$o++){

    #$pang_stamp_send_pang_a = $pang_stamp_send_pang[$o];
    #$pang_stamp_send_visit_a = $pang_stamp_send_visit[$o];
    #$pang_stamp_send_money_a = $pang_stamp_send_money[$o];
    #$pang_stamp_send_responsible_a = $pang_stamp_send_responsible[$o];

    if(@$_POST["pang_stamp_edit_pang"][$o]!=''){
      $pang_stamp_edit_pang = "'".$_POST["pang_stamp_edit_pang"][$o]."'";
    }else{
      $pang_stamp_edit_pang = 'null';
    }

    if(@$_POST["pang_stamp_edit_olddata"][$o]!=''){
      $pang_stamp_edit_olddata =  "'".$_POST["pang_stamp_edit_olddata"][$o]."'";
    }else{
      $pang_stamp_edit_olddata = 'null';
    }

    if(@$_POST["pang_stamp_status_send"][$o]!=''){
      $pang_stamp_status_send = "'".$_POST["pang_stamp_status_send"][$o]."'";
    }else{
      $pang_stamp_status_send = 'null';
    }

    #ตรวจสอบ max_pang_stamp_vstdate
    $s_check_max_vstdate = "SELECT MAX(pang_stamp_vstdate) AS max_pang_stamp_vstdate
                            FROM pang_stamp WHERE pang_stamp_send = '$date_now' ";
    $q_check_max_vstdate = mysqli_query($con_money, $s_check_max_vstdate) or die(nl2br($s_check_max_vstdate));
    $r_check_max_vstdate = mysqli_fetch_array($q_check_max_vstdate);
    $max_pang_stamp_vstdate = $r_check_max_vstdate["max_pang_stamp_vstdate"];
    #ตรวจสอบ max_pang_stamp_vstdate

    $s_insert = "INSERT INTO pang_stamp_send 
      (pang_stamp_send_pang, pang_stamp_send_visit    
      , pang_stamp_send_money                           , pang_stamp_send_responsible                    
      , pang_stamp_send             , pang_stamp_send_year    , pang_stamp_send_date    ,pang_stamp_send_time     ,pang_stamp_send_user
      , pang_stamp_send_money_kor_tok
      , pang_stamp_edit_pang      ,pang_stamp_edit_olddata
      , pang_stamp_month_send
      ,pang_stamp_latest_date_send                  ,pang_stamp_status_send
      ,min_pang_stamp_vstdate                         ,max_pang_stamp_vstdate
      )
      VALUES ('".substr($_POST["pang_stamp_send_pang"][$o],0,14)."', '".$_POST["pang_stamp_send_visit"][$o]."'
      , '".$_POST["pang_stamp_send_money"][$o]."'      , '".$_POST["pang_stamp_send_responsible"][$o]."'
      , '$pang_stamp_send_update'   , '$sir_year'             ,'$pang_stamp_send_date'  ,'$pang_stamp_send_time'  ,'$pang_stamp_user_send'
      , '".@$_POST["pang_stamp_send_money_kor_tok"][$o]."'
      , $pang_stamp_edit_pang      , $pang_stamp_edit_olddata
      ,'$month_send'
      ,'".@$max_pang_stamp_vstdate."' ,$pang_stamp_status_send
      ,'".@$_POST["min_pang_stamp_vstdate"][$o]."'    ,'".@$_POST["max_pang_stamp_vstdate"][$o]."'
      )
    ";
    $Result2 = mysqli_query($con_money,$s_insert);

    

  }

  if($Result2){
    ?>
    <div id="overlay"></div>
    <script>
      setTimeout(function () {
        window.location.href= 'index_other.php?sum=send';
      }, 0);
    </script>
    <?php
    }

}

?>
