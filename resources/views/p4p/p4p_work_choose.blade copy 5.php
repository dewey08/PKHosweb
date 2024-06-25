@extends('layouts.p4pnew')
@section('title', 'PK-OFFICER || P4P')

     <?php
     use App\Http\Controllers\P4pController;
     use Illuminate\Support\Facades\DB;   
     $refnumberwork = P4pController::refnumberwork();
     $refwork = P4pController::refwork();
 ?>


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
        }else{
                $collor = '#99FFFF'; 
        }
        return $collor;

    }

    $check_month; 
    $check_year;

    ?>
    <style>
        body {
           font-size: 13px;
       }
       .btn {
           font-size: 13px;
       }
       .bgc {
           background-color: #264886;
       }
       .bga {
           background-color: #fbff7d;
       }
       .boxpdf {
           /* height: 1150px; */
           height: auto;
       }
       .page {
           width: 90%;
           margin: 10px;
           box-shadow: 0px 0px 5px #000;
           animation: pageIn 1s ease;
           transition: all 1s ease, width 0.2s ease;
       }
       
       @media (min-width: 1500px) {
           .modal-xls {
               --modal-width: 1500px;
           }
       }
        
       
   </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-3">
                                <h5>บันทึกรายการภาระงาน P4P </h5>
                            </div> 
                            <div class="col"></div> 
                            <div class="col-md-2 text-end">
                                <a href="{{ url('p4p_work') }}"
                                    class="btn btn-warning btn-sm"> 
                                    <i class="fa-regular fa-circle-left me-2"></i>
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
                                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>   
                                                    <th class="text-center">ชื่อรายการภาระงาน</th>
                                                    {{-- <th width="5%" class="text-center">ระยะเวลาที่ใช้จริง</th> --}}
                                                    <th width="5%" class="text-center">คะแนน/นาที</th>
                                                    <th width="5%" class="text-center">รวมคะแนน/นาที</th>
                                                    {{-- <th width="5%" class="text-center">หน่วยนับ</th> --}}
                                                    <th width="5%" class="text-center">สถานะ</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($p4p_workset as $item) 
                                                    <tr id="sid{{ $item->p4p_workset_id }}">   
                                                        <td class="text-center" width="5%">{{ $i++ }}</td>    
                                                        <td class="p-2" style="font-size: 13px">
                                                            <button class="btn btn-outline-info btn-sm" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#collapse{{$item->p4p_workset_id}}" aria-expanded="false" aria-controls="collapse{{$item->p4p_workset_id}}">
                                                                <i class="fa-solid fa-circle-info text-info me-2"></i>
                                                                {{ $item->p4p_workset_name }}
                                                            </button>    
                                                                                                           
                                                            <div class="collapse mt-1 mb-1" id="collapse{{$item->p4p_workset_id}}">
                                                                <table class="table table-hover table-secondary">
                                                                    <thead> 
                                                                            <tr>
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
                                                                      <tr>
                                                                        {{-- @for ($i = 1; $i < $d; $i++) 
                                                                            <td width="7%"><input id="p4p_workset_score_now" type="text" class="form-control input-rounded btn-sm" name="p4p_workset_score_now"> </td> 
                                                                        @endfor --}}
                                                                        <td ><input id="p4p_workset_score_now" type="text" class="form-control form-control-sm" name="p4p_workset_score_now"> </td> 
                                                                        <td ><input id="p4p_workset_score_now" type="text" class="form-control form-control-sm" name="p4p_workset_score_now"> </td> 
                                                                        <td ><input id="p4p_workset_score_now" type="text" class="form-control form-control-sm" name="p4p_workset_score_now"> </td> 
                                                                        <td ><input id="p4p_workset_score_now" type="text" class="form-control form-control-sm" name="p4p_workset_score_now"> </td> 
                                                                        <td ><input id="p4p_workset_score_now" type="text" class="form-control form-control-sm" name="p4p_workset_score_now"> </td> 
                                                                        
                                                                      </tr>
                                                                    </tbody>
                                                                </table>
                                                                
                                                            </div>
                                                        </td>
                                                        {{-- <td class="text-center" width="5%" style="font-size: 13px">{{ $item->p4p_workset_time }}</td>  --}}
                                                        <td class="text-center" width="5%" style="font-size: 13px">{{ $item->p4p_workset_score }}</td> 
                                                        <td class="text-center" width="5%" style="font-size: 13px">{{ $item->p4p_workset_wp }}</td> 
                                                        {{-- <td class="text-center" width="5%" style="font-size: 13px">{{ $item->p4p_workgroupset_unit_name }}</td>  --}}
                                                        <td width="5%">
                                                            @if($item-> p4p_workset_active == 'TRUE' )
                                                            <input type="checkbox" id="{{ $item-> p4p_workset_id }}" name="{{ $item-> p4p_workset_id }}" switch="none" onchange="switchactive({{ $item-> p4p_workset_id }});" checked />
                                                            @else
                                                            <input type="checkbox" id="{{ $item-> p4p_workset_id }}" name="{{ $item-> p4p_workset_id }}" switch="none" onchange="switchactive({{ $item-> p4p_workset_id }});" />
                                                            @endif
                                                            <label for="{{ $item-> p4p_workset_id }}" data-on-label="On" data-off-label="Off"></label>
 
                                                        </td>
                                                        
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

    <!--  Modal content for the above example -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">บันทึกรายการภาระงาน P4P</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Cras mattis consectetur purus sit amet fermentum.
                        Cras justo odio, dapibus ac facilisis in,
                        egestas eget quam. Morbi leo risus, porta ac
                        consectetur ac, vestibulum at eros.</p>
                    <p>Praesent commodo cursus magna, vel scelerisque
                        nisl consectetur et. Vivamus sagittis lacus vel
                        augue laoreet rutrum faucibus dolor auctor.</p>
                    
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
{{-- <script>
     $(document).on('click', '.detail', function() {
            var id = $(this).val(); 
            $('#detailModal').modal('show');
            $('#Savebtn').click(function() {
                var p4p_workset_code = $('#p4p_workset_code').val(); 
                var p4p_workset_name = $('#p4p_workset_name').val(); 
                var p4p_workset_user = $('#p4p_workset_user').val(); 
                var p4p_workset_time = $('#p4p_workset_time').val();
                var p4p_workset_score = $('#p4p_workset_score').val();
                var p4p_workset_unit = $('#p4p_workset_unit').val();
                var p4p_workset_group = $('#p4p_workset_group').val();
                $.ajax({
                    url: "{{ route('p4.p4p_workset_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        p4p_workset_code,
                        p4p_workset_name,
                        p4p_workset_user,
                        p4p_workset_time,
                        p4p_workset_score,
                        p4p_workset_unit,
                        p4p_workset_group
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
        });
</script> --}}
<script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#p4p_work_month').select2({
                placeholder:"--เลือก--",
                allowClear:true
            });
            // $('#p4p_workset_id').select2({
            //     placeholder:"--เลือก--",
            //     allowClear:true
            // });
            $('#p4p_work_position').select2({
                placeholder:"--เลือก--",
                allowClear:true
            });
            
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

            $('#Savebtn').click(function() {
                // var p4p_workset_id = $('#p4p_workset_id').val(); 
                var p4p_work_id = $('#p4p_work_id').val(); 
                var p4p_work_position = $('#p4p_work_position').val(); 
                var p4p_workgroupset_user = $('#p4p_workgroupset_user').val(); 
                // alert(p4p_workgroupset_user);
                $.ajax({
                    url: "{{ route('p4.p4p_work_choose_worksetsave') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        p4p_work_id,
                        p4p_workgroupset_user,
                        p4p_work_position
                        // p4p_work_code 
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
        });
        
</script>

@endsection
