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
      body {
          font-family: "THSarabunNew";
          font-size: 13px;
          line-height: 0.8;  
          padding: 10.00pt 7.1732pt 7.1732pt 40.00pt;             
      }
      
  </style>

  <?php
      function RemovethainumDigit($num){
          return str_replace(array( '0' , '1' , '2' , '3' , '4' , '5' , '6' ,'7' , '8' , '9' ),array( "o" , "๑" , "๒" , "๓" , "๔" , "๕" , "๖" , "๗" , "๘" , "๙" ),$num);
      }
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
          <table  width="100%">   
                <tr>
                    <td width="15%" >
                        <img src="image/Garuda.png" width="50" height="50">
                    </td> 
                    <td width="55%" ></td>                 
                    <td width="30%" style="border: 1px solid black;" colspan="2">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;กลุ่มงานการจัดการ<br> 
                        &nbsp;&nbsp;เลขที่รับ ....................................<br>     
                        &nbsp;&nbsp;วันที่ ......................เวลา.............<br> 
                        &nbsp;&nbsp;ชื่อผู้รับ.......................................
                    </td>
                </tr>  
          </table>      
          <br><br>
          <center >
                    {{-- <B style="font-size: 17px;">{{$f}}</B>  --}}
                    <B style="font-size: 17px;">ใบขออนุมัติเดินทางไปราชการ</B> 
              
        </center> <br>
        <table  width="100%">   
            <tr>             
                <td width="100%" >
                    ส่วนราชการ &nbsp;&nbsp;&nbsp; {{$infoorg->ORG_NAME}}&nbsp;&nbsp;&nbsp;อำเภอ&nbsp;{{$infoorg->DISTRICT}}&nbsp;&nbsp;&nbsp;จังหวัด&nbsp;{{$infoorg->PROVINCE}}&nbsp;&nbsp;&nbsp;{{$infoorg->POSECODE}}<br>     
                </td>
            </tr>  
            <tr> 
                <td width="60%" >
                    ที่.................................................................
                </td>
                <td width="40%" >
                    <label for="">วันที่ {{DateThaifrom(date('Y-m-d'))}}</label>
                </td>
            </tr>
            <tr>
                <td width="100%">
                    เรื่อง &nbsp;&nbsp;ขออนุมัติเดินทางไปราชการ
                </td>
            </tr> 
            <tr>
                <td width="100%">
                    เรียน &nbsp;&nbsp;ผู้อำนวยการ{{$infoorg->ORG_NAME}}
                </td>
            </tr>            
      </table> 
      <table  width="100%">
            <tr>
                <td width="10%"></td>
                {{-- @foreach ($index_persons as $index_person)   --}}
                <td width="50%" >                   
                    ข้าพเจ้า&nbsp; {{$infopredev->USER_POST_NAME}}
                    {{-- {{$inforperson->HR_FNAME}} {{$inforperson->HR_LNAME}} --}}
                     
                </td>
                <td width="40%" >
                    ตำแหน่ง&nbsp;{{$infopredev->POSITION_IN_WORK}}
                    {{-- {{$infopredev->POSITION_IN_WORK}} --}}
                </td>
                {{-- @endforeach  --}}
            </tr>           
      </table>
      <table width="100%">
            <tr>
                <td width="100%">
                    มีความประสงค์เดินทางไปราชการ &nbsp;ณ&nbsp;&nbsp; {{$infopredev->LOCATION_ORG_NAME}}
                    {{-- {{$inforcar->LOCATION_ORG_NAME }} --}}
                </td>
            </tr>
      </table>
        <table width="100%">
            <tr>
                <td width="100%">
                    เพื่อ&nbsp;&nbsp; {{$infopredev->RECORD_HEAD_USE}}
                    {{-- {{$inforcar->RESERVE_NAME}} --}}
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="60%">
                    ในวันที่&nbsp;&nbsp; {{DateThaifrom($infopredev->DATE_GO) }}
                </td>
                <td width="40%">
                    ถึงวันที่&nbsp;&nbsp; {{DateThaifrom($infopredev->DATE_BACK) }}
                    {{-- เวลา&nbsp;&nbsp; {{thainumDigit(formatetime($inforcar->RESERVE_BEGIN_TIME))}} น. --}}
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="60%">
                    {{-- ถึงวันที่&nbsp;&nbsp; {{DateThaifrom($infopredev->DATE_BACK) }} --}}
                </td>
                <td width="40%">
                    {{-- เวลา&nbsp;&nbsp; {{thainumDigit(formatetime($inforcar->RESERVE_END_TIME))}} น. --}}
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="100%">
                    โดยมีผู้ร่วมเดินทาง ดังรายชื่อต่อไปนี้
                </td>
            </tr>
        </table>
        <table width="100%">
            @foreach ($index_persons as $index_person)
            <tr>
                <td width="5%"></td>
                <td width="30%">
                    {{$index_person->HR_FULLNAME}}
                </td>  
                <td width="5%"></td>
                <td width="30%">
                    ตำแหน่ง&nbsp;{{$index_person->HR_POSITION}}
                </td>              
            </tr>
            @endforeach 
           
        </table>
    
        <table width="100%">
            <tr>
                <td width="10%">
                   
                </td>
                <td width="80%">                   
                      <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">&nbsp;&nbsp;
                        <label class="form-check-label" for="inlineRadio1">การเดินทางไปราชการครั้งนี้ ขอเบิกค่าใช้จ่ายตามระเบียบฯ</label>
                </td>
            </tr>
            <tr>
                <td width="10%">
                   
                </td>
                <td width="90%">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">&nbsp;&nbsp;
                    <label class="form-check-label" for="inlineRadio2">การเดินทางไปราชการครั้งนี้ ไม่ขอเบิกค่าใช้จ่าย</label>
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="20%">
                   
                </td>
                <td width="80%">
                    จึงเรียนมาเพื่อโปรดทราบ
                </td>
            </tr>
        </table> 
        <br>
      
        <table width="100%">
            <tr>
                <td width="35%">                   
                </td>
                <td  width="25%" >
                     {{-- <br><br> --}}
                    ..........................................................
                    {{-- ({{$infopredev->USER_POST_NAME}}) --}}
                    {{-- @if ($sigper == '')
                    ..........................................................
                    @else
                        @if($checksig == 1 && $sigper !== null && $sigper !== '')
                        <img src="{{Storage::path('public/images/'.$sigper)}}" width="100" height="40">
                        @endif 
                    @endif   --}}
                </td>
                <td width="40%">
                    ผู้ขออนุญาต

                </td>
            </tr>
            <tr>
                <td width="35%">                   
                </td>
                <td  width="25%" > 
                    {{-- <br><br> --}}
                    ..........................................................
                    {{-- @if ($sigper == '')
                    ..........................................................
                    @else
                        @if($checksig == 1 && $sigper !== null && $sigper !== '')
                        <img src="{{Storage::path('public/images/'.$sigper)}}" width="100" height="40">
                        @endif 
                    @endif   --}}
                </td>
                <td width="40%">
                    หัวหน้าฝ่าย/งาน 
                </td>
            </tr>
            <tr>
                <td width="35%"> 
                </td> 
                <td width="25%">
                    ..........................................................
                </td>
                <td width="40%">
                    ว/ด/ป
                </td>
            </tr>
        </table>
        <br>
        <table width="100%">
            <tr>
                <td width="5%">
                    เรียน  
                </td>
                <td width="45%">
                    ผู้อำนวยการ{{$infoorg->ORG_NAME}}
                </td>
                <td width="5%">
                    คำสั่ง
                </td>
                <td width="45%">
                    ผู้อำนวยการ{{$infoorg->ORG_NAME}}
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="5%">
                      
                </td>
                <td width="45%">
                    เพื่อโปรดพิจารณา
                </td>
                <td width="5%">
                   
                </td>
                <td width="15%">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">&nbsp;&nbsp;
                    อนุมัติ
                </td>
                <td width="30%">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">&nbsp;&nbsp;
                    ไม่อนุมัติ
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="5%">
                      
                </td>
                <td width="45%">
                    ..........................................................
                </td>
                <td width="5%">
                   
                </td>
                <td width="45%">
                    
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="5%">
                      
                </td>
                <td width="45%">
                    ..........................................................
                </td>
                              
                @if ($funcgleave == '')
                    <td width="5%">                   
                    </td> 
                    <td width="45%">
                        ..........................................................
                    </td>
                @else
                    <td width="10%">                   
                    </td> 
                    <td width="40%">
                         {{-- @if($checksig == 1 && $sig !== null && $sig !== '')
                                 <img src="{{Storage::path('public/images/'.$sig)}}" width="100" height="40">
                             @endif  --}}
                @endif
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="5%">
                      
                </td>
                <td width="45%">
                    ..........................................................
                </td>
                <td width="7%">
                   
                </td>
                <td width="43%">
                    ({{$infoorg->HR_PREFIX_NAME}}{{$infoorg->HR_FNAME}} {{$infoorg->HR_LNAME}})
                    {{-- ({{$orgname->HR_PREFIX_NAME}} {{$orgname->HR_FNAME}} {{$orgname->HR_LNAME}}) --}}
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="5%">
                      
                </td>
                <td width="45%">
                    ................./................../.......................
                </td>
                <td width="5%">
                   
                </td>
                <td width="45%">
                    ................./................../.......................
                </td>
            </tr>
        </table>
    {{-- <tr>
        <td> <br><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            @if ($sigper == '')
            ........................................
            @else
                @if($checksig == 1 && $sigper !== null && $sigper !== '')
                <img src="{{Storage::path('public/images/'.$sigper)}}" width="100" height="40">
                @endif 
            @endif  
            
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หัวหน้าฝ่ายงาน <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;( {{$inforperson->HR_FNAME}} {{$inforperson->HR_LNAME}} )<br>
            ....................................................... ว/ด/ป --}}
            {{-- วันที่ {{DateThaifrom(date('Y-m-d'))}} --}}

        {{-- </td>
    </tr> --}}
    
