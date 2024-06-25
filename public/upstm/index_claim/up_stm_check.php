<?php
@include("../session/session_claim.php"); // session_login
include("../connect/connect.php");
$backto=$_POST["backto"];
$target_dir = "../file_stm/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$file_name = $_FILES["fileToUpload"]["name"];
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$tmp_name = $_FILES["fileToUpload"]["tmp_name"]; 
// Check if image file is a actual image or fake image
/*
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}
*/

$s_data_hos  = "SELECT data_hos_code FROM data_hos ";
$q_data_hos  = mysqli_query($con_money, $s_data_hos) or die(nl2br($s_data_hos));
$r_data_hos  = mysqli_fetch_assoc($q_data_hos);
$data_hos_code = $r_data_hos['data_hos_code']; #ไว้ตรวจสอบกรณีที่เป็น รพ OFC เบิก 168 แห่ง

echo $file_name."<BR>";
echo $imageFileType."<BR>";
echo $tmp_name."<BR>";

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.<BR>";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 10000000) {
  echo "Sorry, your file is too large.<BR>";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "xls" && $imageFileType != "xml" && $imageFileType != "xlsx"  ) {
  echo "Sorry, only xls & xml files are allowed.<BR>";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.<BR>";
  header("refresh: 3; url=index_other.php?sum=up_stm" );
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.<BR>";
  }
}

if($imageFileType=='xls'){

	$check_sit = substr($file_name,12,2);
  #echo "<BR> sho:".$check_sit."<BR>";
	if($check_sit=="_O"){
    echo "OP_LGO";
    header("refresh: 1; url=up_stm_query_lgo.php?target_file=$target_file&file_name=$file_name&backto=$backto" );

  }elseif($check_sit=="_I"){
    echo "IP_LGO<BR>";
    header("refresh: 1; url=up_stm_query_lgo_ip.php?target_file=$target_file&file_name=$file_name&backto=$backto" );

  }else{
    $check_sit = substr($file_name,10,3);
    
    if($check_sit=="OPU"){
      echo "OPD_UCS<BR>";
      header("refresh: 1; url=up_stm_query_ucs.php?target_file=$target_file&file_name=$file_name&backto=$backto" );
    }elseif($check_sit=="IPU"){
      echo "IP_UCS<BR>";
      header("refresh: 1; url=up_stm_query_ucs_ip.php?target_file=$target_file&file_name=$file_name&backto=$backto" );
    }else{
      $check_sit = substr($file_name,10,2);
      if($check_sit=="OP"){
        echo "OFC_OP<BR>";
        header("refresh: 1; url=up_stm_query_ofc.php?target_file=$target_file&file_name=$file_name&backto=$backto" );  
      }elseif($check_sit=="IP" && $data_hos_code=="10702"){
        echo "OFC_IP168<BR>";
        header("refresh: 1; url=up_stm_query_ofc_ip168.php?target_file=$target_file&file_name=$file_name&backto=$backto" );
      }elseif($check_sit=="IP"){
        echo "OFC_IP<BR>";
        header("refresh: 1; url=up_stm_query_ofc_ip.php?target_file=$target_file&file_name=$file_name&backto=$backto" );  
      }
    }
  }
  ## รอเพิ่มเงื่อนไขตัวเลข

}elseif($imageFileType=='xlsx'){

  $check_sit = substr($file_name,12,2);
  if(is_numeric($check_sit) ){
    echo "UCS<BR>";
    header("refresh: 1; url=up_stm_query_ucs_tai.php?target_file=$target_file&file_name=$file_name&backto=$backto" );

  }
  ## รอเพิ่มเงื่อนไขตัวเลข

}elseif($imageFileType=='xml'){

  echo $check_sit = substr($file_name,6,4); # แยกตามชื่อไฟล์ 

  if($check_sit=="BIGN"){

    echo "BKK OD <BR>".$check_sit;
    header("refresh: 1; url=up_stm_query_bkk_ip.php?target_file=$target_file&file_name=$file_name&backto=$backto" );

  }elseif($check_sit=="BOCD"){

    echo "BKK OD <BR>".$check_sit;
    header("refresh: 1; url=up_stm_query_bkk_op.php?target_file=$target_file&file_name=$file_name&backto=$backto" );

  }elseif($check_sit=="COCD" || $check_sit=="EOCD"){

    echo "BKK OD <BR>".$check_sit;
    header("refresh: 1; url=up_stm_query_ofc_tai.php?target_file=$target_file&file_name=$file_name&backto=$backto" );

  }elseif($check_sit=="SOCD"){

    echo "BKK OD <BR>".$check_sit;
    header("refresh: 1; url=up_stm_query_sss_tai.php?target_file=$target_file&file_name=$file_name&backto=$backto" );
    
  }elseif($check_sit=="CIGN"){

    echo "BKK OD <BR>".$check_sit;
    header("refresh: 1; url=up_stm_query_ofc_ip168.php?target_file=$target_file&file_name=$file_name&backto=$backto" );
    
  }

}

?>