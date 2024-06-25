@extends('layouts.user')
@section('title', 'PK-OFFICER || P4P')

    


@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
    </script>
    <?php
    if (Auth::check()) {
        $type = Auth::user()->type;
        $iduser = Auth::user()->id;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
 

    function Monththai($strtime)
    {
        if($strtime == '1'){
            $month = 'มกราคม';
        }else if($strtime == '2'){
            $month = 'กุมภาพันธ์';
        }else if($strtime == '3'){
            $month = 'มีนาคม';
        }else if($strtime == '4'){
            $month = 'เมษายน';
        }else if($strtime == '5'){
            $month = 'พฤษภาคม';
        }else if($strtime == '6'){
            $month = 'มิถุนายน';
        }else if($strtime == '7'){
            $month = 'กรกฎาคม';
        }else if($strtime == '8'){
            $month = 'สิงหาคม';
        }else if($strtime == '9'){
            $month = 'กันยายน';
        }else if($strtime == '10'){
            $month = 'ตุลาคม';
        }else if($strtime == '11'){
            $month = 'พฤศจิกายน';
        }else if($strtime == '12'){
            $month = 'ธันวาคม';
        }else{
            $month = '';  
        }

        return $month;
    }

    function Yearthai($strtime)
    {
        $year = $strtime+543;
        return $year;
    }

    function dayoff($date)
    {
        $DayOfWeek = date("w", strtotime($date));

        if($DayOfWeek  == 0 || $DayOfWeek  == 6){
                $collor = '#FF9999';
                $readonly = '#FF9999';
        }else{
                $collor = '#99FFFF'; 
        }
        return $collor;

    }
   
    $check_month; 
    $check_year;

    ?>
     <?php
     use App\Http\Controllers\P4pController;
     use Illuminate\Http\Request;
     use Illuminate\Support\Facades\DB;   
     $refnumberwork = P4pController::refnumberwork();
     $refwork = P4pController::refwork();
 ?>
     <style>
        #button{
               display:block;
               margin:20px auto;
               padding:30px 30px;
               background-color:#eee;
               border:solid #ccc 1px;
               cursor: pointer;
               }
               #overlay{	
               position: fixed;
               top: 0;
               z-index: 100;
               width: 100%;
               height:100%;
               display: none;
               background: rgba(0,0,0,0.6);
               }
               .cv-spinner {
               height: 100%;
               display: flex;
               justify-content: center;
               align-items: center;  
               }
               .spinner {
               width: 250px;
               height: 250px;
               border: 5px #ddd solid;
               border-top: 10px #fd6812 solid;
               border-radius: 50%;
               animation: sp-anime 0.8s infinite linear;
               }
               @keyframes sp-anime {
               100% { 
                   transform: rotate(360deg); 
               }
               }
               .is-hide{
               display:none;
               }
    </style>
    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    
                </div>
            </div>
        </div>
        <div class="row">

            <form  method="post" action="{{ route('user.work_load_update') }}" id="Workload_update" enctype="multipart/form-data">
                @csrf 

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-3">
                                <h5>บันทึกรายการภาระงาน P4P </h5>
                            </div> 
                            <div class="col"></div> 
                            <div class="col-md-2 text-end">
                                <a href="{{ url('p4p_user') }}"
                                    class="btn btn-outline-primary btn-sm"> 
                                    <i class="fa-regular fa-circle-left me-1"></i>
                                    ย้อนกลับ
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <h6 style="color: rgb(163, 162, 162)"> เดือน {{$monthth}} ปี {{$check_year}}</h6>
                            </div> 
                            <div class="col"></div> 
                           
                        </div>
                    </div>
                                           
                    <div class="card-body shadow-lg">
                         
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <p class="mb-0"> 
                                        <div class="table-responsive"> 
                                            <table id="example" class="table table-hover table-sm" style="width: 100%"> 
                                            <thead> 
                                                <tr> 
                                                    <th class="p-2">รายการ </th>   
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-01')}};">1</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-02')}};">2</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-03')}};">3</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-04')}};">4</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-05')}};">5</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-06')}};">6</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-07')}};">7</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-08')}};">8</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-09')}};">9</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-10')}};">10</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-11')}};">11</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-12')}};">12</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-13')}};">13</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-14')}};">14</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-15')}};">15</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-16')}};">16</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-17')}};">17</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-18')}};">18</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-19')}};">19</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-20')}};">20</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-21')}};">21</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-22')}};">22</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-23')}};">23</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-24')}};">24</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-25')}};">25</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-26')}};">26</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-27')}};">27</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-28')}};">28</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-29')}};">29</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-30')}};">30</th>
                                                    <th class="text-center" width="1%" style="background-color: {{dayoff($check_year.'-'.$check_month.'-31')}};">31</th>
                                                </tr> 
                                            </thead>                                                                                         
                                                        
                                            <tbody>
                                                    <?php $number = 0;?>
                                                @foreach ($p4p_workload as $item)
                                                    <?php $number++;  ?>
                                                        <tr>  
                                                            <td class="p-2"> 
                                                                <label for="" style="font-size: 13px;">{{$item->p4p_workset_name}}</label>
                                                            </td> 
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_1}}</label> </td> 
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_2}}</label> </td> 
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_3}}</label> </td> 
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_4}}</label> </td> 
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_5}}</label> </td> 
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_6}}</label> </td> 
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_7}}</label> </td> 
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_8}}</label> </td> 
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_9}}</label> </td>  
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_10}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_11}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_12}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_13}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_14}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_15}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_16}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_17}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_18}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_19}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_20}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_21}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_22}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_23}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_24}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_25}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_26}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_27}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_28}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_29}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_30}}</label> </td>
                                                            <td> <label for="" style="font-size: 13px;width: 1%">{{$item->p4p_workload_31}}</label> </td>
                                                        </tr>
                                                @endforeach
                                                        
                                            </tbody>
                                                     
                                            
                                        </table>
                                    </div>
                                </p>     

                            </div>
                        </div>
                       
                    </div>
                    <div class="card-footer">
                        <div class="col-md-12 text-end">
                            <div class="form-group">  
                            </div> 
                        </div>
                    </div>
               
                </div>
            </div>
        </div>
    </div>
    </div>
