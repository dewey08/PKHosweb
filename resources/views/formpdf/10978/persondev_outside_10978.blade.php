
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>    
        <style>
                @font-face {
                    font-family: 'THSarabunNew';
                    src: url('fonts/thsarabunnew-webfont.eot');
                    src: url('fonts/thsarabunnew-webfont.eot?#iefix') format('embedded-opentype'),
                        url('fonts/thsarabunnew-webfont.woff') format('woff'),
                        url('fonts/thsarabunnew-webfont.ttf') format('truetype');
                    font-weight: normal;
                    font-style: normal;
                }        
                @font-face {
                    font-family: 'THSarabunNew';
                    src: url('fonts/thsarabunnew_bolditalic-webfont.eot');
                    src: url('fonts/thsarabunnew_bolditalic-webfont.eot?#iefix') format('embedded-opentype'),
                        url('fonts/thsarabunnew_bolditalic-webfont.woff') format('woff'),
                        url('fonts/thsarabunnew_bolditalic-webfont.ttf') format('truetype');
                    font-weight: bold;
                    font-style: italic;
                }
                @font-face {
                    font-family: 'THSarabunNew';
                    src: url('fonts/thsarabunnew_italic-webfont.eot');
                    src: url('fonts/thsarabunnew_italic-webfont.eot?#iefix') format('embedded-opentype'),
                        url('fonts/thsarabunnew_italic-webfont.woff') format('woff'),
                        url('fonts/thsarabunnew_italic-webfont.ttf') format('truetype');
                    font-weight: normal;
                    font-style: italic;
                }
                @font-face {
                    font-family: 'THSarabunNew';
                    src: url('fonts/thsarabunnew_bold-webfont.eot');
                    src: url('fonts/thsarabunnew_bold-webfont.eot?#iefix') format('embedded-opentype'),
                        url('fonts/thsarabunnew_bold-webfont.woff') format('woff'),
                        url('fonts/thsarabunnew_bold-webfont.ttf') format('truetype');
                    font-weight: bold;
                    font-style: normal;
                } 
                @page {
                        margin: 0cm 0cm;
                            }
                body {
                    /* font-family: 'THSarabunNew', sans-serif;
                        font-size: 13px;
                    line-height: 0.9;  
                    margin-top:    0.2cm;
                    margin-bottom: 0.2cm;
                    margin-left:   1cm;
                    margin-right:  1cm;  */
                    font-family: "THSarabunNew";
                    font-size: 13px;
                    line-height: 0.8;  
                    margin-top:    0.2cm;
                    margin-bottom: 0.2cm;
                    margin-left:   2cm;
                    margin-right:  1.5cm;                     
                }
                #watermark {     
                    position: fixed;
                            bottom:   0px;
                            left:     0px;                   
                            width:    29.5cm;
                            height:   21cm;
                            z-index:  -1000;
                }
                table,td {
                    /* border: 1px solid rgb(255, 255, 255); */
                    }   
                    .text-pedding{
                    /* padding-left:10px;
                    padding-right:10px; */
                    }                     
                    table{
                        border-collapse: collapse;  //กรอบด้านในหายไป
                    }
                    table.one{
                    border: 0.2px solid rgb(5, 5, 5);
                    /* height: 800px; */
                    /* padding: 15px; */
                    }
                    td {
                        margin: .2rem;
                    /* height: 3px; */
                    /* padding: 5px; */
                    /* text-align: left; */
                    }
                    td.o{
                        border: 0.2px solid rgb(5, 5, 5); 
                    }
                    td.b{
                        border: 0.2px solid rgb(255, 255, 255); 
                    }
                    td.d{
                        border: 0.2px solid rgb(5, 5, 5); 
                        height: 170px;
                    }
                    td.e{
                        border: 0.2px solid rgb(255, 255, 255);
                        
                    }
                    td.h{
                        border: 0.2px solid rgb(5, 5, 5); 
                        height: 10px;
                    }
                    .page-break {
                        page-break-after: always;
                    } 
                    
                    input {
                        margin: .3rem;
                    }
            
                         
        </style> 
        
        <?php    
           function caldate($displaydate_end,$displaydate_bigen){ 
                $sumdate = round(abs(strtotime($displaydate_end) - strtotime($displaydate_bigen))/60/60/24)+1;
                return thainumDigit($sumdate); 
                } 

                function DateThaifrom($strDate)
                    {
                            $strYear = date("Y",strtotime($strDate))+543;
                            $strMonth= date("n",strtotime($strDate));
                            $strDay= date("j",strtotime($strDate));

                            $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
                            $strMonthThai=$strMonthCut[$strMonth];
                        return thainumDigit($strDay.' '.$strMonthThai.'  พ.ศ. '.$strYear);
                    }
                    function timefrom($strtime)
                    {
                            $time = substr($strtime,0,5);
                            
                        return thainumDigit($time);
                    }
                    $date = date('Y-m-d');
        ?>    
    </head>
