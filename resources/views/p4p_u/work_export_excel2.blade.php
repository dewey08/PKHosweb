 
   
   <?php
   header("Content-Type: application/vnd.ms-excel");
   header('Content-Disposition: attachment; filename="p4p.xls"');//ชื่อไฟล์
   
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
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>แบบเก็บข้อมูลผลการปฏิบัติงานรายบุคคล  ประจำเดือน  {{$monthth}}  พ.ศ.{{($check_year)+543}}  ปีงบประมาณ {{($check_year)+543}}</b></label><br> 
   <label for="" style="font-family: 'Kanit', sans-serif;font-size:15px;"><b>ชื่อ-สกุล {{$fullname}}   ตำแหน่ง {{$posi}}</b></label><br>
</center>
   <br><br>
     
   <table class="table" style="width: 100%">
    <thead>
        <tr>
            <th rowspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ลำดับ</th>
            <th rowspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ชื่อ-สกุล</th>
            <th rowspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">หน่วยนับ</th>

            <th rowspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">
                ระยะเวลาที่ใช้จริง<br>
                ที่ใช้จริง/ชิ้นงาน(นาที)  
            </th>
            <th rowspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">
                แต้ม/นาที<br>
                นวก.
            </th>

            <th colspan="31" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">จำนวนชิ้นงานที่ทำได้ในวันที่ปฏิบัติงาน</th>

            <th rowspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">รวมชิ้นงาน </th>
            <th rowspan="2" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">รวมแต้ม</th> 
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
        @foreach ($p4p_workload as $item)
        <?php   
                $wid = $item->p4p_work_id;
                $uid = $item->p4p_workload_user;
                $score = $item->p4p_workset_score;

                $total_qty_one = $item->p4p_workload_1+ $item->p4p_workload_2+ $item->p4p_workload_3+ $item->p4p_workload_4+ $item->p4p_workload_5+
                    $item->p4p_workload_6+ $item->p4p_workload_7+ $item->p4p_workload_8+ $item->p4p_workload_9+ $item->p4p_workload_10 + 
                    $item->p4p_workload_11+ $item->p4p_workload_12+ $item->p4p_workload_13+ $item->p4p_workload_14+ $item->p4p_workload_15+ 
                    $item->p4p_workload_16+ $item->p4p_workload_17+ $item->p4p_workload_18+ $item->p4p_workload_19+ $item->p4p_workload_20 +
                    $item->p4p_workload_21+$item->p4p_workload_22+$item->p4p_workload_23+$item->p4p_workload_24+$item->p4p_workload_25 +
                    $item->p4p_workload_26+$item->p4p_workload_27+$item->p4p_workload_28+$item->p4p_workload_29+$item->p4p_workload_30+$item->p4p_workload_31;

                    $sum_total = $total_qty_one * $score;
        
        ?>
            <tr>
                <td rowspan="1" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"> 
                    {{ $i++ }}  
                </td>
                <td rowspan="1" style="border-color:#F0FFFF;text-align: left;border: 1px solid black;">  
                    {{ $item->p4p_workset_name }}  
                </td>
                <td rowspan="1" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">
                    {{$item->p4p_workgroupset_unit_name}}
                </td>

                <td rowspan="1" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" >
                    {{$item->p4p_workset_time}}
                </td>
                <td rowspan="1" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">
                    {{$item->p4p_workset_score}}
                </td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_1}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_2}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_3}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_4}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_5}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_6}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_7}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_8}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_9}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_10}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_11}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_12}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_13}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_14}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_15}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_16}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_17}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_18}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_19}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_20}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_21}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_22}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_23}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_24}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_25}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_26}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_27}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_28}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_29}}</td>

                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_30}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$item->p4p_workload_31}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$total_qty_one}}</td>
                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$sum_total}}</td>
                

            </tr>
 
        @endforeach
        <br><br><br><br>
        <tr>
            <td colspan="35" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%"></td>
            <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">Total</td>
            <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$total_qty}}</td>
            <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;width:10%">{{$data_p4p_sum}}</td>
        </tr>
        
    </tbody>


</table>
   