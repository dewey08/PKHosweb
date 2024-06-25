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
           #request{
                    width: 40px;
                    height: 40px;
                    background-color: rgb(248, 209, 163);
                    border-radius: 100%;
                    margin: 0% auto;
                    -webkit-animation: pulse 3s infinite ease-in-out;
                    -o-animation: pulse 3s infinite ease-in-out;
                    -ms-animation: pulse 3s infinite ease-in-out;
                    -moz-animation: pulse 3s infinite ease-in-out;
                    animation: pulse 3s infinite ease-in-out;
            }
            #acceptssj{
                    width: 40px;
                    height: 40px;
                    background-color: rgb(248, 200, 234);
                    border-radius: 100%;
                    margin: 0% auto;
                    -webkit-animation: pulse 3s infinite ease-in-out;
                    -o-animation: pulse 3s infinite ease-in-out;
                    -ms-animation: pulse 3s infinite ease-in-out;
                    -moz-animation: pulse 3s infinite ease-in-out;
                    animation: pulse 3s infinite ease-in-out;
            }
            #acceptpo{
                    width: 40px;
                    height: 40px;
                    background-color: rgb(209, 200, 248);
                    border-radius: 100%;
                    margin: 0% auto;
                    -webkit-animation: pulse 3s infinite ease-in-out;
                    -o-animation: pulse 3s infinite ease-in-out;
                    -ms-animation: pulse 3s infinite ease-in-out;
                    -moz-animation: pulse 3s infinite ease-in-out;
                    animation: pulse 3s infinite ease-in-out;
            }
            #finish{
                    width: 40px;
                    height: 40px;
                    background-color: rgb(194, 250, 241);
                    border-radius: 100%;
                    margin: 0% auto;
                    -webkit-animation: pulse 3s infinite ease-in-out;
                    -o-animation: pulse 3s infinite ease-in-out;
                    -ms-animation: pulse 3s infinite ease-in-out;
                    -moz-animation: pulse 3s infinite ease-in-out;
                    animation: pulse 3s infinite ease-in-out;
            }
            #success{
                    width: 40px;
                    height: 40px;
                    background-color: rgb(138, 247, 174);
                    border-radius: 100%;
                    margin: 0% auto;
                    -webkit-animation: pulse 3s infinite ease-in-out;
                    -o-animation: pulse 3s infinite ease-in-out;
                    -ms-animation: pulse 3s infinite ease-in-out;
                    -moz-animation: pulse 3s infinite ease-in-out;
                    animation: pulse 3s infinite ease-in-out;
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
                    <h4 class="mb-sm-0">แผนจัดซื้อพัสดุ-ครุภัณฑ์</h4>    
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">แผนจัดซื้อพัสดุ-ครุภัณฑ์</a></li>
                            <li class="breadcrumb-item active" style="color: coral">เพิ่มแผนจัดซื้อพัสดุ-ครุภัณฑ์</li>
                        </ol>
                    </div>
    
                </div>
            </div>
        </div> 
    </div> 
  
    <div data-parent="#accordion" id="collapseOne2" class="collapse">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card cardplan">    
                        <div class="card-body ">  
                            <div class="row">  
                                <div class="col-md-12">         
                                        <form action="{{ route('p.plan_procurement_save') }}" id="Insert_articleplan" method="POST">
                                        @csrf
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h4 class="card-title">แผนจัดซื้อพัสดุ-ครุภัณฑ์</h4>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-2">
                                                <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                                    <i class="pe-7s-diskette btn-icon-wrapper"></i>Save 
                                                </button> 
                                                <a href="{{ url('plan_control_subhos/') }}" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger me-2">
                                                    <i class="fa-solid fa-xmark me-2"></i>
                                                    Back
                                                </a>
                                            
                                            </div>
                                        </div>
                                       
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
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="detail" role="tabpanel">
                                                <p class="mb-0">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="">ชื่อแผนงาน/กิจกรรมสำคัญ</label>
                                                            <div class="form-group">
                                                            <input id="plan_control_activity_name" class="form-control form-control-sm" name="plan_control_activity_name">
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <label for="">กลุ่มเป้าหมาย</label>
                                                            <div class="form-group"> 
                                                            
                                                                <input id="plan_control_activity_group" class="form-control form-control-sm" name="plan_control_activity_group">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">จำนวน</label>
                                                            <div class="form-group">
                                                            <input id="qty" class="form-control form-control-sm" name="qty">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2"> 
                                                            <label for="">หน่วย</label>
                                                            <div class="form-group">
                                                                <select name="plan_control_unit" id="plan_control_unit" class="form-control form-control-sm" style="width: 100%"> 
                                                                    <option value="">-เลือก-</option>
                                                                    @foreach ($plan_unit as $item_u)                                                       
                                                                    <option value="{{$item_u->plan_unit_id}}">{{$item_u->plan_unit_name}}</option>                                                                                                        
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <label for="">ยุทธศาสตร์ </label>
                                                            <div class="form-group">
                                                                <select name="plan_strategic_id" id="plan_strategic_id" class="form-control form-control-sm" style="width: 100%">   
                                                                    <option value="">-เลือก-</option>                                                 
                                                                    @foreach ($plan_strategic as $item_st)
                                                                    {{-- @if ($plan_control->department == $item->DEPARTMENT_SUB_ID) --}}
                                                                    {{-- <option value="{{$item->DEPARTMENT_SUB_ID}}" selected>{{$item->DEPARTMENT_SUB_NAME}}</option> --}}
                                                                    {{-- @else --}}
                                                                    <option value="{{$item_st->plan_strategic_id}}">{{$item_st->plan_strategic_name}}</option>
                                                                    {{-- @endif  --}}
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">ผู้รับผิดชอบ </label>
                                                            <div class="form-group">
                                                                <select name="responsible_person" id="responsible_person" class="form-control form-control-sm" style="width: 100%">   
                                                                    <option value="">-เลือก-</option>                                                 
                                                                    @foreach ($department_sub as $item)
                                                                    {{-- @if ($plan_control->department == $item->DEPARTMENT_SUB_ID) --}}
                                                                    {{-- <option value="{{$item->DEPARTMENT_SUB_ID}}" selected>{{$item->DEPARTMENT_SUB_NAME}}</option> --}}
                                                                    {{-- @else --}}
                                                                    <option value="{{$item->DEPARTMENT_SUB_ID}}">{{$item->DEPARTMENT_SUB_NAME}}</option>
                                                                    {{-- @endif                                                                 --}}
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">แหล่งงบประมาณ </label>
                                                            <div class="form-group">
                                                                <select name="budget_source" id="budget_source" class="form-control form-control-sm" style="width: 100%"> 
                                                                    <option value="">-เลือก-</option>
                                                                    @foreach ($plan_control_type as $item2)
                                                                    {{-- @if ($plan_control->plan_type == $item2->plan_control_type_id) --}}
                                                                    {{-- <option value="{{$item2->plan_control_type_id}}" selected>{{$item2->plan_control_typename}}</option> --}}
                                                                    {{-- @else --}}
                                                                    <option value="{{$item2->plan_control_type_id}}">{{$item2->plan_control_typename}}</option>
                                                                    {{-- @endif                                                        --}}
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
                                                                    <input class="form-check-input checkboxs" type="checkbox" name="trimart_11" id="trimart_11" >
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_11">ต.ค.</label> 
                                                                </div> 
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input checkboxs" type="checkbox" name="trimart_12" id="trimart_12">
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_12">พ.ย.</label>
                                                                </div> 
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input checkboxs" type="checkbox" name="trimart_13" id="trimart_13">
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_13">ธ.ค.</label>
                                                                </div> 
                                                            </div>
                                                        </div>  
                                                        <div class="col-md-6">
                                                            <label for="">ไตรมาสที่ 2 </label>
                                                            <div class="form-group">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input checkboxs" type="checkbox" name="trimart_21" id="trimart_21">
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_21">ม.ค.</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input checkboxs" type="checkbox" name="trimart_22" id="trimart_22">
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_22">ก.พ.</label>
                                                                </div> 
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input checkboxs" type="checkbox" name="trimart_23" id="trimart_23">
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
                                                                    <input class="form-check-input checkboxs" type="checkbox" name="trimart_31" id="trimart_31">
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_31">เม.ย.</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input checkboxs" type="checkbox" name="trimart_32" id="trimart_32">
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_32">พ.ค.</label>
                                                                </div> 
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input checkboxs" type="checkbox" name="trimart_33" id="trimart_33">
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_33">มิ.ย.</label>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">ไตรมาสที่ 4 </label>
                                                            <div class="form-group">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input checkboxs" type="checkbox" name="trimart_41" id="trimart_41">
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_41">ก.ค.</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input checkboxs" type="checkbox" name="trimart_42" id="trimart_42">
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_42">ส.ค.</label>
                                                                </div> 
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input checkboxs" type="checkbox" name="trimart_43" id="trimart_43">
                                                                    <label class="form-check-label mt-2 ms-2" for="trimart_43">ก.ย.</label>
                                                                </div> 
                                                            </div>
                                                        </div>  
                                                    </div> 
                                                </p>
                                            </div>
                                        
                                        </div> 
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
                <div class="card-body"> 
                    <div class="row mb-2">
                        <div class="col-md-8 text-start"> 
                            {{-- <h5 class="modal-title me-3" id="editModalLabel">แผนจัดซื้อพัสดุ-ครุภัณฑ์ </h5> --}} 
                            <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(248, 209, 163);border-radius: 3em 3em 3em 3em"> 
                                ยังไม่ดำเนินการ
                            </button>
                            <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(248, 200, 234);border-radius: 3em 3em 3em 3em"> 
                                รอ สสจ.อนุมัติ
                            </button>
                            <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(209, 200, 248);border-radius: 3em 3em 3em 3em"> 
                                รอ ผอ. อนุมัติ
                            </button>
                            <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(194, 250, 241);border-radius: 3em 3em 3em 3em"> 
                                อนุมัติ
                            </button>
                            <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(138, 247, 174);border-radius: 3em 3em 3em 3em"> 
                                SUCCESS
                            </button>   
                        </div>                     
                        <div class="col-md-4 text-end">
                            <div id="headingTwo" class="b-radius-0">   
                                <button type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="false" aria-controls="collapseTwo" class="btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(176, 205, 243);border-radius: 3em 3em 3em 3em"> 
                                    เพิ่มแผนจัดซื้อพัสดุ-ครุภัณฑ์
                                </button>  
                            </div>      
 
                                {{-- <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(176, 205, 243);border-radius: 3em 3em 3em 3em"> 
                                    เพิ่มแผนจัดซื้อพัสดุ-ครุภัณฑ์
                                </button>          --}}
                    
                            </div> 
                    </div>  
                    <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
                        <thead >
                            <tr style="font-size: 13px;background-color: rgb(255, 231, 226);border-color: rgb(183, 180, 180)">
                                <th rowspan="3" colspan="1" class="text-center" width="4%" style="border-color: rgb(183, 180, 180)">ลำดับ</th>
                                <th rowspan="3" colspan="1" class="text-center" width="4%" style="border-color: rgb(183, 180, 180)">สถานะ</th>
                                <th rowspan="3" colspan="1" class="text-center" style="border-color: rgb(183, 180, 180)"> กิจกรรม/กลยุทธ์</th> 
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
                                <td style="text-align: center;border-color: rgb(183, 180, 180)"">รวม(บาท)</td> 
                            </tr> 
                        </thead>
                        <tbody style="font-size: 13px;border-color: rgb(183, 180, 180)">
                            <?php $i = 1; ?>
                            @foreach ($plan_control_activity as $item_)   
                            <?php 
                                $datasub = DB::select('
                                    SELECT * FROM plan_control_budget 
                                    WHERE plan_control_activity_id = "'.$item_->plan_control_activity_id.'" 
                                '); 
                                $datasubsub = DB::select('
                                    SELECT * FROM plan_control_activity_sub 
                                    WHERE plan_control_activity_id = "'.$item_->plan_control_activity_id.'" 
                                '); 
                                // $datasubsub_count_ = DB::select('
                                //     SELECT COUNT(plan_control_activity_sub_id) as Csub FROM plan_control_activity_sub 
                                //     WHERE plan_control_activity_id = "'.$item_->plan_control_activity_id.'" AND plan_control_id = "'.$plan_control->plan_control_id.'"
                                // ');  
                                // foreach ($datasubsub_count_ as $key => $value_c) {
                                //     $datasubsub_count = $value_c->Csub;
                                // }
                                // $datapay_ = DB::select('
                                //     SELECT SUM(sum_total) as total FROM plan_control_budget_pay 
                                //     WHERE plan_control_activity_id = "'.$item_->plan_control_activity_id.'" AND plan_control_id = "'.$plan_control->plan_control_id.'" 
                                // ');
                                // foreach ($datapay_ as $key => $value_pay) {
                                //     $datapay     = $value_pay->total;
                                // }
                            ?>                                                          
                            
                            <tr id="sid{{ $item_->plan_control_activity_id }}">
                                <td class="text-center" width="4%">{{ $i++ }}</td>
                                            <td class="text-center" width="4%">
                                                @if ($item_->status == 'REQUEST')
                                                    <div id="request"> 
                                                        <span class="badge badge badge-secondary"></span>
                                                    </div> 
                                                @elseif ($item_->status == 'INPROGRESS_SSJ')
                                                    <div id="acceptssj"> 
                                                        <span class="badge badge badge-secondary"></span>
                                                    </div>
                                                @elseif ($item_->status == 'INPROGRESS_PO')
                                                    <div id="acceptpo"> 
                                                        <span class="badge badge badge-secondary"></span>
                                                    </div>
                                                @elseif ($item_->status == 'FINISH')
                                                    <div id="finish"> 
                                                        <span class="badge badge badge-secondary"></span>
                                                    </div>
                                                @else
                                                <div id="success"> 
                                                    <span class="badge badge badge-secondary"></span>
                                                </div>
                                                @endif
                                            </td>
                                            <td class="text-start" >

                                                {{ $item_->plan_control_activity_name }}   
                                                
                                               
                                           


                                                {{-- <a href="{{url('plan_control_subhosactivity_edit/'.$id.'/'.$plan_control->plan_control_id.'/'.$item_->plan_control_activity_id)}}">
                                                    {{ $item_->plan_control_activity_name }} 
                                                </a> --}}
                                                {{-- <a href="{{url('plan_control_subhosactivity_sub/'.$plan_control->plan_control_id.'/'.$item_->plan_control_activity_id)}}" class="btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(209, 200, 248);border-radius: 3em 3em 3em 3em">
                                                   กิจกรรมย่อย
                                                </a> --}}
                                                <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-secondary ActivitysubModal_"  value="{{$item_->plan_control_activity_id}}" style="background-color: rgb(243, 207, 213);border-radius: 3em 3em 3em 3em"> 
                                                    เพิ่มกิจกรรมย่อย
                                                </button> <br> 
                                                {{-- @if ($datasubsub_count > '0')
                                                    <span class="text-danger"> กิจกรรมย่อย</span>   <br> 
                                                @else
                                                    
                                                @endif --}}
                                                @foreach ($datasubsub as $item_subsub)    
                                                <span class="text-danger">กิจกรรมย่อย</span><span class="text-primary"> {{$item_subsub->plan_control_activity_sub_name}}</span>   <br>  
                                                @endforeach 


                                                {{-- @foreach ($datasubsub as $item_subsub)                                           
                                                        <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="plan_control_activity_subdestroy({{ $item_subsub->plan_control_activity_sub_id }})" style="font-size:13px">                                                            
                                                            <span> {{$item_subsub->plan_control_activity_sub_name}}</span>
                                                            <i class="fa-solid fa-trash-can ms-2 me-2 text-danger" style="font-size:13px"></i>
                                                            {{$datasubsub_count}}
                                                        </a>                                               
                                                @endforeach  --}}
                                                
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
                                            <td class="text-start" width="15%">  
                                                {{-- <div class="dropdown">
                                                    <button class="btn btn-outline-primary dropdown-toggle menu btn-sm"
                                                        type="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">ทำรายการ</button>
                                                    <ul class="dropdown-menu">
                                                          
                                                            <button type="button" class="dropdown-item menu btn btn-outline-info btn-sm edit_data"  value="{{ $item_->plan_control_activity_id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="วัตถุประสงค์"> 
                                                                <i class="fa-solid fa-plus-minus me-3 mb-1" style="font-size:17px;color: rgb(40, 177, 246)"></i> 
                                                                <label for=""
                                                                style="color: rgb(34, 148, 255);font-size:13px">เพิ่มรายละเอียด</label> 
                                                            </button> 
                                                        
                                                            <a class="dropdown-item menu btn btn-outline-info btn-sm" href="javascript:void(0)"
                                                                onclick="plan_control_activ_ssj({{  $item_->plan_control_activity_id}})"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                data-bs-custom-class="custom-tooltip" title="เสนอ สสจ. อนุมัติ">
                                                                <i class="fa-solid fa-signature me-3 mb-1"></i>
                                                                <label for="" style="color: rgb(7, 166, 194);font-size:13px">เสนอ สสจ. อนุมัติ</label>
                                                            </a>
                                                            <a class="dropdown-item menu btn btn-outline-primary btn-sm" href="javascript:void(0)"
                                                                onclick="plan_control_activ_po({{  $item_->plan_control_activity_id}})"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                data-bs-custom-class="custom-tooltip" title="เสนอ ผอ. อนุมัติ"> 
                                                                <i class="fa-solid fa-signature me-3 mb-1" ></i>
                                                                <label for="" style="color: rgb(7, 110, 194);font-size:13px">เสนอ ผอ. อนุมัติ</label>
                                                            </a>
                                                            <a type="button" href="{{url('plan_control_subhosactivity_edit/'.$id.'/'.$plan_control->plan_control_id.'/'.$item_->plan_control_activity_id)}}"
                                                                class="dropdown-item menu btn btn-outline-warning btn-sm" data-bs-toggle="tooltip"
                                                                data-bs-placement="left" title="แก้ไข" target="_blank">
                                                                <i class="fa-solid fa-pen-to-square me-3 mb-1" style="color: rgb(252, 185, 0);font-size:13px"></i>
                                                                    <label for=""
                                                                    style="color: rgb(252, 185, 0);font-size:13px">แก้ไข</label>
                                                            </a>

                                                            <a class="dropdown-item menu btn btn-outline-danger btn-sm" href="javascript:void(0)"
                                                                onclick="plan_control_destroy({{  $item_->plan_control_activity_id}})"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                data-bs-custom-class="custom-tooltip" title="ลบ">
                                                                <i class="fa-solid fa-trash-can me-3 mb-1"></i>
                                                                <label for=""
                                                                    style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
                                                            </a>
                                                    </ul>
                                                </div>                                           
                                                @foreach ($datasub as $item_sub)                                           
                                                        <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="plan_control_activity_destroy({{ $item_sub->plan_control_budget_id }})" style="font-size:13px">                                                            
                                                            <span> - {{$item_sub->plan_list_budget_name}} / {{$item_sub->plan_control_budget_price}}</span>
                                                            <i class="fa-solid fa-trash-can ms-2 me-2 text-danger" style="font-size:13px"></i>
                                                        </a>                                               
                                                @endforeach  --}}
                                            </td>                                           
                                            <td class="text-end" width="4%" style="color:rgb(216, 95, 14)">{{ $item_->budget_price }}</td>  
                                                                             
                                        </tr>

                            @endforeach
                        </tbody>
                    </table>                         
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
                $('#ECLAIM_STATUS').select2({
                    dropdownParent: $('#detailclaim')
                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#Insert_articleplan').on('submit',function(e){
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
                                        title: 'เพิ่มแผนจัดซื้อพัสดุ-ครุภัณฑ์สำเร็จ',
                                        text: "You Insert data success",
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
