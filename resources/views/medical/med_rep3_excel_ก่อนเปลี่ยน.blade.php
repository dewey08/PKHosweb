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
         style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>รายงานยืม/การใช้เครื่องมือแพทย์ (ใช้ประจำ/ยืม)</b></label><br>

 </center>
 <br><br>
 <table class="table" style="width: 100%">
     <thead>
         <tr>
             <th width="10%" class="text-center" rowspan="3" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ที่</th>
             <th class="text-center" rowspan="3" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">หน่วยงาน</th>
             <th class="text-center" colspan="10" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ประเภทเครื่องมือ/จำนวน(เครื่อง)</th>
         </tr>
         <tr>
             <th class="text-center" colspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">Infusion Pump</th>
             <th class="text-center" colspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">Syring Pump</th>
             <th class="text-center" colspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">Monitor</th>
             <th class="text-center" colspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">EKG</th>
             <th class="text-center" colspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">Defrib</th>
         </tr>
         <tr>
             <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ใช้ประจำ</th>
             <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ยืม</th>
             <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ใช้ประจำ</th>
             <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ยืม</th>
             <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ใช้ประจำ</th>
             <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ยืม</th>
             <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ใช้ประจำ</th>
             <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ยืม</th>
             <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ใช้ประจำ</th>
             <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ยืม</th>
         </tr>
     </thead>
     <tbody>
        <?php $i = 1; ?>
        @foreach ($medical_deb as $item)
            <?php                                    
             // ใช้ประจำ
             $Infusionpump_n = DB::table('article_data')->where('medical_typecat_id','=',5)->where('article_deb_subsub_id','=',$item->DEPARTMENT_SUB_SUB_ID)->count(); 
            $SyringPump_n = DB::table('article_data')->where('medical_typecat_id','=',4)->where('article_deb_subsub_id','=',$item->DEPARTMENT_SUB_SUB_ID)->count(); 
            $Monitor_n = DB::table('article_data')->where('medical_typecat_id','=',3)->where('article_deb_subsub_id','=',$item->DEPARTMENT_SUB_SUB_ID)->count(); 
            $Ekg_n = DB::table('article_data')->where('medical_typecat_id','=',2)->where('article_deb_subsub_id','=',$item->DEPARTMENT_SUB_SUB_ID)->count(); 
            $Defrib_n = DB::table('article_data')->where('medical_typecat_id','=',1)->where('article_deb_subsub_id','=',$item->DEPARTMENT_SUB_SUB_ID)->count(); 
        // ยืม
            $Infusionpump_c = DB::table('medical_borrow')->where('medical_borrow_typecat_id','=',5)->where('medical_borrow_debsubsub_id','=',$item->DEPARTMENT_SUB_SUB_ID)->count(); 
            $SyringPump_c = DB::table('medical_borrow')->where('medical_borrow_typecat_id','=',4)->where('medical_borrow_debsubsub_id','=',$item->DEPARTMENT_SUB_SUB_ID)->count(); 
            $Monitor_c = DB::table('medical_borrow')->where('medical_borrow_typecat_id','=',3)->where('medical_borrow_debsubsub_id','=',$item->DEPARTMENT_SUB_SUB_ID)->count(); 
            $Ekg_c = DB::table('medical_borrow')->where('medical_borrow_typecat_id','=',2)->where('medical_borrow_debsubsub_id','=',$item->DEPARTMENT_SUB_SUB_ID)->count(); 
            $Defrib_c = DB::table('medical_borrow')->where('medical_borrow_typecat_id','=',1)->where('medical_borrow_debsubsub_id','=',$item->DEPARTMENT_SUB_SUB_ID)->count(); 
            ?>
            <tr >
                <td width="10%" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">{{ $i++ }}</td>
                <td style="border-color:#F0FFFF;text-align: left;border: 1px solid black;">&nbsp;&nbsp;{{ $item->DEPARTMENT_SUB_SUB_NAME }}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{$Infusionpump_n}} </td>    
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{$Infusionpump_c}} </td>    
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{$SyringPump_n}} </td>                                  
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{$SyringPump_c}} </td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{$Monitor_n}} </td> 
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{$Monitor_c}} </td> 
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{$Ekg_n}} </td> 
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{$Ekg_c}} </td> 
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{$Defrib_n}} </td> 
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{$Defrib_c}} </td>                                     
            </tr>    

        @endforeach
     </tbody>
     <br>

 </table>