</form>

     <!--  Modal content for the copydata example -->
     <div class="modal fade" id="Copy_worksetbtn" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="myExtraLargeModalLabel">คัดลอกข้อมูลภาระงาน</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body"> 
                 <div class="row">                    
                     <div class="col-md-2 text-end"><label for="">ปี / เดือน</label></div>
                     <div class="col-md-8"> 
                         <div class="form-group text-center">
                             <select name="p4p_work_id2" id="p4p_work_id2" class="form-control form-control-sm"
                                 style="width: 100%" required>
                                 <option value="">=เลือก=</option>
                                 @foreach ($p4p_work_show as $leave) 
                                         <option value="{{ $leave->p4p_work_id }}">{{ $leave->p4p_work_year }} :: {{ $leave->p4p_work_monthth }} </option> 
                                 @endforeach                                 
                             </select>
                         </div>
                     </div> 
                </div>
            </div>
             <div class="modal-footer">
                 <div class="col-md-12 text-end">
                     <div class="form-group"> 
                         <button type="button" id="SaveCopy" class="btn btn-outline-info btn-sm" >
                            <i class="fa-regular fa-clone me-1"></i>
                            คัดลอกภาระงาน
                        </button>
                         <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><i
                                 class="fa-solid fa-xmark me-2"></i>Close</button>

                     </div>
                 </div>
             </div> 
         </div>
     </div>
 </div>

    
    
@endsection
@section('footer')
<script>
    
    function switchactive(idfunc){
            // var nameVar = document.getElementById("name").value;
            var checkBox = document.getElementById(idfunc);
            var onoff;
            
            if (checkBox.checked == true){
                onoff = "TRUE";
            } else {
                onoff = "FALSE";
            }
 
            var _token=$('input[name="_token"]').val();
                $.ajax({
                        url:"{{route('p4.p4p_workset_switchactive')}}",
                        method:"GET",
                        data:{onoff:onoff,idfunc:idfunc,_token:_token}
                })
       }
       function addunitwork() {
          var unitnew = document.getElementById("UNIT_INSERT").value;
        //   alert(unitnew);
          var _token = $('input[name="_token"]').val();
          $.ajax({
              url: "{{url('addunitwork')}}",
              method: "GET",
              data: {
                unitnew: unitnew,
                  _token: _token
              },
              success: function (result) {
                  $('.show_unit').html(result);
              }
          })
      }
