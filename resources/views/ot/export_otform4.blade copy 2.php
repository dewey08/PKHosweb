 <?php
 header('Content-Type: application/vnd.ms-excel');
 header('Content-Disposition: attachment; filename="OT1.xls"'); //ชื่อไฟล์
 
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
             <th rowspan="2" style="text-align: center">ลำดับ</th>
             <th rowspan="2" style="text-align: center">ชื่อ-สกุล</th>
             <th rowspan="2" style="text-align: center">ค่า OT</th>

             <th colspan="31" style="text-align: center">วันที่ ที่ปฏิบัติงานนอกเวลาราชการ</th>

             <th rowspan="2" style="text-align: center">จำนวน<br>วัน/ชม.</th>
             <th rowspan="2" style="text-align: center">จำนวนเงิน<br>บาท/สต.</th>
             <th rowspan="2" style="text-align: center">ลายมือชื่อ<br>ผู้รับเงิน</th>
             <th rowspan="2" style="text-align: center">ว/ด/ป<br>ที่รับเงิน</th>
             <th rowspan="2" style="text-align: center">หมายเหต</th>
         </tr>
         <tr>
             <th style="text-align: center">1</th>
             <th style="text-align: center">2</th>
             <th style="text-align: center">3</th>
             <th style="text-align: center">4</th>
             <th style="text-align: center">5</th>
             <th style="text-align: center">6</th>
             <th style="text-align: center">7</th>
             <th style="text-align: center">8</th>
             <th style="text-align: center">9</th>
             <th style="text-align: center">10</th>
             <th style="text-align: center">11</th>
             <th style="text-align: center">12</th>
             <th style="text-align: center">13</th>
             <th style="text-align: center">14</th>
             <th style="text-align: center">15</th>
             <th style="text-align: center">16</th>
             <th style="text-align: center">17</th>
             <th style="text-align: center">18</th>
             <th style="text-align: center">19</th>
             <th style="text-align: center">20</th>
             <th style="text-align: center">21</th>
             <th style="text-align: center">22</th>
             <th style="text-align: center">23</th>
             <th style="text-align: center">24</th>
             <th style="text-align: center">25</th>
             <th style="text-align: center">26</th>
             <th style="text-align: center">27</th>
             <th style="text-align: center">28</th>
             <th style="text-align: center">29</th>
             <th style="text-align: center">30</th>
             <th style="text-align: center">31</th>
         </tr>

     </thead>
     <tbody>
         <?php $i = 1; ?>
         @foreach ($usershow as $item)
             <tr>
                 <td rowspan="3"style="text-align: center">
                     {{ $i++ }}
                 </td>
                 <td rowspan="3" style="text-align: center">
                     {{ $item->prefix_name }} {{ $item->fname }} {{ $item->lname }}
                 </td>
                 {{-- @if ($item->users_group_id == '1'|| $item->users_group_id == '2' || $item->users_group_id == '3' || $item->users_group_id == '4' ) --}}
                 @if ($reqsend == '1')
                    {{-- @if ($item->id == '754')
                        <td rowspan="3">
                            87.50<br>
                            620 
                        </td>
                    @elseif($item->id == '722')  
                        <td rowspan="3">
                            55<br>
                            400 
                        </td>
                    @elseif($item->id == '753')  
                        <td rowspan="3">
                            47.50<br>
                            340 
                        </td>
                    @else --}}
                        <td rowspan="3">
                            xx<br>
                            xxx 
                        </td>                        
                    {{-- @endif  --}}
                     
                 @else
                     <td rowspan="3">
                         50<br>
                         60<br>
                         420
                     </td>
                 @endif


                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>


                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>

             </tr>

             <tr>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
             </tr>

             <tr>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
                 <td style="text-align: center"></td>
             </tr>
         @endforeach
         <br><br>
         <tr>
             <td colspan="34"></td>
             <td>รวมเป็นเงิน</td>
             <td>12500</td>
         </tr>
         <tr>
             <td colspan="35"> </td>
             <td>หนึ่งหมื่นสองพันห้าร้อยบาท</td>
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
