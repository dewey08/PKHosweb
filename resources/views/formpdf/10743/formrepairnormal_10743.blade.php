
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
           <img src="{{ asset('image/Garuda.png') }}" width="50" height="50">
        </td>
        <td width="55%" >
          
        </td>
        <td width="30%" >
        เอกสารหมายเลข : &nbsp;
       <!-- {{$informrepair_indexs->REPAIR_ID}}-->
      </td>
    </tr>           
</table> 
  <center> 
      <B style="font-size: 14px;">บันทึกข้อความ</B>      
  </center><br>  
  <table  width="100%" height="10px">
      <tr>          
          <td width="55%" >
              <b>ส่วนราชการ</b>  ฝ่าย/กลุ่มงาน/หน่วยงาน :&nbsp; <span style="border-bottom: black 1px dotted">{{$informrepair_indexs->HR_DEPARTMENT_SUB_SUB_NAME}}</span>
          </td>
          <td width="25%" >
            {{$info_orgs->ORG_NAME}}
          </td>
          <td width="20%" >
            วันที่&nbsp;<span style="border-bottom: black 1px dotted">{{DateThai($informrepair_indexs->DATE_TIME_REQUEST)}}</span>
        </td>
      </tr>           
  </table> 
  <table  width="100%">
    <tr >          
        <td width="100%" >
            <b>เรื่อง</b>&nbsp;ขออนุมัติซ่อมบำรุงครุภัณฑ์ / สิ่งก่อสร้าง
        </td>        
    </tr>           
</table> 

  <hr> 
  <table  width="100%">
    <tr>          
        <td width="100%" >
            <b>เรียน</b>&nbsp; ผู้อำนวยการ <span style="border-bottom: black 1px dotted">{{$info_orgs->ORG_NAME}}</span>
        </td>        
    </tr>           
</table> 
  <table  width="100%">
      <tr>          
          <td width="5%" >
             
          </td>
          <td width="45%" >
              ด้วยกลุ่มงาน / ฝ่าย /งาน :&nbsp;<span style="border-bottom: black 1px dotted">{{$informrepair_indexs->HR_DEPARTMENT_SUB_SUB_NAME}}</span>
          </td>
          <td width="50%" >
              มีความประสงค์ขออนุญาติซ่อม :&nbsp;<span style="border-bottom: black 1px dotted">{{$informrepair_indexs->REPAIR_NAME}}</span>
          </td>
      </tr>           
  </table>  
  <table  width="100%">
    <tr> 
        <td width="40%" >
            @if ($informrepair_indexs->ARTICLE_NUM == '')
            หมายเลขครุภัณฑ์ :&nbsp;...............................................
            @else
            หมายเลขครุภัณฑ์ :&nbsp;<span style="border-bottom: black 1px dotted">{{$informrepair_indexs->ARTICLE_NUM}}</span>
            @endif
            
        </td>
        <td width="60%" >
            เนื่องจาก : &nbsp; <span style="border-bottom: black 1px dotted">{{$informrepair_indexs->SYMPTOM}}</span>
        </td>
    </tr>           
</table> 
<table  width="100%">
    <tr> 
        <td width="90%" >
            <u>ความต้องการ</u> &nbsp;&nbsp;( &nbsp;&nbsp; ) เร่งด่วน &nbsp;&nbsp;เพราะ................................................................................................................................
        </td>
        <td width="10%" >
            ( &nbsp;&nbsp; ) ปกติ
        </td>
    </tr>           
</table> 
<table  width="100%">
    <tr> 
        <td width="10%" >
           
        <td width="90%" >
           จึงเรียนมาเพื่อโปรดพิจารณา
        </td>
    </tr>           
</table> 
<table  width="100%">
    <tr>  
        <td width="5%" >               
        </td> 
        <td width="45%" >
          
       </td> 
       <td width="50%" >
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลงชื่อ .................................................ผู้แจ้งซ่อม <br>          
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( &nbsp;<span style="border-bottom: black 1px dotted">{{$informrepair_indexs->USRE_REQUEST_NAME}}</span>  &nbsp; ) <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตำแหน่ง&nbsp;&nbsp;<span style="border-bottom: black 1px dotted">{{$informrepair_indexs->POSITION_IN_WORK}}</span> <br>
        
   </td>         
    </tr> 