<body>
<br>
<table width="100%">        
    <tr>
      <td rowspan="2" width = "10%">
           <img src="image/Garuda.png" width="50" height="50"> 
      </td>
      <td colspan="5" width = "80%">        
    </td>
      <td colspan="2" rowspan="2" width = "10%">       
      </td>
    </tr>
    <tr>
      <td colspan="1" > <label for="" style="font-size: 19px"><b></b></label> </td>   
      <td colspan="4" > <label for="" style="font-size: 22px"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บันทึกข้อความ</b></label></td>  
    </tr> 
               
</table>
<table  width="100%">
    <tr>
        <td width="10%"><label for="" style="font-size: 14px">ส่วนราชการ </label> </td>
        <td width="90%"><label for="" style="font-size: 13px">&nbsp;&nbsp;&nbsp;{{$infoorg->ORG_NAME}} &nbsp;&nbsp;{{thainumDigit($infoorg->ORG_PHONE)}}</label> </td>      
    </tr>       
</table> 
<table  width="100%">
    <tr>
        @if ($hrddepartment->BOOK_NUM == '')
            <td width="30%"><label for="" style="font-size: 14px">ที่&nbsp;..............................................................</label> </td>   
        @else
            <td width="30%"><label for="" style="font-size: 14px">ที่ &nbsp;{{thainumDigit($hrddepartment->BOOK_NUM.''                )}}</label> </td> 
        @endif   
        <td width="70%"><label for="" style="font-size: 14px">วันที่&nbsp;&nbsp;{{DateThaifrom(date('Y-m-d'))}}</label> </td>          
    </tr> 
</table> 
<table  width="100%">   
    <tr>
        <td width="100%"><label for="" style="font-size: 14px">เรื่อง &nbsp;ขออนุมัติเข้าร่วมประชุม/อบรม/สัมมนาและขออนุญาตเดินทางไปราชการ</label> </td>       
    </tr>      
</table>
<table  width="100%">   
    <tr height="5px">
        <td width="20%"></td> 
        <td width="60%">----------------------------------------------------------------------------</td> 
        <td width="20%"></td>       
    </tr>      
</table>


<label for="">  เรียน ผู้ว่าราชการจังหวัด{{thainumDigit($infoorg->PROVINCE)}}</label> <br>
<table width="100%">
    <?php $num = 0; ?>
        @foreach ($index_persons as $index_person)  
            <?php $num++; ?>
                <tr>
                    <td style="width: 7%">&nbsp;</td>
                    @if($num == '1' && $check != '1')
                    <td style="width: 43%">ด้วยข้าพเจ้า&nbsp;{{$index_person->HR_FULLNAME}}</td>
                    @else
                    <td style="width: 43%">ด้วยข้าพเจ้า&nbsp;{{$index_person->HR_FULLNAME}}</td>
                    @endif

                    <td style="width: 6%">ตำแหน่ง&nbsp;</td>                
                    @if($num == '1'  && $check != '1')
                    <td style="width: 39%">{{$index_person->HR_POSITION}}{{$index_person->HR_LAVEL}} พร้อมด้วย</td>
                    @else
                    <td style="width: 39%">{{$index_person->HR_POSITION}}{{$index_person->HR_LAVEL}}</td>
                    @endif
                </tr>
                {{-- <tr height="5px">
                    <td width="5%">หน่วยงาน</td> 
                    <td width="50%">{{$index_person->HR_DEPARTMENT_SUB_SUB_NAME}}</td> 
                    <td width="5%">พร้อมกับ</td>   
                    <td width="40%">.......................................................................</td>     
                </tr> --}}
        @endforeach  
</table>
<table  width="100%">  
    <?php $num = 0; ?>
    @foreach ($index_persons as $index_per)  
        <?php $num++; ?> 
            <tr height="5px">
                <td width="5%">หน่วยงาน&nbsp;</td> 
                <td width="35%">{{$index_per->HR_DEPARTMENT_SUB_SUB_NAME}}</td> 
                <td width="5%">พร้อมกับ&nbsp;</td>   
                <td width="55%">..................................................................................</td>     
            </tr>  
    @endforeach     
