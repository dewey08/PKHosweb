@extends('layouts.backend')



@section('content')
<script>
function checklogin(){
 window.location.href = '{{route("index")}}'; 
}
</script>
<?php

if(Auth::check()){
    $status = Auth::user()->status;
    $id_user = Auth::user()->PERSON_ID;   
}else{
    
    echo "<body onload=\"checklogin()\"></body>";
    exit();
} 

$url = Request::url();
$pos = strrpos($url, '/') + 1;
$user_id = substr($url, $pos); 


?>
<style>
        body {
            font-family: 'Kanit', sans-serif;
            font-size: 13px;
            }

            p {
                word-wrap:break-word;
                }
       
</style>
             
        <!-- Advanced Tables -->     
        <div class="bg-body-light">
                    <div class="content content-full">
                        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                            <h1 style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.3rem;font-weight:normal;">{{ $inforpersonuser -> HR_PREFIX_NAME }}   {{ $inforpersonuser -> HR_FNAME }}  {{ $inforpersonuser -> HR_LNAME }}</h1>
                            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="content">
                <div class="block block-rounded block-bordered">

                <div class="block-header block-header-default ">
                            <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>รายละเอียดข้อมูลบุคคล</B></h3>
                </div>

                <div class="block-content"> 
                <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;"><span style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลส่วนตัว&nbsp;&nbsp;</span></h2>   

                        <div class="row push">
                                <div class="col-lg-4">
                                       
                                        <div class="form-group">
                                       
                                        @if ( $inforpersonuser->HR_IMAGE == Null )
                                                <img src="{{asset('image/pers.png')}}" height="80%" width="60%"> 
                                        @else
                                                <img src="data:image/png;base64,{{ chunk_split(base64_encode($inforpersonuser->HR_IMAGE)) }}" height="80%" width="60%">
                                        @endif
                                
                                
                                </div>
                                                
                                  
                                </div>
                                <div class="col-lg-4">
                                       
                                      
                                                <div class="form">
                                                <div class="row">
                                                        <div class="col-lg-3">
                                                                <label>Username</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                                {{ $name_user }}
                                                        </div>
                                                        </div>
                                                        </div>  

                                                        <div class="form">
                                                                <div class="row">
                                                                <div class="col-lg-3">
                                                                        <label>คำนำหน้า</label>
                                                                </div>
                                                                <div class="col-lg-9">
                                                                        {{ $inforpersonuser -> HR_PREFIX_NAME }} 
                                                                </div>
                                                                </div>
                                                                </div>
                                                        <div class="form">   
                                                <div class="row">
                                                <div class="col-lg-3">
                                                        <label>ชื่อ</label>
                                                </div>
                                                <div class="col-lg-9">
                                                        {{ $inforpersonuser -> HR_FNAME }}
                                                </div>
                                                </div>
                                                </div>
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-3">
                                                        <label>นามสกุล</label>
                                                </div>
                                                <div class="col-lg-9">
                                                        {{ $inforpersonuser -> HR_LNAME }}
                                                </div>
                                                </div>
                                                </div>
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-3">
                                                        <label>ชื่ออังกฤษ</label>
                                                </div>
                                                <div class="col-lg-9">
                                                        {{ $inforpersonuser -> HR_EN_NAME }}
                                                </div>
                                                </div>
                                                </div>
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-3">
                                                        <label>ชื่อเล่น </label>
                                                </div>
                                                <div class="col-lg-9">
                                                        {{ $inforpersonuser -> NICKNAME }}
                                                </div>
                                                </div>
                                                </div>
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-3">
                                                        <label>วันเกิด </label>
                                                </div>
                                                <div class="col-lg-9">
                                                        {{ DateThai($inforpersonuser -> HR_BIRTHDAY) }}
                                                </div>
                                                </div>
                                                </div>
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-5">
                                                        <label>เลขประจำตัวประชาชน </label>
                                                </div>
                                                <div class="col-lg-7">
                                                        {{ $inforpersonuser -> HR_CID }}
                                                </div>
                                                </div>
                                                </div>
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-5">
                                                        <label>สถานะสมรส </label>
                                                </div>
                                                <div class="col-lg-7">
                                                        {{ $inforpersonuser -> HR_MARRY_STATUS_NAME }}
                                                </div>
                                                </div>
                                                </div>
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-5">
                                                        <label>ศาสนา </label>
                                                </div>
                                                <div class="col-lg-7">
                                                        {{ $inforpersonuser -> HR_RELIGION_NAME }}
                                                </div>
                                                </div>
                                                </div>

                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-4">
                                                        <label>Line Token</label>
                                                </div>
                                                <div class="col-lg-8">
                                                        {{ $inforpersonuser -> HR_LINE }}
                                                </div>
                                                </div>
                                                </div>
                                               
                                               
                                   
                                </div>
                                <div class="col-lg-4">
                                       
                                        <div class="form">
                                                <div class="row">
                                                <div class="col-lg-3">
                                                        <label>เชื้อชาติ </label>
                                                </div>
                                                <div class="col-lg-9">
                                                        {{ $inforpersonuser -> HR_NATIONALITY_NAME }}
                                                </div>
                                                </div>
                                                </div>
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-3">
                                                        <label>สัญชาติ </label>
                                                </div>
                                                <div class="col-lg-9">
                                                        {{ $inforpersonuser -> HR_CITIZENSHIP_NAME }}
                                                </div>
                                                </div>
                                                </div>
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-3">
                                                        <label>เพศ </label>
                                                </div>
                                                <div class="col-lg-9">
                                                        {{ $inforpersonuser -> SEX_NAME }}
                                                </div>
                                                </div>
                                                </div>
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-3">
                                                        <label>กรุ๊ปเลือด </label>
                                                </div>
                                                <div class="col-lg-9">
                                                        {{ $inforpersonuser -> HR_BLOODGROUP_NAME }}
                                                </div>
                                                </div>
                                                </div>
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-12">
                                                        <label>ส่วนสูง </label>
                                                        {{ $inforpersonuser -> HR_HIGH }}
                                                        <label>เซนติเมตร</label>
                                                        <label>น้ำหนัก </label>
                                                        {{ $inforpersonuser -> HR_WEIGHT }}
                                                        <label>กิโลกรัม</label>
                                                </div>
                                                </div>
                                                 <div class="form">
                                                 <div class="row">
                                                <div class="col-lg-3">
                                                        <label>เบอร์โทร </label>
                                                </div>
                                                <div class="col-lg-9">
                                                        {{ $inforpersonuser -> HR_PHONE }}
                                                </div>
                                                </div>
                                                </div>
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-3">
                                                        <label>อีเมล </label>
                                                </div>
                                                <div class="col-lg-9">
                                                        {{ $inforpersonuser -> HR_EMAIL  }}
                                                </div>
                                                </div>
                                                </div>
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-3">
                                                        <label>Facebook </label>
                                                </div>
                                                <div class="col-lg-9">
                                                        <p>{{ $inforpersonuser -> HR_FACEBOOK }}</p>
                                                </div>
                                                </div>
                                                </div>
                                               
                                      
                                </div>

                        </div>
                        
                </div>
               
              
                      
                <div class="block-content">  
                <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;"><span style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลอาชีพ&nbsp;&nbsp;</span></h2>     
                        <div class="row push">
                                <div class="col-lg-4">
                                        <form role="form">
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-4">
                                                        <label>กลุ่มงาน </label>
                                                </div>
                                                <div class="col-lg-8">
                                                        {{ $inforpersonuser -> HR_DEPARTMENT_NAME }}
                                                </div>
                                                </div>
                                                </div>
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-4">
                                                        <label>ฝ่าย/แผนก </label>
                                                </div>
                                                <div class="col-lg-8">
                                                        {{ $inforpersonuser -> HR_DEPARTMENT_SUB_NAME }}
                                                </div>
                                                </div>
                                                </div>
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-4">
                                                        <label>หน่วยงาน </label>
                                                </div>
                                                <div class="col-lg-8">
                                                        {{$inforpersonuser -> HR_DEPARTMENT_SUB_SUB_NAME }}
                                                </div>
                                                </div>
                                                </div>
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-4">
                                                        <label>วันที่บรรจุ </label>
                                                </div>
                                                <div class="col-lg-8">
                                                        {{DateThai($inforpersonuser -> HR_STARTWORK_DATE)}}
                                                </div>
                                                </div>
                                                </div>
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-4">
                                                        <label>เลขตำแหน่ง </label>
                                                </div>
                                                <div class="col-lg-8">
                                                        {{ $inforpersonuser -> HR_POSITION_NUM }}
                                                </div>
                                                </div>
                                                </div>   
                                        </form>
                                </div>
                                <div class="col-lg-4">
                                        <form role="form">
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-5">
                                                        <label>เลขใบประกอบวิชาชีพ </label>
                                                </div>
                                                <div class="col-lg-7">
                                                        {{ $inforpersonuser -> VCODE }}
                                                </div>
                                                </div>
                                                </div> 
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-5">
                                                        <label>วดป.รับใบประกอบ </label>
                                                </div>
                                                <div class="col-lg-7">
                                                        {{ DateThai($inforpersonuser -> VCODE_DATE) }}
                                                </div>
                                                </div>
                                                </div> 
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-4">
                                                        <label>ตำแหน่ง </label>
                                                </div>
                                                <div class="col-lg-8">
                                                        {{ $inforpersonuser -> POSITION_IN_WORK }}
                                                </div>
                                                </div>
                                                </div> 
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-4">
                                                        <label>ระดับ </label>
                                                </div>
                                                <div class="col-lg-8">
                                                        {{ $inforpersonuser -> HR_LEVEL_NAME}}
                                                </div>
                                                </div>
                                                </div> 
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-4">
                                                        <label>สถานะปัจจุบัน </label>
                                                </div>
                                                <div class="col-lg-8">
                                                        {{ $inforpersonuser -> HR_STATUS_NAME }}
                                                </div>
                                                </div>
                                                </div> 
                                               
                                        </form>
                                </div>
                                <div class="col-lg-4">
                                        <form role="form">
                                                <div class="form">
                                                <div class="row">
                                                <div class="col-lg-5">
                                                        <label>กลุ่มข้าราชการ </label>
                                                </div>
                                                <div class="col-lg-7">
                                                        {{ $inforpersonuser -> HR_KIND_NAME }}
                                                </div>
                                                </div>
                                                </div>
                                        <div class="form">
                                                <div class="row">
                                                <div class="col-lg-5">
                                                        <label>ประเภทข้าราชการ </label>
                                                </div>
                                                <div class="col-lg-7">
                                                        {{ $inforpersonuser -> HR_KIND_TYPE_NAME }}
                                                </div>
                                                </div>
                                                </div>
                                        <div class="form">
                                                <div class="row">
                                                <div class="col-lg-5">
                                                        <label>กลุ่มบุคลากร </label>
                                                </div>
                                                <div class="col-lg-7">
                                                        {{ $inforpersonuser -> HR_PERSON_TYPE_NAME }}
                                                </div>
                                                </div>
                                                </div>
                                        <div class="form">
                                                <div class="row">
                                                <div class="col-lg-5">
                                                        <label>ต้นสังกัด </label>
                                                </div>
                                                <div class="col-lg-7">
                                                        {{ $inforpersonuser -> HR_AGENCY_ID }}
                                        
                                                </div>
                                                </div> 
                                                </div>
                                        <div class="form">
                                                <div class="row">
                                                <div class="col-lg-5">
                                                        <label>เงินเดือน</label> 
                                                </div>
                                                <div class="col-lg-7">
                                                        {{ number_format($inforpersonuser -> HR_SALARY,2) }}
                                                        <label>บาท</label>
                                                </div>
                                                </div> 
                                                </div>          
                                        <div class="form">
                                                <div class="row">
                                                <div class="col-lg-5">
                                                        <label>เงินประจำตำแหน่ง</label> 
                                                </div>
                                                <div class="col-lg-7">
                                                        {{ number_format($inforpersonuser -> MONEY_POSITION,2) }}
                                                        <label>บาท</label> 
                                                </div>
                                                </div> 
                                                </div>             
                                        </form>
                                </div>
                        </div>

                </div>
               

                        <div class="block-content">   
                        <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;"><span style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลที่อยู่อาศัยปัจจุบัน&nbsp;&nbsp;</span></h2>     
                        <div class="row">

                                <div class="col-lg-3">
                                        <div class="form">
                                        <div class="row">
                                        <div class="col-lg-4"> 
                                        <label>บ้านเลขที่ </label>
                                        </div>
                                        <div class="col-lg-8"> 
                                        {{ $inforpersonuser ->HR_HOME_NUMBER  }}
                                        </div>
                                        </div>
                                        </div>
                                        <div class="form">
                                        <div class="row">
                                        <div class="col-lg-4"> 
                                        <label>ตำบล </label>
                                        </div>
                                        <div class="col-lg-8"> 
                                         {{ $inforpersonuser -> TUMBON_NAME }}
                                        </div>
                                        </div>
                                        </div>
                                       
                                </div>
                                <div class="col-lg-3">
                                        <div class="form">
                                        <div class="row">
                                        <div class="col-lg-4"> 
                                        <label>หมู่ที่ </label>
                                        </div>
                                        <div class="col-lg-8"> 
                                        {{ $inforpersonuser ->HR_VILLAGE_NO  }}
                                        </div>
                                        </div>
                                        </div>
                                        <div class="form">
                                        <div class="row">
                                        <div class="col-lg-4"> 
                                        <label>อำเภอ </label>
                                        </div>
                                        <div class="col-lg-8"> 
                                        {{ $inforpersonuser -> AMPHUR_NAME }}
                                        </div>
                                        </div>
                                        </div>
                                       
                                </div>
                                <div class="col-lg-3">
                                        <div class="form">
                                        <div class="row">
                                        <div class="col-lg-4"> 
                                        <label>ถนน </label>
                                        </div>
                                        <div class="col-lg-8"> 
                                        {{  $inforpersonuser -> HR_ROAD_NAME }}
                                        </div>
                                        </div>
                                        </div>
                                        <div class="form">
                                        <div class="row">
                                        <div class="col-lg-4"> 
                                        <label>จังหวัด </label>
                                        </div>
                                        <div class="col-lg-8"> 
                                        {{ $inforpersonuser -> PROVINCE_NAME }}
                                        </div>
                                        </div>
                                        </div>
                                       
                                </div>
                                <div class="col-lg-3">
                                        <div class="form">
                                        <div class="row">
                                        <div class="col-lg-4"> 
                                        <label>ซอย </label>
                                        </div>
                                        <div class="col-lg-8"> 
                                        {{ $inforpersonuser -> HR_SOI_NAME }}
                                        </div>
                                        </div>
                                        </div>
                                        <div class="form">
                                        <div class="row">
                                        <div class="col-lg-5"> 
                                        <label>รหัสไปรษณีย์ </label>
                                        </div>
                                        <div class="col-lg-7"> 
                                        {{ $inforpersonuser -> HR_ZIPCODE }}
                                        </div>
                                        </div>
                                        </div>
                                       
                                </div>
                        </div> 
                        </div>
                      

                <div class="block-content">   
                <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;"><span style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลที่อยู่อาศัยตามทะเบียนบ้าน&nbsp;&nbsp;</span></h2>      
                        <div class="row push">

                                <div class="col-lg-3">
                                        <div class="form">
                                        <div class="row">
                                        <div class="col-lg-4"> 
                                        <label>บ้านเลขที่ </label>
                                        </div>
                                        <div class="col-lg-8"> 
                                        {{ $inforpersonuser -> HR_HOME_NUMBER_1 }}
                                        </div>
                                        </div>
                                        </div>
                                        <div class="form">
                                        <div class="row">
                                        <div class="col-lg-4"> 
                                        <label>ตำบล </label>
                                        </div>
                                        <div class="col-lg-8"> 
                                         {{ $inforadd2 -> TUMBON_NAME }}
                                         </div>
                                         </div>
                                         </div>
                                       
                                </div>
                                <div class="col-lg-3">
                                        <div class="form">
                                        <div class="row">
                                        <div class="col-lg-4"> 
                                        <label>หมู่ที่ </label>
                                        </div>
                                        <div class="col-lg-8"> 
                                        {{ $inforpersonuser -> HR_VILLAGE_NO_1 }}
                                        </div>
                                         </div>
                                         </div>
                                        <div class="form">
                                        <div class="row">
                                        <div class="col-lg-4"> 
                                        <label>อำเภอ </label>
                                        </div>
                                        <div class="col-lg-8"> 
                                        {{ $inforadd2 -> AMPHUR_NAME }}
                                        </div>
                                        </div>
                                        </div>
                                       
                                </div>
                                <div class="col-lg-3">
                                        <div class="form">
                                        <div class="row">
                                        <div class="col-lg-4"> 
                                        <label>ถนน </label>
                                        </div>
                                        <div class="col-lg-8"> 
                                        {{  $inforpersonuser -> HR_ROAD_NAME_1 }}
                                        </div>
                                        </div>
                                        </div>
                                        <div class="form">
                                        <div class="row">
                                        <div class="col-lg-4"> 
                                        <label>จังหวัด </label>
                                        </div>
                                        <div class="col-lg-8"> 
                                        {{ $inforadd2 -> PROVINCE_NAME }}
                                        </div>
                                        </div>
                                        </div>
                                       
                                </div>
                                <div class="col-lg-3">
                                        <div class="form">
                                        <div class="row">
                                        <div class="col-lg-4"> 
                                        <label>ซอย </label>
                                        </div>
                                        <div class="col-lg-8"> 
                                        {{ $inforpersonuser -> HR_SOI_NAME_1 }}
                                        </div>
                                        </div>
                                        </div>
                                        <div class="form">
                                        <div class="row">
                                        <div class="col-lg-5"> 
                                        <label>รหัสไปรษณีย์ </label>
                                        </div>
                                        <div class="col-lg-7"> 
                                        {{ $inforpersonuser -> HR_ZIPCODE_1 }}
                                        </div>
                                        </div>
                                        </div>
                                       
                                </div>
                        </div> 
                        </div>
                      

                        <div class="block-content">  
                        <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;"><span style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลบัญชีธนาคาร&nbsp;&nbsp;</span></h2>    
                        <div class="row">
                                <div class="col-lg-4">
                                        <form role="form">
                                                <div class="form">
                                            
                                                        <label>เงินค่าตอบแทน </label>
                                                </div>
                                                 <div class="form">
                                                        <div class="row">
                                                        <div class="col-lg-5"> 
                                                        <label>เลขบัญชีธนาคาร </label>
                                                        </div>
                                                        <div class="col-lg-7"> 
                                                        {{ $inforpersonuser -> BOOK_BANK_NUMBER }}
                                                </div>
                                                </div>
                                                </div>
                                                <div class="form">
                                                        <div class="row">
                                                        <div class="col-lg-5"> 
                                                        <label>ชื่อบัญชีธนาคาร </label>
                                                        </div>
                                                        <div class="col-lg-7"> 
                                                        {{ $inforpersonuser -> BOOK_BANK_NAME }}
                                                        </div>
                                                        </div>
                                                        </div>
                                                <div class="form">
                                                        <div class="row">
                                                        <div class="col-lg-5"> 
                                                        <label>ธนาคาร </label>
                                                        </div>
                                                        <div class="col-lg-7"> 
                                                        {{ $inforpersonuser -> BOOK_BANK }}
                                                        </div>
                                                        </div>
                                                        </div>
                                                <div class="form">
                                                        <div class="row">
                                                        <div class="col-lg-5"> 
                                                        <label>สาขา </label>
                                                        </div>
                                                        <div class="col-lg-7"> 
                                                        {{ $inforpersonuser -> BOOK_BANK_BRANCH }}
                                                        </div>
                                                        </div>
                                                        </div>
                                        </form>
                                </div>
                                <div class="col-lg-4">
                                        <form role="form">
                                                <div class="form">
                                                        <label>เงินค่าตอบแทน OT</label>
                                                </div>
                                                <div class="form">
                                                        <div class="row">
                                                        <div class="col-lg-5"> 
                                                        <label>เลขบัญชีธนาคาร </label>
                                                        </div>
                                                        <div class="col-lg-7"> 
                                                        {{ $inforpersonuser -> BOOK_BANK_OT_NUMBER }}
                                                        </div>
                                                        </div>
                                                        </div>
                                                <div class="form">
                                                        <div class="row">
                                                        <div class="col-lg-5"> 
                                                        <label>ชื่อบัญชีธนาคาร </label>
                                                        </div>
                                                        <div class="col-lg-7"> 
                                                        {{ $inforpersonuser -> BOOK_BANK_OT_NAME }}
                                                        </div>
                                                        </div>
                                                        </div>
                                                <div class="form">
                                                        <div class="row">
                                                        <div class="col-lg-5"> 
                                                        <label>ธนาคาร </label>
                                                        </div>
                                                        <div class="col-lg-7"> 
                                                        {{ $inforpersonuser -> BOOK_BANK_OT }}
                                                        </div>
                                                        </div>
                                                        </div>
                                                <div class="form">
                                                        <div class="row">
                                                        <div class="col-lg-5"> 
                                                        <label>สาขา </label>
                                                        </div>
                                                        <div class="col-lg-7"> 
                                                        {{ $inforpersonuser -> BOOK_BANK_OT_BRANCH }}
                                                        </div>
                                                        </div>
                                                        </div>
                                                
                                        </form>
                                </div>
                                                <div class="col-lg-4">
                                       
                                                </div>
                        </div> 
                       
            
                       <div align="right"><a href="{{ url('person/personinfouser/edit/'.$userid -> ID)}}"  class="btn btn-hero-sm btn-hero-warning" ><i class="fas fa-edit"></i> &nbsp;แก้ไขข้อมูล</a></div><br>   
                   </div>
                   </div>       
                </div>                                        
       
       
               
                       </div>
                   </div>
               </div>
           </div>
          
       </div>
                  
      
                      
       </main>
@endsection

@section('footer')

<script src="{{ asset('datepicker/bootstrap-3.3.7-dist/js/bootstrap.js') }}"></script>
@endsection