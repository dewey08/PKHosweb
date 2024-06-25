 
   
   <?php
   header("Content-Type: application/vnd.ms-excel");
   header('Content-Disposition: attachment; filename="รายงานยืม/การใช้เครื่องมือแพทย์.xls"');//ชื่อไฟล์
   
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
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>รายงานยืม/การใช้เครื่องมือแพทย์</b></label><br>
   
</center>
   <br><br>
   <table class="table" style="width: 100%">
       <thead>
        <tr>
            <th width="10%" class="text-center" rowspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ที่</th>
            <th class="text-center" rowspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ประเภทเครื่องมือ</th> 
            <th class="text-center" colspan="5" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">จำนวน(เครื่อง)</th> 
        </tr>
        <tr> 
            <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">มีทั้งหมด</th>
            <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ถูกยืม</th>
            <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ส่งซ่อม</th>
            <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ระหว่างซ่อม</th>
            <th class="text-center" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">พร้อมใช้</th>
        </tr>
       </thead>
       <tbody>
        <?php $i = 1; ?>
        @foreach ($medical_typecat as $item)
            <?php                                    
             $counttype = DB::table('article_data')->where('medical_typecat_id','=',$item->medical_typecat_id)->count();   
             $counbetweenrepair = DB::table('article_data')->where('medical_typecat_id','=',$item->medical_typecat_id)->where('article_status_id','=',4)->count(); 
             $counready = DB::table('article_data')->where('medical_typecat_id','=',$item->medical_typecat_id)->where('article_status_id','=',3)->count();  
             $counborow = DB::table('article_data')->where('medical_typecat_id','=',$item->medical_typecat_id)->where('article_status_id','=',1)->count();  
             $counrepaire = DB::table('article_data')->where('medical_typecat_id','=',$item->medical_typecat_id)->where('article_status_id','=',2)->count();                                    
            ?>
            <tr id="sid{{ $item->medical_typecat_id }}">
                <td width="10%" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">{{ $i++ }}</td>
                <td style="border-color:#F0FFFF;text-align: left;border: 1px solid black;">&nbsp;&nbsp;{{ $item->medical_typecatname }}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{$counttype}} </td>    
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{$counborow}} </td>    
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{$counrepaire}} </td>                                  
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{$counbetweenrepair}} </td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">{{$counready}} </td>                                     
            </tr>    

        @endforeach
       </tbody> 
       <br> 
       
   </table>
   
 

   