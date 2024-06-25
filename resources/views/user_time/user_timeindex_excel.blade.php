 
   
   <?php
   header("Content-Type: application/vnd.ms-excel");
   header('Content-Disposition: attachment; filename="ระบบลงเวลาเข้า-ออก.xls"');//ชื่อไฟล์
   
   function DateThais($strDate)
   {
     $strYear = date("Y",strtotime($strDate))+543;
     $strMonth= date("n",strtotime($strDate));
     $strDay= date("j",strtotime($strDate));
   
     $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
     $strMonthThai=$strMonthCut[$strMonth];
     return "$strDay $strMonthThai $strYear";
     }
   
     function getAges($birthday) {
       $then = strtotime($birthday);
       return(floor((time()-$then)/31556926));
   }

   $datenow = date("Y-m-d");
    $y = date('Y') + 543;
    $m_ = date('m');

    if ( $m_ == '1') {
        $m = 'มกราคม';
    } else if( $m_ == '2'){
        $m = 'กุมภาพันธ์';
    } else if( $m_ == '3'){
        $m = 'มีนาคม';
    } else if( $m_ == '4'){
        $m = 'เมษายน';
    } else if( $m_ == '5'){
        $m = 'พฤษภาคม';
    } else if( $m_ == '6'){
        $m = 'มิถุนายน';
    } else if( $m_ == '7'){
        $m = 'กรกฎาคม';
    } else if( $m_ == '8'){
        $m = 'สิงหาคม';
    } else if( $m_ == '9'){
        $m = 'กันยายน';
    } else if( $m_ == '10'){
        $m = 'ตุลาคม';
    } else if( $m_ == '11'){
        $m = 'พฤษจิกายน';
    } else{
        $m = 'ธันวาคม';  
    }
    
   
   ?>
<center>
    <br><br>
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>บัญชีรายชื่อการปฏิบัติงาน </b>กลุ่มภารกิจ {{$debname}}</label><br>
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>กลุ่มงาน/งาน</b>{{$debsubname}}<b>หน่วยงาน </b>{{$debsubsubname}}</label><br>
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>{{$org}}</b></label><br>
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>ประจำเดือน…{{$m}}….พ.ศ…{{$y}}</b></label><br>
</center>
   <br><br>
   <center>
   <table class="table" style="width: 100%">
       <thead>
           <tr>
              
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">ลำดับ</th>
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">วันที่</th>
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;">ชื่อ-สกุล</th>
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">เวลาเข้า</th>              
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">เวลาออก</th> 
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">ประเภท</th> 
           </tr>
       </thead>
       <tbody>
        <?php $i = 1; ?>
        @foreach ($export as $item) 
            <tr>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" align="center" width="10%">{{ $i++ }} </td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" align="center" width="15%">{{ Datethai($item->CHEACKIN_DATE) }}</td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: left;border: 1px solid black;">{{ $item->hrname }}</td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" align="center" width="15%">&nbsp;&nbsp;{{ $item->CHEACKINTIME }}</td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" align="center" width="15%">{{ $item->CHEACKOUTTIME }} </td> 
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" align="center" width="10%">{{ $item->OPERATE_TYPE_NAME }} </td> 
            </tr>
        @endforeach        
       </tbody> 
       <br> 
       <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td></tr>
       <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td></tr>
        <tr>
            <td></td>
            <td></td>
            <td colspan="2">
                <center>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ขอรับรองว่าผู้มาปฏิบัติหน้าที่ราชการตามรายชื่อข้างต้นนี้  ข้าพเจ้าเป็นผู้สั่งให้มาปฏิบัติหน้าที่ราชการ</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> อันเป็นงานที่จำเป็นจะต้องปฏิบัติทำเร่งด่วนเป็นกรณีพิเศษ</label><br><br><br> 
                </center>
            </td> 
            <td></td>  
        </tr> 
        <tr>
            <td></td> 
            <td colspan="2"> 
                <center>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ลงชื่อ..............................................ควบคุม</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ( ..............................................)<br> 
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> หัวหน้ากลุ่มงาน/งาน {{$debsubname}}</label><br>
                </center>
            </td> 
        
            
            <td colspan="2"> 
                <center>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ลงชื่อ..............................................ผู้รับรอง</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ( ..............................................)<br> 
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> หัวหน้ากลุ่มภารกิจ {{$debname}}</label><br>
                </center>
            </td> 
        </tr> 
   </table>
</center>
 

   