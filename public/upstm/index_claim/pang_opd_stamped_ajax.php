<?php

include("../connect/connect.php");

function DateThaisubmonth($strDate){
  $strYear = date("Y",strtotime($strDate))+543;
  $strMonth= date("n",strtotime($strDate));
  $strDay= date("j",strtotime($strDate));
  $strMonthCut = Array("","มค","กพ","มีค","มย","พค","มิย","กค","สค","กย","ตค","พย","ธค");
  $strMonthThai=$strMonthCut[$strMonth];
  return "$strDay $strMonthThai $strYear";
}

/* Database connection end */
$pang=$_POST["pang"];
$start_year=$_POST["start_year"];
$end_year=$_POST["end_year"];
$pang_type=$_POST["pang_type"];
$m_s=$_POST["m_s"];
$y_s=$_POST["y_s"];
$backto=$_POST["backto"];

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$sql_pang_preview=" SELECT p.pang_id, p.pang_fullname, p.pang_instument, p.pang_stm, p.pang_kor_tok, p.pang_kor_tok_icd
                  , p.pang_cancer, p.pang_type
                  FROM pang p LEFT OUTER JOIN pang_sub ps ON p.pang_id=ps.pang_id
                  WHERE p.pang_id='$pang' AND p.pang_year='$y_s'
                  LIMIT 100";
$result_pang_preview = mysqli_query($con_money, $sql_pang_preview) or die(mysqli_error($con_money));
$row_pang_preview = mysqli_fetch_array($result_pang_preview);
$pang_type = $row_pang_preview["pang_type"];##ตรวจว่าเป็นคนไข้ในหรือคนไข้นอก

##ตรวจการตัดชดเชย
$pang_stm = $row_pang_preview["pang_stm"];
##ตรวจการตัดชดเชย

if($pang_type=='OPD'){
  $s_date = "ps.pang_stamp_vstdate";
}elseif($pang_type=='IPD'){
  $s_date = "ps.pang_stamp_dchdate";
}else{
}

$sqlshow = "SELECT IF(ps.pang_stamp_vn IS NULL,'','Y')AS Stamp
            ,ps.pang_stamp_vn AS 'vn'
            ,ps.pang_stamp_hn AS 'hn'
            ,ps.pang_stamp_vstdate
            ,ps.pang_stamp_nhso
            ,ps.pang_stamp_uc_money  ,ps.pang_stamp_uc_money_kor_tok
            ,ps.pang_stamp_stm_money AS stm
            ,ps.pang_stamp_uc_money_minut_stm_money
            ,ps.pang_stamp_send
            ,ps.pang_stamp_id
            ,ps.pang_stamp
            ,ps.pang_stamp_stm_file_name ,ps.pang_stamp_stm_rep
            ,ps.pang_stamp_edit_send_id
            ,CONCAT(ps.pang_stamp_pname,CONCAT(SUBSTR(ps.pang_stamp_fname,1,4),'xxx'),' ',CONCAT(SUBSTR(ps.pang_stamp_lname,1,4)),'xxx') AS pt_sub_name
            FROM $database_ii.pang_stamp ps
            WHERE ps.pang_stamp = '$pang'
            AND $s_date BETWEEN '$start_year' AND '$end_year'
            AND ps.pang_stamp_uc_money <>0
            ORDER BY ps.pang_stamp_hn
            LIMIT 50000 ";

if($pang_stm=='doc'){
  $columns = array( 
  // datatable column index  => database column name
    0 =>'pang_stamp_stm_file_name',
    1 =>'pang_stamp_stm_file_name',
    2 =>'pang_stamp_send',
    3 =>'pang_stamp_stm_file_name',
    4 =>'pang_stamp_edit_send_id',
    5 =>'pang_stamp_hn',
    6 =>'pang_stamp_fname',
    7 =>'pang_stamp_vstdate',
    8 =>'pang_stamp_uc_money',
    9 =>'pang_stamp_stm_money',
    10 =>'pang_stamp_uc_money_minut_stm_money',
    11 =>'pang_stamp_uc_money_minut_stm_money',
    12 =>'pang_stamp_stm_file_name',
    13 =>'pang_stamp_send'
  );
}else{
$columns = array( 
  // datatable column index  => database column name
    0 =>'pang_stamp_stm_file_name',
    1 =>'pang_stamp_stm_file_name',
    2 =>'pang_stamp_send',
    3 =>'pang_stamp_stm_file_name',
    4 =>'pang_stamp_hn',
    5 =>'pang_stamp_fname',
    6 =>'pang_stamp_vstdate',
    7 =>'pang_stamp_uc_money',
    8 =>'pang_stamp_stm_money',
    9 =>'pang_stamp_uc_money_minut_stm_money',
    10 =>'pang_stamp_uc_money_minut_stm_money',
    11 =>'pang_stamp_stm_file_name',
    12 =>'pang_stamp_send'
  );
}

