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
          padding: 3.00pt 3.1732pt 3.1732pt 10.00pt;             
      }
      input {
            margin: .3rem;
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
                    </td> 
                    <td width="55%" ></td>                 
                    <td width="30%" style="border: 0px solid rgb(250, 250, 250);" colspan="2">
                        &nbsp;&nbsp;เลขที่....................../.................                      
                    </td>
                </tr>  
          </table>     
        
            <center >
                    <B style="font-size: 15px;">{{$f}}</B> 
            </center> 
            <center >
                <B style="font-size: 15px;">{{$orgname->ORG_NAME}}</B> 
            </center> 
       
        <table  width="100%">  
            <tr> 
                <td width="60%" >
                 
                </td>
                <td width="40%" >
                    <label for="">วันที่ {{DateThaifrom(date('Y-m-d'))}}</label>
                </td>
            </tr>
         
            <tr>
                <td width="100%">
                    เรียน &nbsp;&nbsp;ผู้อำนวยการ{{$orgname->ORG_NAME}}
                </td>
            </tr>            
        </table> 
        <table  width="100%">
                <tr>
                    <td width="10%"></td>
                    <td width="45%" >
                        ข้าพเจ้า&nbsp; {{$inforperson->HR_FNAME}} {{$inforperson->HR_LNAME}}
                    </td>
                    <td width="45%" >
                        ตำแหน่ง&nbsp;{{$inforperson->POSITION_IN_WORK}}
                    </td>
                </tr>           
        </table>
        <table  width="100%">
            <tr>               
                <td width="65%" >
                    กลุ่มงาน/ฝ่าย/งาน&nbsp; {{$inforperson->HR_DEPARTMENT_SUB_NAME}}
                </td>
                <td width="35%" >
                    เบอร์โทรติดต่อกลับ&nbsp; {{$inforperson->HR_PHONE}}
                </td>
            </tr>           
    </table>
        <table width="100%">
                <tr>
                    <td width="100%">
                        ขออนุญาตใช้รถยนต์ราชการส่วนกลางไป (ระบุสถานที่) &nbsp;&nbsp; {{$inforcar->LOCATION_ORG_NAME}}                      
                    </td>
                </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="55%">
                    เพื่อ&nbsp;&nbsp; {{$inforcar->RESERVE_NAME}}
                </td>
                <td width="45%">
                    จำนวน .............. คน  
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="55%">
                    ในวันที่&nbsp;&nbsp; {{DateThaifrom($inforcar->RESERVE_BEGIN_DATE)}}
                </td>
                <td width="45%">
                    เวลา&nbsp;&nbsp; {{thainumDigit(formatetime($inforcar->RESERVE_BEGIN_TIME))}} น.
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="55%">
                    ถึงวันที่&nbsp;&nbsp; {{DateThaifrom($inforcar->RESERVE_END_DATE)}}
                </td>
                <td width="45%">
                    เวลา&nbsp;&nbsp; {{thainumDigit(formatetime($inforcar->RESERVE_END_TIME))}} น.
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="100%">
                    รายนามเจ้าหน้าที่ที่ไปด้วย
                </td>
            </tr>
        </table>
        <table width="100%">
            @foreach ($indexpersons as $indexperson)
            <tr>
                <td width="10%"></td>
                <td width="30%">
                    {{$indexperson->HR_FULLNAME}}
                </td>  
                <td width="5%"></td>
                <td width="40%">
                    ตำแหน่ง&nbsp;{{$indexperson->HR_POSITION}}
                </td>              
            </tr>
            @endforeach 
        </table>   
        <table width="100%">
            <tr>
                <td width="30%">                   
                </td>
                <td width="5%">   
                    ลงฃื่อ                
                </td>
                <td  width="25%" > 

                    @if ($sigper == '' || $checksig != 1 )
                    ..................................................................
                    @else
                        @if($checksig == 1 && $sigper !== null && $sigper !== '')&nbsp;
                        <img src="{{Storage::path('public/images/'.$sigper)}}" width="100" height="40">
                        @endif 
                    @endif  

                </td>
                <td width="40%">
                    ผู้ขออนุญาต
                </td>
            </tr>          
        </table>
        <table width="100%">
            <tr>
                <td width="33%">                   
                </td>
                <td  width="27%" >  
                    ( &nbsp;&nbsp;{{$inforcar->RESERVE_PERSON_NAME}} &nbsp;&nbsp;)                  
                </td>
                <td width="30%">                   
                </td>
            </tr>           
        </table>        
        <table width="100%">
            <tr>
                <td width="30%">                   
                </td>
                <td width="5%">   
                    ลงฃื่อ                
                </td>
                <td  width="25%" > 
                    ..................................................................
                   <!-- @if ($sigper == '' || $checksig != 1 )
                    ..................................................................
                    @else
                        @if($checksig == 1 && $sigper !== null && $sigper !== '')&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <img src="{{Storage::path('public/images/'.$sigper)}}" width="100" height="40">
                        @endif 
                    @endif   
                -->

                </td>
                <td width="40%">
                    หัวหน้ากลุ่มงาน/ฝ่าย/งาน/ผู้แทน
                </td>
            </tr>          
        </table>

        <table width="100%">
            <tr>
                <td width="30%">                   
                </td>
                <td  width="60%" > 
                    วันที่ ............/........................./.............. 
                     <!-- ( &nbsp;&nbsp;{{$inforcar->RESERVE_PERSON_NAME}} &nbsp;&nbsp;) วันที่ ........./.........../..........  -->                
                </td>              
            </tr>           
        </table>  
        <table width="100%">
            <tr>              
                <td width="2%">                   
                </td>
                <td width="15%">    
                    <input type="checkbox" name="inlineRadioOptions" id="inlineRadio1" >
                    <label for="inlineRadio1">อนุญาต</label> 
                </td>
                <td width="20%"> 
                    <input type="checkbox" name="inlineRadioOptions" id="inlineRadio2" >
                    <label for="inlineRadio2">ไม่อนุญาต </label>    
                </td>
                <td width="63%">                   
                </td>
            </tr>
        </table>     
        
        <table width="100%">
            <tr>
                <td width="5%">   
                    ลงฃื่อ                
                </td>
                <td  width="85%" >                  
                    @if ($sig == '' || $checksig != 1 )
                    ..................................................................
                    @else
                        @if($checksig == 1 && $sig !== null && $sig !== '')&nbsp;
                        <img src="{{Storage::path('public/images/'.$sig)}}" width="100" height="40">
                        @endif 
                    @endif  
                </td>
            </tr>          
        </table>

        <table width="100%">
            <tr>
                <td width="5%"> </td>
                <td  width="95%" >(&nbsp;.............................................................&nbsp;)</td>
            </tr>           
        </table>
        <table width="100%">           
            <tr>               
                <td width="100%">
                    &nbsp;&nbsp;ผู้อำนวยการ หรือรองผู้อำนวยการ หรือผู้แทน&nbsp; 
                </td>              
            </tr>    
            <tr>               
                <td width="100%">
                    &nbsp;&nbsp;วันที่ ............./............................/................... &nbsp; 
                </td>              
            </tr>           
        </table>
   
        <table width="100%">
            <tr>          
                <td width="10%">                   
                </td>     
                <td  width="70%" >  
                    งานยานพาหนะ ขอมอบหมายให้พนักงานขับรถยนต์ ชื่อ &nbsp;{{$inforcar->HR_PREFIX_NAME}}{{$inforcar->HR_FNAME}}  {{$inforcar->HR_LNAME}}                   
                </td> 
                <td width="20%">ไปราชการในครั้งนี้               
                </td>              
            </tr>           
        </table>
        <table width="100%">
            <tr>  
                <td  width="55%" >  
                    โดยใช้รถยนต์ส่วนกลางหมายเลขทะเบียน &nbsp;&nbsp;{{$inforcar->CAR_REG }}                  
                </td> 
                <td width="45%">อื่นฯ .............................               
                </td>              
            </tr>           
        </table>
        <br>       
        <table width="100%">
            <tr>               
                <td width="5%">   
                    ลงฃื่อ                
                </td>
                <td  width="25%" >  
                    .................................................                
                   <!-- @if ($sigdriver == '' || $checksig != 1 )
                    .................................................
                    @else
                        @if($checksig == 1 && $sigdriver !== null && $sigdriver !== '')&nbsp;
                        <img src="{{Storage::path('public/images/'.$sigdriver)}}" width="100" height="40">
                        @endif 
                    @endif   -->
                </td>
                <td width="5%">
                    เจ้าหน้าที่จัดยานพาหนะ                   
                </td>
                <td width="5%">                    
                </td>
                <td width="5%">  ลงฃื่อ                  
                </td>
                <td  width="25%" >              
                    @if ($sigdriver == '' || $checksig != 1 )
                    ...................................................
                    @else
                        @if($checksig == 1 && $sigdriver !== null && $sigdriver !== '')&nbsp;
                        <img src="{{Storage::path('public/images/'.$sigdriver)}}" width="100" height="40">
                        @endif 
                    @endif  
                </td>
                <td width="5%">
                    พนักงานขับรถยนต์
                </td>
                <td width="30%">                    
                </td>
            </tr> 
        </table>
        <table width="100%">   
            <tr>       
                <td width="5%">                    
                </td>        
                <td width="50%">
                    (...................................................)
                   <!--  &nbsp;&nbsp;( &nbsp;{{$inforcar->HR_PREFIX_NAME}} {{$inforcar->HR_FNAME}}  {{$inforcar->HR_LNAME}}&nbsp;)&nbsp; -->
                </td>                
                <td width="45%">(...................................................)
                    <!--  &nbsp;&nbsp;( &nbsp;{{$inforcar->HR_PREFIX_NAME}} {{$inforcar->HR_FNAME}}  {{$inforcar->HR_LNAME}}&nbsp;)&nbsp;  -->
                </td>              
            </tr>        
        </table>  
        <table width="100%">   
            <tr>               
                <td width="50%">
                    &nbsp;&nbsp;วันที่ ............./............................/................... &nbsp; 
                </td> 
                <td width="50%">
                    &nbsp;&nbsp;วันที่ ............./............................/................... &nbsp; 
                </td>              
            </tr>        
        </table>
        <table width="100%">   
            <tr>               
                <td width="10%"><label style="font-size: 10px;">หมายเหตุ</label> 
                </td> 
                <td width="90%">
                    <label style="font-size: 10px;color:red">1.การขอใช้รถส่วนกลาง  ให้ผู้ขอใช้ส่งใบขออนุญาตใช้รถ ฯ ล่วงหน้าก่อนวันเดินทางอย่าง  น้อย 1 วัน (ยกเว้นกรณีเร่งด่วน)</label>  &nbsp; 
                </td>              
            </tr>  
            <tr>               
                <td width="10%">
                </td> 
                <td width="90%">
                    <label style="font-size: 10px;color:red">2.ให้พนักงานขับรถปฏิบัติหน้าที่ตามรายการที่กำหนดไว้ในใบอนุญาตใช้รถยนต์ส่วนกลาง</label> 
                </td>              
            </tr>    
            <tr>               
                <td width="10%">
                </td> 
                <td width="90%">
                    <label style="font-size: 10px;color:red">3.ผู้ขอใช้รถส่วนกลาง หากมีความจำเป็นต้องไปราชการนอกเหนือจากที่ขอไว้เดิม  ขอให้แจ้งผู้มีอำนาจสั่งใช้รถยนต์ทุกครั้ง</label> 
                </td>              
            </tr>   
            <tr>               
                <td width="10%">
                </td> 
                <td width="90%">
                    <label style="font-size: 10px;color:red">4.หากผู้ขอใช้รถยนต์ส่วนกลาง มีรายการเปลี่ยนแปลง เช่น เวลา หรือยกเลิก กรุณาแจ้งให้พนักงานขับรถทราบล่วงหน้า</label> 
                </td>              
            </tr>  
            <tr>               
                <td width="10%">
                </td> 
                <td width="90%">
                    <label style="font-size: 10px;color:red">5.หากพนักงานขับรถยนต์ ไม่ปฏิบัติตามหน้าที่ หรือประพฤติตัวไม่เหมาะสม ขอให้รายงานเป็นลายลักษณ์อักษร  ส่งให้ผู้รับ</label>  
                </td>              
            </tr>  
            <tr>               
                <td width="10%">
                </td> 
                <td width="90%">
                    <label style="font-size: 10px;color:red"> ผิดชอบงานยานพาหนะ (งานธุรการ) ทราบด้วย  ทั้งนี้ เพื่อการพัฒนางาน พัฒนาคน  ต่อไป  จะเป็นพระคุณ</label> 
                </td>              
            </tr>        
        </table>
        <br>
        <table width="100%">   
            <tr>               
                <td width="70%">
                  
                </td> 
                <td width="30%">
                    <label style="font-size: 11px;">งานธุรการ  ฝ่ายบริหารทั่วไป</label> 
                </td>              
            </tr>        
        </table>

</center>
     </body>
  </html> 