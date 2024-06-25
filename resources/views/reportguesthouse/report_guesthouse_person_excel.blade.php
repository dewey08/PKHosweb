<?php
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="รายชื่อบุคลากรที่เข้าพักอาศัยในแฟลตและบ้านพัก.xls"');//ชื่อไฟล์

  date_default_timezone_set("Asia/Bangkok");
  $date = date('Y-m-d');
  use App\Http\Controllers\ReportguesthouseController;

?>
   
     <center>
     <B>รายชื่อบุคลากรที่เข้าพักอาศัยในแฟลตและบ้านพัก</B> <br>
     <B> โรงพยาบาล  {{$orgname->ORG_NAME}}  จังหวัด  {{$orgname->PROVINCE}}</B><br>
   
       </center>                   

        <table  width="100%">
            <thead >
                <tr height="40">
                  <th class="text-font" style="text-align: center;border: 1px solid black;" width="5%">ลำดับ</th>
                            <th class="text-font" style="text-align: center;border: 1px solid black;" width="15%">ชื่อแฟลต / บ้านพัก</th>
                            <th class="text-font" style="text-align: center;border: 1px solid black;" width="10%">หมายเลขห้องพักหรือชื่อห้องพัก</th>
                            <th class="text-font" style="text-align: center;border: 1px solid black;" width="20%">ชื่อ-สุกล ผู้ที่พัก</th>
                            <th class="text-font" style="text-align: center;border: 1px solid black;" width="20%">ตำแหน่ง</th>
                            <th class="text-font" style="text-align: center;border: 1px solid black;" width="20%">หน่วยงาน</th> 
                            <th class="text-font" style="text-align: center;border: 1px solid black;" width="8%">สถานะ</th>   
                </tr >
            </thead>
            <tbody>
            
          
              <?php $number = 0; ?>
              @foreach ($report_gesthpers as $reportgesthper)
                  <?php $number++;?>  
                      
                          <?php $checkhom = DB::table('guesthous_infomation_person')->where('INFMATION_ID','=',$reportgesthper->INFMATION_ID)->where('INFMATION_PERSON_STATUS','=','1')->count(); ?>
                         
                          @if($checkhom !== 0) 
                              <tr height="20">                                   
                                  <td class="text-font" style="text-align:center;border: 1px solid black;" width="5%">&nbsp;{{$number}}</td>
                                  <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;" width="15%">&nbsp;&nbsp;{{$reportgesthper->INFMATION_NAME}}</td>
                                  <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;" width="10%">&nbsp;&nbsp;{{$reportgesthper->LEVEL_ROOM_NAME}}</td>
                                  <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;" width="20%">&nbsp;&nbsp;{{$reportgesthper->HR_FNAME}} &nbsp;{{$reportgesthper->HR_LNAME}}</td>
                                  <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;" width="20%">&nbsp;&nbsp;{{$reportgesthper->HR_POSITION_NAME}}</td>                                                             
                                  <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;" width="20%">&nbsp;&nbsp;{{$reportgesthper->HR_DEPARTMENT_SUB_SUB_NAME}}</td>   
                                  <td class="text-font text-pedding" style="text-align: center;border: 1px solid black;" width="8%">
                                  @if($reportgesthper->INFMATION_PERSON_STATUS == '2')
                                      <span class="badge badge-info">ย้ายออกแล้ว</span>
                                  @else
                                      <span class="badge badge-success">ปกติ</span>
                                  @endif
                                  
                                  </td>   
                              </tr> 
                          @else
                                 
                          @endif
                                                                                
                     
              @endforeach   
            </tbody>
        </table>

                   

                
                 
                  
      
                      