// getting total number records without any search
$sql = "SELECT IF(ps.pang_stamp_vn IS NULL,'','Y')AS Stamp
        ,ps.pang_stamp_vn AS 'vn'
        ,ps.pang_stamp_hn AS 'hn'
        ,ps.pang_stamp_vstdate
        ,ps.pang_stamp_nhso
        ,ps.pang_stamp_uc_money  ,ps.pang_stamp_uc_money_kor_tok
        ,ps.pang_stamp_stm_money AS stm
        ,ps.pang_stamp_uc_money_minut_stm_money
        ,ps.pang_stamp_send
        ,ps.pang_stamp_id
        ,ps.pang_stamp
        ,ps.pang_stamp_stm_file_name ,ps.pang_stamp_stm_rep
        ,ps.pang_stamp_edit_send_id
        ,CONCAT(ps.pang_stamp_pname,CONCAT(SUBSTR(ps.pang_stamp_fname,1,4),'xxx'),' ',CONCAT(SUBSTR(ps.pang_stamp_lname,1,4)),'xxx') AS pt_sub_name
        FROM $database_ii.pang_stamp ps
        WHERE ps.pang_stamp = '$pang'
        AND $s_date BETWEEN '$start_year' AND '$end_year'
        AND ps.pang_stamp_uc_money <>0
        ";
