<?php
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="INFOMATION_PERSON.xls"');//ชื่อไฟล์

use Illuminate\Support\Facades\DB;
use App\Models\Person;
?>

ข้อมูลบุคลากรจำนวน  {{ $count }} คน
      

<table  width="100%">
<thead >
        
<tr style="background-color: #FFEBCD;" height="40">    
<th class="text-font" style="border-color:#F0FFFF;text-align: center;" >ลำดับ</th>       
<th class="text-font" style="border-color:#F0FFFF;text-align: center;" >เลขบัตรประชาชน</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;" >ชื่อ นามสกุล</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;" >ชื่อภาษาอังกฤษ</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;" >เพศ</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;" >วันเกิด</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;" >อายุ</th>

<th class="text-font" style="border-color:#F0FFFF;text-align: center;" >สถานะสมรส</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;" >ศาสนา</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;" >เชื้อชาติ</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;" >สัญชาติ</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;" >กรุ๊ปเลือด</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;" >ส่วนสูง/ซ.ม.</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;" >น้ำหนัก/ก.ก.</th>

<th class="text-font" style="border-color:#F0FFFF;text-align: center;" >เบอร์โทรศัพท์</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;" >อีเมล</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;" >Facebook</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;" >Line</th>

<th class="text-font" style="border-color:#F0FFFF;text-align: center;" >สถานะปัจจุบัน</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">ตำแหน่ง</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">ระดับ</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">หน่วยงาน</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">ฝ่าย/แผนก</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">กลุ่มงาน</th>

<th class="text-font" style="border-color:#F0FFFF;text-align: center;">วันที่เริ่มงาน</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">เลขตำแหน่ง</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">เลขใบประกอบวิชาชีพ</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">วันที่ได้รับ</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">กลุ่มข้าราชการ</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">ประเภทข้าราชการ</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">กลุ่มบุคลากร</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">ต้นสังกัด</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">เงินเดือน</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">เงินประจำตำแหน่ง</th>

<th class="text-font" style="border-color:#F0FFFF;text-align: center;">บ้านเลขที่ปัจจุบัน</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">หมู่ที่</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">ถนน</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">ซอย</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">ตำบล</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">อำเภอ</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">จังหวัด</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">รหัสไปรษณีย์</th>

<th class="text-font" style="border-color:#F0FFFF;text-align: center;">บ้านเลขที่ตามทะเบียนบ้าน</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">หมู่ที่</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">ถนน</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">ซอย</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">ตำบล</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">อำเภอ</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">จังหวัด</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">รหัสไปรษณีย์</th>

<th class="text-font" style="border-color:#F0FFFF;text-align: center;">เลขบัญชีธนาคาร (เงินค่าตอบแทน)</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">ชื่อบัญชีธนาคาร</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">ธนาคาร</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">สาขา</th>

<th class="text-font" style="border-color:#F0FFFF;text-align: center;">เลขบัญชีธนาคาร (เงินค่าตอบแทน OT)</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">ชื่อบัญชีธนาคาร</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">ธนาคาร</th>
<th class="text-font" style="border-color:#F0FFFF;text-align: center;">สาขา</th>


