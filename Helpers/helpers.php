<?php
use App\Models\Person;
use App\Models\Org;
use Illuminate\Support\Facades\DB;
//เมื่อมีการเพิ่ม Function ใหม่ให้สั้ง composer dump-autoload

function getDateTimeDiff($date){
    $now_timestamp     = strtotime(date('Y-m-d H:i:s'));
    $diff_timestamp    =$now_timestamp - strtotime($date);

    if ($diff_timestamp < 60) {
        return 'few seconds ago';
    } else if ($diff_timestamp >= 60 && $diff_timestamp < 3600) {
        return round($diff_timestamp / 60). 'min ago';
    } else if ($diff_timestamp >= 3600 && $diff_timestamp < 86400) {
        return round($diff_timestamp / 3600). 'hours ago';
    } else if ($diff_timestamp >= 86400 && $diff_timestamp < (86400 *30)) {
        return round($diff_timestamp / 86400). 'days ago';

    } else if ($diff_timestamp >= (86400 *30) && $diff_timestamp < (86400 *365)) {
        return round($diff_timestamp / (86400 *30)). 'months ago';     
    } else {
        return round($diff_timestamp / (86400 *365)). 'years ago';
    }
    
  
}

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }

    return $bytes;
}


//สร้าง File PDF
function viewPdf($html){
    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];
    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

   $mpdf = new \Mpdf\Mpdf([
       'fontDir' => array_merge($fontDirs, [ public_path('fonts/'),]),
       // ตจั้งค่า Fonts
       'fontdata' => $fontData + [
           'sarabun_new' => [
           'R' => 'THSarabunNew.ttf',
           'I' => 'THSarabunNew Italic.ttf',
           'B' => 'THSarabunNew Bold.ttf',
           ],
       ],
       'default_font' => 'sarabun_new',
       ]);
       $stylesheet1 = public_path('css/pdf.css'); // external css
    //    $mpdf->WriteHTML($stylesheet,1);
       $stylesheet = file_get_contents($stylesheet1); // external css
       $mpdf->WriteHTML($stylesheet,1);
       $mpdf->WriteHTML($html);
       $mpdf->Output();
       return $mpdf->Output();
}



function thainumDigit($num){
    return str_replace(array( '0' , '1' , '2' , '3' , '4' , '5' , '6' ,'7' , '8' , '9' ),array( "o" , "๑" , "๒" , "๓" , "๔" , "๕" , "๖" , "๗" , "๘" , "๙" ),$num);
}

function convert($number){ 
    $txtnum1 = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ'); 
    $txtnum2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน'); 
    $number = str_replace(",","",$number); 
    $number = str_replace(" ","",$number); 
    $number = str_replace("บาท","",$number); 
    $number = explode(".",$number); 
    if(sizeof($number)>2){ 
    return ''; 
    exit; 
    } 
    $strlen = strlen($number[0]); 
    $convert = ''; 
    for($i=0;$i<$strlen;$i++){ 
        $n = substr($number[0], $i,1); 
        if($n!=0){ 
            if($i==($strlen-1) AND $n==1){ $convert .= 'เอ็ด'; } 
            elseif($i==($strlen-2) AND $n==2){  $convert .= 'ยี่'; } 
            elseif($i==($strlen-2) AND $n==1){ $convert .= ''; } 
            else{ $convert .= $txtnum1[$n]; } 
            $convert .= $txtnum2[$strlen-$i-1]; 
        } 
    } 
    
    $convert .= 'บาท'; 
    if($number[1]=='0' OR $number[1]=='00' OR 
    $number[1]==''){ 
    $convert .= 'ถ้วน'; 
    }else{ 
    $strlen = strlen($number[1]); 
    for($i=0;$i<$strlen;$i++){ 
    $n = substr($number[1], $i,1); 
        if($n!=0){ 
        if($i==($strlen-1) AND $n==1){$convert 
        .= 'เอ็ด';} 
        elseif($i==($strlen-2) AND 
        $n==2){$convert .= 'ยี่';} 
        elseif($i==($strlen-2) AND 
        $n==1){$convert .= '';} 
        else{ $convert .= $txtnum1[$n];} 
        $convert .= $txtnum2[$strlen-$i-1]; 
        } 
    } 
    $convert .= 'สตางค์'; 
    } 
    return $convert; 
    } 

