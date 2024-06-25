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
           .checkboxs{
            width: 25px;
            height: 25px;
           }
</style>
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
    function plan_control_activity_destroy(plan_control_budget_id) {
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
                        url: "{{ url('plan_control_activity_destroy') }}" + '/' + plan_control_budget_id,
                        type: 'POST',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
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
                                    // $("#sid" + plan_control_budget_id).remove();
                                    window.location.reload();
                                    //   window.location = "/person/person_index"; //     
                                }
                            })
                        }
                    })
                }
            })
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
                    <h4 class="mb-sm-0">แผนงาน/กิจกรรมสำคัญ</h4>
    
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">แผนงาน/กิจกรรมสำคัญ</a></li>
                            <li class="breadcrumb-item active">เพิ่มกิจกรรมสำคัญ</li>
                        </ol>
                    </div>
    
                </div>
            </div>
        </div> 
    </div> 
        <div class="row">
            <div class="col-xl-12">
                <div class="card cardplan">    
                    <div class="card-body ">  
                        <div class="row">                          
                            <div class="col-md-12"> 
                                <form action="{{ route('p.plan_control_activity_update') }}" id="Update_data" method="POST">
                                    @csrf
                                    <div class="card-body"> 
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h4 class="card-title">แผนงาน/กิจกรรมสำคัญ</h4>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-2">
                                                <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                                    <i class="pe-7s-diskette btn-icon-wrapper"></i>Update 
                                                </button>
                                               
                                                <a href="{{ url('plan_control_activity/'.$id.'/'.$sid) }}" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger me-2">
                                                    <i class="fa-solid fa-xmark me-2"></i>
                                                    Back
                                                </a>
                                            </div>
                                        </div>
                                        <input type="hidden" id="id" name="id" value="{{$id}}">
                                        <input type="hidden" id="sid" name="sid" value="{{$sid}}">
                                         <!-- Nav tabs -->
                                         <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#detail" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-detail"></i></span>
                                                    <span class="d-none d-sm-block">รายละเอียด</span>    
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#trimart" role="tab">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">ไตรมาส</span>    
                                                </a>
                                            </li>
                                            {{-- <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab">
                                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                                    <span class="d-none d-sm-block">งบประมาณ</span>    
                                                </a>
                                            </li>                                            --}}
                                        </ul>
                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="detail" role="tabpanel">
                                                <p class="mb-0">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="">ชื่อแผนงาน/กิจกรรมสำคัญ</label>
                                                            <div class="form-group">
                                                            <input id="plan_control_activity_name" class="form-control form-control-sm" name="plan_control_activity_name" value="{{$data_activity->plan_control_activity_name}}">
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-md-7">
                                                            <label for="">กลุ่มเป้าหมาย</label>
                                                            <div class="form-group"> 
                                                               
                                                                <input id="plan_control_activity_group" class="form-control form-control-sm" name="plan_control_activity_group" value="{{$data_activity->plan_control_activity_group}}"> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">จำนวน</label>
                                                            <div class="form-group">
                                                            <input id="qty" class="form-control form-control-sm" name="qty" value="{{$data_activity->qty}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3"> 
                                                            <label for="">หน่วย</label>
                                                            <div class="form-group">
                                                                <select name="plan_control_unit" id="plan_control_unit" class="form-control form-control-sm" style="width: 100%"> 
                                                                    <option value="">-เลือก-</option>
                                                                    @foreach ($plan_unit as $item_u)
                                                                    @if ($data_activity->plan_control_unit == $item_u->plan_unit_id)
                                                                    <option value="{{$item_u->plan_unit_id}}" selected>{{$item_u->plan_unit_name}}</option>
                                                                    @else
                                                                    <option value="{{$item_u->plan_unit_id}}">{{$item_u->plan_unit_name}}</option>
                                                                    @endif                                       
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                       
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">ผู้รับผิดชอบ </label>
                                                            <div class="form-group">
                                                                <select name="responsible_person" id="responsible_person" class="form-control form-control-sm" style="width: 100%">   
                                                                    <option value="">-เลือก-</option>                                                 
                                                                    @foreach ($department_sub as $item)
                                                                    @if ($data_activity->responsible_person == $item->DEPARTMENT_SUB_ID)
                                                                    <option value="{{$item->DEPARTMENT_SUB_ID}}" selected>{{$item->DEPARTMENT_SUB_NAME}}</option>
                                                                    @else
                                                                    <option value="{{$item->DEPARTMENT_SUB_ID}}">{{$item->DEPARTMENT_SUB_NAME}}</option>
                                                                    @endif
                                                                        
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">แหล่งงบประมาณ </label>
                                                            <div class="form-group">
                                                                <select name="budget_source" id="budget_source" class="form-control form-control-sm" style="width: 100%"> 
                                                                    <option value="">-เลือก-</option>
                                                                    @foreach ($plan_control_type as $item2)
                                                                    @if ($data_activity->budget_source == $item2->plan_control_type_id)
                                                                    <option value="{{$item2->plan_control_type_id}}" selected>{{$item2->plan_control_typename}}</option>
                                                                    @else
                                                                    <option value="{{$item2->plan_control_type_id}}">{{$item2->plan_control_typename}}</option>
                                                                    @endif                                                                   
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>   
                                                    </div> 
                                                </p>
                                            </div>
                                            <div class="tab-pane" id="trimart" role="tabpanel">
                                                <p class="mb-0">
                                                    <div class="row mt-2">   
                                                        <div class="col-md-6">
                                                            <label for="">ไตรมาสที่ 1 </label>
                                                            <div class="form-group">
                                                            
                                                                <div class="form-check form-check-inline"> 
                                                                    @if ($data_activity->trimart_11 == 'on')
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_11" name="trimart_11" checked/>
                                                                    @else
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_11" name="trimart_11"/>
                                                                    @endif
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_11">ต.ค.</label> 
                                                                </div> 
                                                                <div class="form-check form-check-inline"> 
                                                                    @if ($data_activity->trimart_12 == 'on')
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_12" name="trimart_12" checked/>
                                                                    @else
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_12" name="trimart_12"/>
                                                                    @endif
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_12">พ.ย.</label>
                                                                </div> 
                                                                <div class="form-check form-check-inline"> 
                                                                    @if ($data_activity->trimart_13 == 'on')
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_13" name="trimart_13" checked/>
                                                                    @else
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_13" name="trimart_13"/>
                                                                    @endif
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_13">ธ.ค.</label>
                                                                </div> 
                                                            </div>
                                                        </div>  
                                                        <div class="col-md-6">
                                                            <label for="">ไตรมาสที่ 2 </label>
                                                            <div class="form-group">
                                                                <div class="form-check form-check-inline"> 
                                                                    @if ($data_activity->trimart_21 == 'on')
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_21" name="trimart_21" checked/>
                                                                    @else
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_21" name="trimart_21"/>
                                                                    @endif
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_21">ม.ค.</label>
                                                                </div>
                                                                <div class="form-check form-check-inline"> 
                                                                    @if ($data_activity->trimart_22 == 'on')
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_22" name="trimart_22" checked/>
                                                                    @else
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_22" name="trimart_22"/>
                                                                    @endif
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_22">ก.พ.</label>
                                                                </div> 
                                                                <div class="form-check form-check-inline"> 
                                                                    @if ($data_activity->trimart_23 == 'on')
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_23" name="trimart_23" checked/>
                                                                    @else
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_23" name="trimart_23"/>
                                                                    @endif
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_23">มี.ค.</label>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <hr>
                                                    <div class="row mt-2"> 
                                                        <div class="col-md-6">
                                                            <label for="">ไตรมาสที่ 3 </label>
                                                            <div class="form-group">
                                                                <div class="form-check form-check-inline"> 
                                                                    @if ($data_activity->trimart_31 == 'on')
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_31" name="trimart_31" checked/>
                                                                    @else
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_31" name="trimart_31"/>
                                                                    @endif
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_31">เม.ย.</label>
                                                                </div>
                                                                <div class="form-check form-check-inline"> 
                                                                    @if ($data_activity->trimart_32 == 'on')
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_32" name="trimart_32" checked/>
                                                                    @else
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_32" name="trimart_32"/>
                                                                    @endif
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_32">พ.ค.</label>
                                                                </div> 
                                                                <div class="form-check form-check-inline"> 
                                                                    @if ($data_activity->trimart_33 == 'on')
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_33" name="trimart_33" checked/>
                                                                    @else
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_33" name="trimart_33"/>
                                                                    @endif
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_33">มิ.ย.</label>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">ไตรมาสที่ 4 </label>
                                                            <div class="form-group">
                                                                <div class="form-check form-check-inline"> 
                                                                    @if ($data_activity->trimart_41 == 'on')
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_41" name="trimart_41" checked/>
                                                                    @else
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_41" name="trimart_41"/>
                                                                    @endif
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_41">ก.ค.</label>
                                                                </div>
                                                                <div class="form-check form-check-inline"> 
                                                                    @if ($data_activity->trimart_42 == 'on')
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_42" name="trimart_42" checked/>
                                                                    @else
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_42" name="trimart_42"/>
                                                                    @endif
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_42">ส.ค.</label>
                                                                </div> 
                                                                <div class="form-check form-check-inline"> 
                                                                    @if ($data_activity->trimart_43 == 'on')
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_43" name="trimart_43" checked/>
                                                                    @else
                                                                    <input class="form-check-input checkboxs" type="checkbox" id="trimart_43" name="trimart_43"/>
                                                                    @endif
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_43">ก.ย.</label>
                                                                </div> 
                                                            </div>
                                                        </div>  
                                                    </div> 
                                                </p>
                                            </div>
                                            {{-- <div class="tab-pane" id="messages" role="tabpanel">
                                                <p class="mb-0">
                                                  
                                                    <div class="row mt-2">
                                                        <div class="col-md-4">
                                                            <label for="">รายละเอียดงบประมาณ</label>
                                                            <div class="form-group">  
                                                                <select name="plan_list_budget_id" id="plan_list_budget_id" class="form-control form-control-sm" style="width: 100%"> 
                                                                    <option value="">-เลือก-</option>
                                                                    @foreach ($plan_list_budget as $item_list)
                                                                    <option value="{{$item_list->plan_list_budget_id}}">{{$item_list->plan_list_budget_name}}</option>
                                                                    @endforeach
                                                                </select> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="">ถ้าไม่มีรายละเอียดงบประมาณให้เพิ่ม</label>
                                                            <div class="form-group"> 
                                                                <input id="PLAN_LIST" class="form-control form-control-sm" name="PLAN_LIST">
                                                            </div>
                                                        </div>  
                                                        <div class="col-md-1"> 
                                                            <br>
                                                            <div class="form-group mt-2"> 
                                                                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Adddata_Sub">
                                                                    <i class="fa-solid fa-plus me-2"></i>เพิ่ม 
                                                                </button>
                                                            </div>
                                                        </div>   
                                                        <div class="col-md-2">
                                                            <label for="">บาท</label>
                                                            <div class="form-group"> 
                                                                <input id="plan_control_budget_price_new" class="form-control form-control-sm" name="plan_control_budget_price_new">
                                                            </div>
                                                        </div>  
                                                        <div class="col-md-2"> 
                                                            <br>
                                                            <div class="form-group mt-2"> 
                                                                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Insertdata_Sub">
                                                                    <i class="pe-7s-diskette btn-icon-wrapper me-2"></i>Save 
                                                                </button>
                                                            </div>
                                                        </div>        
                                                    </div>
                                             
                                                    <div class="row mt-3">
                                                        <div class="col-md-12">
                                                            <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
                                                                <tr>
                                                                    <thead>
                                                                        <th class="text-center">รายละเอียดงบประมาณ</th>
                                                                        <th class="text-center">จำนวนเงิน</th>
                                                                    </thead>
                                                                </tr>
                                                              <tbody>
                                                                @foreach ($plan_control_budget as $item_su)
                                                                <tr>
                                                                    <td class="text-start" >{{$item_su->plan_list_budget_name}}</td>
                                                                    <td class="text-center" width="20%">{{$item_su->plan_control_budget_price}}</td>
                                                                </tr>
                                                                @endforeach
                                                                
                                                              </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </p>
                                            </div> --}}
                                          
                                        </div>

                                        {{-- <div class="row">
                                            <div class="col-md-8 ">
                                                <label for="">ชื่อแผนงาน/กิจกรรมสำคัญ</label>
                                                <div class="form-group">
                                                <input id="plan_control_activity_name" class="form-control form-control-sm" name="plan_control_activity_name" value="{{$data_activity->plan_control_activity_name}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3 ">
                                                <label for="">กลุ่มเป้าหมาย</label>
                                                <div class="form-group"> 
                                                    <input id="plan_control_activity_group" class="form-control form-control-sm" name="plan_control_activity_group" value="{{$data_activity->plan_control_activity_group}}">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <label for="">จำนวน(คน) </label>
                                                <div class="form-group"> 
                                                    <input id="qty" class="form-control form-control-sm" name="qty" value="{{$data_activity->qty}}">
                                                </div>
                                            </div>
                                        </div> --}}
                                        {{-- <div class="row mt-2">
                                            <div class="col-md-8 ">
                                                <label for="">รายละเอียดงบประมาณ</label>
                                                <div class="form-group"> 
                                                    <input id="budget_detail" class="form-control form-control-sm" name="budget_detail" value="{{$data_activity->budget_detail}}">
                                                </div>
                                            </div>
                                            <div class="col-md-1 ">
                                                <label for="">บาท</label>
                                                <div class="form-group"> 
                                                    <input id="budget_price" class="form-control form-control-sm" name="budget_price" value="{{$data_activity->budget_price}}">
                                                </div>
                                            </div>                                            
                                            <div class="col-md-3 ">
                                                <label for="">แหล่งงบประมาณ </label>
                                                <div class="form-group">
                                                    <select name="budget_source" id="budget_source" class="form-control form-control-sm" style="width: 100%"> 
                                                        <option value="">-เลือก-</option>
                                                        @foreach ($plan_control_type as $item2)
                                                        @if ($data_activity->budget_source == $item2->plan_control_type_id)
                                                        <option value="{{$item2->plan_control_type_id}}" selected>{{$item2->plan_control_typename}}</option>
                                                        @else
                                                        <option value="{{$item2->plan_control_type_id}}">{{$item2->plan_control_typename}}</option>
                                                        @endif
                                                       
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>                    
                                        </div> --}}
                                        {{-- <div class="row mt-2">   --}}
                                           
                                            {{-- <div class="col-md-2">
                                                <label for="">ไตรมาสที่ 1 </label>
                                                <div class="form-group">
                                                    <div class="form-check form-check-inline"> 
                                                        @if ($data_activity->trimart_11 == 'on')
                                                        <input class="form-check-input" type="checkbox" id="trimart_11" name="trimart_11" checked/>
                                                        @else
                                                        <input class="form-check-input" type="checkbox" id="trimart_11" name="trimart_11"/>
                                                        @endif
                                                        <label class="form-check-label" for="trimart_11">ต.ค.</label> 
                                                    </div> 
                                                    <div class="form-check form-check-inline"> 
                                                        @if ($data_activity->trimart_12 == 'on')
                                                        <input class="form-check-input" type="checkbox" id="trimart_12" name="trimart_12" checked/>
                                                        @else
                                                        <input class="form-check-input" type="checkbox" id="trimart_12" name="trimart_12"/>
                                                        @endif
                                                        <label class="form-check-label" for="trimart_12">พ.ย.</label>
                                                    </div> 
                                                    <div class="form-check form-check-inline"> 
                                                        @if ($data_activity->trimart_13 == 'on')
                                                        <input class="form-check-input" type="checkbox" id="trimart_13" name="trimart_13" checked/>
                                                        @else
                                                        <input class="form-check-input" type="checkbox" id="trimart_13" name="trimart_13"/>
                                                        @endif
                                                        <label class="form-check-label" for="trimart_13">ธ.ค.</label>
                                                    </div> 
                                                </div>
                                            </div>  
                                            <div class="col-md-2">
                                                <label for="">ไตรมาสที่ 2 </label>
                                                <div class="form-group">
                                                    <div class="form-check form-check-inline"> 
                                                        @if ($data_activity->trimart_21 == 'on')
                                                        <input class="form-check-input" type="checkbox" id="trimart_21" name="trimart_21" checked/>
                                                        @else
                                                        <input class="form-check-input" type="checkbox" id="trimart_21" name="trimart_21"/>
                                                        @endif
                                                        <label class="form-check-label" for="trimart_21">ม.ค.</label>
                                                    </div>
                                                    <div class="form-check form-check-inline"> 
                                                        @if ($data_activity->trimart_22 == 'on')
                                                        <input class="form-check-input" type="checkbox" id="trimart_22" name="trimart_22" checked/>
                                                        @else
                                                        <input class="form-check-input" type="checkbox" id="trimart_22" name="trimart_22"/>
                                                        @endif
                                                        <label class="form-check-label" for="trimart_22">ก.พ.</label>
                                                    </div> 
                                                    <div class="form-check form-check-inline"> 
                                                        @if ($data_activity->trimart_23 == 'on')
                                                        <input class="form-check-input" type="checkbox" id="trimart_23" name="trimart_23" checked/>
                                                        @else
                                                        <input class="form-check-input" type="checkbox" id="trimart_23" name="trimart_23"/>
                                                        @endif
                                                        <label class="form-check-label" for="trimart_23">มี.ค.</label>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">ไตรมาสที่ 3 </label>
                                                <div class="form-group">
                                                    <div class="form-check form-check-inline"> 
                                                        @if ($data_activity->trimart_31 == 'on')
                                                        <input class="form-check-input" type="checkbox" id="trimart_31" name="trimart_31" checked/>
                                                        @else
                                                        <input class="form-check-input" type="checkbox" id="trimart_31" name="trimart_31"/>
                                                        @endif
                                                        <label class="form-check-label" for="trimart_31">เม.ย.</label>
                                                    </div>
                                                    <div class="form-check form-check-inline"> 
                                                        @if ($data_activity->trimart_32 == 'on')
                                                        <input class="form-check-input" type="checkbox" id="trimart_32" name="trimart_32" checked/>
                                                        @else
                                                        <input class="form-check-input" type="checkbox" id="trimart_32" name="trimart_32"/>
                                                        @endif
                                                        <label class="form-check-label" for="trimart_32">พ.ค.</label>
                                                    </div> 
                                                    <div class="form-check form-check-inline"> 
                                                        @if ($data_activity->trimart_33 == 'on')
                                                        <input class="form-check-input" type="checkbox" id="trimart_33" name="trimart_33" checked/>
                                                        @else
                                                        <input class="form-check-input" type="checkbox" id="trimart_33" name="trimart_33"/>
                                                        @endif
                                                        <label class="form-check-label" for="trimart_33">มิ.ย.</label>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">ไตรมาสที่ 4 </label>
                                                <div class="form-group">
                                                    <div class="form-check form-check-inline"> 
                                                        @if ($data_activity->trimart_41 == 'on')
                                                        <input class="form-check-input" type="checkbox" id="trimart_41" name="trimart_41" checked/>
                                                        @else
                                                        <input class="form-check-input" type="checkbox" id="trimart_41" name="trimart_41"/>
                                                        @endif
                                                        <label class="form-check-label" for="trimart_41">ก.ค.</label>
                                                    </div>
                                                    <div class="form-check form-check-inline"> 
                                                        @if ($data_activity->trimart_42 == 'on')
                                                        <input class="form-check-input" type="checkbox" id="trimart_42" name="trimart_42" checked/>
                                                        @else
                                                        <input class="form-check-input" type="checkbox" id="trimart_42" name="trimart_42"/>
                                                        @endif
                                                        <label class="form-check-label" for="trimart_42">ส.ค.</label>
                                                    </div> 
                                                    <div class="form-check form-check-inline"> 
                                                        @if ($data_activity->trimart_43 == 'on')
                                                        <input class="form-check-input" type="checkbox" id="trimart_43" name="trimart_43" checked/>
                                                        @else
                                                        <input class="form-check-input" type="checkbox" id="trimart_43" name="trimart_43"/>
                                                        @endif
                                                        <label class="form-check-label" for="trimart_43">ก.ย.</label>
                                                    </div> 
                                                </div>
                                            </div>  --}}
                                             
                                            {{-- <div class="col-md-4">
                                                <label for="">ผู้รับผิดชอบ </label>
                                                <div class="form-group">
                                                    <select name="responsible_person" id="responsible_person" class="form-control form-control-sm" style="width: 100%"> 
                                                        <option value="">-เลือก-</option>                                                   
                                                        @foreach ($department_sub as $item)
                                                        @if ($data_activity->responsible_person == $item->DEPARTMENT_SUB_ID)
                                                        <option value="{{$item->DEPARTMENT_SUB_ID}}" selected>{{$item->DEPARTMENT_SUB_NAME}}</option>
                                                        @else
                                                        <option value="{{$item->DEPARTMENT_SUB_ID}}">{{$item->DEPARTMENT_SUB_NAME}}</option>
                                                        @endif
                                                            
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div> --}}

                                            <input type="hidden" id="plan_control_activity_id" class="form-control form-control-sm" name="plan_control_activity_id" value="{{$data_activity->plan_control_activity_id}}">
                                            <input type="hidden" id="plan_control_id" name="plan_control_id" value="{{$data_plan_control->plan_control_id}}">
                                            <input type="hidden" id="billno" name="billno" value="{{$data_plan_control->billno}}">
                                        {{-- </div> 
                                    </div> --}}
                                    {{-- <div class="card-footer mt-2">
                                        <div class="btn-actions-pane-right mt-2"> 
                                            <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                                <i class="pe-7s-diskette btn-icon-wrapper"></i>Update 
                                            </button>
                                           
                                            <a href="{{ url('plan_control_activity/'.$id.'/'.$sid) }}" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger me-2">
                                                <i class="fa-solid fa-xmark me-2"></i>
                                                Back
                                            </a>
                                        </div>
                                    </div>                                --}}
                            </div>                              
                        </div>                
                    </div>                                
                </div>
            </div>
        </div>  
    </form>
        <div class="row">
            <div class="col-xl-12">
                <div class="card cardplan">  
                                 
                    <div class="card-body">  

                        <div class="row">
                            <div class="col-md-8 text-start"> <h5 class="modal-title me-3" id="editModalLabel">แผนงาน/กิจกรรมสำคัญ   <a href="{{url('plan_control_activity/'.$id.'/'.$sid)}}"> {{$data_plan_control->plan_name}}</a></h5>  </div>
                            <div class="col"></div>
                            <div class="col-md-2 text-end"> <h6 class="mt-2 me-3"> เลขที่ {{$data_plan_control->billno}}</h6> </div>
                        </div> 
                        
                        <div class="table-responsive"> 
                            <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
                                <thead >
                                    <tr style="font-size: 13px;background-color: rgb(255, 231, 226);border-color: rgb(183, 180, 180)">
                                        <th rowspan="3" colspan="1" class="text-center" width="4%" style="border-color: rgb(183, 180, 180)">ลำดับ</th>
                                        <th rowspan="3" colspan="1" class="text-center" style="border-color: rgb(183, 180, 180)"> แผนงาน/กิจกรรมสำคัญ</th> 
                                        <th rowspan="3" colspan="1" class="text-center" style="border-color: rgb(183, 180, 180)">กลุ่มเป้าหมาย</th> 
                                        <th rowspan="3" colspan="1" class="text-center" width="4%" style="border-color: rgb(183, 180, 180)">จำนวน<br>(คน) </th> 
                                        <th colspan="12" class="text-center" style="border-color: rgb(183, 180, 180)">เป้าหมายการดำเนินงาน (1ต.ค.66 - 30 ก.ย.67)</th>  
                                        <th colspan="2" rowspan="2" style="text-align: center;">งบประมาณ</th>  
                                    </tr>
                                    <tr style="font-size: 13px;background-color: rgb(255, 231, 226);border-color: rgb(183, 180, 180)">
                                        <td colspan="3" style="text-align: center;border-color: rgb(183, 180, 180)">ไตรมาสที่ 1</td>
                                        <td colspan="3" style="text-align: center;border-color: rgb(183, 180, 180)">ไตรมาสที่ 2</td>
                                        <td colspan="3" style="text-align: center;border-color: rgb(183, 180, 180)">ไตรมาสที่ 3</td>       
                                        <td colspan="3" style="text-align: center;border-color: rgb(183, 180, 180)">ไตรมาสที่ 4</td>    
                                    </tr>
                                    <tr style="font-size: 13px;background-color: rgb(255, 231, 226);border-color: rgb(183, 180, 180)">
                                        <td style="text-align: center;border-color: rgb(183, 180, 180)"">ต.ค</td>
                                        <td style="text-align: center;border-color: rgb(183, 180, 180)"">พ.ย.</td>
                                        <td style="text-align: center;border-color: rgb(183, 180, 180)"">ธ.ค.</td>                                          
                                        <td style="text-align: center;border-color: rgb(183, 180, 180)"">ม.ค.</td>
                                        <td style="text-align: center;border-color: rgb(183, 180, 180)"">ก.พ.</td>
                                        <td style="text-align: center;border-color: rgb(183, 180, 180)"">มี.ค.</td>                                         
                                        <td style="text-align: center;border-color: rgb(183, 180, 180)"">เม.ย.</td>
                                        <td style="text-align: center;border-color: rgb(183, 180, 180)"">พ.ค.</td>
                                        <td style="text-align: center;border-color: rgb(183, 180, 180)"">มิ.ย.</td>                                          
                                        <td style="text-align: center;border-color: rgb(183, 180, 180)"">ก.ค.</td>
                                        <td style="text-align: center;border-color: rgb(183, 180, 180)"">ส.ค.</td>
                                        <td style="text-align: center;border-color: rgb(183, 180, 180)"">ก.ย.</td>  
                                
                                        <td style="text-align: center;border-color: rgb(183, 180, 180)"">รายละเอียด</td>
                                        <td style="text-align: center;border-color: rgb(183, 180, 180)"">บาท</td> 
                                    </tr> 
                                </thead>
                                <tbody style="font-size: 13px;border-color: rgb(183, 180, 180)">
                                    <?php $i = 1; ?>
                                    @foreach ($plan_control_activity as $item_)                                                        
                                    
                                    <tr id="sid{{ $item_->plan_control_activity_id }}">
                                            <td class="text-center" width="4%">{{ $i++ }}</td>
                                            <td class="text-start" >
                                                <a href="{{url('plan_control_activity_edit/'.$id.'/'.$data_plan_control->plan_control_id.'/'.$item_->plan_control_activity_id)}}">
                                                    {{ $item_->plan_control_activity_name }}
                                                </a>
                                            </td>
                                            <td class="text-start" width="10%">{{ $item_->plan_control_activity_group }}</td>
                                            <td class="text-center" width="3%">{{ $item_->qty }}</td>
                                            <td class="text-center" width="2%">
                                                @if ($item_->trimart_11 == 'on')
                                                    <img src="{{ asset('images/true.png') }}" height="30px" width="30px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                                @else 
                                                @endif 
                                            </td>
                                            <td class="text-center" width="2%">
                                                @if ($item_->trimart_12 == 'on')
                                                    <img src="{{ asset('images/true.png') }}" height="30px" width="30px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                                @else 
                                                @endif 
                                            </td>
                                            <td class="text-center" width="2%">
                                                @if ($item_->trimart_13 == 'on')
                                                    <img src="{{ asset('images/true.png') }}" height="30px" width="30px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                                @else 
                                                @endif
                                            </td>
                                            <td class="text-center" width="2%">
                                                @if ($item_->trimart_21 == 'on')
                                                    <img src="{{ asset('images/true.png') }}" height="30px" width="30px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                                @else 
                                                @endif
                                            </td>
                                            <td class="text-center" width="2%">
                                                @if ($item_->trimart_22 == 'on')
                                                    <img src="{{ asset('images/true.png') }}" height="30px" width="30px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                                @else 
                                                @endif
                                            </td>
                                        
                                            <td class="text-center" width="2%">
                                                @if ($item_->trimart_23 == 'on')
                                                    <img src="{{ asset('images/true.png') }}" height="30px" width="30px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                                @else 
                                                @endif
                                            </td>
                                            <td class="text-center" width="2%">
                                                @if ($item_->trimart_31 == 'on')
                                                    <img src="{{ asset('images/true.png') }}" height="30px" width="30px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                                @else 
                                                @endif
                                            </td>
                                            <td class="text-center" width="2%">
                                                @if ($item_->trimart_32 == 'on')
                                                    <img src="{{ asset('images/true.png') }}" height="30px" width="30px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                                @else 
                                                @endif
                                            </td>
                                            <td class="text-center" width="2%">
                                                @if ($item_->trimart_33 == 'on')
                                                    <img src="{{ asset('images/true.png') }}" height="30px" width="30px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                                @else 
                                                @endif
                                            </td>
                                            <td class="text-center" width="2%">
                                                @if ($item_->trimart_41 == 'on')
                                                <img src="{{ asset('images/true.png') }}" height="30px" width="30px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                                @else 
                                                @endif
                                            </td>
                                            <td class="text-center" width="2%">
                                                @if ($item_->trimart_42 == 'on')
                                                <img src="{{ asset('images/true.png') }}" height="30px" width="30px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                                @else 
                                                @endif
                                            </td>
                                            <td class="text-center" width="2%">
                                                @if ($item_->trimart_43 == 'on')
                                                <img src="{{ asset('images/true.png') }}" height="30px" width="30px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                                @else 
                                                @endif
                                            </td>
                                                <?php 
                                                    $datasub = DB::select('
                                                        SELECT * FROM plan_control_budget WHERE plan_control_activity_id = "'.$item_->plan_control_activity_id.'" 
                                                    ');  
                                                ?>                                              
                                            <td class="text-start" width="15%">
                                                <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary edit_data" value="{{ $item_->plan_control_activity_id }}">
                                                    <i class="pe-7s-plus btn-icon-wrapper"></i>
                                                </button> 
                                                <br>
                                                @foreach ($datasub as $item_sub) 
                                                    <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="plan_control_activity_destroy({{ $item_sub->plan_control_budget_id }})" style="font-size:13px">
                                                        <span> - {{$item_sub->plan_list_budget_name}} / {{$item_sub->plan_control_budget_price}}</span>
                                                    <i class="fa-solid fa-trash-can ms-2 me-2 text-danger" style="font-size:13px"></i>
                                                    </a>
                                                    <br>
                                                @endforeach                                                
                                            </td>                                           
                                            <td class="text-end" width="4%" style="color:rgb(216, 95, 14)">{{ number_format($item_->budget_price, 2) }}</td>
                                        </tr>

                                        {{-- <div class="modal fade" id="DetailModal{{ $item_->plan_control_activity_id }}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg"> 
                                                <div class="modal-content">
                                                    <div class="modal-header">                                                        
                                                        <div class="row">
                                                            <div class="col-md-12 text-start"><h2>รายละเอียดในการเบิกงบประมาณ</h2> </div>
                                                            
                                                        </div>                                                    
                                                    </div>
                                                    <input id="plan_control_money_no" class="form-control form-control-sm" name="plan_control_money_no" type="hidden" >
                                                    <input id="update_plan_control_id" class="form-control form-control-sm" name="update_plan_control_id" type="hidden" >
                                                    <div class="modal-body">
                                                        <div class="row mt-2">
                                                            <div class="col-md-8 ">
                                                                <label for="">รายละเอียดงบประมาณ</label>
                                                                <div class="form-group"> 
                                                                    <select name="plan_list_budget_id" id="plan_list_budget_id" class="form-control form-control-sm" style="width: 100%"> 
                                                                        <option value="">-เลือก-</option>
                                                                        @foreach ($plan_list_budget as $item_list)
                                                                        <option value="{{$item_list->plan_list_budget_id}}">{{$item_list->plan_list_budget_name}}</option>
                                                                        @endforeach
                                                                    </select> 
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="">บาท</label>
                                                                <div class="form-group"> 
                                                                    <input id="budget_price" class="form-control form-control-sm" name="budget_price">
                                                                </div>
                                                            </div>          
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="col-md-12 text-end">
                                                            <div class="form-group">
                                                                <button type="button" id="SaveMoneyBtn"
                                                                    class="btn-icon btn-shadow btn-dashed btn btn-outline-info me-2"> 
                                                                    <i class="pe-7s-diskette btn-icon-wrapper me-2"></i>
                                                                    Save
                                                                </button>
                                                                <button type="button"
                                                                    class="btn-icon btn-shadow btn-dashed btn btn-outline-danger"
                                                                    data-bs-dismiss="modal"><i
                                                                        class="fa-solid fa-xmark me-2"></i>Close</button> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>                                                    
                                            </div>
                                        </div> --}}
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                            
                    </div>   
                </div>
            </div>
        </div>  
                    
    </div> 

    <div class="modal fade" id="DetailModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> 
            <div class="modal-content">
                <div class="modal-header">                                                        
                    <div class="row">
                        <div class="col-md-12 text-start"><h2>รายละเอียดในการเบิกงบประมาณ</h2> </div>                        
                    </div>                                                    
                </div>

                <input id="edit_plan_control_activity_id" class="form-control form-control-sm" name="edit_plan_control_activity_id" type="hidden" >
                <input id="edit_plan_control_id" class="form-control form-control-sm" name="edit_plan_control_id" type="hidden" >
                 
                
                <div class="modal-body">
                    <div class="row mt-2">
                        <div class="col-md-8 ">
                            <label for="">รายละเอียดงบประมาณ</label>
                            <div class="form-group"> 
                                <select name="plan_list_budget_id" id="plan_list_budget_id" class="form-control form-control-sm" style="width: 100%"> 
                                    <option value="">-เลือก-</option>
                                    @foreach ($plan_list_budget as $item_list)
                                    <option value="{{$item_list->plan_list_budget_id}}">{{$item_list->plan_list_budget_name}}</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">จำนวนเงิน(บาท)</label>
                            <div class="form-group"> 
                                <input id="plan_control_budget_price" class="form-control form-control-sm" name="plan_control_budget_price">
                            </div>
                        </div>          
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="button" id="SaveDetailBtn"
                                class="btn-icon btn-shadow btn-dashed btn btn-outline-info me-2"> 
                                <i class="pe-7s-diskette btn-icon-wrapper me-2"></i>
                                Save
                            </button>
                            <button type="button"
                                class="btn-icon btn-shadow btn-dashed btn btn-outline-danger"
                                data-bs-dismiss="modal"><i
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
                // $('#plan_list_budget_id').select2({
                //     placeholder: "--เลือก--",
                //     allowClear: true
                // });
                $('#plan_list_budget_id').select2({
                    dropdownParent: $('#DetailModal')
                });
              
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
  
            $(document).on('click', '.edit_data', function() {
                var plan_control_activity_id = $(this).val();
                $('#DetailModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('plan_control_budget_edit') }}" + '/' + plan_control_activity_id,
                    success: function(data) {
                        $('#edit_plan_control_id').val(data.budget.plan_control_id) 
                        $('#edit_plan_control_activity_id').val(data.budget.plan_control_activity_id)
                    },
                });
            });

            $('#SaveDetailBtn').click(function() {
                    var plan_list_budget_id            = $('#plan_list_budget_id').val();
                    var plan_control_budget_price      = $('#plan_control_budget_price').val();        
                    var plan_control_activity_id       = $('#edit_plan_control_activity_id').val();
                    var plan_control_id                = $('#edit_plan_control_id').val();
                    var billno                         = $('#billno').val();
                    
                $.ajax({
                    url: "{{ route('p.plan_control_budget_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        plan_list_budget_id,plan_control_activity_id,billno,plan_control_id,plan_control_budget_price
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'เพิ่มรายละเอียดการใช้งบประมาณสำเร็จ',
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
                                        // window.location="{{url('plan_control')}}";
                                    window.location.reload();
                                }
                            })
                        } else {

                        }

                    },
                });
            });

            $('#Updatedata').click(function() {
                    var plan_control_activity_name       = $('#plan_control_activity_name').val();
                    var plan_control_activity_group      = $('#plan_control_activity_group').val();
                    var qty                              = $('#qty').val();
                    var budget_detail                    = $('#budget_detail').val();
                    var budget_price                     = $('#budget_price').val();
                    var budget_source                    = $('#budget_source').val();
                    var trimart_11                       = $('#trimart_11').val();
                    var trimart_12                       = $('#trimart_12').val();
                    var trimart_13                       = $('#trimart_13').val();
                    var trimart_21                       = $('#trimart_21').val();
                    var trimart_22                       = $('#trimart_22').val();
                    var trimart_23                       = $('#trimart_23').val();
                    var trimart_31                       = $('#trimart_31').val();
                    var trimart_32                       = $('#trimart_32').val();
                    var trimart_33                       = $('#trimart_33').val();
                    var trimart_41                       = $('#trimart_41').val();
                    var trimart_42                       = $('#trimart_42').val();
                    var trimart_43                       = $('#trimart_43').val();
                    var responsible_person               = $('#responsible_person').val();
                    var plan_control_id                  = $('#plan_control_id').val();
                    var billno                           = $('#billno').val();
                    var plan_control_activity_id         = $('#plan_control_activity_id').val();
                    
                $.ajax({
                    url: "{{ route('p.plan_control_activity_update') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        plan_control_activity_name,plan_control_activity_group,qty,budget_detail
                        ,budget_price,budget_source,trimart_11,trimart_12,trimart_13,trimart_21,trimart_22,trimart_23
                        ,trimart_31,trimart_32,trimart_33,trimart_41,trimart_42,trimart_43,responsible_person,plan_control_id,billno,plan_control_activity_id
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'แก้ไขแผนงาน/กิจกรรมสำคัญสำเร็จ',
                                text: "You Update data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                        // window.location="{{url('plan_control')}}";
                                    window.location.reload();
                                }
                            })
                        } else {

                        }

                    },
                });
            });

            $('#Update_data').on('submit',function(e){
                    e.preventDefault();            
                    var form = this; 
                    $.ajax({
                          url:$(form).attr('action'),
                          method:$(form).attr('method'),
                          data:new FormData(form),
                          processData:false,
                          dataType:'json',
                          contentType:false,
                          beforeSend:function(){
                            $(form).find('span.error-text').text('');
                          },
                          success:function(data){
                            if (data.status == 0 ) {
                              
                            } else {          
                              Swal.fire({
                                title: 'แก้ไขแผนงาน/กิจกรรมสำคัญสำเร็จ',
                                text: "You Update data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177', 
                                confirmButtonText: 'เรียบร้อย'
                              }).then((result) => {
                                if (result.isConfirmed) {                  
                                  window.location="{{url('plan_control')}}";
                                //   window.location.reload();
                                }
                              })      
                            }
                          }
                    });
            });

                              
            });
           
        </script>    
       
    @endsection
