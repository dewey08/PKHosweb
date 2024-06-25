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
//$pang_kor_tok=$_POST["pang_kor_tok"];


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$date_now=date("Y-m-d");

if($pang_type=='OPD'){
  $pang_sql = "pang_opd_sql.php";
  $s_date = "o.vstdate";
  $s_ipd_an = ',null AS an';
  $show_adjrw = '1 AS rw'; #สำหรับ opd ใส่ 1 ไปเลย เพื่อให้มีค่า checkbox ขึ้น
  $s_vn_or_an = 'vn';
  $pttype_from_ovst_o_iptpttype = 'o.pttype';
  $colum_show_vst_or_dch = 'วันที่รับบริการ';
  $having_s =' HAVING uc_moneyx >0 ';
  
}elseif($pang_type=='IPD'){
  $pang_sql = "pang_ipd_sql.php";
  $s_date = "v.dchdate";
  $s_ipd_an = ',v.an AS an';
  $show_adjrw = 'o.rw AS rw';
  $s_vn_or_an = 'an';
  $pttype_from_ovst_o_iptpttype = 'ip.pttype';
  $colum_show_vst_or_dch = 'วันที่จำหน่าย';
  $having_s =' HAVING uc_moneyx >0 ';
}else{
}



if($pang_type=='IPD'){
  $columns = array( 
  // datatable column index  => database column name
    0 =>'hn',
    1 =>'hn',
    2 =>'hn',
    3 =>'vstdate',
    4 =>'check_sit_temp',
    5 =>'icd',
    6 =>'rw',
    7 =>'income',
    8 =>'uc_money',
    9 =>'paid_money'   
  );
}else{
  $columns = array( 
    // datatable column index  => database column name
      0 =>'pst.hn',
      1 =>'pst.hn',
      2 =>'pst.hn',
      3 =>'pst.vstdate',
      4 =>'check_sit_temp',
      5 =>'pttype_stamp',
      6 =>'pst.icd',
      7 =>'pst.income',
      8 =>'pst.uc_money',
      9 =>'pst.paid_money' 
  );
}

// getting total number records without any search
$sql = "SELECT pst.*,r.sss_approval_code
        ,IF(pst.pttype!=pst.check_sit_subinscl, CONCAT('z-',pst.pttype) , pst.pttype ) AS check_sit_temp
        ,tph.name AS pttype_name ,tph.pttype AS temp_pttype
        FROM pang_stamp_temp pst 
        LEFT JOIN temp_edc_401 r ON pst.vn=r.vn
        LEFT JOIN temp_pttype_hos tph ON pst.pttype=tph.pttype
        WHERE pst.pang_stamp = '$pang' AND pst.pang_stamp_check_date ='$date_now'
        AND pst.vstdate BETWEEN '$start_year' AND '$end_year'
        AND pst.hn IS NOT NULL ";
