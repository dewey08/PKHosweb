 
   
   <?php
   header("Content-Type: application/vnd.ms-excel");
   header('Content-Disposition: attachment; filename="OTFORM-3.xls"');//ชื่อไฟล์
   
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
   
   ?>
<center>
    <br><br>
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>รายงานผลปฏิบัติงานนอกเวลาราชการและวันหยุดราชการ (ตามภาระงานที่เพิ่มขึ้น)</b></label><br>
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>กลุ่มงาน/งาน</b>  {{$datadepartment_sub_sub->DEPARTMENT_SUB_SUB_NAME}}   <b>กลุ่มภารกิจ </b>{{$depuser->DEPARTMENT_NAME}}</label><br>
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>ประจำวันที่…………............เดือน…………………………………….…….พ.ศ…………..…..</b></label><br>
</center>
   <br><br>
   <table class="table" style="width: 100%">
       <thead>
           <tr>
              
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">วันเดือนปี</th>
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">เวลา</th>
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;">ชื่อ-สกุล</th>
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;">หน้าที่ที่ปฏิบัติ/ภาระงาน</th>              
               <th style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">รายมือชื่อ</th> 
             
           </tr>
       </thead>
       <tbody>
        <?php $i = 1; ?>
        @foreach ($ot_one as $item) 
            <tr>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" align="center" width="10%">{{ $item->ot_one_date }} </td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" align="center" width="10%">{{ $item->ot_one_starttime }}-{{ $item->ot_one_endtime }}</td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;">{{ $item->prefix_name }} {{ $item->fname }} {{ $item->lname }}</td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: left;border: 1px solid black;">&nbsp;&nbsp;{{ $item->ot_one_detail }}</td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;" align="center" width="10%">{{ $item->ot_one_sign2 }} </td> 
   
            </tr>
        @endforeach        
       </tbody> 
       
        <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td></tr>
        <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td></tr>  
        <br>
        <tr> 
            <td colspan="2">
               <center>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ลงชื่อ……………………………………………….ผู้ควบคุม</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ( นางเยี่ยมรัตน์  จักรโนวรรณ )</label><br> 
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> หัวหน้ากลุ่มงานประกันสุขภาพ</label><br>
               </center>
            </td>
            <td></td>
            <td colspan="2">
                <center>
                 <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ลงชื่อ……………………………………………….ผู้จตรวจสอบ</label><br>
                 <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ( นายนิวัฒน์  ขจัดพาล  )</label><br> 
                 <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> หัวหน้ากลุ่มภารกิจด้านพัฒนาระบบบริการและสนับสนุนบริการสุขภาพ</label><br>
                </center>
             </td>
        </tr>    
   </table>
   
 

   