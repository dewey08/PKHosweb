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
                                <form action="{{ route('p.plan_control_activity_save') }}" id="Insert_data" method="POST">
                                    @csrf
                                    <div class="card-body"> 

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="">ชื่อแผนงาน/กิจกรรมสำคัญ</label>
                                                        <div class="form-group">
                                                        <input id="plan_control_activity_name" class="form-control form-control-sm" name="plan_control_activity_name">
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="row mt-2">
                                                    <div class="col-md-7">
                                                        <label for="">กลุ่มเป้าหมาย</label>
                                                        <div class="form-group"> 
                                                            {{-- <select name="plan_control_activity_group" id="plan_control_activity_group" class="form-control form-control-sm" style="width: 100%"> 
                                                                <option value="">-เลือก-</option>
                                                            </select> --}}
                                                            <input id="plan_control_activity_group" class="form-control form-control-sm" name="plan_control_activity_group">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="">จำนวน</label>
                                                        <div class="form-group">
                                                        <input id="qty" class="form-control form-control-sm" name="qty">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3"> 
                                                        <label for="">หน่วย</label>
                                                        <div class="form-group">
                                                            <select name="plan_control_unit" id="plan_control_unit" class="form-control form-control-sm" style="width: 100%"> 
                                                                <option value="">-เลือก-</option>
                                                                @foreach ($plan_unit as $item_u)
                                                                {{-- @if ($plan_control->plan_control_unit == $item_u->plan_unit_id) --}}
                                                                {{-- <option value="{{$item_u->plan_unit_id}}" selected>{{$item_u->plan_unit_name}}</option> --}}
                                                                {{-- @else --}}
                                                                <option value="{{$item_u->plan_unit_id}}">{{$item_u->plan_unit_name}}</option>
                                                                {{-- @endif                                                        --}}
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-md-5">                                              
                                                        <br>
                                                        <div class="form-group mt-2">
                                                        <input id="plan_control_activity_group" class="form-control form-control-sm" name="plan_control_activity_group" placeholder="เพิ่มกลุ่มเป้าหมาย">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2"> 
                                                        <br>
                                                        <div class="form-group mt-2"> 
                                                            <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                                                <i class="fa-solid fa-plus me-2"></i>เพิ่ม 
                                                            </button>
                                                        </div>
                                                    </div> --}}
                                                </div> 
                                                {{-- <div class="row">
                                                    <div class="col-md-2">
                                                        <label for="">จำนวน</label>
                                                        <div class="form-group">
                                                        <input id="qty" class="form-control form-control-sm" name="qty">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3"> 
                                                        <label for="">หน่วย</label>
                                                        <div class="form-group">
                                                            <select name="plan_control_unit" id="plan_control_unit" class="form-control form-control-sm" style="width: 100%"> 
                                                                <option value="">-เลือก-</option>
                                                                @foreach ($plan_control_type as $item2)
                                                                @if ($plan_control->plan_type == $item2->plan_control_type_id)
                                                                <option value="{{$item2->plan_control_type_id}}" selected>{{$item2->plan_control_typename}}</option>
                                                                @else
                                                                <option value="{{$item2->plan_control_type_id}}">{{$item2->plan_control_typename}}</option>
                                                                @endif                                                       
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5"> 
                                                        <br>
                                                        <div class="form-group mt-2">
                                                        <input id="" class="form-control form-control-sm" name="" placeholder="เพิ่มหน่วยนับ">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2"> 
                                                        <br>
                                                        <div class="form-group mt-2"> 
                                                            <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                                                <i class="fa-solid fa-plus me-2"></i>เพิ่ม 
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>  --}}
                                                {{-- <hr> --}}
                                                <input type="hidden" id="plan_control_id" name="plan_control_id" value="{{$plan_control->plan_control_id}}">
                                                <input type="hidden" id="billno" name="billno" value="{{$plan_control->billno}}">
                                                
                                                <div class="row mt-2">
                                                    <div class="col-md-7">
                                                        <label for="">รายละเอียดงบประมาณ</label>
                                                        <div class="form-group">  
                                                            <select name="budget_detail" id="budget_detail" class="form-control form-control-sm" style="width: 100%"> 
                                                                <option value="">-เลือก-</option>
                                                                @foreach ($plan_list_budget as $item_list)
                                                                <option value="{{$item_list->plan_list_budget_id}}">{{$item_list->plan_list_budget_name}}</option>
                                                                @endforeach
                                                            </select> 
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-md-3"> 
                                                        <br>
                                                        <div class="form-group mt-2">
                                                        <input id="" class="form-control form-control-sm" name="" placeholder="เพิ่มรายละเอียดงบประมาณ">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2"> 
                                                        <br>
                                                        <div class="form-group mt-2"> 
                                                            <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                                                <i class="fa-solid fa-plus me-2"></i>เพิ่ม 
                                                            </button>
                                                        </div>
                                                    </div> --}}
                                                    <div class="col-md-2">
                                                        <label for="">บาท</label>
                                                        <div class="form-group"> 
                                                            <input id="budget_price" class="form-control form-control-sm" name="budget_price">
                                                        </div>
                                                    </div>  
                                                    <div class="col-md-2"> 
                                                        <br>
                                                        <div class="form-group mt-2"> 
                                                            <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                                                <i class="fa-solid fa-plus me-2"></i>เพิ่ม 
                                                            </button>
                                                        </div>
                                                    </div>        
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-12">
                                                        <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
                                                            <tr>
                                                                <thead>
                                                                    <th>รายละเอียดงบประมาณ</th>
                                                                    <th>จำนวนเงิน</th>
                                                                </thead>
                                                            </tr>
                                                          <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                          </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="row mt-2">   
                                                    <div class="col-md-6">
                                                        <label for="">ไตรมาสที่ 1 </label>
                                                        <div class="form-group">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" name="trimart_11" id="trimart_11" >
                                                                <label class="form-check-label" for="trimart_11">ต.ค.</label> 
                                                            </div> 
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" name="trimart_12" id="trimart_12">
                                                                <label class="form-check-label" for="trimart_12">พ.ย.</label>
                                                            </div> 
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" name="trimart_13" id="trimart_13">
                                                                <label class="form-check-label" for="trimart_13">ธ.ค.</label>
                                                            </div> 
                                                        </div>
                                                    </div>  
                                                    <div class="col-md-6">
                                                        <label for="">ไตรมาสที่ 2 </label>
                                                        <div class="form-group">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" name="trimart_21" id="trimart_21">
                                                                <label class="form-check-label" for="trimart_21">ม.ค.</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" name="trimart_22" id="trimart_22">
                                                                <label class="form-check-label" for="trimart_22">ก.พ.</label>
                                                            </div> 
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" name="trimart_23" id="trimart_23">
                                                                <label class="form-check-label" for="trimart_23">มี.ค.</label>
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
                                                                <input class="form-check-input" type="checkbox" name="trimart_31" id="trimart_31">
                                                                <label class="form-check-label" for="trimart_31">เม.ย.</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" name="trimart_32" id="trimart_32">
                                                                <label class="form-check-label" for="trimart_32">พ.ค.</label>
                                                            </div> 
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" name="trimart_33" id="trimart_33">
                                                                <label class="form-check-label" for="trimart_33">มิ.ย.</label>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="">ไตรมาสที่ 4 </label>
                                                        <div class="form-group">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" name="trimart_41" id="trimart_41">
                                                                <label class="form-check-label" for="trimart_41">ก.ค.</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" name="trimart_42" id="trimart_42">
                                                                <label class="form-check-label" for="trimart_42">ส.ค.</label>
                                                            </div> 
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" name="trimart_43" id="trimart_43">
                                                                <label class="form-check-label" for="trimart_43">ก.ย.</label>
                                                            </div> 
                                                        </div>
                                                    </div>  
                                                </div> 
                                                <hr>
                                                <div class="row mt-2">
                                                    <div class="col-md-12">
                                                        <label for="">ผู้รับผิดชอบ </label>
                                                        <div class="form-group">
                                                            <select name="responsible_person" id="responsible_person" class="form-control form-control-sm" style="width: 100%">   
                                                                <option value="">-เลือก-</option>                                                 
                                                                @foreach ($department_sub as $item)
                                                                @if ($plan_control->department == $item->DEPARTMENT_SUB_ID)
                                                                <option value="{{$item->DEPARTMENT_SUB_ID}}" selected>{{$item->DEPARTMENT_SUB_NAME}}</option>
                                                                @else
                                                                <option value="{{$item->DEPARTMENT_SUB_ID}}">{{$item->DEPARTMENT_SUB_NAME}}</option>
                                                                @endif
                                                                    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>   
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="">แหล่งงบประมาณ </label>
                                                        <div class="form-group">
                                                            <select name="budget_source" id="budget_source" class="form-control form-control-sm" style="width: 100%"> 
                                                                <option value="">-เลือก-</option>
                                                                @foreach ($plan_control_type as $item2)
                                                                @if ($plan_control->plan_type == $item2->plan_control_type_id)
                                                                <option value="{{$item2->plan_control_type_id}}" selected>{{$item2->plan_control_typename}}</option>
                                                                @else
                                                                <option value="{{$item2->plan_control_type_id}}">{{$item2->plan_control_typename}}</option>
                                                                @endif                                                       
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>   
                                                </div> 
                                            </div>
                                            {{-- <div class="col-md-3 ">
                                                <label for="">กลุ่มเป้าหมาย</label>
                                                <div class="form-group"> 
                                                    <input id="plan_control_activity_group" class="form-control form-control-sm" name="plan_control_activity_group">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <label for="">จำนวน(คน) </label>
                                                <div class="form-group"> 
                                                    <input id="qty" class="form-control form-control-sm" name="qty">
                                                </div>
                                            </div> --}}
                                        </div>
                                       
                                        <div class="row mt-2">   
                                            {{-- <div class="col-md-2">
                                                <label for="">ไตรมาสที่ 1 </label>
                                                <div class="form-group">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name="trimart_11" id="trimart_11" >
                                                        <label class="form-check-label" for="trimart_11">ต.ค.</label> 
                                                    </div> 
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name="trimart_12" id="trimart_12">
                                                        <label class="form-check-label" for="trimart_12">พ.ย.</label>
                                                    </div> 
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name="trimart_13" id="trimart_13">
                                                        <label class="form-check-label" for="trimart_13">ธ.ค.</label>
                                                    </div> 
                                                </div>
                                            </div>  
                                            <div class="col-md-2">
                                                <label for="">ไตรมาสที่ 2 </label>
                                                <div class="form-group">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name="trimart_21" id="trimart_21">
                                                        <label class="form-check-label" for="trimart_21">ม.ค.</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name="trimart_22" id="trimart_22">
                                                        <label class="form-check-label" for="trimart_22">ก.พ.</label>
                                                    </div> 
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name="trimart_23" id="trimart_23">
                                                        <label class="form-check-label" for="trimart_23">มี.ค.</label>
                                                    </div> 
                                                </div>
                                            </div> --}}
                                            {{-- <div class="col-md-2">
                                                <label for="">ไตรมาสที่ 3 </label>
                                                <div class="form-group">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name="trimart_31" id="trimart_31">
                                                        <label class="form-check-label" for="trimart_31">เม.ย.</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name="trimart_32" id="trimart_32">
                                                        <label class="form-check-label" for="trimart_32">พ.ค.</label>
                                                    </div> 
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name="trimart_33" id="trimart_33">
                                                        <label class="form-check-label" for="trimart_33">มิ.ย.</label>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">ไตรมาสที่ 4 </label>
                                                <div class="form-group">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name="trimart_41" id="trimart_41">
                                                        <label class="form-check-label" for="trimart_41">ก.ค.</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name="trimart_42" id="trimart_42">
                                                        <label class="form-check-label" for="trimart_42">ส.ค.</label>
                                                    </div> 
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name="trimart_43" id="trimart_43">
                                                        <label class="form-check-label" for="trimart_43">ก.ย.</label>
                                                    </div> 
                                                </div>
                                            </div>                                          --}}
                                            {{-- <div class="col-md-4">
                                                <label for="">ผู้รับผิดชอบ </label>
                                                <div class="form-group">
                                                    <select name="responsible_person" id="responsible_person" class="form-control form-control-sm" style="width: 100%">   
                                                        <option value="">-เลือก-</option>                                                 
                                                        @foreach ($department_sub as $item)
                                                        @if ($plan_control->department == $item->DEPARTMENT_SUB_ID)
                                                        <option value="{{$item->DEPARTMENT_SUB_ID}}" selected>{{$item->DEPARTMENT_SUB_NAME}}</option>
                                                        @else
                                                        <option value="{{$item->DEPARTMENT_SUB_ID}}">{{$item->DEPARTMENT_SUB_NAME}}</option>
                                                        @endif
                                                            
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div> --}}                                           
                                        </div> 

                                      

                                        

                                    </div>
                                    <div class="card-footer mt-2">
                                        <div class="btn-actions-pane-right mt-2">
                                            <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                                <i class="pe-7s-diskette btn-icon-wrapper"></i>Save 
                                            </button>
                                            {{-- <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Insertdata">
                                                <i class="pe-7s-diskette btn-icon-wrapper"></i>Save 
                                            </button> --}}
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
    </form>
        <div class="row">
            <div class="col-xl-12">
                <div class="card cardplan">  
                    <input type="hidden" id="billno" name="billno" value="{{$plan_control->billno}}">
                    {{--<div class="card-header">  
                        <h5 class="modal-title me-3" id="editModalLabel">แผนงาน/กิจกรรมสำคัญ  {{$plan_control->plan_name}}</h5>  
                        <div class="btn-actions-pane-right">   
                        <h6 class="mt-2 me-3"> เลขที่ {{$plan_control->billno}}</h6> 
                        <input type="hidden" id="billno" name="billno" value="{{$plan_control->billno}}">
                    </div>  
                    </div>--}}
                    <div class="card-body"> 
                        <div class="row">
                            <div class="col-md-8 text-start"> <h5 class="modal-title me-3" id="editModalLabel">แผนงาน/กิจกรรมสำคัญ  {{$plan_control->plan_name}}</h5>  </div>
                            <div class="col"></div>
                            <div class="col-md-2 text-end"> <h6 class="mt-2 me-3"> เลขที่ {{$plan_control->billno}}</h6> </div>
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
                                                <a href="{{url('plan_control_activity_edit/'.$id.'/'.$plan_control->plan_control_id.'/'.$item_->plan_control_activity_id)}}">
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
                                            <td class="text-center" width="12%">{{$item_->budget_detail}}</td>
                                            <td class="text-center" width="4%">{{$item_->budget_price}}</td>
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
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
                $.ajax({
                    url: "{{ route('p.plan_control_activity_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        plan_control_activity_name,plan_control_activity_group,qty,budget_detail
                        ,budget_price,budget_source,trimart_11,trimart_12,trimart_13,trimart_21,trimart_22,trimart_23
                        ,trimart_31,trimart_32,trimart_33,trimart_41,trimart_42,trimart_43,responsible_person,plan_control_id,billno
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'บันทึกแผนงาน/กิจกรรมสำคัญสำเร็จ',
                                text: "You Save data success",
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

            $('#Insert_data').on('submit',function(e){
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
                                title: 'เพิ่มแผนงาน/กิจกรรมสำคัญสำเร็จ',
                                text: "You Update data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177', 
                                confirmButtonText: 'เรียบร้อย'
                              }).then((result) => {
                                if (result.isConfirmed) {                  
                                  // window.location="{{url('plan_control')}}";
                                  window.location.reload();
                                }
                              })      
                            }
                          }
                    });
            });

                              
            });
           
        </script>    
       
    @endsection
