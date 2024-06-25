 <?php
 header('Content-Type: application/vnd.ms-excel');
 header('Content-Disposition: attachment; filename="OTFORM-4.xls"'); //ชื่อไฟล์
 
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
 {{-- <center>
    <br><br>
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>หลักฐานการจ่ายเงินตอบแทนการปฏิบัติงานนอกเวลาราชการ{{$dataorginfo->orginfo_name}}</b></label><br>
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>ชื่อส่วนราชการ</b>  {{$dataorginfo->orginfo_name}} <b>อำเภอ</b>ภูเขียว  <b>จังหวัด</b>ชัยภูมิ   (กลุ่มงาน/งาน{{$datadepartment_sub_sub->DEPARTMENT_SUB_SUB_NAME}})</label><br>
 
</center> --}}
 <table class="table" style="width: 100%">
     <tr>
         <td style="width: 50%;" align="center" colspan="15"></td>
         <td style="width: 50%;" align="center" colspan="15">
             <label for=""
                 style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>หลักฐานการจ่ายเงินตอบแทนการปฏิบัติงานนอกเวลาราชการ{{ $dataorginfo->orginfo_name }}</b></label>

         </td>
     </tr>
     <tr>
         <td style="width: 50%;" align="center" colspan="15"></td>
         <td style="width: 100%;" align="center" colspan="15">
             <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>ชื่อส่วนราชการ</b>
                 {{ $dataorginfo->orginfo_name }} <b>อำเภอ</b>ภูเขียว <b>จังหวัด</b>ชัยภูมิ
                 (กลุ่มงาน/งาน{{ $datadepartment_sub_sub->DEPARTMENT_SUB_SUB_NAME }})</label>
         </td>
     </tr>
 </table>
{{-- {{$start}} {{$end}} --}}
 <br><br>
 <table class="table" style="width: 100%">
     <thead>
         <tr>
             <th rowspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ลำดับ</th>
             <th rowspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ชื่อ-สกุล</th>
             <th rowspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ค่า OT</th>

             <th colspan="31" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">วันที่ ที่ปฏิบัติงานนอกเวลาราชการ</th>

             <th rowspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">จำนวน<br>วัน/ชม.</th>
             <th rowspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">จำนวนเงิน<br>บาท/สต.</th>
             <th rowspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ลายมือชื่อ<br>ผู้รับเงิน</th>
             <th rowspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ว/ด/ป<br>ที่รับเงิน</th>
             <th rowspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">หมายเหต</th>
         </tr>
         <tr>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">1</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">2</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">3</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">4</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">5</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">6</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">7</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">8</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">9</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">10</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">11</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">12</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">13</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">14</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">15</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">16</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">17</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">18</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">19</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">20</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">21</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">22</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">23</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">24</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">25</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">26</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">27</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">28</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">29</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">30</th>
             <th style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">31</th>
         </tr>

     </thead>
     <tbody>
         <?php $i = 1; ?>
         @foreach ($usershow as $item)
             <tr>
                 <td rowspan="3" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">
                     {{-- <br> --}}
                     {{ $i++ }}
                     {{-- <br> --}}
                 </td>
                 <td rowspan="3" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">  
                     {{ $item->fname }} {{ $item->lname }} 
                 </td>
                 @if ($reqsend == '2')
                    @if ($item->id == '754')
                        <td rowspan="3" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">
                            87.50<br>
                            620 <br>
                            xx
                        </td>
                    @elseif($item->id == '722')  
                        <td rowspan="3" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">
                            55<br>
                            400 <br>
                            xx
                        </td>
                    @elseif($item->id == '753')  
                        <td rowspan="3" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">
                            47.50<br>
                            340 <br>
                            xx
                        </td>
                    @else
                        <td rowspan="3" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">
                            xx<br>
                            xxx 
                        </td>                        
                    @endif 

                    
                  
                @else
                    <td rowspan="3" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">
                        50<br>
                        60<br>
                        420
                    </td>
                @endif
                 

                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" ></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>

                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>

                 {{-- <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td> --}}

                 {{-- <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td> --}}

             </tr>

             <tr>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>

                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>

             </tr>

             <tr>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>

                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                 <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>

             </tr>
         @endforeach
         <br><br><br><br>
         <tr>
             <td colspan="34"></td>
             <td>รวมเป็นเงิน</td>
             <td>xxxxxx</td>
         </tr>
         <tr>
             <td colspan="35"> </td>
             <td> xxxxxx บาท</td>
         </tr>

     </tbody>


 </table>

 <br><br>
 <table class="table" style="width: 100%">
     <tr>
         <td style="width: 30%" colspan="10"> </td>
         <td style="width: 60%" colspan="25">
             <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;">
                 ข้าพเจ้าขอรับรองว่าผู้ที่รับค่าตอบแทนได้ขึ้นปฏิบัติงานจริงและขอรับรองว่าได้ตรวจสอบเอกสารหลักฐานการจ่ายเงินครบถ้วนถูกต้องแล้ว
             </label>
         </td>
     </tr>
 </table>
 <br><br>


 <table class="table" style="width: 100%">
     <tr>

         <td style="width: 30%;" align="center" colspan="8">
             ลงชื่อ.....................................................ผู้เบิก <br>
             ( นางเยี่ยมรัตน์ จักรโนวรรณ ) <br>
             ตำแหน่ง พยาบาลวิชาชีพชำนาญการ <br>
             หัวหน้ากลุ่มงานประกันสุขภาพ <br>
         </td>
         <td colspan="2"></td>

         <td style="width: 40%" colspan="8" align="center">
             ลงชื่อ.....................................................ผู้ควบคุม <br>
             ( นายนิวัฒน์ ขจัดพาล )<br>
             ตำแหน่ง นายแพทย์ชำนาญการ <br>
             หัวหน้ากลุ่มภารกิจด้านพัฒนาระบบบริการและสนับสนุนบริการสุขภาพ <br>
         </td>

         <td colspan="2"></td>
         <td style="width: 30%" colspan="8" align="center">
             ลงชื่อ.....................................................ผู้จ่ายเงิน <br>
             ( นางปราณี สังข์สูงเนิน ) <br>
             ตำแหน่ง เจ้าพนักงานการเงินและบัญชีชำนาญงาน <br>
         </td>

         <td colspan="2"></td>
         <td style="width: 30%" colspan="8" align="center">
             ลงชื่อ.....................................................ผู้อนุมัติ <br>
             ( นายสุภาพ สำราญวงษ์ ) <br>
             ผู้อำนวยการโรงพยาบาลภูเขียวเฉลิมพระเกียรติ <br>
         </td>

     </tr>
 </table>
