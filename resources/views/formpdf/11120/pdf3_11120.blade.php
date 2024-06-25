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
                        <!--  <img src="image/Garuda.png" width="50" height="50">-->
                    </td> 
                    <td width="55%" ></td>                 
                    <td width="30%" style="border: 0px solid rgb(250, 250, 250);" colspan="2">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;แบบ ๓<br> 
                       
                    </td>
                </tr>  
          </table>      
          <br><br>
          <center >
                    <B style="font-size: 17px;">{{$f}}</B>             
              
        </center> 
        <br>
        <table  width="100%">   
            <tr>  
                <td width="50%" >                  
                 </td>           
                <td width="50%" >
                    เขียนที่ &nbsp;&nbsp;รพ.เทพรัตนเวชชานุกูลฯ<br>     
                </td>
            </tr>  
            <tr> 
                <td width="50%" >
                 
                </td>
                <td width="50%" >
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
                    <td width="50%" >
                        ข้าพเจ้า&nbsp; {{$inforperson->HR_FNAME}} {{$inforperson->HR_LNAME}}
                    </td>
                    <td width="40%" >
                        ตำแหน่ง&nbsp;{{$inforperson->POSITION_IN_WORK}}
                    </td>
                </tr>           
        </table>
        <table width="100%">
                <tr>
                    <td width="100%">
                        มีความประสงค์จะขออนุญาตใช้รถส่วนกลาง หมายเลขทะเบียน &nbsp;&nbsp; {{$inforcar->CAR_REG }}
                    </td>
                </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="60%">
                    เพื่อ&nbsp;&nbsp; {{$inforcar->RESERVE_NAME}}
                </td>
                <td width="40%">
                    มีผู้นั่งไปในครั้งนี้ จำนวน .............. คน  
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="60%">
                    ในวันที่&nbsp;&nbsp; {{DateThaifrom($inforcar->RESERVE_BEGIN_DATE)}}
                </td>
                <td width="40%">
                    เวลา&nbsp;&nbsp; {{thainumDigit(formatetime($inforcar->RESERVE_BEGIN_TIME))}} น.
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="60%">
                    ถึงวันที่&nbsp;&nbsp; {{DateThaifrom($inforcar->RESERVE_END_DATE)}}
                </td>
                <td width="40%">
                    เวลา&nbsp;&nbsp; {{thainumDigit(formatetime($inforcar->RESERVE_END_TIME))}} น.
                </td>
            </tr>
        </table>
          <table width="100%">
            <tr>
                <td width="10%">                   
                </td>
                <td width="90%">
                    เพื่อให้การปฏิบัติงานเป็นด้วยความเรียบร้อยเป็นผลดีต่อการปฏิบัติราชการ
                </td>
            </tr>
        </table>            

        <table width="100%">
            <tr>
                <td width="100%">
                    จึงขออนุญาต เพื่อมอบหมายให้
                    &nbsp;&nbsp;
                    
                    @if ($inforcar->CAR_DRIVER_SET_ID == '' || $inforcar->CAR_DRIVER_SET_ID == null)
                        ...................................................................
                    @else
                    {{$inforcar->HR_PREFIX_NAME}}{{$inforcar->HR_FNAME}}  {{$inforcar->HR_LNAME}}
                    @endif                   
                    
                    &nbsp;&nbsp;
                    เป็นผู้ขับขี่รถยนต์ส่วนกลาง 
                </td>
               
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="60%">
                    ไปปฏิบัติราชการตามที่ได้รับมอบหมาย
                </td>
                <td width="40%">
                    <!--ใช้รถยนต์ ทะเบียน ..................................... ---->
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="50%">
                    <label class="form-check-label" for="inlineRadio1">เลขไมล์ระยะทางก่อนออกเดินทาง 
                        &nbsp;&nbsp;                            
                        @if ($inforcar->CAR_NUMBER_BEGIN == '' || $inforcar->CAR_NUMBER_BEGIN == null)
                        ................................
                        @else
                        {{$inforcar->CAR_NUMBER_BEGIN}}
                        @endif      
                    </label>
                </td>
                <td width="50%"> 
                        <label class="form-check-label" for="inlineRadio1">เลขไมล์ระยะทางหลังออกเดินทาง 
                            &nbsp;&nbsp;                            
                            @if ($inforcar->CAR_NUMBER_BACK == '' || $inforcar->CAR_NUMBER_BACK == null)
                                ................................
                            @else
                            {{$inforcar->CAR_NUMBER_BACK}}
                            @endif      
                        </label>
                </td>
            </tr>           
        </table>
        <br> <br>
        <table width="100%">
            <tr>
                <td width="40%">                   
                </td>
                <td width="5%">   
                    ลงฃื่อ                
                </td>
                <td  width="35%" > 

                    @if ($sigper == '' || $checksig != 1 )
                    ..................................................................
                    @else
                        @if($checksig == 1 && $sigper !== null && $sigper !== '')&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <img src="{{Storage::path('public/images/'.$sigper)}}" width="100" height="40">
                        @endif 
                    @endif  

                </td>
                <td width="20%">
                    ผู้ขออนุญาตใช้รถ 
                </td>
            </tr>          
        </table>

        <table width="100%">
            <tr>
                <td width="45%">                   
                </td>
                <td  width="35%" >  
                    ( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$inforcar->RESERVE_PERSON_NAME}}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)                  
                </td>
                <td width="20%">                   
                </td>
            </tr>           
        </table>
        <table width="100%">           
            <tr>
                <td width="40%">                   
                </td>
                <td width="5%">   
                    ตำแหน่ง                
                </td>
                <td width="35%">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$inforcar->RESERVE_PERSON_POSITION}}
                </td>
                <td width="25%">                   
                </td>
            </tr>           
        </table>
        <br> <br>
        
   
        <table width="100%">
            <tr>               
                <td  width="100%" >  
                    เรียน &nbsp;&nbsp;ผู้อำนวยการ{{$orgname->ORG_NAME}}                  
                </td>               
            </tr>           
        </table>
        <br>
        {{-- <table width="100%">
            <tr>              
                <td width="2%">                   
                </td>
                <td width="15%">
                      <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                            <label class="form-check-label" for="inlineRadio1">อนุญาต</label>                           
                        </div>                       
                      </div>
                </td>
                <td width="20%">
                    <div class="form-group">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio2" value="option1">
                          <label class="form-check-label" for="inlineRadio2">ไม่อนุญาต </label>                          
                        </div>
                      </div>
                </td>
                <td width="63%">                   
                </td>
            </tr>
        </table> --}}
        <table width="100%">
            <tr>  
                <td width="5%">
                      <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio1" value="option1">                           
                        </div>                       
                      </div>
                </td>   
                <td  width="95%" >  
                    <label class="form-check-label" for="inlineRadio1">เห็นสมควรอนุมัติ</label>                 
                </td>      
            </tr>
        </table>
        <table width="100%">
            <tr>  
                <td width="5%">
                      <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio1" value="option1">                                                         
                        </div>                       
                      </div>
                </td>   
                <td  width="95%" >  
                    <label class="form-check-label" for="inlineRadio1">ไม่เห็นสมควร...........................</label>                 
                </td>      
            </tr>

        </table>
        <table width="100%">
            <tr> 
                <td width="5%">                   
                </td>              
                <td  width="95%" >  
                    จึงขอรายงานเพื่อโปรดพิจารณาอนุมัติ                 
                </td>               
            </tr>           
        </table>
        <table width="100%">
            <tr>
              
                <td width="5%">   
                    ลงฃื่อ                
                </td>
                <td  width="35%" >                  
                    @if ($sigdriver == '' || $checksig != 1 )
                    ..................................................................
                    @else
                        @if($checksig == 1 && $sigdriver !== null && $sigdriver !== '')&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <img src="{{Storage::path('public/images/'.$sigdriver)}}" width="100" height="40">
                        @endif 
                    @endif  
                </td>
                <td width="20%">
                    ผู้อนุญาต
                </td>
                <td width="40%">                   
                </td>
            </tr>          
        </table>
        <table width="100%">
            <tr>
                <td width="5%">                   
                </td>
                <td  width="35%" >  
                    ( &nbsp;&nbsp;{{$inforcar->HR_PREFIX_NAME}} {{$inforcar->HR_FNAME}}  {{$inforcar->HR_LNAME}} &nbsp;)                    
                </td>               
                <td width="60%">                   
                </td>
            </tr>           
        </table>
        <table width="100%">           
            <tr>
                <td width="5%">                   
                </td>
                <td width="30%">  &nbsp;&nbsp;&nbsp;&nbsp;
                    พนักงานขับรถ                
                </td>               
                <td width="65%">                   
                </td>
               
            </tr>           
        </table>
        <table width="100%">           
            <tr>
                <td width="50%">                   
                </td>
                <td width="50%">  
                    ความเห็นและอนุมัติ                
                </td>   
            </tr>           
        </table>
        <table width="100%">
            <tr>  
                <td width="20%">                   
                </td>
                <td width="5%">
                      <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio1" value="option1">                                                         
                        </div>                       
                      </div>
                </td>   
                <td  width="75%" >  
                    <label class="form-check-label" for="inlineRadio1">อนุมัติ</label>                 
                </td>      
            </tr>
        </table>
        <table width="100%">
            <tr>  
                <td width="20%">                   
                </td>
                <td width="5%">
                      <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio1" value="option1">                                                         
                        </div>                       
                      </div>
                </td>   
                <td  width="75%" >  
                    <label class="form-check-label" for="inlineRadio1">ไม่อนุมัติ</label>                 
                </td>      
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="40%">                   
                </td>
                <td width="5%">   
                    ลงฃื่อ                
                </td>
                <td  width="35%" >                  
                    @if ($sig == '' || $checksig != 1 )
                    ..................................................................
                    @else
                        @if($checksig == 1 && $sig !== null && $sig !== '')&nbsp;&nbsp;&nbsp;&nbsp;
                        <img src="{{Storage::path('public/images/'.$sig)}}" width="100" height="40">
                        @endif 
                    @endif  
                </td>
                <td width="20%">
                    ผู้อนุมัติ 
                </td>
            </tr>          
        </table> 

        <table width="100%">
            <tr>
                <td width="45%">                   
                </td>
                <td  width="35%" >  
                    ( &nbsp;&nbsp;{{$orgname->HR_PREFIX_NAME}} {{$orgname->HR_FNAME}}  {{$orgname->HR_LNAME}} &nbsp;&nbsp; )                    
                </td>
                <td width="20%">                   
                </td>
            </tr>           
        </table>
        <table width="100%">           
            <tr>
                <td width="40%">                   
                </td>               
                <td width="50%">
                    นายแพทย์ชำนาญการพิเศษ รักษาการในตำแหน่ง
                   
                </td>
                <td width="10%">                   
                </td>
            </tr>           
        </table>
        <table width="100%">           
            <tr>
                <td width="30%">                   
                </td>               
                <td width="70%">                    
                 {{$orgname->ORG_LEADER_POSITION}}&nbsp;  
                </td>
              
            </tr>           
        </table>

</center>
     </body>
  </html> 