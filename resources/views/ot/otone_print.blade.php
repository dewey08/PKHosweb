<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            /* src: url("{{ asset('fonts/THSarabunNew.ttf') }}") format('truetype'); */
            src: url("{{ asset('http://127.0.0.1:8000/pkclaim/fonts/THSarabunNew/THSarabunNew.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            /* src: url("{{ asset('fonts/THSarabunNew Bold.ttf') }}") format('truetype'); */
            src: url("{{ asset('http://127.0.0.1:8000/pkclaim/fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            /* src: url("{{ asset('fonts/THSarabunNew Italic.ttf') }}") format('truetype'); */
            src: url("{{ asset('http://127.0.0.1:8000/pkclaim/fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            /* src: url("{{ asset('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype'); */
            src: url("{{ asset('http://127.0.0.1:8000/pkclaim/fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }
        body {
            font-family: "THSarabunNew";
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
<body>
    <table  width="100%">   
          <tr>
              <td width="15%" >
                  {{-- <img src="image/Garuda.png" width="50" height="50"> --}}
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
              {{-- <B style="font-size: 17px;">{{$f}}</B>              --}}
        
  </center> <br>
  <table  width="100%">   
      <tr>             
          <td width="100%" >
              ส่วนราชการ &nbsp;&nbsp;&nbsp; สววสว&nbsp;&nbsp;&nbsp;อำเภอ&nbsp;่า่่า&nbsp;&nbsp;&nbsp;จังหวัด&nbsp;สวสว&nbsp;&nbsp;&nbsp;สสส<br>     
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
              เรื่อง &nbsp;&nbsp;ขออนุมัติเดินทางไปราชการและขอใช้รถส่วนกลาง
          </td>
      </tr> 
      <tr>
          <td width="100%">
              เรียน &nbsp;&nbsp;ผู้อำนวยการ
          </td>
      </tr>            
  </table> 
  <table  width="100%">
          <tr>
              <td width="10%"></td>
              <td width="50%" >
                  ข้าพเจ้า&nbsp; 
              </td>
              <td width="40%" >
                  ตำแหน่ง&nbsp;
              </td>
          </tr>           
  </table>
  <table width="100%">
          <tr>
              <td width="100%">
                  มีความประสงค์เดินทางไปราชการและขออนุญาติใช้รถส่วนกลาง &nbsp;ณ&nbsp;&nbsp; 
              </td>
          </tr>
  </table>
  <table width="100%">
      <tr>
          <td width="100%">
              เพื่อ&nbsp;&nbsp; 
          </td>
      </tr>
  </table>
  <table width="100%">
      <tr>
          <td width="60%">
              ในวันที่&nbsp;&nbsp; 
          </td>
          <td width="40%">
              เวลา&nbsp;&nbsp;  น.
          </td>
      </tr>
  </table>
  <table width="100%">
      <tr>
          <td width="60%">
              ถึงวันที่&nbsp;&nbsp; 
          </td>
          <td width="40%">
              เวลา&nbsp;&nbsp;  น.
          </td>
      </tr>
  </table>

 

  <table width="100%">
      <tr>
          <td width="60%">
              ผู้ควบคุมการใช้รถยนต์ ลงชื่อ  ......................................................
          </td>
          <td width="40%">
              ตำแหน่ง  ......................................................
          </td>
      </tr>
  </table>
  <table width="100%">
      <tr>
          <td width="60%">
              ผู้ดูแลการใช้รถยนต์ (ธุรการ)  ......................................................
          </td>
          <td width="40%">
              ใช้รถยนต์ ทะเบียน .....................................
          </td>
      </tr>
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
  <br>
  <table width="100%">
      <tr>
          <td width="35%">                   
          </td>
          <td  width="25%" >
             
              
              ..........................................................
              
          </td>
          <td width="40%">
              ผู้ขออนุญาต 
          </td>
      </tr>
    
  </table>

  <table width="100%">
      <tr>
          <td width="35%">                   
          </td>
          <td  width="25%" > 
             
              
              ..........................................................
              
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
              ผู้อำนวยการ
          </td>
          <td width="5%">
              คำสั่ง
          </td>
          <td width="45%">
              ผู้อำนวยการ
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
                <div class="form-group">
                  <div class="form-check">
                      <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                      <label class="form-check-label" for="inlineRadio1">อนุมัติ </label>                           
                  </div>                       
                </div>
          </td>
          <td width="30%">
              <div class="form-group">
                  <div class="form-check">
                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option1">
                    <label class="form-check-label" for="inlineRadio2">ไม่อนุมัติ </label>                          
                  </div>
                </div>
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
                        
      
              <td width="5%">                   
              </td> 
              <td width="45%">
                  ..........................................................
              </td>
   
              <td width="10%">                   
              </td> 
              <td width="40%">
                 322323 
       
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
            333333333
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

</center>
</body>
</html>