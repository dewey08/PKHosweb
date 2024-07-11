 
   
   <?php
   header("Content-Type: application/vnd.ms-excel");
   header('Content-Disposition: attachment; filename="จำนวนอัตรากำลังกลุ่มภารกิจด้านการพยาบาล.xls"');//ชื่อไฟล์
   
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
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>จำนวนอัตรากำลังกลุ่มภารกิจด้านการพยาบาล</b></label><br>
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>ปีงบประมาณ {{DateThais($datenow)}}</b></label><br> 
</center>
   <br><br>
   <center>
    <table class="table table-borderless table-bordered" style="width: 100%;border: 1px;color:black;"> 
        <thead>
            <tr>                                        
                <th class="text-center" rowspan="2" style="background: #fdf7e4;border: 1px;color:black;">ward</th>
                <th class="text-center" width="15%" rowspan="2" style="background: #fdf7e4;border: 1px;color:black;">ward name</th> 
                <th class="text-center" style="background: #e4fdfc;border: 1px;color:black;">ยอดผู้ป่วย</th> 
                <th class="text-center" style="background: #e4fdfc;border: 1px;color:black;" colspan="2">จำนวนพยาบาลเวรเช้า</th>
                <th class="text-center" style="background: #e4fdfc;border: 1px;color:black;" rowspan="2">Nursing <br> product</th>

                <th class="text-center" style="background: #dadffa;border: 1px;color:black;">ยอดผู้ป่วย</th> 
                <th class="text-center" style="background: #dadffa;border: 1px;color:black;" colspan="2">จำนวนพยาบาลเวรบ่าย</th>
                <th class="text-center" style="background: #dadffa;border: 1px;color:black;" rowspan="2">Nursing<br> product</th>

                <th class="text-center" style="background: #fadbda;border: 1px;color:black;">ยอดผู้ป่วย</th> 
                <th class="text-center" style="background: #fadbda;border: 1px;color:black;" colspan="2">จำนวนพยาบาลเวรดึก</th> 
                <th class="text-center" style="background: #fadbda;border: 1px;color:black;" rowspan="2">Nursing<br> product</th>  
            </tr>
            <tr> 
                <th class="text-center" style="background: #fde4f8;border: 1px;color:black;">8.00</th>
                <th class="text-center" style="background: #fde4f8;border: 1px;color:black;">ควรจะเป็น</th>
                <th class="text-center" style="background: #fde4f8;border: 1px;color:black;">ขึ้นจริง</th> 

                <th class="text-center" style="background: #fde4f8;border: 1px;color:black;">16.00</th>
                <th class="text-center" style="background: #fde4f8;border: 1px;color:black;">ควรจะเป็น</th>
                <th class="text-center" style="background: #fde4f8;border: 1px;color:black;">ขึ้นจริง</th> 

                <th class="text-center" style="background: #fde4f8;border: 1px;color:black;">24.00</th>
                <th class="text-center" style="background: #fde4f8;border: 1px;color:black;">ควรจะเป็น</th>
                <th class="text-center" style="background: #fde4f8;border: 1px;color:black;">ขึ้นจริง</th>                                          
            </tr>
        </thead>
        <tbody> 
            <?php $i = 1; ?>
                @foreach ($datashow as $item) 
                    <tr style="font-size:13px"> 
                        <td class="text-center" width="5%" style="border: 1px;color:black;">{{ $item->ward }} </td>
                        <td class="p-2" style="border: 1px;color:black;"> {{ $item->ward_name }}</td> 
                        <td class="text-center" width="7%" style="border: 1px;color:black;">{{ $item->count_an1 }} </td> 
                        <td class="text-center" width="5%" style="border: 1px;color:black;">{{$item->soot_a}} </td> 
                        <td class="text-center" width="5%" style="border: 1px;color:black;">{{ $item->np_a }} </td>
                        <td class="text-center" width="7%" style="border: 1px;color:black;"> {{number_format($item->soot_a_total, 2) }}</td> 
                        <td class="text-center" width="7%" style="border: 1px;color:black;">{{ $item->count_an2 }} </td>  
                        <td class="text-center" width="5%" style="border: 1px;color:black;">{{ $item->soot_b }} </td>  
                        <td class="text-center" width="5%" style="border: 1px;color:black;"> {{$item->np_b}} </td>                                          
                        <td class="text-center" width="7%" style="border: 1px;color:black;">{{number_format($item->soot_b_total, 2) }}</td> 
                        <td class="text-center" width="7%" style="border: 1px;color:black;">{{ $item->count_an3 }} </td>  
                        <td class="text-center" width="5%" style="border: 1px;color:black;">{{ $item->soot_c}} </td>  
                        <td class="text-center" width="5%" style="border: 1px;color:black;"> {{$item->np_c}} </td>                                          
                        <td class="text-center" width="7%" style="border: 1px;color:black;">{{number_format($item->soot_c_total, 2) }}</td>
                    </tr>
                @endforeach
        </tbody>
    </table>
   <table class="table" style="width: 100%">
       
       <br> 
       <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td></tr>
       <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td></tr>
       
        {{-- <tr>
            <td></td> 
            <td colspan="2"> 
                <center>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ลงชื่อ..........................................ผู้ตรวจสอบ</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> (   นายจตุพร   มิ่งศิริ   )<br> 
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ตำแหน่ง พนักงานบริการ</label><br>
                </center>
            </td> 
            <td colspan="2"> 
            </td> 
            <td colspan="2"> 
                <center>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ลงชื่อ..........................................ผู้ควบคุม</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ( นายพงศ์วิจักษณ์   พรมทอง)<br> 
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ตำแหน่ง นักจัดการงานทั่วไป </label><br>
                </center>
            </td> 
            <td colspan="2"> 
            </td> 
            <td colspan="2"> 
                <center>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ลงชื่อ............................................</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ( นายสถาพร   ป้อมสุวรรณ)<br> 
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> หัวหน้ากลุ่มภารกิจด้านอำนวยการ </label><br>
                </center>
            </td> 
        </tr>  --}}
   </table>
</center>
 

   