<?php
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="รายงานการเข้าพักอาศัยในแฟลตและบ้านพัก.xls"');//ชื่อไฟล์


  date_default_timezone_set("Asia/Bangkok");
  $date = date('Y-m-d');
  use App\Http\Controllers\ReportguesthouseController;

?>
   
     <center>
     <B>รายงานการเข้าพักอาศัยในแฟลตและบ้านพัก ในโรงพยาบาล</B> <br>
     <B> โรงพยาบาล  {{$orgname->ORG_NAME}}  จังหวัด  {{$orgname->PROVINCE}}</B><br>
     {{-- <B> ปีงบประมาณ  {{$orgname->ORG_NAME}}  จังหวัด </B><br> --}}
       </center>                   


        <!-- DataTables init on table by adding .js-dataTable-simple class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
        <table  width="100%">
            <thead >
                <tr height="40">
                  <th class="text-font" style="text-align: center;border: 1px solid black;" width="5%">ลำดับ</th>
                  <th class="text-font" style="text-align: center;border: 1px solid black;" width="15%">ประเภทที่พัก</th>
                  <th class="text-font" style="text-align: center;border: 1px solid black;" width="25%">ชื่อแฟลต / บ้านพัก</th>
                  <th class="text-font" style="text-align: center;border: 1px solid black;" width="10%">จำนวนห้องที่มีทั้งหมด (ห้อง)</th>
                  <th class="text-font" style="text-align: center;border: 1px solid black;" width="10%">จำนวนห้องที่ใช้พัก (ห้อง)</th>
                  <th class="text-font" style="text-align: center;border: 1px solid black;" width="10%">จำนวนผู้ที่พักในห้อง (คน)</th>
                  <th class="text-font" style="text-align: center;border: 1px solid black;" width="10%">จำนวนห้องว่าง (ห้อง)</th>    
                </tr >
            </thead>
            <tbody>
            
          
                <?php $number = 0; ?>
                @foreach ($report_gesths as $reportgesth)
                <?php $number++;?>
                    <tr height="20">
                        <td class="text-font" style="text-align:center;border: 1px solid black;" width="5%">&nbsp;{{$number}}</td>
                        @if ($reportgesth->INFMATION_TYPE == '1')
                            <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;" width="15%">&nbsp;&nbsp;แฟลต</td>
                        @else
                            <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;" width="15%">&nbsp;&nbsp;บ้านพัก</td>
                        @endif 

                        <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;" width="25%">&nbsp;&nbsp;{{$reportgesth->INFMATION_NAME}}</td>    
          
                        <td class="text-font text-pedding" style="text-align: center;border: 1px solid black;" width="10%">{{ReportguesthouseController::amountroom($reportgesth->LOCATION_ID)}}</td>
                        <td class="text-font text-pedding" style="text-align: center;border: 1px solid black;" width="10%">{{ReportguesthouseController::amountroomuser($reportgesth->INFMATION_ID)}}</td>
                        <td class="text-font text-pedding" style="text-align: center;border: 1px solid black;" width="10%">{{ReportguesthouseController::amountperson($reportgesth->INFMATION_ID)}}</td>
                        <td class="text-font text-pedding" style="text-align: center;border: 1px solid black;" width="10%">{{ReportguesthouseController::amountroom($reportgesth->LOCATION_ID)-ReportguesthouseController::amountroomuser($reportgesth->INFMATION_ID)}}</td>
                                                       
                    </tr>  
                @endforeach  
            </tbody>
        </table>

                   

                
                 
                  
      
                      

