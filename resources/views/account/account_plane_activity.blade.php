@extends('layouts.accountnew')
@section('title','PK-OFFICER || ACCOUNT')
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
           .datepicker {
            z-index: 2051 !important;
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
            /* #acceptssj{ */
                /* อยู่ระหว่างดำเนินการ */
            #accept{
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
            /* #acceptpo{ */
                /* ดำเนินการ */
            #verify{
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
    function plan_control_activ_ssj(plan_control_activity_id)
    {
        Swal.fire({
            title: 'ต้องการเสนอ สสจ.ใช่ไหม?',
            text: "ข้อมูลนี้จะถูกเสนอ สสจ. !!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ส่งเดี๋ยวนี้ !',
            cancelButtonText: 'ไม่, ยกเลิก'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url:"{{url('plan_control_activ_ssj')}}" +'/'+ plan_control_activity_id,  
                type:'POST',
                data:{
                    _token : $("input[name=_token]").val()
                },
                success:function(response)
                {          
                    Swal.fire({
                        title: 'เสนอ สสจ. สำเร็จ !',
                        text: "You Send data success",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#06D177',
                        // cancelButtonColor: '#d33',
                        confirmButtonText: 'เรียบร้อย'
                    }).then((result) => {
                        if (result.isConfirmed) {                  
                        $("#sid"+plan_control_activity_id).remove();     
                        window.location.reload(); 
                        //   window.location = "/person/person_index"; //     
                        }
                    }) 
                }
            })        
            }
        })
    }

    function plan_control_activ_po(plan_control_activity_id)
    {
        Swal.fire({
            title: 'ต้องการเสนอ ผอ.ใช่ไหม?',
            text: "ข้อมูลนี้จะถูกเสนอ ผอ. !!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ส่งเดี๋ยวนี้ !',
            cancelButtonText: 'ไม่, ยกเลิก'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url:"{{url('plan_control_activ_po')}}" +'/'+ plan_control_activity_id,  
                type:'POST',
                data:{
                    _token : $("input[name=_token]").val()
                },
                success:function(response)
                {          
                    Swal.fire({
                        title: 'เสนอ ผอ. สำเร็จ !',
                        text: "You Send data success",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#06D177',
                        // cancelButtonColor: '#d33',
                        confirmButtonText: 'เรียบร้อย'
                    }).then((result) => {
                        if (result.isConfirmed) {                  
                        $("#sid"+plan_control_activity_id).remove();     
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
                    <h4 class="mb-sm-0">กิจกรรม/กลยุทธ์</h4>
    
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">กิจกรรม/กลยุทธ์</a></li>
                            <li class="breadcrumb-item active">เบิก-จ่ายเงิน</li>
                        </ol>
                    </div>
    
                </div>
            </div>
        </div> 
    </div> 
    
        <div class="row">
            <div class="col-xl-12">
                <div class="card cardfinan">  
                    <input type="hidden" id="billno" name="billno" value="{{$plan_control->billno}}">
                   
                    <div class="card-body"> 
                        <div class="row mb-2">
                            <div class="col-md-8 text-start"> <h5 class="modal-title me-2" id="editModalLabel">กิจกรรม/กลยุทธ์  {{$plan_control->plan_name}} เลขที่ {{$plan_control->billno}}</h5>  </div>
                            {{-- <div class="col"></div> --}}
                            <div class="col-md-4 text-end">
                                <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(248, 209, 163);border-radius: 3em 3em 3em 3em"> 
                                    ยังไม่ดำเนินการ
                                </button>
                                <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(248, 200, 234);border-radius: 3em 3em 3em 3em"> 
                                    อยู่ระหว่างดำเนินการ
                                </button>
                                <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(194, 250, 241);border-radius: 3em 3em 3em 3em"> 
                                    อนุมัติ
                                </button>
                                <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(209, 200, 248);border-radius: 3em 3em 3em 3em"> 
                                    ดำเนินการ
                                </button>                               
                                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(138, 247, 174);border-radius: 3em 3em 3em 3em"> 
                                    SUCCESS
                                </button>
                                {{-- <h6 class="mt-2 me-3"> เลขที่ {{$plan_control->billno}}</h6> --}}
                            </div>
                            {{-- <div class="col-md-2 text-end"> <h6 class="mt-2 me-3"> เลขที่ {{$plan_control->billno}}</h6> </div> --}}
                        </div> 
                        
                        <div class="table-responsive"> 
                            <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
                                <thead >
                                    <tr style="font-size: 13px;background-color: rgb(255, 231, 226);border-color: rgb(183, 180, 180)">
                                        <th rowspan="3" colspan="1" class="text-center" width="4%" style="border-color: rgb(183, 180, 180)">ลำดับ</th>
                                        <th rowspan="3" colspan="1" class="text-center" width="4%" style="border-color: rgb(183, 180, 180)">สถานะ</th>
                                        <th rowspan="3" colspan="1" class="text-center" style="border-color: rgb(183, 180, 180)"> กิจกรรม/กลยุทธ์</th> 
                                        <th rowspan="3" colspan="1" class="text-center" style="border-color: rgb(183, 180, 180)">กลุ่มเป้าหมาย</th> 
                                        <th rowspan="3" colspan="1" class="text-center" width="4%" style="border-color: rgb(183, 180, 180)">จำนวน<br>(คน) </th> 
                                        {{-- <th colspan="12" class="text-center" style="border-color: rgb(183, 180, 180)">เป้าหมายการดำเนินงาน (1ต.ค.66 - 30 ก.ย.67)</th>   --}}
                                        <th colspan="1" rowspan="1" style="text-align: center;">งบประมาณ</th>
                                        <th rowspan="1" style="text-align: center;">งบที่ตั้ง</th>   
                                        <th rowspan="1" style="text-align: center;">เบิก</th> 
                                        <th rowspan="1" style="text-align: center;">คงเหลือ</th> 
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
                                        $datasubsub_count_ = DB::select('
                                            SELECT COUNT(plan_control_activity_sub_id) as Csub FROM plan_control_activity_sub 
                                            WHERE plan_control_activity_id = "'.$item_->plan_control_activity_id.'" AND plan_control_id = "'.$plan_control->plan_control_id.'"
                                        ');  
                                        foreach ($datasubsub_count_ as $key => $value_c) {
                                            $datasubsub_count = $value_c->Csub;
                                        }
                                        $datapay_ = DB::select('
                                            SELECT SUM(sum_total) as total FROM plan_control_budget_pay 
                                            WHERE plan_control_activity_id = "'.$item_->plan_control_activity_id.'" AND plan_control_id = "'.$plan_control->plan_control_id.'" 
                                        ');
                                        foreach ($datapay_ as $key => $value_pay) {
                                            $datapay     = $value_pay->total;
                                        }
                                    ?>                                                          
                                    
                                    <tr id="sid{{ $item_->plan_control_activity_id }}">
                                            <td class="text-center" width="4%">{{ $i++ }}</td>
                                            <td class="text-center" width="4%">
                                                @if ($item_->status == 'REQUEST')
                                                    <div id="request"> 
                                                        <span class="badge badge badge-secondary"></span>
                                                    </div> 
                                                @elseif ($item_->status == 'ACCEPT')
                                                    <div id="accept"> 
                                                        <span class="badge badge badge-secondary"></span>
                                                    </div>
                                                @elseif ($item_->status == 'VERIFY')
                                                    <div id="verify"> 
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
                                                    {{ $item_->plan_control_activity_name }} <br>  
                                                    @if ($datasubsub_count > '0')
                                                        <span class="text-danger"> กิจกรรมย่อย</span>   <br> 
                                                    @else
                                                        
                                                    @endif
                                                   
                                                    @foreach ($datasubsub as $item_subsub)    
                                                                =><span class="text-primary"> {{$item_subsub->plan_control_activity_sub_name}}</span>   <br>  
                                                    @endforeach 
                                            </td>
                                                                                  
                                            <td class="text-start" width="10%">{{ $item_->plan_control_activity_group }}</td>
                                            <td class="text-center" width="5%">{{ $item_->qty }}</td>
                                                                                                                             
                                            <td class="text-start" width="15%">  
                                                 
                                                    @if ($item_->budget_price == '')
                                                        
                                                    @else
                                                        <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary MoneyModal_" value="{{ $item_->plan_control_activity_id }}" style="background-color: rgb(200, 233, 248);border-radius: 3em 3em 3em 3em"> 
                                                            เบิกเงิน
                                                        </button>
                                                    <br>  
                                                    @endif
                                                   
                                                    @foreach ($datasub as $item_sub)   
                                                                <span> - {{$item_sub->plan_list_budget_name}} / {{$item_sub->plan_control_budget_price}}</span> <br>                                           
                                                    @endforeach 
                                            </td>                                           
                                            <td class="text-end" width="4%" style="color:rgb(216, 95, 14)">{{ $item_->budget_price }}</td>  
                                            <td class="text-end" width="4%" style="color:rgb(5, 127, 95)">{{ number_format($datapay, 2) }}</td> 
                                            <td class="text-end" width="6%" style="color:rgb(13, 101, 188)">{{ number_format(($item_->budget_price)-($datapay) , 2)}}</td>                                
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

    <div class="modal fade" id="MoneyModal" tabindex="-1"
    role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        {{-- <div class="modal-dialog modal-dialog-slideout"> --}}
        <div class="modal-content">
            <div class="modal-header"> 
                        <h2>เบิกเงินทะเบียนควบคุมแผนงานโครงการ</h2> 
            </div>
            <input id="editplan_control_id" class="form-control form-control-sm" name="editplan_control_id" type="hidden" >
            <input id="editplan_control_activity_id" class="form-control form-control-sm" name="editplan_control_activity_id" type="hidden" >

            <div class="modal-body">
                <div class="row ">
                    <div class="col-md-2 text-end mt-2"> 
                        <p for="">วันที่</p>
                         
                    </div>
                    <div class="col-md-3"> 
                        <input type="text" id="editplan_control_budget_paydate" class="form-control" data-toggle="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker" data-date-language="th-th" autocomplete="off" value="{{ $datenow }}">
       
                    </div>
                    <div class="col-md-1 text-start"><i class="fa-solid fa-calendar-days mt-2"></i> </div>
                    <div class="col-md-2 text-end"> <p for="">ผู้เบิก </p> </div>
                    <div class="col-md-4"> 
                        <div class="form-group">
                            <select name="user_id" id="edituser_id"
                                class="form-control"
                                style="width: 100%">
                                @foreach ($users as $item3)
                                @if ($iduser == $item3->id)
                                    <option value="{{ $item3->id }}" selected> {{ $item3->fname }} {{ $item3->lname }} </option>
                                @else
                                    <option value="{{ $item3->id }}"> {{ $item3->fname }} {{ $item3->lname }} </option>
                                @endif 
                                @endforeach
                            </select>
                        </div>
                    </div>
                    

                </div>

                 <div class="row mt-2">
                    <div class="col-md-2 text-end"> <p for="">รายการเบิก </p> </div>
                    <div class="col-md-4"> 
                        <div class="form-group">
                            <input id="editplan_list_budget_name" class="form-control form-control-sm" name="editplan_list_budget_name" value="เบิกทั้งหมด" readonly>
                            {{-- <select name="plan_list_budget_id" id="plan_list_budget_id"
                                class="form-control"
                                style="width: 100%">
                                @foreach ($plan_list_budget as $item_bud)  
                                    <option value="{{ $item_bud->plan_list_budget_id }}"> {{ $item_bud->plan_list_budget_name }} </option> 
                                @endforeach
                            </select> --}}
                        </div>
                    </div>
                    <div class="col-md-2 text-end mt-2"> 
                        <p for="">ยอดเบิก</p>                         
                    </div>
                    <div class="col-md-3 "> 
                        <div class="form-group">
                            <input id="editsum_total" class="form-control form-control-sm" name="editsum_total" readonly>
                        </div>
                    </div>
                    <div class="col-md-1 text-start mt-2"> <p for="">บาท</p> </div> 
                 </div>

                 <div class="row mt-2">
                    <div class="col-md-2 text-end"> <p for="">หมายเหตุ </p> </div>
                    <div class="col-md-10"> 
                        <textarea name="detail" id="editdetail" class="form-control form-control-sm" rows="2"></textarea>
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
</div>

    <div class="modal fade" id="ObjModalModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h2>เพิ่มวัตถุประสงค์</h2> 
                </div>
            
                <input id="plan_control_activity_id" class="form-control form-control-sm" name="plan_control_activity_id" type="hidden" >

                <div class="modal-body">
                    <div class="row mt-3">
                                    
                        <div class="col-md-2 text-end mt-2"> 
                            <p for="">วัตถุประสงค์</p> 
                        </div>
                        <div class="col-md-9 "> 
                            <div class="form-group">
                                <input id="plan_control_objactivity_name" class="form-control form-control-sm" name="plan_control_objactivity_name">
                            </div>
                        </div>
                        <div class="col"></div>                  
                    </div> 
                </div>  

                <div class="modal-footer">
                
                        <button type="button" id="SaveObjectBtn"
                            class="btn-icon btn-shadow btn-dashed btn btn-outline-info me-2"> 
                            <i class="pe-7s-diskette btn-icon-wrapper me-2"></i>
                            Save
                        </button>
                        <button type="button"
                            class="btn-icon btn-shadow btn-dashed btn btn-outline-danger"
                            data-bs-dismiss="modal"><i
                                class="fa-solid fa-xmark me-2"></i>Close
                        </button>  
            
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ActivitysubModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h2>เพิ่มกิจกรรม/กลยุทธ์ ย่อย</h2> 
                </div>
             
                <form action="{{ route('p.plan_control_subhosactivity_subsave') }}" id="Insertsub_data" method="POST">
                    @csrf
                    <div class="modal-body">  
                        
                            <input type="hidden" id="sub_plan_control_id" name="sub_plan_control_id" value="{{$plan_control->plan_control_id}}"> 
                            <input id="sub_plan_control_activity_id" class="form-control form-control-sm" name="sub_plan_control_activity_id" type="hidden" >
 
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#detail_sub" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-detail"></i></span>
                                        <span class="d-none d-sm-block">รายละเอียด</span>    
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#trimart_sub" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">ไตรมาส</span>    
                                    </a>
                                </li>
                           
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="detail_sub" role="tabpanel">
                                    <p class="mb-0">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="">ชื่อกิจกรรม/กลยุทธ์ ย่อย</label>
                                                <div class="form-group">
                                                <input id="plan_control_activity_sub_name" class="form-control form-control-sm" name="plan_control_activity_sub_name">
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-md-7">
                                                <label for="">กลุ่มเป้าหมาย</label>
                                                <div class="form-group"> 
                                                   
                                                    <input id="sub_plan_control_activity_group" class="form-control form-control-sm" name="sub_plan_control_activity_group">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">จำนวน</label>
                                                <div class="form-group">
                                                <input id="sub_qty" class="form-control form-control-sm" name="sub_qty">
                                                </div>
                                            </div>
                                            <div class="col-md-3"> 
                                                <label for="">หน่วย</label>
                                                <div class="form-group">
                                                    <select name="sub_plan_control_unit" id="sub_plan_control_unit" class="form-control form-control-sm" style="width: 100%"> 
                                                        <option value="">-เลือก-</option>
                                                        @foreach ($plan_unit as $item_u)
                                                   
                                                        <option value="{{$item_u->plan_unit_id}}">{{$item_u->plan_unit_name}}</option>
                                                                                                    
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                           
                                        </div> 
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="">ผู้รับผิดชอบ </label>
                                                <div class="form-group">
                                                    <select name="sub_responsible_person" id="sub_responsible_person" class="form-control form-control-sm" style="width: 100%">   
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
                                            <div class="col-md-6">
                                                <label for="">แหล่งงบประมาณ </label>
                                                <div class="form-group">
                                                    <select name="sub_budget_source" id="sub_budget_source" class="form-control form-control-sm" style="width: 100%"> 
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
                                    </p>
                                </div>
                                <div class="tab-pane" id="trimart_sub" role="tabpanel">
                                    <p class="mb-0">
                                        <div class="row mt-2">   
                                            <div class="col-md-6">
                                                <label for="">ไตรมาสที่ 1 </label>
                                                <div class="form-group">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input checkboxs" type="checkbox" name="subtrimart_11" id="subtrimart_11" >
                                                        <label class="form-check-label mt-2 ms-2" for="subtrimart_11">ต.ค.</label> 
                                                    </div> 
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input checkboxs" type="checkbox" name="subtrimart_12" id="subtrimart_12">
                                                        <label class="form-check-label mt-2 ms-2" for="subtrimart_12">พ.ย.</label>
                                                    </div> 
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input checkboxs" type="checkbox" name="subtrimart_13" id="subtrimart_13">
                                                        <label class="form-check-label mt-2 ms-2" for="subtrimart_13">ธ.ค.</label>
                                                    </div> 
                                                </div>
                                            </div>  
                                            <div class="col-md-6">
                                                <label for="">ไตรมาสที่ 2 </label>
                                                <div class="form-group">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input checkboxs" type="checkbox" name="subtrimart_21" id="subtrimart_21">
                                                        <label class="form-check-label mt-2 ms-2" for="subtrimart_21">ม.ค.</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input checkboxs" type="checkbox" name="subtrimart_22" id="subtrimart_22">
                                                        <label class="form-check-label mt-2 ms-2" for="subtrimart_22">ก.พ.</label>
                                                    </div> 
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input checkboxs" type="checkbox" name="subtrimart_23" id="subtrimart_23">
                                                        <label class="form-check-label mt-2 ms-2" for="subtrimart_23">มี.ค.</label>
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
                                                        <input class="form-check-input checkboxs" type="checkbox" name="subtrimart_31" id="subtrimart_31">
                                                        <label class="form-check-label mt-2 ms-2" for="subtrimart_31">เม.ย.</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input checkboxs" type="checkbox" name="subtrimart_32" id="subtrimart_32">
                                                        <label class="form-check-label mt-2 ms-2" for="subtrimart_32">พ.ค.</label>
                                                    </div> 
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input checkboxs" type="checkbox" name="subtrimart_33" id="subtrimart_33">
                                                        <label class="form-check-label mt-2 ms-2" for="subtrimart_33">มิ.ย.</label>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">ไตรมาสที่ 4 </label>
                                                <div class="form-group">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input checkboxs" type="checkbox" name="subtrimart_41" id="subtrimart_41">
                                                        <label class="form-check-label mt-2 ms-2" for="subtrimart_41">ก.ค.</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input checkboxs" type="checkbox" name="subtrimart_42" id="subtrimart_42">
                                                        <label class="form-check-label mt-2 ms-2" for="subtrimart_42">ส.ค.</label>
                                                    </div> 
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input checkboxs" type="checkbox" name="subtrimart_43" id="subtrimart_43">
                                                        <label class="form-check-label mt-2 ms-2" for="subtrimart_43">ก.ย.</label>
                                                    </div> 
                                                </div>
                                            </div>  
                                        </div> 
                                    </p>
                                </div> 
                            </div> 
                    </div>

                <div class="modal-footer">
                        <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                            <i class="pe-7s-diskette btn-icon-wrapper"></i>Save 
                        </button> 
                        <button type="button"
                        class="btn-icon btn-shadow btn-dashed btn btn-outline-danger"
                        data-bs-dismiss="modal"><i
                            class="fa-solid fa-xmark me-2"></i>Close
                    </button>   
                </div>
            </div>
        </div>
    </div>
</form>
 
    <div class="modal fade" id="DetailModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> 
            <div class="modal-content">
                <div class="modal-header">                                                        
                    <div class="row">
                        <div class="col-md-12 text-start"><h2>รายละเอียดงบประมาณ</h2> </div>                        
                    </div>                                                    
                </div>

                
                
                {{-- <input type="hidden" id="plan_control_id" name="plan_control_id" value="{{$data_plan_control->plan_control_id}}"> --}}
                {{-- <input type="hidden" id="billno" name="billno" value="{{$data_plan_control->billno}}">  --}}
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

    <div class="modal fade" id="DetailsubModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> 
            <div class="modal-content">
                <div class="modal-header">                                                        
                    <div class="row">
                        <div class="col-md-12 text-start"><h2>รายละเอียดงบประมาณ</h2> </div>                        
                    </div>                                                    
                </div>
 
                <input id="editsub_plan_control_activity_sub_id" class="form-control form-control-sm" name="editsub_plan_control_activity_sub_id" type="text" >
                <input id="editsub_plan_control_activity_id" class="form-control form-control-sm" name="editsub_plan_control_activity_id" type="text" >
                <input id="editsub_plan_control_id" class="form-control form-control-sm" name="editsub_plan_control_id" type="text" >

                <div class="modal-body">
                    <div class="row mt-2">
                        <div class="col-md-8 ">
                            <label for="">รายละเอียดงบประมาณ</label>
                            <div class="form-group"> 
                                <select name="subplan_list_budget_id" id="subplan_list_budget_id" class="form-control form-control-sm" style="width: 100%"> 
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
                                <input id="subplan_control_budget_price" class="form-control form-control-sm" name="subplan_control_budget_price">
                            </div>
                        </div>          
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="button" id="SaveDetailsubBtn"
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
                
                    $('#startdate').datepicker({
                        format: 'yyyy-mm-dd'
                    });
                    $('#enddate').datepicker({
                        format: 'yyyy-mm-dd'
                    });
                    $('#plan_list_budget_id').select2({
                        dropdownParent: $('#DetailModal')
                    });
                    $('#subplan_list_budget_id').select2({
                        dropdownParent: $('#DetailsubModal')
                    });

                    $('#sub_plan_control_unit').select2({
                        dropdownParent: $('#ActivitysubModal')
                    });
                    $('#sub_responsible_person').select2({
                        dropdownParent: $('#ActivitysubModal')
                    });
                    $('#sub_budget_source').select2({
                        dropdownParent: $('#ActivitysubModal')
                    });
                    $('#plan_control_moneyuser_id').select2({
                        dropdownParent: $('#MoneyModal')
                    });
                    $('#plan_list_budget_id').select2({
                        dropdownParent: $('#MoneyModal')
                    });
                    
                    $('[data-toggle="datepicker"]').datepicker({ 
                        autoHide: true,
                        zIndex: 2048,
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
                    $('#Insertdata_Sub').click(function() {
                            var plan_list_budget_id       = $('#plan_list_budget_id').val();
                            var plan_control_budget_price      = $('#plan_control_budget_price_new').val(); 
                            var plan_control_id                  = $('#plan_control_id').val();
                            var billno                           = $('#billno').val();
                        $.ajax({
                            url: "{{ route('p.plan_control_budget_save') }}",
                            type: "POST",
                            dataType: 'json',
                            data: {
                                plan_list_budget_id,plan_control_budget_price,plan_control_id,billno
                            },
                            success: function(data) {
                                if (data.status == 200) {
                                    Swal.fire({
                                        title: 'บันทึกรายละเอียดงบประมาณ',
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

                    $(document).on('click', '.MoneyModal_', function() {
                        var plan_control_activity_id = $(this).val();
                        $('#plan_control_moneydate').datepicker();
                        // alert(plan_control_activity_id);
                        $('#MoneyModal').modal('show');
                        
                        $.ajax({
                            type: "GET",
                            url: "{{ url('account_plane_payedit') }}" + '/' + plan_control_activity_id,
                            success: function(data) { 
                                $('#editplan_control_activity_id').val(data.data_show.plan_control_activity_id)
                                $('#editplan_control_id').val(data.data_show.plan_control_id)
                                $('#editsum_total').val(data.sum_total)
                            },
                        });
                    });

                    $('#SaveMoneyBtn').click(function() {
                        var detail                     = $('#editdetail').val();
                        var sum_total                  = $('#editsum_total').val();
                        var plan_list_budget_name      = $('#editplan_list_budget_name').val();
                        var user_id                    = $('#edituser_id').val();
                        var plan_control_activity_id   = $('#editplan_control_activity_id').val();
                        var plan_control_id            = $('#editplan_control_id').val();
                        
                        $.ajax({
                            url: "{{ route('acc.account_plane_paysave') }}",
                            type: "POST",
                            dataType: 'json',
                            data: {detail,sum_total,plan_list_budget_name, user_id, plan_control_activity_id , plan_control_id},
                            success: function(data) {
                                if (data.status == 200) {
                                    Swal.fire({
                                        title: 'เบิกเงินสำเร็จ',
                                        text: "You Request Money success",
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

                    // $(document).on('click', '.ojectModal_', function() {
                    //     var plan_control_activity_id = $(this).val(); 
                    //     $('#ObjModalModal').modal('show');
                    //     // 
                    //     // plan_control_moneyedit
                    //     $.ajax({
                    //         type: "GET",
                    //         url: "{{ url('plan_control_activ_edit') }}" + '/' + plan_control_activity_id,
                    //         success: function(data) { 
                    //             $('#plan_control_activity_id').val(data.data_show.plan_control_activity_id)
                    //             // $('#obj_billno').val(data.data_show.billno)
                    //         },
                    //     });
                    // });
                    // $('#SaveObjectBtn').click(function() { 
                    //     var plan_control_objactivity_name    = $('#plan_control_objactivity_name').val();
                    //     var plan_control_activity_id         = $('#plan_control_activity_id').val();
                    //     // var obj_billno                    = $('#obj_billno').val();
                    //     // alert(obj_billno);
                    //     $.ajax({
                    //         url: "{{ route('p.plan_control_activobj_save') }}",
                    //         type: "POST",
                    //         dataType: 'json',
                    //         data: { plan_control_activity_id, plan_control_objactivity_name},
                    //         success: function(data) {
                    //             if (data.status == 200) {
                    //                 Swal.fire({
                    //                     title: 'เพิ่มวัตถุประสงค์สำเร็จ',
                    //                     text: "You Insert Obj success",
                    //                     icon: 'success',
                    //                     showCancelButton: false,
                    //                     confirmButtonColor: '#06D177',
                    //                     confirmButtonText: 'เรียบร้อย'
                    //                 }).then((result) => {
                    //                     if (result
                    //                         .isConfirmed) {
                    //                         console.log(
                    //                             data);

                    //                         window.location
                    //                             .reload();
                    //                     }
                    //                 })
                    //             } else {

                    //             }

                    //         },
                    //     });
                    // });

                    // $(document).on('click', '.ActivitysubModal_', function() {
                    //     var plan_control_activity_id = $(this).val(); 
                    //     $('#ActivitysubModal').modal('show');
                     
                    //     // plan_control_moneyedit
                    //     $.ajax({
                    //         type: "GET",
                    //         url: "{{ url('plan_control_activ_edit') }}" + '/' + plan_control_activity_id,
                    //         success: function(data) { 
                    //             $('#sub_plan_control_activity_id').val(data.data_show.plan_control_activity_id)
                    //             // $('#obj_billno').val(data.data_show.billno)
                    //         },
                    //     });
                    // });
                    // $('#Insertsub_data').on('submit',function(e){
                    //         e.preventDefault();            
                    //         var form = this; 
                    //         $.ajax({
                    //             url:$(form).attr('action'),
                    //             method:$(form).attr('method'),
                    //             data:new FormData(form),
                    //             processData:false,
                    //             dataType:'json',
                    //             contentType:false,
                    //             beforeSend:function(){
                    //                 $(form).find('span.error-text').text('');
                    //             },
                    //             success:function(data){
                    //                 if (data.status == 0 ) {
                                    
                    //                 } else {          
                    //                 Swal.fire({
                    //                     title: 'เพิ่มกิจกรรม/กลยุทธ์ ย่อยสำเร็จ',
                    //                     text: "You Insert data success",
                    //                     icon: 'success',
                    //                     showCancelButton: false,
                    //                     confirmButtonColor: '#06D177', 
                    //                     confirmButtonText: 'เรียบร้อย'
                    //                 }).then((result) => {
                    //                     if (result.isConfirmed) {                  
                    //                     // window.location="{{url('plan_control')}}";
                    //                     window.location.reload();
                    //                     }
                    //                 })      
                    //                 }
                    //             }
                    //         });
                    // });

                          
            });
           
        </script>    
        <script>
                $(document).on('click', '.edit_data_sub', function() {
                    var plan_control_activity_sub_id = $(this).val();
                    $('#DetailsubModal').modal('show');
                    $.ajax({
                        type: "GET",
                        url: "{{ url('plan_control_subhosactivity_sub_edit') }}" + '/' + plan_control_activity_sub_id,
                        success: function(data) {
                            $('#editsub_plan_control_id').val(data.budget.plan_control_id) 
                            $('#editsub_plan_control_activity_id').val(data.budget.plan_control_activity_id)
                            $('#editsub_plan_control_activity_sub_id').val(data.budget.plan_control_activity_sub_id)
                        },
                    });
                });
                $('#SaveDetailsubBtn').click(function() {
                        var plan_list_budget_id            = $('#subplan_list_budget_id').val();
                        var plan_control_budget_price      = $('#subplan_control_budget_price').val();  
                        var plan_control_id                = $('#editsub_plan_control_id').val();      
                        var plan_control_activity_id       = $('#editsub_plan_control_activity_id').val();
                        var plan_control_activity_sub_id   = $('#editsub_plan_control_activity_sub_id').val(); 
                        
                        
                    $.ajax({
                        url: "{{ route('p.plan_control_subhosactivity_subupdate') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            plan_list_budget_id,plan_control_activity_id,billno,plan_control_id,plan_control_budget_price,plan_control_activity_sub_id
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
        </script>
       
    @endsection
