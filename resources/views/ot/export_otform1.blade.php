 
   
   <?php
   header("Content-Type: application/vnd.ms-excel");
   header('Content-Disposition: attachment; filename="OTFORM-2.xls"');//ชื่อไฟล์
   
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
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>บัญชีรายชื่อปฏิบัติงานนอกเวลาราชการและในวันหยุดราชการ</b></label><br>
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>กลุ่มงาน/งาน  {{$datadepartment_sub_sub->DEPARTMENT_SUB_SUB_NAME}}  {{$dataorginfo->orginfo_name}}</b></label><br>
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>ประจำวันที่…………............เดือน…………………………………….…….พ.ศ…………..…..</b></label><br>
</center>
   <br><br>
   <table class="table" style="width: 100%">
       <thead>
           <tr>
               <th align="center" width="5%" style="font-family: 'Kanit', sans-serif;" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ที่</th>
               <th style="font-family: 'Kanit', sans-serif;" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">วันที่</th>
               <th style="font-family: 'Kanit', sans-serif;" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ชื่อ-สกุล</th>
               <th style="font-family: 'Kanit', sans-serif;" width="10%" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">รายมือชื่อ</th>
               <th style="font-family: 'Kanit', sans-serif;" width="10%" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">เวลามา</th>
               <th style="font-family: 'Kanit', sans-serif;" width="10%" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">รายมือชื่อ</th>
               <th style="font-family: 'Kanit', sans-serif;" width="10%" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">เวลากลับ</th>
               <th style="font-family: 'Kanit', sans-serif;" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">หน้าที่ที่ปฏิบัติ/ภาระงาน</th>
           </tr>
       </thead>
       <tbody>
        <?php $i = 1; ?>
        @foreach ($ot_one as $item) 
            <tr>
                <td align="center" width="5%" style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;">{{ $i++ }}</td> 
                <td align="center" width="10%" style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;"> {{ $item->ot_one_date }} </td>
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;">{{ $item->prefix_name }} {{ $item->fname }} {{ $item->lname }}</td>
                <td align="center" width="10%" style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;"> {{ $item->ot_one_sign }} </td>
                <td align="center" width="10%" style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;">{{ $item->ot_one_starttime }}</td>
                <td align="center" width="10%" style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;">{{ $item->ot_one_sign2 }} </td>
                <td align="center" width="10%" style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: center;border: 1px solid black;">{{ $item->ot_one_endtime }} </td> 
                <td style="font-family: 'Kanit', sans-serif;border-color:#F0FFFF;text-align: left;border: 1px solid black;">&nbsp;&nbsp;{{ $item->ot_one_detail }}</td> 
            </tr>
        @endforeach        
       </tbody> 
       <br> 
       <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td></tr>
       <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td></tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> รวม………………………………………..คน</label><br></td>
        </tr> 
        <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td></tr>
        <tr> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td></tr>  
        <br>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td> 
            <td colspan="2">
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ขอรับรองว่าผู้มาปฏิบัติหน้าที่ราชการตามรายชื่อข้างต้นนี้  ข้าพเจ้าเป็นผู้สั่งให้มาปฏิบัติหน้าที่ราชการ</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> อันเป็นงานที่จำเป็นจะต้องปฏิบัติทำเร่งด่วนเป็นกรณีพิเศษ</label><br><br><br>
               <center>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ลงชื่อ……………………………………………….ผู้รับรอง/ควบคุม</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ( นางเยี่ยมรัตน์  จักรโนวรรณ )</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> ตำแหน่ง พยาบาลวิชาชีพชำนาญการ</label><br>
                <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"> หัวหน้ากลุ่มงานประกันสุขภาพ</label><br>
               </center>
            </td>
        </tr>    
   </table>
   
 

   