</table>
<table  width="100%">     
    <tr height="5px"> 
        <td width="100%">มีความประสงค์ขออนุมัติเข้าร่วมประชุม/อบรม/สัมนา พร้อมขออนุญาตเดินทางไปราชการ เพื่อเข้าร่วมประชุม</td>           
    </tr> 
</table>
<table  width="100%">     
    <tr height="5px"> 
        <td width="100%">( ชื่อหลักสูตร )...................................................................................................................................................................</td>           
    </tr> 
</table>
<table  width="100%">     
    <tr height="5px"> 
        <td width="5%">หน่วยงานผู้จัด</td>  
        <td width="30%">.................................................................</td>   
        <td width="5%">สถานที่จัดประชุม</td>   
        <td width="60%">&nbsp;{{$infopredev->LOCATION_ORG_NAME}}</td>          
    </tr> 
</table>
<table  width="100%">     
    <tr height="5px"> 
        <td width="45%">ในระหว่างวันที &nbsp;{{DateThaifrom($infopredev->DATE_GO) }}&nbsp;</td>         
        <td width="5%">ถึงวันที่</td>   
        <td width="50%">{{DateThaifrom($infopredev->DATE_BACK) }}&nbsp;รวม......วัน(วันอบรมจริง)</td>  
    </tr> 
</table>
<table  width="100%">     
    <tr height="5px"> 
        <td width="46%">โดยเริ่มออกเดินทางตั้งแต่วันที่{{DateThaifrom($infopredev->DATE_TRAVEL_GO)}}</td>         
        <td width="1%">ถึงวันที่</td>   
        <td width="53%">{{DateThaifrom($infopredev->DATE_TRAVEL_BACK)}}&nbsp;รวม......วัน(วันอบรม+วันเดินทาง)</td>  
    </tr> 
</table>
<table  width="100%">     
    <tr height="5px"> 
        <td width="15%">เดินทางโดย</td>         
        <td width="25%">( &nbsp;)&nbsp;รถโดยสารประจำทาง</td> 
        <td width="20%">( &nbsp;)&nbsp;รถยนต์ส่วนบุคคล</td> 
        <td width="25%">( &nbsp;)&nbsp;รถยนต์ของทางราชการ</td>   
        <td width="15%"></td>  
    </tr>
</table>
<table  width="100%">  
    <tr height="5px"> 
        <td width="15%"></td>         
        <td width="85%">( &nbsp;)&nbsp;อื่นฯ(โปรดระบุ)...........................................................................................................</td>       
    </tr> 
</table>
<table  width="100%">  
    <tr height="5px"> 
        <td width="50%">ประมาณการค่าใช้จ่ายทั้งสิ้น..................................................บาท</td>         
        <td width="50%">( มีค่าลงทะเบียน ......................................................บาท )</td>       
    </tr> 
</table>
<table  width="100%">  
    <tr height="5px"> 
        <td width="15%">เบิกค่าใช้จ่ายจาก</td>         
        <td width="15%">( &nbsp;)&nbsp;ต้นสังกัด</td> 
        <td width="15%">( &nbsp;)&nbsp;ผู้จัด</td> 
        <td width="55%">( &nbsp;)&nbsp;ไม่เบิกค่าใช้จ่ายใด ฯ</td>   
    </tr> 
</table>
<table  width="100%">  
    <tr height="5px"> 
        <td width="100%">ระหว่างข้าพเจ้าไม่อยู่ขอมอลหมายให้&nbsp;  {{$infopredev->OFFER_WORK_HR_NAME}}&nbsp;&nbsp; เป็นผู้รับผิดชอบแทน</td>         
    </tr> 
