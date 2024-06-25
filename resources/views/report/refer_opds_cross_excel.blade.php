 
   
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
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">cid</th>
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="7%">hn</th>
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;">ชื่อ-สกุล</th>
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">โรงพยาบาล</th>  
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="7%">สิทธิ์ Hos</th>              
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="7%">วันที่รับบริการ</th> 
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="5%">pdx</th> 
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="5%">dx0</th> 
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="5%">dx1</th> 
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="7%">income</th> 
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="7%">inst</th>  
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="7%">ยอดเรียกเก็บ</th> 
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">Total</th> 
           </tr>
       </thead>
       <tbody> 
        <?php $i = 1;;$total1 = 0; $total2 = 0;$total3 = 0; ?>
        @foreach ($export as $item) 
                    <?php  
                        $data_ = DB::connection('mysql3')->select('
                            SELECT sum(sum_price) as sum_price                                
                                FROM vn_stat v  
                                left join opitemrece op ON op.vn = v.vn
                                WHERE v.vn="'.$item->vn.'"
                                and op.income ="02" 
                        '); 
                        foreach ($data_ as $key => $value) {
                            $inst_income = $value->sum_price;
                        }                        
                    ?>
            <tr>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="5%">{{ $i++ }} </td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{ $item->cid }}</td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="7%">{{ $item->hn }}</td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: left;border: 1px solid black;">&nbsp;&nbsp;{{ $item->ptname }}</td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{ $item->hospmain }}</td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="7%">{{ $item->pttype }}</td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="7%">{{ $item->vstdate }} </td> 
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="5%">{{ $item->pdx }} </td> 
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="5%">{{ $item->dx0 }} </td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="5%">{{ $item->dx1 }} </td> 
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: right;border: 1px solid black;" width="7%">&nbsp;&nbsp;{{ number_format($item->income,2) }} </td> 
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: right;border: 1px solid black;" width="7%">&nbsp;&nbsp;{{ number_format($item->income,2) }} </td> 
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: right;border: 1px solid black;" width="7%">&nbsp;&nbsp;{{ number_format($inst_income,2) }} </td> 
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: right;border: 1px solid black;" width="10%">&nbsp;&nbsp;{{ number_format($item->total,2) }} </td> 
            </tr>
            <?php
                $total1 = $total1 + ($item->income); 
                $total2 = $total2 + $item->refer;
                $total3 = $total3 + $item->total;
            ?>
        @endforeach        
       </tbody> 
       <tr>
            <td colspan="10" class="text-end" style="font-family: 'Kanit', sans-serif;border-color:#030303;text-align: right;"></td> 
            <td class="text-end" style="font-family: 'Kanit', sans-serif;border-color:#020202;text-align: right;">{{ number_format($total1,2)}}</td> 
            <td class="text-end" style="font-family: 'Kanit', sans-serif;border-color:#070707;text-align: right;">{{ number_format($total2,2)}}</td> 
            <td class="text-end" style="font-family: 'Kanit', sans-serif;border-color:#0f0f0f;text-align: right;"></td> 
            <td class="text-end" style="font-family: 'Kanit', sans-serif;border-color:#000000;text-align: right;">{{ number_format($total3,2)}}</td>   
        </tr>  
   </table>
   
 

   