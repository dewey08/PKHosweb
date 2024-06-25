<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <!-- Pignose Calender -->
    <link href="../plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="../plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="../plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
    <!-- Custom Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">

</head>

<?php
@session_start();
include("../session/session_claim.php");
include("../connect/connect.php");

$claim_doc_number_user_reccord=$_SESSION["UserID_BN"];

if( isset($_REQUEST['y_s']) ){
    $sir_year= $_SESSION["y_s"] = $_REQUEST['y_s'];
}elseif( isset($_SESSION["y_s"]) ){
    $sir_year= $_SESSION["y_s"];
}else{
    $sir_year = date("Y");
} 




# $pang_stamp_id  = $_POST["pang_stamp_id"];
$pang_stamp     = $_POST["pang_stamp"];
$pang_type      = $_POST["pang_type"];
$m_s            = $_POST["m_s"];



#ตรวจสอบว่ามีเลขที่หนังสือเบิกนี้ในระบบหรือยัง ถ้ามีแล้วจะไม่ให้เพิ่ม
$check_pang_stamp_stm_file_name = $_POST["pang_stamp_stm_file_name"];
$s_check_s_rep="SELECT pang_stamp_stm_rep FROM pang_stamp 
WHERE pang_stamp_stm_rep='$check_pang_stamp_stm_file_name' AND pang_year='$sir_year' LIMIT 1 ";
$q_check_s_rep = mysqli_query($con_money, $s_check_s_rep);
$r_check_s_rep = mysqli_fetch_array($q_check_s_rep);
$check_pang_stamp_stm_rep = $r_check_s_rep['pang_stamp_stm_rep'];
if($check_pang_stamp_stm_rep!=''){
#$err_already_rep='Y';
?>
<!-- <div id="overlay"><h3 style="color:red;">มีเลขที่เอกสารเบิกนี้ในระบบแล้ว ให้ใช้การลงเลขที่หนังสือที่ลงแล้ว</h3></div> -->
<div class="col-lg-12">
  <div class="card">
    <div class="card-body">
    <!-- <h4 class="card-title">Link color</h4> -->
      <div class="card-content">
        <h2 class="alert alert-danger">มีเลขที่เอกสารเบิกนี้ในระบบแล้ว ให้ใช้การลงเลขที่หนังสือที่ลงแล้ว</h2>
        <div class="form-group">
        <img style="width:30%" src="rep_doc_already.jpg" alt="Card image cap">
        <div class="form-group">
      </div>
    </div>
  </div>
</div>
<script>
  setTimeout(function () {
    window.location.href= 'index.php?pang=<?=$pang_stamp?>&pang_type=<?=$pang_type?>&m_s=<?=$m_s?>&stamp=y';
  }, 5000);
</script>
<?php  

#ตรวจสอบว่ามีเลขที่หนังสือเบิกนี้ในระบบหรือยัง ถ้ามีแล้วจะไม่ให้เพิ่ม 
}elseif($_POST["pang_stamp_id"]!=''){#ดักกรณีไม่ได้ติ๊ก_Check_box

  for($i=0;$i<count($_POST["pang_stamp_id"]);$i++){
    $pang_stamp_id=$_POST["pang_stamp_id"][$i];

    if(@$_POST['pang_stamp_stm_file_name_already']!='' ){
      @$post_pstm=$_POST['pang_stamp_stm_file_name'];
      $pieces = explode(" ", $post_pstm);
      $pang_stamp_stm_file_name_check = $pieces[0];
      $s_check_doc_stm=" 
                    SELECT pang_stamp_stm_file_name, pang_stamp_stm_rep FROM pang_stamp 
                    WHERE pang_stamp_stm_file_name='$pang_stamp_stm_file_name_check'
                    AND pang_year='$sir_year'
                    LIMIT 1 ";
      $q_check_doc_stm = mysqli_query($con_money, $s_check_doc_stm);
      $r_check_doc_stm = mysqli_fetch_array($q_check_doc_stm);
      $pang_stamp_stm_file_name_doc = $r_check_doc_stm['pang_stamp_stm_file_name'];
      $pang_stamp_stm_file_name = $r_check_doc_stm['pang_stamp_stm_rep'];
    }else{
      $pang_stamp_stm_file_name = $_POST["pang_stamp_stm_file_name"]; # เก็บเลขที่หนังสือไว้ที่ pang_stamp_stm_rep
      $pang_stamp_stm_file_name_doc = 'doc_'.date('YmdHis');
    }

      if(isset($_POST["pang_stamp_stm_file_name"])){
        $s_update_doc = "UPDATE pang_stamp SET 
                      pang_stamp_stm_file_name = '$pang_stamp_stm_file_name_doc'
                      , pang_stamp_stm_rep = '$pang_stamp_stm_file_name'
                      WHERE pang_stamp_id='$pang_stamp_id'
                    ";
        $Result2 = mysqli_query($con_money,$s_update_doc);
      }  
  }
     
    if(isset($_POST["pang_stamp_stm_file_name"]) && empty(@$_POST['pang_stamp_stm_file_name_already']) ){    
      $claim_doc_pic=$sir_year+543;
      ##ตรวจสอบว่ามีโฟลเดอร์หรือยัง
      $target_dirr = "../pic/claim_doc/".$claim_doc_pic;
      if( !is_dir($target_dirr) ){
          mkdir("../pic/claim_doc/".$claim_doc_pic, 0777);
          $target_dir = "../pic/claim_doc/".$claim_doc_pic."/";
      }else{
          $target_dir = "../pic/claim_doc/".$claim_doc_pic."/";    
      }
      ##ตรวจสอบว่ามีโฟลเดอร์หรือยัง

      # ลบรูปเก่าๆ ๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒
      $chk_time = date('Y-m-d H:i:s' , strtotime("-1 day"));
      $files = (array) glob('../pic/temp/*');
        foreach ($files as $file){
          if( date("Y-m-d H:i:s", filemtime($file)) < $chk_time ){
            //echo date("Y-m-d H:i:s", filemtime($file));
            @unlink($file);
          }
        }
      # ลบรูปเก่าๆ ๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒
      //จัดการไฟล์ภาพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพ
          $file = strtolower($_FILES["file"]["name"]);
          $sizefile = $_FILES["file"]["size"]; 
          $type= strrchr($file,".");

          if(trim($_FILES["file"]["tmp_name"]) != ""&& ( ($type==".jpg")||($type==".jpeg") ) ){
            $images = $_FILES["file"]["tmp_name"];
            $new_images = "Thumbnails_".$_FILES["file"]["name"];
            copy($_FILES["file"]["tmp_name"],"../pic/temp/".$_FILES["file"]["name"]);
            $width=800; //*** Fix Width & Heigh (Autu caculate) ***//
            $size=GetimageSize($images);
            $height=round($width*$size[1]/$size[0]);
            $images_orig = ImageCreateFromJPEG($images);
            $photoX = ImagesX($images_orig);
            $photoY = ImagesY($images_orig);
            $images_fin = ImageCreateTrueColor($width, $height);
            ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
            ImageJPEG($images_fin,"../pic/temp/".$new_images);
            ImageDestroy($images_orig);
            ImageDestroy($images_fin);
            $filepath = "../pic/temp/".$new_images;
            @$rm_pic=$_SESSION["filepath"]=$filepath;
          }elseif(trim($_FILES["file"]["tmp_name"]) != ""&& ($type==".png")  ){
            $images = $_FILES["file"]["tmp_name"];
            $new_images = "Thumbnails_".$_FILES["file"]["name"];
            copy($_FILES["file"]["tmp_name"],"../pic/temp/".$_FILES["file"]["name"]);
            $width=800; //*** Fix Width & Heigh (Autu caculate) ***//
            $size=GetimageSize($images);
            $height=round($width*$size[1]/$size[0]);
            $images_orig = ImageCreateFromPNG($images);
            $photoX = ImagesX($images_orig);
            $photoY = ImagesY($images_orig);
            $images_fin = ImageCreateTrueColor($width, $height);
            ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
            ImagePNG($images_fin,"../pic/temp/".$new_images);
            ImageDestroy($images_orig);
            ImageDestroy($images_fin);
            $filepath = "../pic/temp/".$new_images; 
            @$rm_pic=$_SESSION["filepath"]=$filepath;
          }
      $target="../pic/claim_doc/".$claim_doc_pic."/".$pang_stamp_stm_file_name_doc.".jpg";//$tad_lname; //target //ชื่อและ path ของรูปที่จะ Restore
      copy($filepath,$target);
      //จัดการไฟล์ภาพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพพ



      

    }
#ดักกรณีไม่ได้ติ๊ก_Check_box
}else{
?>
    <div id="overlay">ไม่ได้ Check_box</div>
    <script>
      setTimeout(function () {
        //index.php?pang=1102050101.203&pang_type=OPD&m_s=09&stamp=y
        ////$pang_stamp_id.'|'.$pang_stamp."|".$pang_type."|".$m_s
        window.location.href= 'index.php?pang=<?=$pang_stamp?>&pang_type=<?=$pang_type?>&m_s=<?=$m_s?>&stamp=y';
      }, 3000);
    </script>
<?php  
}

if($Result2){
    ?>
    <div id="overlay"></div>
    <script>
      setTimeout(function () {
        //index.php?pang=1102050101.203&pang_type=OPD&m_s=09&stamp=y
        ////$pang_stamp_id.'|'.$pang_stamp."|".$pang_type."|".$m_s
        window.location.href= 'index.php?pang=<?=$pang_stamp?>&pang_type=<?=$pang_type?>&m_s=<?=$m_s?>&stamp=y';
      }, 0);
    </script>
<?php
}
?>