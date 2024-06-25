@extends('layouts.plannew')
@section('title','PK-OFFICER || Plan')
@section('content')
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
           border-top: 10px #1fdab1 solid;
           border-radius: 50%;
           animation: sp-anime 0.8s infinite linear;
           }
           @keyframes sp-anime {
           100% { 
               transform: rotate(390deg); 
           }
           }
           .is-hide{
           display:none;
           }
</style>
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
</script>
<?php
if (Auth::check()) {
        $type = Auth::user()->type;
        $iduser = Auth::user()->id;
        $iddep =  Auth::user()->dep_subsubtrueid;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;

    $datenow = date("Y-m-d");
    $y = date('Y') + 543;
    $newweek = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
    $newDate = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน 
    use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PlanController; 
$refnumber = PlanController::refnumber();
?>
   <div class="tabs-animation">
    <div class="row text-center">
        <div id="overlay">
            <div class="cv-spinner">
                <span class="spinner"></span>
            </div>
        </div> 
    </div> 
    <div id="preloader">
        <div id="status">
            <div class="spinner"> 
            </div>
        </div>
    </div>
    <div class="container-fluid"> 
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">เพิ่มทะเบียนควบคุมแผนงานโครงการ</h4>
    
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">เพิ่มทะเบียนควบคุมแผนงานโครงการ</a></li>
                            <li class="breadcrumb-item active">เพิ่มทะเบียน</li>
                        </ol>
                    </div>
    
                </div>
            </div>
        </div> 
    </div> 
        <div class="row">
            <div class="col-xl-12">
                <div class="card cardplan">   
                    {{-- <div class="card-header ">
                        เพิ่มทะเบียนควบคุมแผนงานโครงการ
                        <div class="btn-actions-pane-right">
                            <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Insertdata">
                                <i class="pe-7s-diskette btn-icon-wrapper"></i>Save 
                            </button>
                            <a href="{{ url('plan_control') }}" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger me-2">
                                <i class="fa-solid fa-xmark me-2"></i>
                                Back
                            </a>
                        </div>                        
                    </div>    --}}
                    <div class="card-body"> 
                        <div class="row"> 
                            <div class="col-md-12">
                                    <div class="card-header">  
                                        <h5 class="modal-title me-3" id="editModalLabel">เพิ่มทะเบียนควบคุม</h5>  
                                        <div class="btn-actions-pane-right">   
                                            <h6 class="mt-2 me-3"> เลขที่ {{$refnumber}}</h6>                                         
                                            <input type="hidden" id="billno" name="billno" value="{{$refnumber}}">
                                        </div>  
                                    </div>  

                                    <div class="card-body"> 
                                        <div class="row">
                                            <div class="col-md-9">
                                                <label for="">ชื่อโครงการ</label>
                                                <div class="form-group">
                                                <input id="plan_name" class="form-control form-control-sm" name="plan_name" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">รพ./รพ.สต./สสอ.</label>
                                                <div class="form-group">
                                                    <select name="hos_group" id="hos_group" class="form-control form-control-sm" style="width: 100%"> 
                                                        {{-- <option value="">-เลือก-</option> --}}
                                                        <option value="1">-รพ.สต-</option>
                                                        <option value="2">-สสอ.-</option>

                                                        {{-- <option value="3">-รพ.-</option> --}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-3 ">
                                                <label for="">ระยะเวลา วันที่</label>
                                                <div class="form-group"> 
                                                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                                        data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                        <input type="text" class="form-control" name="startdate" id="startdate" placeholder="Start Date"
                                                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                                            autocomplete="off" data-date-language="th-th" value="{{ $datenow }}" required />
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 ">
                                                <label for="">ถึง </label>
                                                <div class="form-group"> 
                                                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                                        data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                                       
                                                        <input type="text" class="form-control" name="enddate" placeholder="End Date" id="enddate"
                                                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                                            autocomplete="off" data-date-language="th-th" value="{{ $datenow }}" /> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 ">
                                                <label for="">งบประมาณ (ใส่เฉพาะตัวเลข)</label>
                                                <div class="form-group">
                                                    <input id="plan_price" class="form-control form-control-sm" name="plan_price" >
                                                </div>
                                            </div>
                                            <div class="col-md-3 ">
                                                <label for="">แหล่งงบ </label>
                                                <div class="form-group">
                                                    <select name="plan_type" id="plan_type" class="form-control form-control-sm" style="width: 100%"> 
                                                        @foreach ($plan_control_type as $item2)
                                                        @if ($id == $item2->plan_control_type_id)
                                                             <option value="{{$item2->plan_control_type_id}}" selected>{{$item2->plan_control_typename}}</option>
                                                        @else
                                                            <option value="{{$item2->plan_control_type_id}}">{{$item2->plan_control_typename}}</option>
                                                        @endif 
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                    
                                        </div>
                                        <div class="row mt-2 mb-3"> 
                                            <div class="col-md-6">
                                                <label for="">สอดคล้องกับยุทธศาสตร์ </label>
                                                <div class="form-group">
                                                    <select name="plan_strategic_id" id="plan_strategic_id" class="form-control form-control-sm" style="width: 100%"> 
                                                        @foreach ($plan_strategic as $itemy)
                                                        <option value="{{$itemy->plan_strategic_id}}">{{$itemy->plan_strategic_name}}</option> 
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 ">
                                                <label for="">กลุ่มงาน </label>
                                                <div class="form-group">
                                                    <select name="department" id="department" class="form-control form-control-sm" style="width: 100%">
                                                        @foreach ($department_sub as $item)
                                                        @if ($iddep == $item->DEPARTMENT_SUB_ID)
                                                        <option value="{{$item->DEPARTMENT_SUB_ID}}" selected>{{$item->DEPARTMENT_SUB_NAME}}</option>
                                                        @else
                                                        <option value="{{$item->DEPARTMENT_SUB_ID}}">{{$item->DEPARTMENT_SUB_NAME}}</option>
                                                        @endif
                                                            
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <input type="hidden" id="plan_control_id" name="plan_control_id">

                                            <div class="col-md-3 ">
                                                <label for="">ผู้รับผิดชอบ </label>
                                                <div class="form-group">
                                                    <select name="user_id" id="user_id" class="form-control form-control-sm" style="width: 100%"> 
                                                        @foreach ($users as $item3)
                                                       @if ( $iduser == $item3->id)
                                                       <option value="{{$item3->id}}" selected>{{$item3->fname}} {{$item3->lname}}</option>
                                                       @else
                                                       <option value="{{$item3->id}}">{{$item3->fname}} {{$item3->lname}}</option>
                                                       @endif 
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
 
                                    </div>

                                    <div class="card-footer mt-2">
                                        <div class="btn-actions-pane-right mt-2">
                                            <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Insertdata">
                                                <i class="pe-7s-diskette btn-icon-wrapper"></i>Save 
                                            </button>
                                            <a href="{{ url('plan_control_sub/'.$id) }}" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger me-2">
                                                <i class="fa-solid fa-xmark me-2"></i>
                                                Back
                                            </a>
                                        </div>
                                    </div>
                            </div>                           
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
              
                $('#startdate').datepicker({
                    format: 'yyyy-mm-dd'
                });
                $('#enddate').datepicker({
                    format: 'yyyy-mm-dd'
                });
              
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
 
            $("#spinner-div").hide(); //Request is complete so hide spinner
  

          
            $('#Insertdata').click(function() {
                    var plan_name              = $('#plan_name').val();
                    var datepicker1            = $('#startdate').val();
                    var datepicker2            = $('#enddate').val();
                    var plan_price             = $('#plan_price').val();
                    var department             = $('#department').val();
                    var plan_type              = $('#plan_type').val();
                    var user_id                = $('#user_id').val();
                    var billno                 = $('#billno').val();
                    var plan_strategic_id      = $('#plan_strategic_id').val();
                    var plan_control_id        = $('#plan_control_id').val();
                    var hos_group              = $('#hos_group').val();
                $.ajax({
                    url: "{{ route('p.plan_control_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        plan_name,datepicker1,datepicker2,plan_price,department,plan_type,user_id,billno,plan_control_id,plan_strategic_id,hos_group
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'เพิ่มข้อมูลสำเร็จ',
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
                                        window.location="{{url('plan_control_sub')}}"+'/'+ plan_control_id;
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
