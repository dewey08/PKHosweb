
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
            font-family: 'THSarabunNew', sans-serif;
              font-size: 13px;
            line-height: 0.9;  
            margin-top:    0.2cm;
            margin-bottom: 0.2cm;
            margin-left:   1cm;
            margin-right:  1cm; 
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
            height: 5px;
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
          .page-break {
              page-break-after: always;
          }  
          input {
            margin: .3rem;
        }
   } 
                       
      </style> 
      
      <?php    
          function DateThaimount($strDate)
          {
          $strYear = date("Y",strtotime($strDate))+543;
          $strMonth= date("n",strtotime($strDate));
          $strDay= date("j",strtotime($strDate));
  
          $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤษจิกายน","ธันวาคม");
          $strMonthThai=$strMonthCut[$strMonth];
          return thainumDigit($strMonthThai);
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
          $date = date('Y-m-d');    
          function timefor($strtime)
              {
              $H = substr($strtime,10,6);
              return $H;
              }
      ?>    
  </head>
  
  <body>
 
   <table  width="100%">
    <tr>          
        <td width="15%" >
          <!-- <img src="{{ asset('image/Garuda.png') }}" width="50" height="50"> -->
        </td>
        <td width="55%" >
          
        </td>
        <td width="30%" >
        เอกสารหมายเลข : &nbsp;

      </td>
    </tr>           
</table> 
  <table  width="100%">
    <tr >          
        <td width="40%" >
            <img src="{{ asset('image/Garuda.png') }}" width="50" height="50">
        </td>  
        <td width="40%" >
            <B style="font-size: 16px;">บันทึกข้อความ</B> 
        </td> 
        <td width="20%" >
        </td>       
    </tr>               
</table> 
  <table  width="100%" height="10px">
      <tr>          
          <td width="50%" >
              <b>ส่วนราชการ</b>  งานยานพาหนะ กลุ่มงานบริหารทั่วไป
          </td>
          <td width="25%" >
            <b>{{$orgname->ORG_NAME}}</b>
          </td>
          <td width="25%" >
            <b>โทร</b>&nbsp;<span style="border-bottom: black 1px dotted"> {{$orgname->ORG_PHONE}}</span>
        </td>
      </tr>           
  </table> 
  <table  width="100%">
    <tr >          
        <td width="50%" >
            <b>ที่</b>&nbsp;.................................................
        </td>    
        <td width="50%" >
            <b>วันที่</b>&nbsp; {{DateThaifrom(date('Y-m-d'))}}
        </td>     
    </tr> 
     
</table> 
<table  width="100%">   
    <tr >          
        <td width="100%" >
            <b>เรื่อง</b>&nbsp; ขออนุมัติใช้รถยนต์ไปราชการ
        </td>        
    </tr>   
    <tr>          
        <td width="100%" >
            <b>เรียน</b>&nbsp;<span style="border-bottom: black 1px dotted">ผู้อำนวยการ{{$orgname->ORG_NAME}}</span>
        </td>        
    </tr>  
</table> 

  <table  width="100%">
      <tr>          
          <td width="5%" >
             
          </td>
          <td width="45%" >
              ข้าพเจ้า :&nbsp;<span style="border-bottom: black 1px dotted"> {{$inforperson->HR_FNAME}} {{$inforperson->HR_LNAME}}</span>
          </td>
          <td width="50%" >
              ตำแหน่ง :&nbsp;<span style="border-bottom: black 1px dotted"> {{$inforperson->POSITION_IN_WORK}}</span>
          </td>
      </tr>           
  </table>  
  <table  width="100%">
    <tr> 
        <td width="50%" >           
            หน่วยงาน :&nbsp;<span style="border-bottom: black 1px dotted"> {{$inforcar->HR_DEPARTMENT_SUB_SUB_NAME}}</span> 
        </td>
        <td width="50%" >
            มีความประสงค์ขออนุมัติใช้รถยนต์ของ{{$orgname->ORG_NAME}}
        </td>
    </tr>           
</table> 
<table  width="100%">
    <tr> 
        <td width="5%" >เพื่อ :&nbsp;</td>  
        <td width="25%" > 
                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
                <label class="form-check-label" for="flexCheckChecked">
                ไปราชการต่างจังหวัด
                </label>         
        </td>   
        <td width="20%" > 
            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
            <label class="form-check-label" for="flexCheckChecked">
                ใช้ส่งต่อผู้ป่วย
            </label>         
        </td>  
        <td width="10%" > 
            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
            <label class="form-check-label" for="flexCheckChecked">
                EMS
            </label>         
        </td>
        <td width="20%" > 
            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
            <label class="form-check-label" for="flexCheckChecked">
                ใช้ภายในจังหวัด
            </label>         
        </td>
        <td width="15%" > 
            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
            <label class="form-check-label" for="flexCheckChecked">
               อื่น ฯ
            </label>         
        </td> 
    </tr>           
</table>
<table  width="100%">
    <tr>          
        <td width="5%" >           
        </td>
        <td width="95%" >
            เรื่อง :&nbsp;<span style="border-bottom: black 1px dotted">{{$inforcar->RESERVE_NAME}}</span>
        </td>       
    </tr>           
</table> 
<table  width="100%">
    <tr> 
        <td width="50%" >
            ( กรณีส่งต่อผู้ป่วย ชื่อผู้ป่วย :&nbsp;.........................................................
        </td>
        <td width="50%" >
            ป่วยเป็นโรค :&nbsp;......................................................................................
        </td>
    </tr>           
</table>   
<table  width="100%">
    <tr> 
        <td width="50%" >
            ไปรักษาต่อที่ :&nbsp;.................................................................................)
        </td>
        <td width="50%" >
            โดยมีเจ้าหน้าที่ร่วมเดิรทางจำนวน  :&nbsp;..........................................คน
        </td>
    </tr>           
</table>  
<table  width="100%">
    <tr>          
        <td width="5%" >           
        </td>
        <td width="45%" >
            1 :&nbsp;...........................................................................................
        </td>  
        <td width="50%" >
            ตำแหน่ง :&nbsp;...........................................................................................
        </td>      
    </tr>  
    <tr>          
        <td width="5%" >           
        </td>
        <td width="45%" >
            2 :&nbsp;...........................................................................................
        </td>  
        <td width="50%" >
            ตำแหน่ง :&nbsp;...........................................................................................
        </td>      
    </tr>         
</table> 
<table  width="100%">
    <tr> 
        <td width="30%" >
            ไปวันที่ :&nbsp;<span style="border-bottom: black 1px dotted">{{DateThaifrom($inforcar->RESERVE_BEGIN_DATE)}}</span>
        </td>
        <td width="20%" >
            เวลา :&nbsp;<span style="border-bottom: black 1px dotted">{{thainumDigit(formatetime($inforcar->RESERVE_BEGIN_TIME))}} </span> น.
        </td>
        <td width="30%" >
            ถึงวันที่ :&nbsp;<span style="border-bottom: black 1px dotted">{{DateThaifrom($inforcar->RESERVE_END_DATE)}}</span>
        </td>
        <td width="20%" >
            เวลา :&nbsp;<span style="border-bottom: black 1px dotted">{{thainumDigit(formatetime($inforcar->RESERVE_END_TIME))}}</span> น.
        </td>
    </tr>           
</table> 
<br><br>
<table  width="100%">
    <tr> 
        <td width="30%" >  </td> 
           
        <td width="30%" >
           ลงชื่อ
                    @if ($sigper == '' || $checksig != 1 )
                        ...................................................... 
                    @else
                        @if($checksig == 1 && $sigper !== null && $sigper !== '')&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <img src="{{Storage::path('public/images/'.$sigper)}}" width="100" height="40">
                        @endif 
                    @endif  
        </td>
        <td width="40%" > ผู้ขออนุญาต         
        </td> 
    </tr>           
</table> 
<table  width="100%">
    <tr>  
        <td width="30%" >          
       </td> 
      <td width="70%" >
        @if ($inforcar->RESERVE_PERSON_NAME == '' || $inforcar->RESERVE_PERSON_NAME == null)
            ( &nbsp;.................................................................&nbsp; )   
        @else
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span style="border-bottom: black 1px dotted">{{$inforcar->RESERVE_PERSON_NAME}}</span>
        @endif
              
    </td>       
    </tr> 
</table> 
<hr>
<table  width="100%">
    <tr>  
        <td width="100%" >
            <b>ความเห็นของผู้จัดรถ</b>
        </td>       
    </tr>           
</table> 
<table  width="100%">
    <tr> 
        <td width="5%" >
        </td> 
        <td width="10%" >ให้ใช้ &nbsp;</td>  
        <td width="25%" > 
                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                <label class="form-check-label" for="flexCheckChecked">
                    &nbsp;รถส่วนกลาง
                </label>         
        </td>   
        <td width="50%" > 
            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
            <label class="form-check-label" for="flexCheckChecked">
                @if ($inforcar->CAR_REG == '' || $inforcar->CAR_REG == null)
                &nbsp;รถพยาบาล &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หมายเลขทะเบียน .................................
                @else
                &nbsp;รถพยาบาล &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หมายเลขทะเบียน<span style="border-bottom: black 1px dotted">&nbsp;&nbsp; {{$inforcar->CAR_REG }}</span>
                @endif
                
            </label>         
        </td>  
        <td width="10%" >
        </td>
    </tr>           
</table>
<table  width="100%">
    <tr>         
 
        <td width="40%" >
            โดยไห้นาย :&nbsp;
            @if ($inforcar->CAR_DRIVER_SET_ID == '' || $inforcar->CAR_DRIVER_SET_ID == null)
            ...........................................................
            @else
            <span style="border-bottom: black 1px dotted">{{$inforcar->HR_PREFIX_NAME}}{{$inforcar->HR_FNAME}}  {{$inforcar->HR_LNAME}}</span>
            @endif     
            
        </td> 
        <td width="60%" > เป็นพนักงานขับรถ          
        </td>      
    </tr>           
</table>
<table  width="100%">
    <tr>
        <td width="100%" >
            ความเห็นอื่น ฯ :&nbsp;............................................................................................................................................................................................
        </td> 
             
    </tr>           
</table>
<br><br>
<table  width="100%">
    <tr> 
        <td width="30%" >  </td> 
           
        <td width="30%" >
           ลงชื่อ 
           @if ($sigper == '' || $checksig != 1 )
           ...................................................... 
            @else
                @if($checksig == 1 && $sigper !== null && $sigper !== '')&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <img src="{{Storage::path('public/images/'.$sigper)}}" width="100" height="40">
                @endif 
            @endif 
        </td>
        <td width="40%" > ผู้ขออนุญาต         
        </td> 
    </tr>           
</table> 
<table  width="100%">
    <tr>  
        <td width="30%" >          
       </td> 
      <td width="70%" >
        @if ($inforcar->RESERVE_PERSON_NAME == '' || $inforcar->RESERVE_PERSON_NAME == null)
        ( &nbsp;.................................................................&nbsp; )   
        @else
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span style="border-bottom: black 1px dotted">{{$inforcar->RESERVE_PERSON_NAME}}</span>
        @endif       
    </td>       
    </tr> 
</table> 
<hr>
<table  width="100%">
    <tr>
        <td width="100%" >
            <b>คำสั่งผู้อำนวยการ หรือผู้รับมอบหมาย พิจารณา</b>
        </td>
    </tr>           
</table>
<table  width="100%">
    <tr> 
        <td width="5%" >
        </td> 
        <td width="25%" > 
            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
            <label class="form-check-label" for="flexCheckChecked">
            อนุมัติใช้ภายในจังหวัด
            </label>         
        </td>   
        <td width="30%" > 
            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
            <label class="form-check-label" for="flexCheckChecked">
            ไม่อนุมัติ
            </label>         
        </td>  
        <td width="40%" >
            @if ($sig == '' || $checksig != 1 )
            ลงชื่อ.....................................................ผู้อนุมัติ
            @else
                @if($checksig == 1 && $sig !== null && $sig !== '')&nbsp;&nbsp;&nbsp;&nbsp;
                ลงชื่อ&nbsp;&nbsp;<img src="{{Storage::path('public/images/'.$sig)}}" width="100" height="40">&nbsp;&nbsp;ผู้อนุมัติ
                @endif 
            @endif  
        </td>
    </tr>           
</table>
<table  width="100%">
    <tr> 
        <td width="5%" >
        </td> 
        <td width="55%" > 
            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
            <label class="form-check-label" for="flexCheckChecked">
            อนุมัติไห้เดินทางไปราชการต่างจังหวัด
            </label>         
        </td> 
        <td width="40%" >
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;นายสาโรจน์ จันทร์แก้ว&nbsp;)
        </td>
    </tr>           
</table>
<table  width="100%">
    <tr>  
        <td width="60%" > 
            </label>         
        </td> 
        <td width="40%" >
            รองผู้อำนวยการฝ่ายบริหาร ปฎิบัติราชการแทน
        </td>
    </tr>           
</table>
<table  width="100%">
    <tr>  
        <td width="60%" > 
            </label>         
        </td> 
        <td width="40%" >
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้อำนวยการ{{$orgname->ORG_NAME}}
        </td>
    </tr>           
</table>
<table  width="100%">
    <tr>
        <td width="100%" >
            <b>หมายเหตุ ผู้มีอำนาจ</b>
        </td>
    </tr>           
</table>
<table  width="100%">
    <tr>  
        <td width="10%" > 
                <label for=""></label>
        </td> 
        <td width="90%" >
            <label for="" style="font-size: 11px;">- ในเวลาราชการ ผู้อำนวยการหรือผู้ที่ได้รับมอบหมาย</label><br>
            <label for="" style="font-size: 11px;">- นอกเวลาราชการ แพทย์เวร</label>
        </td>
    </tr>           
</table>
  </body>
</html>
