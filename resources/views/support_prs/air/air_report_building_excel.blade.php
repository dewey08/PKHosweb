 
   
   <?php
   header("Content-Type: application/vnd.ms-excel");
   header('Content-Disposition: attachment; filename="รายงานการข้อมูลเครื่องปรับอากาศ.xls"');//ชื่อไฟล์
   
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
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>รายงานการข้อมูลเครื่องปรับอากาศ โรงพยาบาลภูเขียวเฉลิมพระเกียรติ</b></label><br>
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>ปีงบประมาณ {{$ynow}}</b></label><br> 
</center>
   <br><br>
   <center>
    <table class="table table-borderless table-bordered" style="width: 100%;border: 1px;color:black;">
        <thead>
            <tr style="font-size:13px"> 
                <th rowspan="2" width="3%" class="text-center" style="border: 1px;color:black;background-color: rgb(255, 251, 228);width: 5%">ลำดับ</th>  
                <th rowspan="2" class="text-center" style="border: 1px;color:black;background-color: rgb(199, 253, 237)">อาคาร</th>  
                <th rowspan="2" class="text-center" style="border: 1px;color:black;background-color: rgb(199, 253, 237);width: 7%">เลขอาคาร</th>  
                <th rowspan="2" class="text-center" style="border: 1px;color:black;background-color: rgb(199, 253, 237);width: 7%">จำนวน</th>  
                <th colspan="6" class="text-center" style="border: 1px;color:black;background-color: rgb(239, 228, 255);width: 40%">ขนาด(btu)</th>   
            </tr> 
            <tr style="font-size:13px">  
                <th class="text-center" style="border: 1px;color:black;">ต่ำกว่า 10000</th> 
                <th class="text-center" style="border: 1px;color:black;">10001-20000</th>   
                <th class="text-center" style="border: 1px;color:black;">20001-30000</th> 
                <th class="text-center" style="border: 1px;color:black;">30001-40000</th>
                <th class="text-center" style="border: 1px;color:black;">40001-50000</th>
                <th class="text-center" style="border: 1px;color:black;">50000 ขึ้นไป</th>
            </tr> 
        </thead>
        <tbody>
            <?php $i = 0; ?>
            @foreach ($datashow as $item) 
            <?php $i++ ?> 
                     
                <tr> 
                    <td class="text-center" style="width: 5%;border: 1px;color:black">{{$i}}</td>
                    <td class="text-start;" style="border: 1px;color:black"> {{$item->building_name}}</td>
                    <td class="text-center;" style="border: 1px;color:black;width: 7%;"> {{$item->building_id}} </td>
                    <td class="text-center;" style="border: 1px;color:black;width: 7%;"> {{$item->qtyall}}</td>
                    <td class="text-center;" style="border: 1px;color:black;width: 7%;"> {{$item->less_10000}} </td>
                    <td class="text-center;" style="border: 1px;color:black;width: 7%;"> {{$item->one_two}} </td>
                    <td class="text-center;" style="border: 1px;color:black;width: 7%;"> {{$item->two_tree}} </td>
                    <td class="text-center;" style="border: 1px;color:black;width: 7%;"> {{$item->tree_four}} </td>
                    <td class="text-center;" style="border: 1px;color:black;width: 7%;"> {{$item->four_five}} </td>
                    <td class="text-center;" style="border: 1px;color:black;width: 7%;"> {{$item->more_five}} </td>
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
 

   