</table> 
<br>
<table width="100%" class="one">  
    <tr align="center" >          
        <td width="100%" colspan="4" height="2%">
            <b>บันทึกของหน่วยซ่อมบำรุง</b>
        </td> 
    </tr> 
    <tr>          
        <td width="25%" class="o">
            เลขที่รับงาน <span style="border-bottom: black 1px dotted">{{$informrepair_indexs->REPAIR_ID}}</span>
        </td> 
        <td width="25%" class="o">
            วันที่รับงาน <span style="border-bottom: black 1px dotted">{{DateThai($informrepair_indexs->TECH_RECEIVE_DATE)}}</span>
        </td>
        <td width="25%" class="o">
            วันที่ตรวจสอบ <span style="border-bottom: black 1px dotted">{{DateThai($informrepair_indexs->TECH_REPAIR_DATE)}}</span>
        </td>
        <td width="25%" class="o">
            ช่างผู้รับผิดชอบ &nbsp;.........................
        </td>
    </tr>
    <tr>          
        <td width="100%" class="o" colspan="4">
            @if ($informrepair_indexs->REPAIR_COMMENT == '')
            1.ผลการตรวจสอบ พบว่าส่วนที่ชำรุด คือ :&nbsp;...............................................
            @else
            1.ผลการตรวจสอบ พบว่าส่วนที่ชำรุด คือ <span style="border-bottom: black 1px dotted">{{$informrepair_indexs->REPAIR_COMMENT}}</span>
            @endif
           
        </td>         
    </tr>
    <tr>          
        <td width="100%" class="o" colspan="4">
            2.สรุปผลการตรวจสอบ &nbsp;&nbsp;&nbsp;&nbsp; ( &nbsp;&nbsp; )&nbsp; มีความคุ้มค่าในการซ่อม
            &nbsp;&nbsp;&nbsp;&nbsp; ( &nbsp;&nbsp; )&nbsp; ไม่ควรซ่อมเนื่องจากมีค่าใช้จ่ายสูงใกล้เคียงกับซื้อใหม่
        </td>         
    </tr>
    <tr>          
        <td width="100%" class="o" colspan="4">
            3.ข้อเสนอการซ่อม &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( &nbsp;&nbsp; )&nbsp; ซ่อมได้เอง
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( &nbsp;&nbsp; )&nbsp; ส่งซ่อมศูนย์ช่าง&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( &nbsp;&nbsp; )&nbsp;ส่งซ่อมเอกชน
        </td>         
    </tr>
    <tr>          
        <td width="100%" class="d" colspan="4" style="vertical-align:top;">
            4.ประมาณการอุปกรณ์ / อะไหล่ที่ใช้ในการซ่อม <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            1.&nbsp;................................................................................... ราคา ........................บาท <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            2.&nbsp;................................................................................... ราคา ........................บาท <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            3.&nbsp;................................................................................... ราคา ........................บาท <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            4.&nbsp;................................................................................... ราคา ........................บาท <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            5.&nbsp;................................................................................... ราคา ........................บาท <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;ประมาณค่าใช้จ่าย&nbsp;&nbsp; รวม&nbsp;.............................................................................บาท <br>
        </td> 
    </tr>    
</table>
<table width="100%" class="one">   
    <tr>
        <td rowspan="2" class="o" width = "40%" style="vertical-align:top;">
            ความเห็นของคณะกรรมการซ่อมบำรุง <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( &nbsp;&nbsp; ) &nbsp; เห็นควรอนุมัติ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( &nbsp;&nbsp; ) &nbsp; เพื่อโปรดพิจารณาใหม่<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( &nbsp;&nbsp; ) &nbsp; เห็นควรจำหน่าย &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( &nbsp;&nbsp; ) &nbsp;เห็นควรจัดหาใหม่<br>
            &nbsp;&nbsp;&nbsp;.....................................................&nbsp;รองผู้อำนวยการฝ่ายบริหาร<br>
            &nbsp;&nbsp;&nbsp;.....................................................&nbsp;หัวหน้าฝ่ายบริหารทั่วไป<br>
            &nbsp;&nbsp;&nbsp;.....................................................&nbsp;หัวหน้างานการพัสดุ<br>
            &nbsp;&nbsp;&nbsp;.....................................................&nbsp;หัวหน้างานช่างและซ่อมบำรุง<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            ลงชื่อ............................................... &nbsp;<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;ประธานคณะกรรมการซ่อมบำรุง<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            วันที่............................................... &nbsp;
        </td>
        <td class="o" style="vertical-align:top;">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลงชื่อ ..................................................................ช่างผู้ตรวจ <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;วันที่ ..................................................................
        </td>
    </tr>
    <tr>
        <td class="o" style="vertical-align:top;">
            คำสั่งผู้อำนวยการโรงพยาบาลระนอง  <br>
            &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;( &nbsp;&nbsp; ) &nbsp; อนุมัติ<br>
            &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;( &nbsp;&nbsp; ) &nbsp; .................................................................................<br>
            &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;................................................................................<br>
            &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;ลงชื่อ.........................................................................<br>
            &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;วันที่..........................................................................<br><br>
        </td>
    </tr>
    <tr>
        <td class="o" colspan="2">
            &nbsp;&nbsp;&nbsp;บันทึกการส่งมอบหมายงาน&nbsp;&nbsp;&nbsp; วันที่.........................................	เวลา.........................สถานที่ได้รับมอบ................................................	<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                ผู้รับมอบงาน.......................................................................................................................................<br><br>
        </td>
    </tr>
    
  </table>

  </body>
  </html>