</table>
{{-- <table>
    <tr>
        <td>มีความประสงค์ขออนุมัติไปราชการเพื่อ &nbsp;{{$infopredev->RECORD_HEAD_USE}}</td>
    </tr>
    <tr>
        <td>สถานที่ไป &nbsp;{{$infopredev->LOCATION_ORG_NAME}} จังหวัด {{$infopredev->PROVINCE_NAME}} ระยะห่างจากสำนักงาน :&nbsp;{{thainumDigit(number_format($infopredev->DISTANCE/2))}} กิโลเมตร</td>
    </tr>
    <tr>
        <td>ในวันที &nbsp;{{DateThaifrom($infopredev->DATE_GO) }}&nbsp;ถึงวันที่ :&nbsp;{{DateThaifrom($infopredev->DATE_BACK) }}&nbsp;รวม :&nbsp;{{caldate($infopredev->DATE_BACK,$infopredev->DATE_GO) }} วัน</td>
    </tr>
    
</table> --}}
{{-- <table  width="100%">    
    <tr>       
        <td style="width: 22%">จะออกเดินทางในวันที่  :&nbsp;  </td> 
        <td style="width: 78%">{{DateThaifrom($infopredev->DATE_TRAVEL_GO) }}@if ($infopredev->FROM_TIME == '') &nbsp;เวลา ......... น.&nbsp; @else &nbsp;เวลา  {{timefrom($infopredev->FROM_TIME)}} น.@endif</td>
    </tr>  
    <tr>       
        <td style="width: 22%">จะกลับในวันที่ :&nbsp;&nbsp; </td> 
        <td style="width: 78%">{{DateThaifrom($infopredev->DATE_TRAVEL_BACK) }}&nbsp;@if ($infopredev->BACK_TIME == '') &nbsp;เวลา ......... น.&nbsp; @else &nbsp;เวลา  {{timefrom($infopredev->BACK_TIME)}} น.&nbsp; @endif
            &nbsp;&nbsp;&nbsp;โดยพาหนะ :&nbsp;
            @if($infopredev->RECORD_VEHICLE_ID == '3')
                รถยนต์ส่วนราชการ
            @elseif($infopredev->RECORD_VEHICLE_ID == '2')
                รถยนต์ส่วนบุคคล ทะเบียน {{thainumDigit($infopredev->CAR_REG)}}
            @elseif($infopredev->RECORD_VEHICLE_ID == '1')
                รถยนต์ประจำทาง
            @elseif($infopredev->RECORD_VEHICLE_ID == '4')
                เครื่องบิน
            @elseif($infopredev->RECORD_VEHICLE_ID == '5')
                รถไฟ
            @elseif($infopredev->RECORD_VEHICLE_ID == '6')
                เรือ
            @elseif($infopredev->RECORD_VEHICLE_ID == '8')
                รถจ้างเหมา
            @else
                อื่น ๆ {{thainumDigit($infopredev->CAR_REG)}}
            @endif
        </td>
    </tr>  
    
</table>  --}}

{{-- <table  width="100%">
    <tr>
        <td style="width: 10%">&nbsp;</td>
        <td style="width: 90%">ในการไปราชการครั้งนี้ ได้มอบหมายงานในหน้าที่ให้กับ :&nbsp;{{$infopredev->OFFER_WORK_HR_NAME}}&nbsp;  </td>
    </tr>    
</table>  --}}
{{-- <table  width="100%">   
    <tr>        
        <td style="width: 100%">ตำแหน่ง{{$indexpersonwork->POSITION_IN_WORK}} ปฎิบัติงานแทน</td>        
    </tr>    
</table>  --}}
<br>
<table  width="100%"> 
    <tr>
        <td style="width: 10%">&nbsp;</td>
        <td style="width: 90%">
            จึงเรียนมาเพื่อโปรดพิจารณา</td>
    </tr>  
</table> 
<br>
<table  width="100%"> 
    <tr>
        <td style="width: 25%"> </td>
        <td style="width: 75%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.........................................................&nbsp; </td>
    </tr>  
    <tr>
        <td style="width: 30%">&nbsp;</td>
        <td style="width: 70%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (&nbsp;&nbsp;{{$infopredev->USER_POST_NAME}}&nbsp;&nbsp;) </td>
    </tr> 
    <tr>
        <td style="width: 30%">&nbsp;</td>
        <td style="width: 70%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตำแหน่ง {{$infopredev->POSITION_IN_WORK}}</td>
    </tr>  
</table>
<br> 
<table width="100%"> 
    <tr>
        {{-- <td style="width: 10%">&nbsp;</td> --}}
        <td style="width: 20%">ความคิดเห็นของหัวกลุ่มภารกิจ</td>
        <td style="width: 15%"> </td>
        <td style="width: 20%"> ( &nbsp;)&nbsp;หน่วยงานส่ง</td>
        <td style="width: 45%">( &nbsp;)&nbsp;สมัครไปครั้งที่ ................. </td>
    </tr> 
    <tr>
        {{-- <td style="width: 10%">&nbsp;</td> --}}
        <td style="width: 20%"></td>
        <td style="width: 15%"> </td>
        <td style="width: 20%"> ( &nbsp;)&nbsp;อบรมตามแผนก</td>
        <td style="width: 45%">( &nbsp;)&nbsp;อื่น ฯ ระบุ ................. </td>
    </tr> 