$query=mysqli_query($con_money, $sql) or die(nl2br ($sql)."employee-grid-data.php: get employees1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT pst.*,r.sss_approval_code
        ,IF(pst.pttype!=pst.check_sit_subinscl, CONCAT('z-',pst.pttype) , pst.pttype ) AS check_sit_temp
        ,tph.name AS pttype_name ,tph.pttype AS temp_pttype
        FROM pang_stamp_temp pst 
        LEFT JOIN temp_edc_401 r ON pst.vn=r.vn
        LEFT JOIN temp_pttype_hos tph ON pst.pttype=tph.pttype
        WHERE pst.pang_stamp = '$pang' AND pst.pang_stamp_check_date ='$date_now'
        AND pst.vstdate BETWEEN '$start_year' AND '$end_year'
        AND pst.hn IS NOT NULL ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( pst.hn LIKE '%".$requestData['search']['value']."%' ";    
	$sql.=" OR pst.hn LIKE '%".$requestData['search']['value']."%' )";
}
$query=mysqli_query($con_money, $sql) or die("employee-grid-data.php: get employees2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($con_money, $sql) or die("employee-grid-data.php: get employees3");

$data = array();
$no=1;
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $vn = $row["vn"];
  $view_income_vn_or_an = $row["$s_vn_or_an"];
  $uc_money = $row['uc_money'];
  $no++;
  $uc_money_kor_tok = $row['uc_money_kor_tok'];

	$nestedData=array();   


  if($row["pttype_stamp"]!='' && $uc_money!='' && $uc_money>0 ){
    $nestedData[] = '<input type="checkbox" name="vn[]" value="'.$view_income_vn_or_an.$uc_money.'|'.@$uc_money_kor_tok.'|'.@$row['rw'].'" ><input type="hidden" name="pang" value="'.$pang.'">';
  }else{
    $nestedData[] =null;
  }
  #check_box

  $nestedData[] =$no;

  #HN(การรักษา)
  $nestedData[] = '<button type="button" name="view_patient" class="btn mb-1 btn-secondary view_patient" id="'.$vn.'" >'.$row["hn"].'</button>';
  #HN(การรักษา)

  #วันที่รับบริการ
  $nestedData[] = DateThaisubmonth($row["vstdate"]);
  #วันที่รับบริการ

  #สิทธิส่งตรวจ
  #กรณีผัง 401 ให้แสดงข้อมูล EDC
  // if($pang=='1102050101.401'){
    //  $s_edc="SELECT sss_approval_code FROM rcpt_debt WHERE vn='$vn' LIMIT 1";
    //  $q_edc = mysqli_query($con_hos, $s_edc) or die("employee-grid-data.php: get employees4");
    //  $r_edc = mysqli_fetch_array($q_edc);
    //  $r_edc['sss_approval_code'];
     #$show_edc =' (EDC:'.$r_edc['sss_approval_code'].')';    
  // }else{
  //   $show_edc = null;
  // }

  if($row['pttype']!=$row['check_sit_subinscl']){
    $nestedData[] = '<button type="button" name="view_pttype" data-toggle="tooltip" title="'.$row["pttype_name"].'" class="btn mb-1 btn-danger view_pttype" id="'.$row["temp_pttype"].'" >'.$row["check_sit_temp"].'</button>'.@$row["sss_approval_code"].'<div class="tooltip">Hover over me
    <span class="tooltiptext">Tooltip text</span>
  </div>';  
  }else{
    $nestedData[] = '<button type="button" name="view_pttype" data-toggle="tooltip" title="'.$row["pttype_name"].'" class="btn mb-1 btn-success view_pttype" id="'.$row["temp_pttype"].'" >'.$row["check_sit_temp"].'</button>'.@$row["sss_approval_code"];  
  }    
  #สิทธิส่งตรวจ

  #สิทธิ สปสช (วันเริ่มสิทธิ)
  $nestedData[] =$row["pttype_stamp"];
  #สิทธิ สปสช (วันเริ่มสิทธิ)

  #ICD
  $nestedData[] = '<button type="button" name="view_choose_icd" class="btn btn-info view_choose_icd" id="'.$vn.'" >'.$row["icd"].'</button>';
  #ICD

  #RW IF IPD
  if($pang_type=='IPD'){
    if($row["rw"]==0){
      $nestedData[] = '<button type="button" class="btn btn-danger ">'.$row["rw"].'</button>';
    }elseif($row["rw"]>=2){
      $nestedData[] = '<button type="button" class="btn btn-success ">'.$row["rw"].'</button>';
    }else{
      $nestedData[] = $row["rw"]; 
    }
  }  
  #RW IF IPD       
  
  
  #ค่าใช้จ่ายทั้งหมด
  $nestedData[] = '<button type="button" name="view_income" class="btn btn-primary view_income" id="'.$view_income_vn_or_an.'" >'.number_format($row["income"],2).'</button>';
  #ค่าใช้จ่ายทั้งหมด

  #ค่าลูกหนี้ทั้งหมด
    ############# ข้อตกลง ##########################
    #ตรวจสอบว่าเงินลูกหนี้เป็นค่าว่างหรือไม่ ถ้าเป็นแสดงว่าไม่ได้กำหนดวงเงิน ในสิทธิ ipt_pttype เกิน 2 สิทธิ
    if($uc_money==''){
      $uc_money_show='<span class="label label-pill label-danger text-white">ตรวจสอบวงเงิน</span>';
    }elseif($uc_money<0){
      $uc_money_show='<span class="label label-pill label-warning ">'.number_format($uc_money,2).'</span>';
    }else{
      $uc_money_show=number_format($uc_money,2);
    }
    #ตรวจสอบว่าเงินลูกหนี้เป็นค่าว่างหรือไม่ ถ้าเป็นแสดงว่าไม่ได้กำหนดวงเงิน ในสิทธิ ipt_pttype เกิน 2 สิทธิ
                          
    if(isset($uc_money_kor_tok)){ ## if ตรวจสอบว่ามีการกำหนดข้อตกลงหรือไม่
      $nestedData[] = $uc_money_show."<span style='color:red;'>(".number_format($uc_money_kor_tok,2).")</span>";;
    }else{ ## if ตรวจสอบว่ามีการกำหนดข้อตกลงหรือไม่
      $nestedData[] = $uc_money_show;
    } ## else ตรวจสอบว่ามีการกำหนดข้อตกลงหรือไม่
    ############# ข้อตกลง ##########################
  #ค่าลูกหนี้ทั้งหมด

  #ยอดที่ชำระเอง
  $nestedData[] = number_format($row["paid_money"],2);
  #ยอดที่ชำระเอง
  
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