// Format Display วันที่
function formate($strDate)
    {
    if($strDate == '' || $strDate == null || $strDate == '0000-00-00'){

        $date = '';

    }else{

        $strYear = date("Y",strtotime($strDate));
        $strMonth= date("m",strtotime($strDate));
        $strDay= date("d",strtotime($strDate));
        $date = $strDay."/".$strMonth."/".$strYear;
    }
    
    return $date;

    }
    

    function formatetime($strtime)
    {
    $H = substr($strtime, 0, 5);
    return $H;
    }
// รับค่าปีงบประมาณปัจจุบัน
function getBudgetYear()
{
    if(date('m') > 9){
        $year = date('Y') + 544;        
    }else{
        $year = date('Y') + 543;        
    }
    return $year;
}
//รับค่าปีจาก ปีปัจจุบัน ย้อนหลังไป ตามที่กำหนด(ปี) ค่าเริ่มต้น 10 ปี
function getYearAmount($amontbefore = 10)
{
    $year = date('Y') + 543;
    for($i = $year ;$i > $year - $amontbefore; $i--){
        $year_result[$i] = $i;
    } 
    return $year_result;
}
//รับค่าปีจาก ปีงบประมาณปัจจุบัน ย้อนหลังไป ตามที่กำหนด(ปี) ค่าเริ่มต้น 10 ปี เพิ่มทั้งหมด
function getBudgetYearAmount_all($amontbefore = 10)
{
    $yearbudget = getBudgetYear();
    $year['all'] = 'ทั้งหมด';
    for($i = $yearbudget ;$i > $yearbudget - $amontbefore; $i--){
        $year[$i] = $i;
    } 
    return $year;
}
//รับค่าปีจาก ปีงบประมาณปัจจุบัน ย้อนหลังไป ตามที่กำหนด(ปี) ค่าเริ่มต้น 10 ปี
function getBudgetYearAmount($amontbefore = 10)
{
    $yearbudget = getBudgetYear();
    for($i = $yearbudget ;$i > $yearbudget - $amontbefore; $i--){
        $year[$i] = $i;
    } 
    return $year;
}
// คำนวนอายุ Y-m-d
function getAge($birthday) 
{
    $then = strtotime($birthday);
    return(floor((time()-$then)/31556926));
}

function dateThaifromFull($strDate)
    {
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("j",strtotime($strDate));

    $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤษจิกายน","ธันวาคม");
    $strMonthThai=$strMonthCut[$strMonth];
    return $strDay.' '.$strMonthThai.'  พ.ศ. '.$strYear;
    }

function shortMonthThai($month)
{
    $month = (int)$month;
    $strMonthCut    = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    return !empty($strMonthCut[$month])?$strMonthCut[$month]:'';
}
// แปลงวันที่ภาษาไทย
function DateThai($strDate)
{
    if($strDate == '' || $strDate == null || $strDate == '0000-00-00'){
        $datethai = '';
    }else{
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        $datethai = $strDate ? ($strDay.' '.$strMonthThai.' '.$strYear) : '-';
    }
    return $datethai;
}

