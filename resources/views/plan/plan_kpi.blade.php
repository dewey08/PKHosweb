@extends('layouts.plannew')
@section('title','PK-OFFICER || Plan')
@section('content')
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
<script>
    
    function plan_kpi_destroy(plan_kpi_id)
    {
      Swal.fire({
      title: 'ต้องการลบใช่ไหม?',
      text: "ข้อมูลนี้จะถูกลบไปเลย !!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
      cancelButtonText: 'ไม่, ยกเลิก'
      }).then((result) => {
      if (result.isConfirmed) {
          $.ajax({
          url:"{{url('plan_kpi_destroy')}}" +'/'+ plan_kpi_id,  
          type:'DELETE',
          data:{
              _token : $("input[name=_token]").val()
          },
          success:function(response)
          {          
              Swal.fire({
                title: 'ลบข้อมูล!',
                text: "You Delet data success",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#06D177',
                // cancelButtonColor: '#d33',
                confirmButtonText: 'เรียบร้อย'
              }).then((result) => {
                if (result.isConfirmed) {                  
                  $("#sid"+plan_kpi_id).remove();     
                  window.location.reload();      
                }
              }) 
          }
          })        
        }
        })
    }
</script>

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
                        <h6 class="mb-sm-0">ยุทธศาสตร์ {{$data_plan_strategic->plan_strategic_name}} <br> เป้าประสงค์ {{$data_plan_taget->plan_taget_name}}</h6>
                    </div>                   
                    <div class="col"></div>
                    <div class="col-md-3">
                        <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-info" data-bs-toggle="modal"
                            data-bs-target="#insertdata">
                            <i class="fa-solid fa-folder-plus text-info me-2"></i>
                            เพิ่มตัวชี้วัด
                        </button>
                        <a href="{{url('plan_taget/'.$data_plan_taget->plan_taget_id)}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-secondary">
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
                                        <th class="text-center">รหัส</th>
                                        <th class="text-center">ตัวชี้วัด</th>
                                        <th class="text-center" width="10%">ปีงบ</th>       
                                        <th class="text-center" width="10%">จัดการ</th>                                              
                                    </tr>                                            
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($plan_kpi as $item)
                                        <tr id="sid{{ $item->plan_kpi_id }}">
                                            <td class="text-center">{{$i++}}</td>  
                                            <td class="text-center" width="7%">{{$item->plan_kpi_code}}</td> 
                                            <td class="p-2">{{$item->plan_kpi_name}}</td> 
                                            <td class="text-center" width="7%">{{$item->plan_kpi_year}}</td> 
                                              
                                            <td class="text-center" width="7%">
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-info dropdown-toggle menu btn-sm"
                                                        type="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">ทำรายการ</button>
                                                    <ul class="dropdown-menu"> 
                                                        <button type="button"class="dropdown-item menu"
                                                            data-bs-toggle="modal" data-bs-target="#updateModal{{ $item->plan_kpi_id }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square ms-2 me-2 text-warning"></i>
                                                            <label for=""
                                                                style="font-size:13px;color: rgb(255, 185, 34)">แก้ไข</label>
                                                        </button>
                                                        <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                            onclick="plan_kpi_destroy({{ $item->plan_kpi_id }})"
                                                            style="font-size:13px">
                                                            <i class="fa-solid fa-trash-can ms-2 me-2 text-danger"
                                                                style="font-size:13px"></i>
                                                            <span>ลบ</span>
                                                        </a>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>

                                         <!--  Modal content Update -->
                                         <div class="modal fade" id="updateModal{{ $item->plan_kpi_id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="invenModalLabel">แก้ไขตัวชี้วัด</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input id="editplan_kpi_id" type="hidden" class="form-control form-control-sm" value="{{ $item->plan_kpi_id }}">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="">ปีงบประมาณ</label> 
                                                                <select name="leave_year_id" id="editleave_year_id" class="form-control form-control-sm" style="width: 100%">
                                                                    <option value="">=เลือก=</option>
                                                                    @foreach ($budget_year as $year)
                                                                    @if ($item->plan_kpi_year == $year->leave_year_id)
                                                                    <option value="{{ $year->leave_year_id }}" selected>{{ $year->leave_year_id }} </option>  
                                                                    @else
                                                                    <option value="{{ $year->leave_year_id }}">{{ $year->leave_year_id }} </option>  
                                                                    @endif
                                                                                      
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-12 mt-3">
                                                                <label for="">ยุทธศาสตร์ {{$data_plan_strategic->plan_strategic_name}}</label> 
                                                                <input type="hidden" id="editplan_strategic_id" class="form-control form-control-sm" name="plan_strategic_id" value="{{$data_plan_strategic->plan_strategic_id}}">               
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <label for="">เป้าประสงค์ {{$data_plan_taget->plan_taget_name}}</label> 
                                                                <input type="hidden" id="editplan_taget_id" class="form-control form-control-sm" name="plan_taget_id" value="{{$data_plan_taget->plan_taget_id}}">               
                                                            </div>
                                                        </div> 
                                                      
                                                        <div class="row">
                                                            <div class="col-md-2 mt-3">
                                                                <label for="">รหัส</label>
                                                                <div class="form-group">
                                                                    <input id="editplan_kpi_code" class="form-control form-control-sm" name="plan_kpi_code" value="{{$item->plan_kpi_code}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-10 mt-3">
                                                                <label for="">ตัวชี้วัด</label>
                                                                <div class="form-group">
                                                                    <input id="editplan_kpi_name" class="form-control form-control-sm" name="plan_kpi_name" value="{{$item->plan_kpi_name}}">
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
                    <h5 class="modal-title" id="myExtraLargeModalLabel">เพิ่มตัวชี้วัด</h5>
                   
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <label for="">ปีงบประมาณ</label> 
                            <select name="leave_year_id" id="leave_year_id" class="form-control form-control-sm" style="width: 100%">
                                <option value="">=เลือก=</option>
                                @foreach ($budget_year as $year)
                                @if ($yearnow == $year->leave_year_id)
                                <option value="{{ $year->leave_year_id }}" selected>{{ $year->leave_year_id }} </option>  
                                @else
                                <option value="{{ $year->leave_year_id }}">{{ $year->leave_year_id }} </option>  
                                @endif
                                                  
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mt-3">
                            <label for="">ยุทธศาสตร์ {{$data_plan_strategic->plan_strategic_name}}</label> 
                            <input type="hidden" id="plan_strategic_id" class="form-control form-control-sm" name="plan_strategic_id" value="{{$data_plan_strategic->plan_strategic_id}}">               
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="">เป้าประสงค์ {{$data_plan_taget->plan_taget_name}}</label> 
                            <input type="hidden" id="plan_taget_id" class="form-control form-control-sm" name="plan_taget_id" value="{{$data_plan_taget->plan_taget_id}}">               
                        </div>
                    </div> 
                  
                    <div class="row">
                        <div class="col-md-2 mt-3">
                            <label for="">รหัส</label>
                            <div class="form-group">
                                <input id="plan_kpi_code" class="form-control form-control-sm" name="plan_kpi_code">
                            </div>
                        </div>
                        <div class="col-md-10 mt-3">
                            <label for="">ตัวชี้วัด</label>
                            <div class="form-group">
                                <input id="plan_kpi_name" class="form-control form-control-sm" name="plan_kpi_name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label for="">เป้าหมาย Baseline</label>
                            <div class="form-group">
                                <input id="baseline" class="form-control form-control-sm" name="baseline">
                            </div>
                        </div>
                        <div class="col-md-2 mt-3">
                            <label for="">เงื่อนไข</label>
                            <div class="form-group">
                                <select name="proviso" id="proviso" class="form-control form-control-sm" style="width: 100%">
                                    <option value="1">>=</option>
                                    <option value="2"><</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label for="">หน่วย</label>
                            <div class="form-group">
                                <input id="proviso_unit" class="form-control form-control-sm" name="proviso_unit">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 mt-3">
                            <label for="">สูตรคำนวณ</label>
                            <div class="form-group">
                                
                            </div>
                        </div>
                        <div class="col-md-2 mt-3">
                            <label for="">ตัวตั้งข้อมูล</label>
                            <div class="form-group">
                                <input id="baseline" class="form-control form-control-sm" name="baseline">
                            </div>
                        </div>
                        <div class="col-md-8 mt-3">
                            <label for="">แหล่งข้อมูล</label>
                            <div class="form-group">
                                <input id="proviso_unit" class="form-control form-control-sm" name="proviso_unit">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 mt-3">
                             
                        </div>
                        <div class="col-md-2 mt-3">
                            <label for="">ตัวหารข้อมูล</label>
                            <div class="form-group">
                                <input id="baseline" class="form-control form-control-sm" name="baseline">
                            </div>
                        </div>
                        <div class="col-md-8 mt-3">
                            <label for="">แหล่งข้อมูล</label>
                            <div class="form-group">
                                <input id="proviso_unit" class="form-control form-control-sm" name="proviso_unit">
                            </div>
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="col-md-6 mt-3">
                            <label for="">หน่วยงานที่รับผิดชอบ</label>
                            <div class="form-group">
                                <select name="depsubsubid" id="depsubsubid" class="form-control form-control-sm" style="width: 100%">
                                    <option value="1">=เลือก=</option>
                                    @foreach ($dep_subsub as $itemsubsub)
                                        <option value="{{$itemsubsub->DEPARTMENT_SUB_SUB_ID}}">{{$itemsubsub->DEPARTMENT_SUB_SUB_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="">ผู้ควบคุมดูแล</label>
                            <div class="form-group">
                                <select name="adminid" id="adminid" class="form-control form-control-sm" style="width: 100%">
                                    <option value="1">=เลือก=</option>
                                    @foreach ($user as $u)
                                        <option value="{{$u->id}}">{{$u->fname}} {{$u->lname}}</option>
                                    @endforeach
                                </select>
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
                $('#leave_year_id').select2({
                    dropdownParent: $('#insertdata')
                });
                
                $('#proviso').select2({
                    dropdownParent: $('#insertdata')
                });
                $('#depsubsubid').select2({
                    dropdownParent: $('#insertdata')
                });
                
                $('#adminid').select2({
                    dropdownParent: $('#insertdata')
                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#saveBtn').click(function() {
                    var plan_strategic_id = $('#plan_strategic_id').val();
                    var plan_taget_id = $('#plan_taget_id').val();plan_taget_id
                    var plan_kpi_code = $('#plan_kpi_code').val();
                    var plan_kpi_name = $('#plan_kpi_name').val(); 
                    var leave_year_id = $('#leave_year_id').val(); 
                    $.ajax({
                        url: "{{ route('p.plan_kpi_save') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            plan_strategic_id,
                            plan_taget_id,
                            plan_kpi_code,
                            plan_kpi_name,
                            leave_year_id
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
                    var editplan_kpi_code = $('#editplan_kpi_code').val();
                    var editplan_kpi_name = $('#editplan_kpi_name').val(); 
                    var editleave_year_id = $('#editleave_year_id').val(); 
                    var editplan_kpi_id = $('#editplan_kpi_id').val(); 
                    $.ajax({
                        url: "{{ route('p.plan_kpi_update') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            editplan_strategic_id,
                            editplan_taget_id,
                            editplan_kpi_code,
                            editplan_kpi_name,
                            editleave_year_id,
                            editplan_kpi_id
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