</script>
 
<script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#p4p_work_month').select2({
                placeholder:"--เลือก--",
                allowClear:true
            });
            $('#p4p_work_id2').select2({
                    dropdownParent: $('#Copy_worksetbtn')
                });
                $('#p4p_work_year').select2({
                    dropdownParent: $('#Copy_worksetbtn')
                });
            $('#p4p_workset_id').select2({
                placeholder:"--เลือก--",
                allowClear:true
            });
            // Saveworksetbtn
            
            $('#SaveScorebtn').click(function() {
                var p4p_workload_date = $('#p4p_workload_date').val(); 
                var p4p_workset_id = $('#p4p_workset_id').val(); 
                var p4p_workset_score_now = $('#p4p_workset_score_now').val();
                var p4p_work_id = $('#p4p_work_id').val();
                $.ajax({
                    url: "{{ route('p4.p4p_work_scorenowsave') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        p4p_workload_date,
                        p4p_workset_id,
                        p4p_workset_score_now,
                        p4p_work_id                       
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    window.location.reload();
                                    // window.location="{{url('warehouse/warehouse_index')}}";
                                }
                            })
                        } else {
                             
                        }

                    },
                });
            });
            $('#Saveonebtn').click(function() {
                var p4p_workset_id = $('#p4p_workset_id').val(); 
                var p4p_work_id = $('#p4p_work_id').val(); 
               
                $.ajax({
                    url: "{{ route('p4.p4p_work_choose_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        p4p_workset_id,
                        p4p_work_id                        
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    window.location.reload();
                                    // window.location="{{url('warehouse/warehouse_index')}}";
                                }
                            })
                        } else {
                            Swal.fire({
                                title: 'มีข้อมูลแล้ว',
                                text: "You have data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    window.location.reload();
                                    // window.location="{{url('warehouse/warehouse_index')}}";
                                }
                            })
                        }

                    },
                });
            });

            $('#Saveworksetbtn').click(function() {
                var p4p_workset_id = $('#p4p_workset_id').val(); 
                var p4p_workload_user = $('#p4p_workload_user').val(); 
                var p4p_work_id = $('#p4p_work_id').val(); 
                // alert(p4p_workgroupset_user);
                $.ajax({
                    url: "{{ route('user.work_load_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        p4p_workset_id,
                        p4p_workload_user,
                        p4p_work_id 
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'เพิ่มภาระงานสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    window.location.reload();
                                    // window.location="{{url('warehouse/warehouse_index')}}";
                                }
                            })
                        } else {
                            Swal.fire({
                                title: 'กรุณาเลือกรายการด้วยค่ะ',
                                text: "please Choose data ?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, Choose New!' 
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    
                                }
                            })
                        }

                    },
                });
            });
            $('#SaveCopy').click(function() {
                // var yearcopy = $('#p4p_work_year').val(); 
                var p4p_work_id2 = $('#p4p_work_id2').val();  
                var p4p_workload_user = $('#p4p_workload_user').val();
                var id = $('#p4p_work_id').val(); 
                
                $.ajax({
                    url: "{{ route('user.work_load_saveCopy') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        // yearcopy,
                        p4p_work_id2,
                        p4p_workload_user,
                        id
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'คัดลอกภาระงานสำเร็จ',
                                text: "You Copy data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    window.location.reload();
                                    // window.location="{{url('warehouse/warehouse_index')}}";
                                }
                            })
                        }else if(data.status == 150){
                            Swal.fire({
                                title: 'ยังไม่มีข้อมูลค่ะ',
                                text: "Don't have data ?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, Choose New!' 
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    
                                }
                            })
                        }else if(data.status == 170){
                            Swal.fire({
                                title: 'มีข้อมูลแล้วค่ะ',
                                text: "Don't have data ?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, Choose New!' 
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    
                                }
                            })
                        } else {
                            Swal.fire({
                                title: 'กรุณาเลือกรายการด้วยค่ะ',
                                text: "please Choose data ?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, Choose New!' 
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    
                                }
                            })
                        }

                    },
                });
            });
           
            
        });
        
</script>

@endsection