</tr>
         </tr>
         </thead>
         <tbody>
         <?php $number = 0; ?>
         @foreach ($persons as $person)
         <?php $number++; ?> 
         <tr height="40">
         <td class="text-font" align="center"> {{ $number }}</td>  
           <td class="text-font" align="center"> {{ $person -> HR_CID }}</td>  
           <td class="text-pedding text-font">{{ $person -> HR_PREFIX_NAME }}{{ $person -> HR_FNAME }} {{ $person -> HR_LNAME }}</td>                     
           <td class="text-pedding text-font"> {{ $person -> HR_EN_NAME }}</td> 
           <td class="text-pedding text-font"> {{ $person -> SEX_NAME }}</td> 
           <td class="text-font" align="center"> {{ DateThai($person -> HR_BIRTHDAY) }}</td>  
           <td class="text-font" align="center"> {{ getAge($person -> HR_BIRTHDAY) }} </td> 

           <td class="text-pedding text-font"> {{ $person -> HR_MARRY_STATUS_NAME }}</td>
           <td class="text-pedding text-font"> {{ $person -> HR_RELIGION_NAME }}</td>   
           <td class="text-pedding text-font"> {{ $person -> HR_NATIONALITY_NAME }}</td>   
           <td class="text-pedding text-font"> {{ $person -> HR_CITIZENSHIP_NAME }}</td>   
           <td class="text-pedding text-font"> {{ $person -> HR_BLOODGROUP_NAME }}</td>   
           <td class="text-pedding text-font"> {{ $person -> HR_HIGH }}</td>   
           <td class="text-pedding text-font"> {{ $person -> HR_WEIGHT }}</td>      

           <td class="text-pedding text-font"> {{ $person -> HR_PHONE }}</td>    
           <td class="text-pedding text-font"> {{ $person -> HR_EMAIL }}</td>    
           <td class="text-pedding text-font"> {{ $person -> HR_FACEBOOK }}</td>    
           <td class="text-pedding text-font"> {{ $person -> HR_LINE }}</td>    

           <td class="text-pedding text-font"> {{ $person -> HR_STATUS_NAME }}</td>   
           <td class="text-pedding text-font"> {{ $person -> POSITION_IN_WORK }}</td> 
           <td class="text-pedding text-font"> {{ $person -> HR_LEVEL_NAME }}</td>   
           <td class="text-pedding text-font"> {{ $person -> HR_DEPARTMENT_SUB_SUB_NAME }}</td> 
           <td class="text-pedding text-font"> {{ $person -> HR_DEPARTMENT_SUB_NAME }}</td> 
           <td class="text-pedding text-font"> {{ $person -> HR_DEPARTMENT_NAME }}</td> 
           
           @if($person -> HR_STARTWORK_DATE == '' || $person -> HR_STARTWORK_DATE == null || $person -> HR_STARTWORK_DATE == '0000-00-00')
           <td class="text-pedding text-font"></td> 
           @else
           <td class="text-pedding text-font"> {{ DateThai($person -> HR_STARTWORK_DATE) }}</td> 
           @endif
           <td class="text-pedding text-font"> {{ $person -> HR_POSITION_NUM }}</td> 
           <td class="text-pedding text-font"> {{ $person -> VCODE }}</td> 
           <td class="text-pedding text-font"> {{ DateThai($person -> VCODE_DATE) }}</td> 
           <td class="text-pedding text-font"> {{ $person -> HR_KIND_NAME }}</td> 
           <td class="text-pedding text-font"> {{ $person -> HR_KIND_TYPE_NAME }}</td> 
           <td class="text-pedding text-font"> {{ $person -> HR_PERSON_TYPE_NAME }}</td> 
           <td class="text-pedding text-font"> {{ $person -> HR_AGENCY_ID }}</td>

           <td class="text-pedding text-font"> {{ $person -> HR_SALARY }}</td> 
           <td class="text-pedding text-font"> {{ $person -> MONEY_POSITION }}</td>

           <td class="text-pedding text-font"> {{ $person -> HR_HOME_NUMBER }}</td>
           <td class="text-pedding text-font"> {{ $person -> HR_VILLAGE_NO }}</td> 
           <td class="text-pedding text-font"> {{ $person -> HR_ROAD_NAME }}</td>   
           <td class="text-pedding text-font"> {{ $person -> HR_SOI_NAME }}</td>
           <td class="text-pedding text-font"> {{ $person -> TUMBON_NAME }}</td>
           <td class="text-pedding text-font"> {{ $person -> AMPHUR_NAME }}</td>
           <td class="text-pedding text-font"> {{ $person -> PROVINCE_NAME }}</td>
           <td class="text-pedding text-font"> {{ $person -> HR_ZIPCODE }}</td>

           <td class="text-pedding text-font"> {{ $person -> HR_HOME_NUMBER_1 }}</td>
           <td class="text-pedding text-font"> {{ $person -> HR_VILLAGE_NO_1 }}</td> 
           <td class="text-pedding text-font"> {{ $person -> HR_ROAD_NAME_1 }}</td>   
           <td class="text-pedding text-font"> {{ $person -> HR_SOI_NAME_1 }}</td>

        <?php   $person_2 = Person::leftJoin('hrd_tumbon','hrd_person.TUMBON_ID_1','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID_1','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID_1','=','hrd_province.ID')
        ->where('hrd_person.HR_CID','=',$person->HR_CID)
        ->first(); 
        
        ?>
           <td class="text-pedding text-font"> {{ $person_2 -> TUMBON_NAME }}</td>
           <td class="text-pedding text-font"> {{ $person_2 -> AMPHUR_NAME }}</td>
           <td class="text-pedding text-font"> {{ $person_2 -> PROVINCE_NAME }}</td>
           <td class="text-pedding text-font"> {{ $person_2 -> HR_ZIPCODE_1 }}</td>

           <td class="text-pedding text-font"> {{ $person -> BOOK_BANK_NUMBER }}</td>
           <td class="text-pedding text-font"> {{ $person -> BOOK_BANK_NAME }}</td>
           <td class="text-pedding text-font"> {{ $person -> BOOK_BANK }}</td>
           <td class="text-pedding text-font"> {{ $person -> BOOK_BANK_BRANCH }}</td>

           <td class="text-pedding text-font"> {{ $person -> BOOK_BANK_OT_NUMBER }}</td>
           <td class="text-pedding text-font"> {{ $person -> BOOK_BANK_OT_NAME }}</td>
           <td class="text-pedding text-font"> {{ $person -> BOOK_BANK_OT }}</td>
           <td class="text-pedding text-font"> {{ $person -> BOOK_BANK_OT_BRANCH }}</td>
         </tr>
       
         @endforeach 
         </tbody>
        </table>
