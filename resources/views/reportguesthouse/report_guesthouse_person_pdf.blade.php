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
          padding: 5.00pt 7.1732pt 7.1732pt 5.00pt;             
      }
      
      table {
  border: 1px solid black;
}
td {
  border: 1px solid black;
  font-size: 13px !important;
  /* vertical-align: top; */
  /* vertical-align:middle; */
}
th {
  border: 1px solid black;
  font-size: 13px !important;
}

table {    
  width: 100%;
  margin-left: 1%;
  border-collapse: collapse;
  /* border: 1px solid black; */
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
        <center >
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
        </center> 
          <center >
            <B style="font-size: 15px;">รายชื่อบุคลากรที่เข้าพักอาศัยในแฟลตและบ้านพัก </B><br>
              <B style="font-size: 15px;">{{$orgname->ORG_NAME}} &nbsp;&nbsp;&nbsp;จังหวัด {{$orgname->PROVINCE}} </B><br>
              <B style="font-size: 15px;">ปีงบประมาณ &nbsp;&nbsp;{{$year_id}} </B>
        </center> <br>

        <table class="table" style="width: 100%;" >
            <thead>
                <tr height="40">
                    <th class="text-font" style="text-align: center;border: 1px solid black;" width="5%">ลำดับ</th>
                    <th class="text-font" style="text-align: center;border: 1px solid black;" width="15%">ชื่อแฟลต / บ้านพัก</th>
                    <th class="text-font" style="text-align: center;border: 1px solid black;" width="20%">หมายเลขห้องพักหรือชื่อห้องพัก</th>
                    <th class="text-font" style="text-align: center;border: 1px solid black;" width="20%">ชื่อ-สุกล ผู้ที่พัก</th>
                    <th class="text-font" style="text-align: center;border: 1px solid black;" width="20%">ตำแหน่ง</th>
                    <th class="text-font" style="text-align: center;border: 1px solid black;" width="20%">หน่วยงาน</th>  
                </tr >
            </thead>
            <tbody>  
                <?php $number = 0; ?>
                @foreach ($report_gesthpers as $reportgesthper)
                    <?php $number++;?> 
                       
                            <?php $checkhom = DB::table('guesthous_infomation_person')->where('INFMATION_ID','=',$reportgesthper->INFMATION_ID)->where('INFMATION_PERSON_STATUS','=','1')->count(); ?>
                           
                            @if($checkhom !== 0)  
                                <tr height="20">                                  
                                    <td class="text-font" style="text-align:center;border: 1px solid black;" width="5%">&nbsp;{{$number}}</td>
                                    <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;" width="15%">&nbsp;&nbsp;{{$reportgesthper->INFMATION_NAME}}</td>
                                    <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;" width="20%">&nbsp;&nbsp;{{$reportgesthper->LEVEL_ROOM_NAME}}</td>
                                    <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;" width="20%">&nbsp;&nbsp;{{$reportgesthper->HR_FNAME}} &nbsp;{{$reportgesthper->HR_LNAME}}</td>
                                    <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;" width="20%">&nbsp;&nbsp;{{$reportgesthper->HR_POSITION_NAME}}</td>                                                             
                                    <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;" width="20%">&nbsp;&nbsp;{{$reportgesthper->HR_DEPARTMENT_SUB_SUB_NAME}}</td>  
                                </tr>    
                            @endif                                                                                  
                       
                @endforeach   
            </tbody>
        </table>
 
  
     </body>
  </html> 