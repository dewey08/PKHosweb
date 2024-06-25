 
   
   <?php
   header("Content-Type: application/vnd.ms-excel");
   header('Content-Disposition: attachment; filename="Referข้าม CUP ภายในจังหวัด.xls"');//ชื่อไฟล์
   
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
    <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>Report REFER ข้าม CUP ภายในจังหวัด </b></label><br>
    {{-- <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>กลุ่มงาน/งาน</b>{{$debsubname}}<b>หน่วยงาน </b>{{$debsubsubname}}</label><br> --}}
    <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>{{$org}}</b></label><br>
    {{-- <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>ประจำเดือน…{{$m}}….พ.ศ…{{$y}}</b></label><br> --}}
</center>
   <br><br>
   <table class="table" style="width: 100%">
       <thead>
           <tr>
              
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="5%">ลำดับ</th>
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">cid</th>
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">hn</th>
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;">ชื่อ-สกุล</th>
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">Hmain</th>  
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">Hcode</th>              
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">วันที่รับบริการ</th> 
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">pdx</th> 
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">ค่าบริการ</th> 
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">ยอดเรียกเก็บตามข้อตกลง</th> 
           </tr>
       </thead>
       <tbody>
        <?php $i = 1; ?>
        @foreach ($export as $item) 
            <tr>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{ $i++ }} </td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">{{ $item->cid }}</td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">{{ $item->hn }}</td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: left;border: 1px solid black;">&nbsp;&nbsp;{{ $item->fullname }}</td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{ $item->hospmain }}</td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{ $item->hcode }}</td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">{{ $item->vstdate }} </td> 
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{ $item->pdx }} </td> 
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: right;border: 1px solid black;" width="10%">&nbsp;&nbsp;{{ number_format($item->uc_money,2) }} </td> 
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: right;border: 1px solid black;" width="15%">&nbsp;&nbsp;{{ number_format($item->uc_money_kor_tok,2) }} </td> 
            </tr>
        @endforeach        
       </tbody> 
       
   </table>
   
 

   