function DatetimeThai($strDate)
{
    if($strDate == '' || $strDate == null || $strDate == '0000-00-00 00:00:00'){
        $datethai = '-';
    }else{
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strTime = date("H:i:s น.",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        $datethai = $strDate ? ($strDay.' '.$strMonthThai.' '.$strYear .' '.$strTime) : '-';
    }
    return $datethai;
}
function DatetimeThainew($strDate)
{
    if($strDate == '' || $strDate == null || $strDate == '0000-00-00 00:00:00'){
        $datethai = '-';
    }else{
        $strYear = date("Y",strtotime($strDate));
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strTime = date("H:i:s",strtotime($strDate));
        // $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        // $strMonthThai=$strMonthCut[$strMonth];
        $datethai = $strDate ? ($strYear.'-'.$strMonth.'-'.$strDay .'-'.$strTime) : '-';
    }
    return $datethai;
}

//แปลง พ.ศ เป็น ค.ศ ลง  Database
  function DateThaiToEn($date)
{
    $strDate =  explode("/", $date);
    $strYear = ($strDate[2]) - 543;
    $strMonth= $strDate[1];
    $strDay= $strDate[0];

    return $strDate ? $strYear.'-'.$strMonth.'-'.$strDay : null;
  }

  function DateEnToThai($date)
  {
      if($date){
          $strDate =  explode("-", $date);
          $strYear = ($strDate[0]) + 543;
          $strMonth = $strDate[1];
          $strDay= $strDate[2];
          
          return $strDay.'/'.$strMonth.'/'.$strYear;
        // return '10/20/2563';
        }else{
            return false;
        }
    }
    // covert datepicker พ.ศ. => ค.ศ.
    function pickerThToEn($date){
        if(!empty($date)){
            $strDate    =  explode("/", $date);
            $strDay     = $strDate[0];
            $strMonth   = $strDate[1];
            $strYear    = $strDate[2];
            if($strYear > 2500){
                $strYear -= 543;
            }
            return $strDay.'/'.$strMonth.'/'.$strYear;
          }else{
            return '';
          }
    }
    //แปลง Thai date to en date แต่ต้องเช็คก่อนว่าเป็น year thai หรือไม่
    function CheckDatethaiParse($date){
        if($date){
            $strDate    =  explode("/", $date);
            $strDay     = $strDate[0];
            $strMonth   = $strDate[1];
            $strYear    = $strDate[2];
            if($strYear > 2500){
                $strYear -= 543;
            }
            return $strYear.'-'.$strMonth.'-'.$strDay;
          }else{
            return false;
          }
    }
    //แปลงใส่ Datepicker 
    function toDatePicker($date)
    {
        if($date){
            $strDate =  explode("-", $date);
            $strYear = $strDate[0];
            $strMonth = $strDate[1];
            $strDay= $strDate[2];
            
            return $strDay.'/'.$strMonth.'/'.$strYear;
          }else{
              return false;
          }
      }
      
      function datepickerTodate($date)
      {
        if($date){
            $strDate =  explode("/", $date);
            $strDay= $strDate[0];
            $strMonth = $strDate[1];
            $strYear = $strDate[2];
            
            return $strYear.'-'.$strMonth.'-'.$strDay;
          }else{
            return false;
          }
      }
      
function DateThairetire($strDate)
{

  $strMonth= date("n",strtotime($strDate));
  if($strMonth  > 9){
    $strYear = date("Y",strtotime($strDate))+543+61;
  }else{
    $strYear = date("Y",strtotime($strDate))+543+60;
  }

  return "30 ก.ย. $strYear";
}


function getAgeretire($birthday) {
  $then = strtotime($birthday);

  return(60-(floor((time()-$then)/31556926)));
}


    // ดึงชื่อและนามสกุลผู้ใช้งานระบบ
    function userInfo(){
        $id = Auth::user()->PERSON_ID;
        $model =  Person::where('ID','=',$id)->first();
        return $model->HR_PREFIX_NAME.' '.$model->HR_FNAME.' '.$model->HR_LNAME;

    }

function Infohostname(){
    $namehos = DB::table('info_org')->where('ORG_ID','=',1)->first();
   
    return $module;
}

function json_encode_u($variable)
{
    return json_encode($variable , JSON_UNESCAPED_UNICODE);
}
