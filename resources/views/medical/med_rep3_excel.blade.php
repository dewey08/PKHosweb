 <?php
 header('Content-Type: application/vnd.ms-excel');
 header('Content-Disposition: attachment; filename="รายงานยืม/การใช้เครื่องมือแพทย์ (ใช้ประจำ/ยืม).xls"'); //ชื่อไฟล์
 
 function DateThais($strDate)
 {
     $strYear = date('Y', strtotime($strDate)) + 543;
     $strMonth = date('n', strtotime($strDate));
     $strDay = date('j', strtotime($strDate));
 
     $strMonthCut = ['', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
     $strMonthThai = $strMonthCut[$strMonth];
     return "$strDay $strMonthThai $strYear";
 }
 
 function getAges($birthday)
 {
     $then = strtotime($birthday);
     return floor((time() - $then) / 31556926);
 }
 
 ?>
 <center>
     <br><br>
     <label for=""
         style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>รายงานยืม/การใช้เครื่องมือแพทย์(ใช้เกินกำหนด(14วัน))</b></label><br>

 </center>
 <br><br>
 <table class="table" style="width: 100%">
     <thead>
        
         <tr>
             <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ลำดับ</th>
             <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">เลขครุภัณฑ์ / SN</th>
             <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">รายการเครื่องมือการแพทย์</th>
             <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">จำนวนวันที่ยืม</th>
             <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">หน่วยงานที่ยืม</th>
         </tr>
         
     </thead>
     <tbody>
        <?php $i = 1; ?>
        @foreach ($medical_borrow_rep3 as $item) 
            <?php
                $date = date('Y-m-d');
                $d = date('d');
                $datestart = $item->medical_borrow_date;
                $newDatestart = date('Y-m-d', strtotime($datestart));
                $newDatestart2 = date('d', strtotime($datestart));
                $dateend = $item->medical_borrow_backdate;

                $countdateold =   round(abs(strtotime(date('Y-m-d')) - strtotime($item->medical_borrow_date))/60/60/24)+1; 
                $datestartss = strtotime($item->medical_borrow_date);
                
                $total = DB::table('medical_borrow')
                ->whereBetween('medical_borrow_date', [$newDatestart, $date])->count(); 

                    $start = strtotime($item->medical_borrow_date);
                    $end = strtotime($date);
                    $tot = ($end - $start) / 25200; 
                
                if ($dateend == '') {
                    $newDatetotal = $countdateold; 
                } else {      
                    $newDateend  = date('d', strtotime($dateend));                                  
                    $newDatetotal  = $newDateend - $newDatestart2;
                } 
        ?>
        @if ($newDatetotal >= 14)
        
        <tr >
            <td width="10%" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">{{ $i++ }}</td>
            <td style="border-color:#F0FFFF;text-align: left;border: 1px solid black;" width="20%">&nbsp;&nbsp;{{ $item->article_num }}</td>
            <td style="border-color:#F0FFFF;text-align: left;border: 1px solid black;" >&nbsp;&nbsp;{{ $item->article_name }} </td>    
            <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{ $newDatetotal }}</td>    
            <td style="border-color:#F0FFFF;text-align: left;border: 1px solid black;" width="30%">&nbsp;&nbsp;{{ $item->DEPARTMENT_SUB_SUB_NAME }} </td>                     
        </tr>  
    @else
        
    @endif
         
        @endforeach
     </tbody>
     <br>

 </table>