{{-- 
    @if ($funch == 'APPROVE')
        <tr>
            <td>
                <br><br>
                @foreach ($infoper as $infoper)
                @if ($infoper->ID == $inforcar->CAR_DRIVER_SET_ID)
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ได้ตรวจสอบแล้ว มีรถยนต์ส่วนกลางที่สามารถนำไปปฎิบัติงานได้ จึงเห็นสมควรอนุญาตไห้ใช้รถยนต์ &nbsp;&nbsp;<br>
                &nbsp;&nbsp;หมายเลขทะเบียน  &nbsp;&nbsp;&nbsp; {{$inforcar->CAR_REG}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; โดยมี &nbsp;&nbsp;&nbsp;{{$infoper->HR_FNAME}} &nbsp;{{$infoper->HR_LNAME}}&nbsp;&nbsp;&nbsp;&nbsp;เป็นพนักงานขับรถยนต์<br>
                &nbsp;&nbsp;เลขไมล์ก่อนไป  &nbsp;&nbsp;&nbsp;{{$inforcar->CAR_NUMBER_BEGIN}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เลขไมล์หลังไป&nbsp;&nbsp;&nbsp;{{$inforcar->CAR_NUMBER_BACK}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รวม. &nbsp;&nbsp; {{$inforcar->CAR_NUMBER_BACK - $inforcar->CAR_NUMBER_BEGIN}} &nbsp;&nbsp;  กิโลเมตร<br><br><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                @if ($sigdriver == '')
                ........................................
                @else
                    @if($checksig == 1 && $sigdriver !== null && $sigdriver !== '')
                    <img src="{{Storage::path('public/images/'.$sigdriver)}}" width="100" height="40">
                    @endif 
                @endif  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;พนักงานขับรถ <br>
          
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( {{$infoper->HR_FNAME}}&nbsp; {{$infoper->HR_LNAME}} )<br>
                @else
              
                @endif
                    
                @endforeach
                </td>
        </tr>
    @else
        
    @endif --}}
   

 
    {{-- <tr>
        <td style="text-align: center;">
            <br>
            <br>
            <br>
            <br>
            <br>  
           @if ($sig == '')
           ........................................
           @else
                @if($checksig == 1 && $sig !== null && $sig !== '')
                        <img src="{{Storage::path('public/images/'.$sig)}}" width="100" height="40">
                    @endif 
           @endif
           

            <br>
            ({{$orgname->HR_PREFIX_NAME}} {{$orgname->HR_FNAME}} {{$orgname->HR_LNAME}})<br>
            ผู้อำนวยการ{{$orgname->ORG_NAME}}<br>
        
        </td>

    </tr>  
  </table>   --}}
  
  
</center>
     </body>
  </html> 