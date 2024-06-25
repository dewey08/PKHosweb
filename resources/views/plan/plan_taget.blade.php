@extends('layouts.plannew')
@section('title','PK-OFFICER || Plan')
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
?>
<style>
    .table th {
        font-family: sans-serif;
        font-size: 12px;
    }
    .table td {
        font-family: sans-serif;
        font-size: 12px;
    }
</style>
<?php
     use App\Http\Controllers\karnController;
     use Illuminate\Support\Facades\DB; 
 ?>
  <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">                    
                <div class="row">
                    <div class="col-md-8">
                        <h6 class="mb-sm-0">ยุทธศาสตร์ {{$data_plan_strategic->plan_strategic_name}}</h6>
                    </div>                   
                    <div class="col"></div>
                    <div class="col-md-3">
                        <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#insertdata">
                            <i class="fa-solid fa-folder-plus text-info me-2"></i>
                            เพิ่มวัตถุประสงค์
                        </button>
                        <a href="{{url('plan_strategic')}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-secondary">
                            <i class="fa-solid fa-angle-left text-secondary me-2"></i>
                            ย้อนกลับ
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">                     
                    <div class="card-body py-0 px-2 mt-2"> 
                        <div class="table-responsive">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                                <thead>                                           
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัสวัตถุประสงค์</th>
                                        <th class="text-center">วัตถุประสงค์</th>
                                        <th class="text-center" width="10%">ตัวชี้วัด KPI</th>       
                                        <th class="text-center" width="7%">จัดการ</th>                                              
                                    </tr>                                            
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($plan_taget as $item)
                                        <tr id="sid{{ $item->plan_taget_id }}">
                                            <td class="text-center">{{$i++}}</td>  
                                            <td class="text-center" width="12%">{{$item->plan_taget_code}}</td> 
                                            <td class="p-2">{{$item->plan_taget_name}}</td> 
                                            <td class="text-center"> 
                                                <a href="{{url('plan_kpi/'.$data_plan_strategic->plan_strategic_id.'/'.$item->plan_taget_id)}}">
                                                    
                                               
                                                <i class="fa-solid fa-2x fa-arrows-down-to-people" style="color: rgb(201, 6, 227)"></i>
                                            </a>
                                            </td>  
                                            <td class="text-center" width="7%">
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-info dropdown-toggle menu btn-sm"
                                                        type="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">ทำรายการ</button>
                                                    <ul class="dropdown-menu"> 
                                                        <button type="button"class="dropdown-item menu"
                                                            data-bs-toggle="modal" data-bs-target="#updateModal{{ $item->plan_taget_id }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square ms-2 me-2 text-warning"></i>
                                                            <label for=""
                                                                style="font-size:13px;color: rgb(255, 185, 34)">แก้ไข</label>
                                                        </button>
                                                        {{-- <a class="dropdown-item menu" href="{{url('plan_taget')}}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="เพิ่มเป้าประสงค์และKPI">
                                                            <i class="fa-solid fa-square-plus ms-2 me-2" style="font-size:13px;color: rgb(22, 76, 251)"></i>
                                                            <label for=""  
                                                                style="font-size:13px;color: rgb(22, 76, 251)">เพิ่มเป้าประสงค์และKPI</label>
                                                        </a> --}}
 
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>

                                         <!--  Modal content Update -->
                                         <div class="modal fade" id="updateModal{{ $item->plan_taget_id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="invenModalLabel">แก้ไขวัตถุประสงค์</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input id="editplan_taget_id" type="hidden" class="form-control form-control-sm" value="{{ $item->plan_taget_id }}">
                                                        
                                                        {{-- <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="">พันธกิจ</label>
                                                                <div class="form-group">
                                                                    <select name="plan_mission_id" id="editplan_mission_id" class="form-control form-control-sm"
                                                                    style="width: 100%">
                                                                    <option value="">=เลือก=</option>
                                                                    @foreach ($plan_mission as $mission)
                                                                    @if ($item->plan_mission_id == $mission->plan_mission_id)
                                                                    <option value="{{ $mission->plan_mission_id }}" selected>{{ $mission->plan_mission_name }} </option>
                                                                    @else
                                                                    <option value="{{ $mission->plan_mission_id }}">{{ $mission->plan_mission_name }} </option>
                                                                    @endif
                                                                        
                                                                    @endforeach
                                                                </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 mt-3">
                                                                <label for="">ยุทธศาสตร์</label>
                                                                <div class="form-group">
                                                                <input id="editplan_strategic_name" class="form-control form-control-sm" name="plan_strategic_name" value="{{$item->plan_strategic_name}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mt-3">
                                                                <label for="">เริ่มต้นปีงบประมาณ</label>
                                                                <div class="form-group">
                                                                    <input id="editplan_strategic_startyear" class="form-control form-control-sm" name="plan_strategic_startyear" value="{{$item->plan_strategic_startyear}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mt-3">
                                                                <label for="">สิ้นสุดปีงบประมาณ</label>
                                                                <div class="form-group">
                                                                    <input id="editplan_strategic_endyear" class="form-control form-control-sm" name="plan_strategic_endyear" value="{{$item->plan_strategic_endyear}}">
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="">ยุทธศาสตร์ {{$data_plan_strategic->plan_strategic_name}}</label> 
                                                                <input type="hidden" id="editplan_strategic_id" class="form-control form-control-sm" name="plan_strategic_id" value="{{$data_plan_strategic->plan_strategic_id}}">               
                                                            </div>
                                                        </div>
                                                      
                                                        <div class="row">
                                                            <div class="col-md-3 mt-3">
                                                                <label for="">รหัสวัตถุประสงค์</label>
                                                                <div class="form-group">
                                                                    <input id="editplan_taget_code" class="form-control form-control-sm" name="plan_taget_code" value="{{ $item->plan_taget_code }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9 mt-3">
                                                                <label for="">วัตถุประสงค์</label>
                                                                <div class="form-group">
                                                                    <input id="editplan_taget_name" class="form-control form-control-sm" name="plan_taget_name" value="{{ $item->plan_taget_name }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="col-md-12 text-end">
                                                            <div class="form-group">
                                                                <button type="button" id="updateBtn"
                                                                    class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-primary">
                                                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                                                    แก้ไขข้อมูล
                                                                </button>
                                                                <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-danger"
                                                                    data-bs-dismiss="modal"><i
                                                                        class="fa-solid fa-xmark me-2"></i>Close</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
 
                                    @endforeach
                                </tbody>
                            </table>
                        </div> 
                    </div>                    
                </div>
            </div>
        </div>       
    </div> 

     <!--  Modal content for the insert example -->
     <div class="modal fade" id="insertdata" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">เพิ่มวัตถุประสงค์</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">ยุทธศาสตร์ {{$data_plan_strategic->plan_strategic_name}}</label> 
                            <input type="hidden" id="plan_strategic_id" class="form-control form-control-sm" name="plan_strategic_id" value="{{$data_plan_strategic->plan_strategic_id}}">               
                        </div>
                    </div>
                  
                    <div class="row">
                        <div class="col-md-3 mt-3">
                            <label for="">รหัสวัตถุประสงค์</label>
                            <div class="form-group">
                                <input id="plan_taget_code" class="form-control form-control-sm" name="plan_taget_code">
                            </div>
                        </div>
                        <div class="col-md-9 mt-3">
                            <label for="">วัตถุประสงค์</label>
                            <div class="form-group">
                                <input id="plan_taget_name" class="form-control form-control-sm" name="plan_taget_name">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="button" id="saveBtn" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-primary">
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                บันทึกข้อมูล
                            </button>
                            <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-danger" data-bs-dismiss="modal"><i
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
            $(document).ready(function() {
                $('#example').DataTable();
                $('#example2').DataTable();
                $('#example3').DataTable();

                $('select').select2();
                $('#plan_mission_id').select2({
                    dropdownParent: $('#insertdata')
                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#saveBtn').click(function() {
                    var plan_strategic_id = $('#plan_strategic_id').val();
                    var plan_taget_code = $('#plan_taget_code').val();
                    var plan_taget_name = $('#plan_taget_name').val(); 
                    $.ajax({
                        url: "{{ route('p.plan_taget_save') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            plan_strategic_id,
                            plan_taget_code,
                            plan_taget_name 
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
                                        window.location
                                            .reload();
                                    }
                                })
                            } else {

                            }

                        },
                    });
                });

                $('#updateBtn').click(function() {
                    var editplan_strategic_id = $('#editplan_strategic_id').val(); 
                    var editplan_taget_id = $('#editplan_taget_id').val();
                    var editplan_taget_code = $('#editplan_taget_code').val();
                    var editplan_taget_name = $('#editplan_taget_name').val(); 
                    $.ajax({
                        url: "{{ route('p.plan_taget_update') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            editplan_strategic_id,
                            editplan_taget_id,
                            editplan_taget_code,
                            editplan_taget_name 
                        },
                        success: function(data) {
                            if (data.status == 200) {
                                Swal.fire({
                                    title: 'แก้ไขข้อมูลสำเร็จ',
                                    text: "You edit data success",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#06D177',
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result
                                        .isConfirmed) {
                                        console.log(
                                            data);

                                        window.location
                                            .reload();
                                    }
                                })
                            } else {

                            }

                        },
                    });
                });

                              
            });
           
        </script>    
       
    @endsection
