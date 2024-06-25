@extends('layouts.p4pnew')
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
               border: 10px #ddd solid;
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
                        <div class="row mb-3">
                            <div class="col"></div> 
                            <div class="col-md-1 text-end">
                                <label for="p4p_workset_id" style="font-family: sans-serif;font-size: 13px">ชื่อรายการ </label>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group"> 
                                    <select name="p4p_workset_id" id="p4p_workset_id" class="form-select form-select-sm" style="width: 100%">
                                        <option value="">-</option> 
                                        @foreach ($p4p_workset as $ws) 
                                        <?php $p4p_workload_ = DB::table('p4p_workload')->where('p4p_workset_id','=',$ws->p4p_workset_id)->count(); ?>                                        
                                        @if ($ws->p4p_workset_id != '' && $p4p_workload_ == 0) 
                                            <option value="{{ $ws->p4p_workset_id  }}">{{ $ws->p4p_workset_code }} :: {{ $ws->p4p_workset_name }}</option> 
                                        @endif                                                                                              
                                        @endforeach         
                                    </select> 

                                </div>
                            </div>
                            <input type="hidden" id="p4p_workload_user" value="{{$iduser}}">
                            <input type="hidden" id="p4p_work_id" value="{{$p4p_work_id}}">
                         

                            <div class="col-md-2 text-start">
                                <button type="button" class="btn btn-info btn-sm" id="Saveworksetbtn">
                                    <i class="fa-solid fa-circle-plus me-1"></i>
                                    เพิ่มภาระงาน
                                </button>
                            </div>
                            <div class="col"></div> 
                        </div>
                        <hr>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <p class="mb-0"> 
                                        <div class="table-responsive">
                                            {{-- <table id="alternative-page-datatable" class="table dt-responsive nowrap w-100"> --}}
                                            <table id="example" class="table table-hover table-sm" width="100%">
                                                {{-- <table id="example" class="table table-hover table-sm table-light dt-responsive nowrap"
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                            <thead>
                                                {{-- <table id="complex-header-datatable" class="table dt-responsive nowrap w-100"> --}}
                                                    {{-- <thead class="thead-light"> --}}
                                                <tr>
                                                    {{-- <th width="5%" class="text-center">ลำดับ</th>    --}}
                                                    <th class="text-center" >รายการ </th> 
                                                    {{-- <th width="5%" class="text-center">คะแนน/นาที</th>
                                                    <th width="5%" class="text-center">รวมคะแนน/นาที</th>   --}}
                                                
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
                                                            {{-- <td align="center" >{{$number}}</td> --}}
                                                            <td align="center" >
                                                                <button type="button" class="btn btn-success btn-sm waves-effect waves-light" data-bs-toggle="popover" data-bs-trigger="focus" title="ภาระงาน" data-bs-content="{{$item->p4p_workset_name}}">รายการ</button>
                                                            </td>
                                                            {{-- <td class="p-2">  --}}
                                                                {{-- <label for="">{{$item->p4p_workset_name}}</label> --}}
                                                                {{-- <input id="p4p_workset_name" type="text" name="p4p_workset_name[]" value="{{$item->p4p_workset_name}}" > --}}
                                                                {{-- <input id="p4p_workset_id" type="hidden" name="p4p_workset_id[]" value="{{$item->p4p_workset_id}}"> --}}
                                                             {{-- </td>  --}}
                                                            <td  ><input id="p4p_workload_1" class="form-control form-control-sm" name="p4p_workload_1"> </td> 
                                                            <td  ><input id="p4p_workload_2" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_3" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_4" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_5" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_6" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_7" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_8" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_9" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_10" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_11" class="form-control form-control-sm" name="p4p_workload_1"> </td> 
                                                            <td  ><input id="p4p_workload_12" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_13" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_14" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_15" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_16" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_17" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_18" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_19" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_20" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_21" class="form-control form-control-sm" name="p4p_workload_1"> </td> 
                                                            <td  ><input id="p4p_workload_22" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_23" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_24" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_25" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_26" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_27" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_28" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_29" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_30" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
                                                            <td  ><input id="p4p_workload_31" class="form-control form-control-sm" name="p4p_workload_2"> </td> 
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
                    url: "{{ route('p4.p4p_work_load_save') }}",
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

            // $('#Savebtn').click(function() {
            //     // var p4p_workset_id = $('#p4p_workset_id').val(); 
            //     var p4p_work_id = $('#p4p_work_id').val(); 
            //     var p4p_work_position = $('#p4p_work_position').val(); 
            //     var p4p_workgroupset_user = $('#p4p_workgroupset_user').val(); 
            //     // alert(p4p_workgroupset_user);
            //     $.ajax({
            //         url: "{{ route('p4.p4p_work_load_save') }}",
            //         type: "POST",
            //         dataType: 'json',
            //         data: {
            //             p4p_work_id,
            //             p4p_workgroupset_user,
            //             p4p_work_position
            //             // p4p_work_code 
            //         },
            //         success: function(data) {
            //             if (data.status == 200) {
            //                 Swal.fire({
            //                     title: 'บันทึกข้อมูลสำเร็จ',
            //                     text: "You Insert data success",
            //                     icon: 'success',
            //                     showCancelButton: false,
            //                     confirmButtonColor: '#06D177',
            //                     confirmButtonText: 'เรียบร้อย'
            //                 }).then((result) => {
            //                     if (result
            //                         .isConfirmed) {
            //                         console.log(
            //                             data);
            //                         window.location.reload();
            //                         // window.location="{{url('warehouse/warehouse_index')}}";
            //                     }
            //                 })
            //             } else {
            //                 Swal.fire({
            //                     title: 'มีข้อมูลแล้ว',
            //                     text: "You have data success",
            //                     icon: 'success',
            //                     showCancelButton: false,
            //                     confirmButtonColor: '#06D177',
            //                     confirmButtonText: 'เรียบร้อย'
            //                 }).then((result) => {
            //                     if (result
            //                         .isConfirmed) {
            //                         console.log(
            //                             data);
            //                         window.location.reload();
            //                         // window.location="{{url('warehouse/warehouse_index')}}";
            //                     }
            //                 })
            //             }

            //         },
            //     });
            // });
        });
        
</script>

@endsection