$query=mysqli_query($con_money, $sql) or die("employee-grid-data.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT IF(ps.pang_stamp_vn IS NULL,'','Y')AS Stamp
        ,ps.pang_stamp_vn AS 'vn'
        ,ps.pang_stamp_hn AS 'hn'
        ,ps.pang_stamp_vstdate
        ,ps.pang_stamp_nhso
        ,ps.pang_stamp_uc_money  ,ps.pang_stamp_uc_money_kor_tok
        ,ps.pang_stamp_stm_money AS stm
        ,ps.pang_stamp_uc_money_minut_stm_money
        ,ps.pang_stamp_send
        ,ps.pang_stamp_id
        ,ps.pang_stamp
        ,ps.pang_stamp_stm_file_name ,ps.pang_stamp_stm_rep
        ,ps.pang_stamp_edit_send_id
        #,CONCAT(ps.pang_stamp_pname,CONCAT(SUBSTR(ps.pang_stamp_fname,1,4),'xxx'),' ',CONCAT(SUBSTR(ps.pang_stamp_lname,1,4)),'xxx') AS pt_sub_name
        ,CONCAT(ps.pang_stamp_pname,ps.pang_stamp_fname,' ',ps.pang_stamp_lname) AS pt_sub_name
        FROM $database_ii.pang_stamp ps
        WHERE ps.pang_stamp = '$pang'
        AND $s_date BETWEEN '$start_year' AND '$end_year'
        AND ps.pang_stamp_uc_money <>0 ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( ps.pang_stamp_hn LIKE '%".$requestData['search']['value']."%' ";    
	$sql.=" OR ps.pang_stamp_vn LIKE '%".$requestData['search']['value']."%' ";
  $sql.=" OR ps.pang_stamp_fname LIKE '%".$requestData['search']['value']."%' ";
  $sql.=" OR ps.pang_stamp_lname LIKE '%".$requestData['search']['value']."%'  )";
}
$query=mysqli_query($con_money, $sql) or die("employee-grid-data.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($con_money, $sql) or die("employee-grid-data.php: get employees");

$data = array();
$i=1;
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $pang_stamp_stm_file_name = $row["pang_stamp_stm_file_name"];
  $pang_stamp_edit_send_id = $row["pang_stamp_edit_send_id"];
  
	$nestedData=array();   
  
  if($pang_stm=='doc' && $pang_stamp_stm_file_name==''){
    $nestedData[] = '<input type="checkbox" name="pang_stamp_id[]" value="'.$row['pang_stamp_id'].'" >
    <input type="hidden" name="pang_stamp"      value="'.$pang.'">
    <input type="hidden" name="pang_type"       value="'.$pang_type.'">
    <input type="hidden" name="m_s"             value="'.$m_s.'">';
  }else{
    $nestedData[] =null;
  }

  $nestedData[] = $i++;

  #stamp(แก้ไข)
	if($row["Stamp"]=="Y" && $row["pang_stamp_send"]!=""){
    $nestedData[] = '<button type="button" name="view_edit_stamp" class="btn btn-danger view_edit_stamp" id="'.$row["vn"].'|'.$pang.'|'.$backto.'" >ส่งการเงินแล้ว</button>';
  }elseif($row["Stamp"]=="Y"){
    $nestedData[] = '<button type="button" name="view_edit_stamp" class="btn btn-primary view_edit_stamp" id="'.$row["vn"].'|'.$pang.'|'.$backto.'" >Stamp</button>';    
  }else{
    $nestedData[] = $row["Stamp"];
  }
  #stamp(แก้ไข)
  
  #เอกสาร
  if($pang_stm=='doc'){
    #ถ้าว่าง แสดงว่ายังไม่ได้ระบุเลขที่เอกสารเบิก
    if($pang_stamp_stm_file_name==''){
      $nestedData[] = '<button type="button" name="view_insert_stm_doc" class="btn btn-info view_insert_stm_doc" id="'.$row["pang_stamp_id"].'|'.$pang.'|'.$pang_type.'|'.$m_s.'" >ลงเอกสาร </button>';
    }else{    
      $nestedData[] = '<button type="button" class="btn btn-success view_doc" id="'.$row["pang_stamp_stm_file_name"].'">'.$row["pang_stamp_stm_rep"].'</button>';     
    }
  }
  #เอกสาร

  #บันทึกแก้
  if($pang_stamp_edit_send_id!=''){
    $nestedData[] ='<a class="btn btn-info" target="_blank" href="../report/edit_stamp.php?pang_stamp_id='.$row["pang_stamp_id"].'">บันทึกข้อความ</a>';     
  }else{
    $nestedData[] = NULL;
  }
  #บันทึกแก้

  #HN(การรักษา)
  $nestedData[] ='<button type="button" name="view_patient" class="btn mb-1 btn-secondary view_patient" id="'.$row["vn"].'"  >'.$row["hn"].'</button>';
  #HN(การรักษา)

  $nestedData[] = $row["pt_sub_name"];
  $nestedData[] = DateThaisubmonth($row["pang_stamp_vstdate"]);


  if($row["pang_stamp_uc_money_kor_tok"]!=0){
    $show_kor_tok="<span style='color:red;'>(".number_format($row["pang_stamp_uc_money_kor_tok"],2).")</span>";
  }else{$show_kor_tok='';}
  $nestedData[] = number_format($row["pang_stamp_uc_money"],2).$show_kor_tok;
  
  #ชดเชย
  if($row["stm"]!='' || $row["stm"] !=0){                        
    $nestedData[] = number_format($row["stm"],2);
  }else{
    $nestedData[] = NULL;
  }
  #ชดเชย

  #ส่วนต่ำ
  if($row["pang_stamp_uc_money_minut_stm_money"]<=0){
    $nestedData[] = $row["pang_stamp_uc_money_minut_stm_money"];
  }else{
    $nestedData[] = NULL;
  }
  #ส่วนต่ำ

  #ส่วนสูง
  if($row["pang_stamp_uc_money_minut_stm_money"]>0){
    $nestedData[] = number_format(abs($row["pang_stamp_uc_money_minut_stm_money"]),2); 
  }else{
    $nestedData[] = NULL;
  }
  #ส่วนสูง

  #STM
  $nestedData[] = $row["pang_stamp_stm_file_name"];
  #STM

  #เลขที่ส่งหนังสือ
  $nestedData[] = $row["pang_stamp_send"];
  #เลขที่ส่งหนังสือ


	$data[] = $nestedData;
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>









