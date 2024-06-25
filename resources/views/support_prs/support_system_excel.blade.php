 
   
   <?php
   header("Content-Type: application/vnd.ms-excel");
   header('Content-Disposition: attachment; filename="รายงานผลการตรวจสอบสภาพถังดับเพลิง.xls"');//ชื่อไฟล์
   
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
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>รายงานผลการตรวจสอบสภาพถังดับเพลิง โรงพยาบาลภูเขียวเฉลิมพระเกียรติ จังหวัดชัยภูมิ</b></label><br>
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>ปีงบประมาณ {{$ynow}}</b></label><br>
   {{-- <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>ประจำเดือน…{{$m}}….พ.ศ…{{$y}}</b></label><br> --}}
</center>
   <br><br>
   <center>
    <table class="table table-borderless table-bordered" style="width: 100%;">
        <thead>
            <tr>
                <th rowspan="3" class="text-center" style="background-color: rgb(255, 251, 228);border: 1px solid black;">ลำดับ</th>
                <th rowspan="3" class="text-center" style="background-color: rgb(255, 251, 228);border: 1px solid black;">เดือนที่ตรวจ</th>
                <th colspan="6" class="text-center" style="background-color: rgb(255, 237, 117);border: 1px solid black;">ถังดับเพลิงทั้งหมดที่มี (ถัง)</th>
                <th colspan="6" class="text-center" style="background-color: rgb(117, 216, 255);border: 1px solid black;">ถังดับเพลิงที่ได้รับการตรวจสอบ (ถัง)</th>
                <th rowspan="3" class="text-center" style="background-color: rgb(247, 157, 151);border: 1px solid black;">จำนวน<br>ที่ไม่ได้ตรวจ<br>รวม(ถัง)</th>
                <th rowspan="3" class="text-center" style="background-color: rgb(250, 211, 226);border: 1px solid black;">จำนวน<br>ที่ชำรุด<br>รวม(ถัง)</th>
                <th colspan="2" class="text-center" style="background-color: rgb(253, 185, 211);border: 1px solid black;">ร้อยละ</th> 
            </tr>
            <tr> 
                <th colspan="3" class="text-center" style="background-color: rgb(255, 176, 157);border: 1px solid black;">ชนิดผงเคมีแห้ง (ถังแดง)</th>
                <th colspan="2" class="text-center" style="background-color: rgb(139, 247, 211);border: 1px solid black;">ชนิดน้ำยาระเหย</th>
                <th rowspan="2" class="text-center" style="background-color: rgb(138, 189, 247);border: 1px solid black;">รวมทั้งหมด</th> 
                <th colspan="3" class="text-center" style="background-color: rgb(255, 176, 157);border: 1px solid black;">ชนิดผงเคมีแห้ง (ถังแดง)</th>
                <th colspan="2" class="text-center" style="background-color: rgb(139, 247, 211);border: 1px solid black;">ชนิดน้ำยาระเหย</th>
                <th rowspan="2" class="text-center" style="background-color: rgb(138, 189, 247);border: 1px solid black;">รวมทั้งหมด</th>   
                <th rowspan="2" class="text-center" style="background-color: rgb(255, 251, 228);border: 1px solid black;">ที่ตรวจ<br> รวม(ถัง)</th> 
                <th rowspan="2" class="text-center" style="background-color: rgb(228, 253, 255);border: 1px solid black;">ที่ชำรุด<br> รวม(ถัง)</th> 
            </tr>
            <tr> 
                <th class="text-center" style="background-color: rgb(253, 210, 199);border: 1px solid black;">10 ปอนด์</th>
                <th class="text-center" style="background-color: rgb(253, 210, 199);border: 1px solid black;">15 ปอนด์</th>
                <th class="text-center" style="background-color: rgb(253, 210, 199);border: 1px solid black;">20 ปอนด์</th>
                <th colspan="2" class="text-center" style="background-color: rgb(218, 252, 241);border: 1px solid black;">(ถังเขียว) 10 ปอนด์</th> 
                <th class="text-center" style="background-color: rgb(253, 210, 199);border: 1px solid black;">10 ปอนด์</th>
                <th class="text-center" style="background-color: rgb(253, 210, 199);border: 1px solid black;">15 ปอนด์</th>
                <th class="text-center" style="background-color: rgb(253, 210, 199);border: 1px solid black;">20 ปอนด์</th>
                <th colspan="2" class="text-center" style="background-color: rgb(218, 252, 241);border: 1px solid black;">(ถังเขียว) 10 ปอนด์</th>  
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            @foreach ($datareport as $itemreport) 
                <?php $i++ ?>
                <?php 
                        $dashboard_ = DB::select(
                                                'SELECT (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red") as red_all
                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="10" AND fire_edit ="Narmal") as redten
                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="15" AND fire_edit ="Narmal") as redfifteen
                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="20" AND fire_edit ="Narmal") as redtwenty 
                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_size ="10" AND fire_edit ="Narmal") as greenten
                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="10" AND fire_edit ="Narmal")+
                                                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="15" AND fire_edit ="Narmal")+
                                                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_size ="20" AND fire_edit ="Narmal")+
                                                    (SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_size ="10" AND fire_edit ="Narmal") total_all
                                                    
                                                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="10" AND month(fc.check_date) = "'.$itemreport->months.'" AND year(fc.check_date) = "'.$itemreport->years.'") as Check_redten
                                                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="15" AND month(fc.check_date) = "'.$itemreport->months.'" AND year(fc.check_date) = "'.$itemreport->years.'") as Check_redfifteen
                                                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="20" AND month(fc.check_date) = "'.$itemreport->months.'" AND year(fc.check_date) = "'.$itemreport->years.'") as Check_redtwenty
                                                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "green" AND f.fire_size ="10" AND month(fc.check_date) = "'.$itemreport->months.'" AND year(fc.check_date) = "'.$itemreport->years.'") as Check_greenten

                                                    ,(SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="10" AND month(fc.check_date) = "'.$itemreport->months.'" AND year(fc.check_date) = "'.$itemreport->years.'")+
                                                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="15" AND month(fc.check_date) = "'.$itemreport->months.'" AND year(fc.check_date) = "'.$itemreport->years.'")+
                                                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "red" AND f.fire_size ="20" AND month(fc.check_date) = "'.$itemreport->months.'" AND year(fc.check_date) = "'.$itemreport->years.'")+
                                                    (SELECT COUNT(fc.fire_id) FROM fire_check fc LEFT JOIN fire f ON f.fire_id=fc.fire_id WHERE fc.fire_check_color = "green" AND f.fire_size ="10" AND month(fc.check_date) = "'.$itemreport->months.'" AND year(fc.check_date) = "'.$itemreport->years.'") as Checktotal_all

                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE active = "N") as camroot
                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green") as green_all
                                                    ,(SELECT COUNT(fire_id) FROM fire_check WHERE fire_check_color = "green") as Checkgreen_all
                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "red" AND fire_backup = "Y") as backup_red
                                                    ,(SELECT COUNT(fire_id) FROM fire WHERE fire_color = "green" AND fire_backup = "Y") as backup_green
                                                FROM fire_check f
                                                WHERE month(f.check_date) = "'.$itemreport->months.'"
                                                AND year(f.check_date) = "'.$itemreport->years.'" 
 
                                            ');                                      
                        foreach ($dashboard_ as $key => $value) {
                            $red_all               = $value->red_all;
                            $redten                = $value->redten;
                            $redfifteen            = $value->redfifteen;
                            $redtwenty             = $value->redtwenty;
                            $greenten              = $value->greenten;
                            $total_all             = $value->total_all;
                            $Check_redten          = $value->Check_redten;
                            $Check_redfifteen      = $value->Check_redfifteen;
                            $Check_redtwenty       = $value->Check_redtwenty;
                            $Check_greenten        = $value->Check_greenten;
                            $Checktotal_all        = $value->Checktotal_all;
                            $camroot               = $value->camroot;
                            $green_all             = $value->green_all;
                            $Checkgreen_all        = $value->Checkgreen_all;
                        } 
                        $sumyokma_all_ = DB::select(
                            'SELECT COUNT(f.fire_id) as cfire 
                                FROM fire_check fc  
                                LEFT OUTER JOIN fire f ON f.fire_id = fc.fire_id
                                WHERE month(fc.check_date) = "'.$itemreport->months.'" 
                                AND year(fc.check_date) = "'.$itemreport->years.'" 
                        '); 
                        $trut          = 100 / $total_all * $Checktotal_all;
                        $chamrootcount = 100 / $total_all * $camroot;
                ?>
                <tr> 
                    <td class="text-center" style="border: 1px;color:black;width: 5%;background-color: rgb(255, 251, 228)">{{$i}}</td>
                    <td class="text-start;" style="border: 1px;color:black;width: 10%;background-color: rgb(255, 251, 228)">
                        {{$itemreport->MONTH_NAME}} พ.ศ.{{$itemreport->yearsthai}}
                    </td>
                    <td class="text-center" style="border: 1px;color:black;background-color: rgb(255, 237, 117)">
                       {{$redten}}
                    </td>
                    <td class="text-center;" style="border: 1px;color:black;background-color: rgb(255, 237, 117)">
                       {{$redfifteen}}
                    </td>
                    <td class="text-center;" style="border: 1px;color:black;background-color: rgb(255, 237, 117)">
                       {{$redtwenty}}
                    </td>
                    <td colspan="2" class="text-center;" style="background-color: rgb(255, 237, 117)">
                        {{$greenten}}
                    </td>
                    <td class="text-center;" style="border: 1px;color:black;background-color: rgb(255, 237, 117)">
                        {{$total_all}}
                    </td>
                    <td class="text-center;" style="border: 1px;color:black;background-color: rgb(117, 216, 255)">
                       {{$Check_redten}}
                    </td>
                    <td class="text-center;" style="border: 1px;color:black;background-color: rgb(117, 216, 255)">
                       {{$Check_redfifteen}}
                    </td>
                    <td class="text-center;" style="border: 1px;color:black;background-color: rgb(117, 216, 255)">
                       {{$Check_redtwenty}}
                    </td>
                    <td colspan="2" class="text-center;" style="border: 1px;color:black;background-color: rgb(117, 216, 255)">
                        {{$Check_greenten}}
                    </td>
                    <td class="text-center;" style="border: 1px;color:black;background-color: rgb(117, 216, 255)">
                       {{$Checktotal_all}}
                    </td> 

                    <td class="text-center;" style="border: 1px;color:black;background-color: rgb(253, 202, 198)"> {{$total_all- $Checktotal_all}} </td>
                    <td class="text-center;" style="border: 1px;color:black;background-color: rgb(252, 216, 214)"> {{$camroot}} </td>
                    <td class="text-center;" style="border: 1px;color:black;background-color: rgb(252, 216, 214)"> {{ number_format($trut, 2) }} </td>
                    <td class="text-center;" style="border: 1px;color:black;background-color: rgb(252, 216, 214)"> {{ number_format($chamrootcount, 2) }} </td>
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
            <td></td>
            <td colspan="2">
                <center>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ขอรับรองว่าผู้มาปฏิบัติหน้าที่ราชการตามรายชื่อข้างต้นนี้  ข้าพเจ้าเป็นผู้สั่งให้มาปฏิบัติหน้าที่ราชการ</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> อันเป็นงานที่จำเป็นจะต้องปฏิบัติทำเร่งด่วนเป็นกรณีพิเศษ</label><br><br><br> 
                </center>
            </td> 
            <td></td>  
        </tr>  --}}
        <tr>
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
        </tr> 
   </table>
</center>
 

   