</table> 
<br>
<table  width="100%"> 
    <tr>
        <td style="width: 25%"> </td>
        <td style="width: 75%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.........................................................&nbsp; </td>
    </tr>  
    <tr>
        <td style="width: 30%">&nbsp;</td>
        <td style="width: 70%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(.........................................................)&nbsp;</td>
    </tr>
</table>
<br>
<table width="100%"> 
    <tr>
        {{-- <td style="width: 10%">&nbsp;</td> --}}
        <td style="width: 20%">ความคิดเห็นของผู้บังคับบัญชา</td>
        <td style="width: 15%"> </td>
        <td style="width: 20%"> ( &nbsp;)&nbsp;อนุมัติ</td>
        <td style="width: 45%">( &nbsp;)&nbsp;ไม่อนุมัติ</td>
    </tr>     
</table>
<br>
<br>
{{-- <br><br>
<table  width="100%"> 
    <tr>
        <td style="width: 30%">&nbsp;</td>
        <td style="width: 70%"> ลงชื่อ........................................................&nbsp;ผู้รับมอบหมายงาน </td>
    </tr>  
    <tr>
        <td style="width: 35%">&nbsp;</td>
        <td style="width: 65%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (&nbsp;&nbsp;{{$infopredev->OFFER_WORK_HR_NAME}}&nbsp;&nbsp;) </td>
    </tr> 
    <tr>
        <td style="width: 35%">&nbsp;</td>
        <td style="width: 65%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตำแหน่ง {{$infooffer->POSITION_IN_WORK}} {{$infooffer->HR_LEVEL_NAME}}</td>
    </tr>  
</table> 
<br><br>
<table  width="100%"> 
    <tr>
        <td style="width: 50%">&nbsp;</td>
        <td style="width: 50%"> <b>คำสั่ง</b> </td>
    </tr>
</table> 
<table  width="100%">
    <tr>
        <td style="width: 35%">&nbsp;</td>
        <td style="width: 65%"> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;              
            @if ($infopredev->STATUS == 'SUCCESS')
                <input type="checkbox" id="scales" name="scales" checked>
                <label for="scales">อนุมัติ</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" id="scales" name="scales">
                <label for="scales">ไม่อนุมัติ</label>
            @else
                <input type="checkbox" id="scales" name="scales">
                <label for="scales">อนุมัติ</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" id="scales" name="scales">
                <label for="scales">ไม่อนุมัติ</label>
            @endif 
        </td>
    </tr>
</table> 
<br><br> --}}
<table  width="100%">
    <tr>
        <td style="width: 30%">&nbsp;</td>
        <td style="width: 70%"> 
            ลงชื่อ........................................................
        </td>
    </tr>    
</table> 
<table  width="100%">   
    <tr>
        <td style="width: 30%">&nbsp;</td>
        <td style="width: 70%"> &nbsp;&nbsp; (&nbsp;&nbsp;{{$infoorg->HR_PREFIX_NAME}}{{$infoorg->HR_FNAME}} {{$infoorg->HR_LNAME}} &nbsp;&nbsp;)</td>
    </tr>  
</table> 
<table  width="100%">
    <tr>
        <td style="width: 27%">&nbsp;</td>
        <td style="width: 73%"> 
            &nbsp;&nbsp;&nbsp;&nbsp; ผู้อำนวยการ{{$infoorg->ORG_NAME}}
        </td>
    </tr>    
</table>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<table  width="100%">
    <tr>
        <td style="width: 40%">&nbsp;</td>
        <td style="width: 60%;font-size:11px">&nbsp;งานการเจ้าหน้าที่บันทึกข้อมูล ......................................................................ลงชื่อ</td>        
    </tr>    
</table>

<table  width="100%">
    <tr>
        <td style="width: 30%">&nbsp;</td>
        <td style="width: 70%;font-size:11px">&nbsp;อัตลักษณ์ โรงพยาบาล {{$infoorg->ORG_NAME}} &nbsp;&nbsp;"ตรงเวลา &nbsp;รู้หน้าที่ &nbsp;มีวินัย"</td>        
    </tr>    
</table>
   </body>
</html> 