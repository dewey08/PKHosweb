 <?php
 header('Content-Type: application/vnd.ms-excel');
 header('Content-Disposition: attachment; filename="สถานะ การยืม/การใช้เครื่องมือแพทย์(ตามประเภท-หน่วยงาน).xls"'); //ชื่อไฟล์
 
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
     <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>สถานะ
             การยืม/การใช้เครื่องมือแพทย์(ตามประเภท-หน่วยงาน)</b></label><br>

 </center>
 <br><br>
 <table class="table" style="width: 100%">
     <thead>
         <tr>
             <th width="10%" class="text-center"
                 style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ลำดับ</th>
             <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">
                 เลขครุภัณฑ์/serial number</th>
                 <th class="text-center" width="11%"
                 style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">รายการเครื่องมือแพทย์</th>
             <th class="text-center" width="11%"
                 style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">จำนวนวันที่ยืม</th>
             <th class="text-center" width="10%"
                 style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">สถานะเครื่อง</th>
             <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">
                 หน่วยงานที่ยืม หรือใช้</th>
         </tr>
     </thead>
     <tbody>
         <?php $i = 1; ?>
         @foreach ($medical_borrow as $item)
             <?php
             
             $colorstatus = $item->medical_borrow_active;
             if ($colorstatus == 'REQUEST') {
                 $color_new = 'background-color: rgb(181, 236, 234)';
             } elseif ($colorstatus == 'APPROVE') {
                 $color_new = 'background-color: rgb(38, 202, 194)';
             } else {
                 $color_new = 'background-color: rgb(107, 180, 248)';
             }
             $date = date('Y-m-d');
             $d = date('d');
             $datestart = $item->medical_borrow_date;
             $newDatestart = date('d', strtotime($datestart));
             
             $dateend = $item->medical_borrow_backdate;
             $countdateold =   round(abs(strtotime(date('Y-m-d')) - strtotime($item->medical_borrow_date))/60/60/24)+1; 
                                    $datestartss = strtotime($item->medical_borrow_date);
             if ($dateend == '') {
                 $newDatetotal = $countdateold;
             } else {
                 $newDateend = date('d', strtotime($dateend));
                 $newDatetotal = $newDateend - $newDatestart;
             }
             
             ?>
             <tr>
                 <td width="10%" class="text-center"
                     style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">{{ $i++ }}</td>
                 <td width="10%" class="text-padding"
                     style="border-color:#F0FFFF;text-align: left;border: 1px solid black;">&nbsp;&nbsp;{{ $item->article_num }}</td>
                     <td width="10%" class="text-padding"
                     style="border-color:#F0FFFF;text-align: left;border: 1px solid black;">&nbsp;&nbsp;{{ $item->article_name }}</td>
                 <td width="10%" class="text-center"
                     style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">{{$item->Days}}</td>
                 <td width="10%" class="text-center"
                     style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">
                     @if ($item->article_status_id == '1' )
                            <button type="button" class="btn btn-sm"
                                style="background-color: rgb(235, 81, 10);font-size:13px;color:white">ยืม
                            </button>
                        @elseif ($item->article_status_id == '2')
                            <button type="button" class="btn btn-sm"
                                style="background-color:rgb(10, 201, 235);font-size:13px;color:white">พร้อมใช้(คืน)
                            </button>
                        @elseif ($item->article_status_id == '3')
                            <button type="button" class="btn btn-sm"
                                style="background-color:rgb(3, 188, 117);font-size:13px;color:white">ปกติ
                            </button>
                        @elseif ($item->article_status_id == '4')
                            <button type="button" class="btn btn-sm"
                                style="background-color:rgb(235, 220, 10);font-size:13px;color:white">ระหว่างซ่อม
                            </button>
                        @elseif ($item->article_status_id == '5')
                            <button type="button" class="btn btn-sm"
                                style="background-color:rgb(44, 10, 235);font-size:13px;color:white">รอจำหน่าย
                            </button>
                        @else
                            <button type="button" class="btn btn-sm"
                                style="background-color: rgb(89, 10, 235);font-size:13px;color:white">จำหน่ายแล้ว
                            </button>
                        @endif
                    </td>
                 <td width="10%" class="p-2"
                     style="border-color:#F0FFFF;text-align: left;border: 1px solid black;">&nbsp;&nbsp;{{ $item->DEPARTMENT_SUB_SUB_NAME }}</td>
             </tr>
             @endforeach
     </tbody>
     <br>

 </table>
