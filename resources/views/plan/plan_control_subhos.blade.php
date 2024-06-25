@extends('layouts.plannew')
@section('title', 'PK-OFFICER || Plan')
@section('content')
    <style>
        #button {
            display: block;
            margin: 20px auto;
            padding: 30px 30px;
            background-color: #eee;
            border: solid #ccc 1px;
            cursor: pointer;
        }

        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
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

        .is-hide {
            display: none;
        }

        .modal-dialog {
            max-width: 60%;
        }
        .modal-dialog-slideout {
            min-height: 100%;
            margin:auto 0 0 0 ;   /*  ซ้าย ขวา */
            background: #fff;
        }
        .modal.fade .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(100%, 0)scale(30);
            transform: translate(100%, 0)scale(5);
        }
        .modal.fade.show .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(0, 0);
            transform: translate(0, 0);
            display: flex;
            align-items: stretch;
            -webkit-box-align: stretch;
            height: 100%;
        }
        .modal.fade.show .modal-dialog.modal-dialog-slideout .modal-body {
            overflow-y: auto;
            overflow-x: hidden;
            /* overflow-y: hidden;
            overflow-x: auto; */
        }
        .modal-dialog-slideout .modal-content {
            border: 0;
        }
        .modal-dialog-slideout .modal-header,
        .modal-dialog-slideout .modal-footer {
            height: 4rem;
            display: block;
        }
        .datepicker {
            z-index: 2051 !important;
        }
        .badge-primary {
            color: #fff;
            }

            .badge {
            display: inline-block;
            /* padding: .4em .4em .4em .4em; */
            font-size: 100%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 100%;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out,
                border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }

            /*Animation*/

            @-webkit-keyframes pulse {
            0% {
                -webkit-transform: scale(0.9);
                opacity: 0.7;
            }
            50% {
                -webkit-transform: scale(1);
                opacity: 1;
            }
            100% {
                -webkit-transform: scale(0.9);
                opacity: 0.7;
            }
            }

            @keyframes pulse {
            0% {
                transform: scale(0.9);
                opacity: 0.7;
            }
            50% {
                transform: scale(1);
                opacity: 1;
            }
            100% {
                transform: scale(0.9);
                opacity: 0.7;
            }
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
        function plan_control_destroy(plan_control_id)
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
                    url:"{{url('plan_control_destroy')}}" +'/'+ plan_control_id,  
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
                            $("#sid"+plan_control_id).remove();     
                            window.location.reload(); 
                            //   window.location = "/person/person_index"; //     
                            }
                        }) 
                    }
                })        
                }
            })
        }

        function subkpi_destroy(plan_control_id)
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
                    url:"{{url('subkpi_destroy')}}" +'/'+ plan_control_id,  
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
                            $("#sid"+plan_control_id).remove();     
                            window.location.reload(); 
                            //   window.location = "/person/person_index"; //     
                            }
                        }) 
                    }
                })        
                }
            })
        }

        function subobj_destroy(plan_control_id)
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
                    url:"{{url('subobj_destroy')}}" +'/'+ plan_control_id,  
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
                            $("#sid"+plan_control_id).remove();     
                            window.location.reload(); 
                            //   window.location = "/person/person_index"; //     
                            }
                        }) 
                    }
                })        
                }
            })
        }

        function plan_control_ssj(plan_control_id)
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
                    url:"{{url('plan_control_ssj')}}" +'/'+ plan_control_id,  
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
                            $("#sid"+plan_control_id).remove();     
                            window.location.reload(); 
                            //   window.location = "/person/person_index"; //     
                            }
                        }) 
                    }
                })        
                }
            })
        }

        function plan_control_po(plan_control_id)
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
                    url:"{{url('plan_control_po')}}" +'/'+ plan_control_id,  
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
                            $("#sid"+plan_control_id).remove();     
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
        $iddep = Auth::user()->dep_subsubtrueid;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    
    $datenow = date('Y-m-d');
    $y = date('Y') + 543;
    $newweek = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
    $newDate = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\PlanController;
    use App\Models\Plan_control_money;
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
                        
                        @if ($id == '1')
                            <h4 class="mb-sm-0">ทะเบียนควบคุมแผนงานโครงการ Hospital PP&P Excellence</h4>
                        @elseif ($id == '2')
                            <h4 class="mb-sm-0">ทะเบียนควบคุมแผนงานโครงการ Hospital Service Excellence</h4>
                        @elseif ($id == '3')
                            <h4 class="mb-sm-0">ทะเบียนควบคุมแผนงานโครงการ Hospital People Excellence</h4>
                        @else
                            <h4 class="mb-sm-0">ทะเบียนควบคุมแผนงานโครงการ Hospital Governance Excellence</h4>
                        @endif
        
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                @if ($id == '1') 
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">ทะเบียนควบคุมแผนงานโครงการ Hospital PP&P Excellence</a></li>
                                @elseif ($id == '2') 
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">ทะเบียนควบคุมแผนงานโครงการ Hospital Service Excellence</a></li>
                                @elseif ($id == '3') 
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">ทะเบียนควบคุมแผนงานโครงการ Hospital People Excellence </a></li>
                                @else 
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">ทะเบียนควบคุมแผนงานโครงการ Hospital Governance Excellence</a></li>
                                @endif
                                
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
                  
                    <div class="card-body p-3">
                        <div class="row mb-3"> 
                            <div class="col-md-7 text-start"> 
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
                            </div>
                            <div class="col"></div>
                            <div class="col-md-2 text-end"> 
                                <a href="{{ url('plan_control_subhos_add/'.$id) }}" class="ladda-button me-2 btn-pill btn btn-primary cardacc" target="_blank">
                                    <i class="fa-solid fa-folder-plus me-2"></i>
                                    เพิ่มทะเบียน
                                </a> 
                            </div>
                        </div>
                        {{-- <div class="table-responsive">       --}}
                                <table id="example" class="table table-striped table-bordered myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr style="font-size: 13px">
                                            <th width="5%" class="text-center">ลำดับ</th>
                                            <th class="text-center">สถานะ</th> 
                                            <th class="text-center"> แผนงาน/โครงการ</th> 
                                            <th class="text-center">งบประมาณ</th> 
                                            <th class="text-center">เบิก</th> 
                                            <th class="text-center">คงเหลือ</th> 
                                            <th width="10%" class="text-center">จัดการ</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($plan_control as $va)
                                        
                                            <tr id="sid{{ $va->plan_control_id }}">
                                                <td class="text-center" width="4%">{{ $i++ }}</td>
                                                <td width="5%">
                                                    @if ($va->status == 'REQUEST')
                                                        <div id="request"> 
                                                            <span class="badge badge badge-secondary"></span>
                                                        </div> 
                                                    @elseif ($va->status == 'ACCEPT')
                                                        <div id="accept"> 
                                                            <span class="badge badge badge-secondary"></span>
                                                        </div>
                                                    @elseif ($va->status == 'VERIFY')
                                                        <div id="verify"> 
                                                            <span class="badge badge badge-secondary"></span>
                                                        </div>
                                                    @elseif ($va->status == 'FINISH') 
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
                                                    <?php 
                                                        $data_sub_ = DB::connection('mysql')->select('SELECT * from plan_control_kpi WHERE plan_control_id = "'.$va->plan_control_id.'"'); 
                                                        $data_subobj_ = DB::connection('mysql')->select('SELECT * from plan_control_obj WHERE plan_control_id = "'.$va->plan_control_id.'"'); 
                                                        $data_sumprice_ = DB::connection('mysql')->select('SELECT sum(budget_price) as budget_price from plan_control_activity WHERE plan_control_id = "'.$va->plan_control_id.'"'); 
                                                        foreach ($data_sumprice_ as $key => $value_price) {
                                                            $plan_price = $value_price->budget_price;
                                                        }
                                                        $datapay_ = DB::select('
                                                            SELECT SUM(sum_total) as total FROM plan_control_budget_pay 
                                                            WHERE plan_control_id = "'.$va->plan_control_id.'" 
                                                        ');
                                                        foreach ($datapay_ as $key => $value_pay) {
                                                            $datapay     = $value_pay->total;
                                                        }
                                                    ?>                                                   
                                                    <div id="headingTwo" class="b-radius-0">                                                         
                                                            <button type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#collapseOne2{{ $va->plan_control_id }}" aria-expanded="false"
                                                                aria-controls="collapseTwo" class="text-start m-0 p-0 btn btn-link btn-block">
                                                                <h6 style="color: rgb(66, 63, 63)">{{ $va->plan_name }} ||<label for="" style="color: red">_KPI_ </label>||</h6> 
                                                            </button> 
                                                            <button type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#collapseOne3{{ $va->plan_control_id }}" aria-expanded="false"
                                                                aria-controls="collapseTree" class="text-start m-0 p-0 btn btn-link btn-block">
                                                                <h6 style="color: rgb(66, 63, 63)"><label for="" style="color: rgb(16, 130, 236)">_วัตถุประสงค์_</label>||</h6> 
                                                            </button> 
                                                    </div>                                                    
                                                    <div data-parent="#accordion" id="collapseOne2{{ $va->plan_control_id }}" class="collapse">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <h6 style="color: red"> *** KPI</h6> 
                                                                @foreach ($data_sub_ as $itemsub)
                                                                    <div class="col-md-12 mb-2">
                                                                        @if ($itemsub->plan_control_kpi_name != '')
                                                                            <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-white" onclick="subkpi_destroy({{ $va->plan_control_id }})">
                                                                            <h6 style="color: red"> {{$itemsub->plan_control_kpi_name}} </h6>
                                                                            </button>
                                                                        @else                                                                    
                                                                        @endif 
                                                                    </div> 
                                                                @endforeach 
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div data-parent="#accordion" id="collapseOne3{{ $va->plan_control_id }}" class="collapse">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <h6 style="color: rgb(16, 130, 236)"> *** วัตถุประสงค์</h6> 
                                                                @foreach ($data_subobj_ as $sub_obj)
                                                                    <div class="col-md-12 mb-2">
                                                                        @if ($sub_obj->plan_control_obj_name != '')
                                                                            <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-white" onclick="subobj_destroy({{ $va->plan_control_id }})">
                                                                            <h6 style="color: rgb(16, 130, 236)"> {{$sub_obj->plan_control_obj_name}} </h6>
                                                                            </button>
                                                                        @else                                                                    
                                                                        @endif 
                                                                    </div> 
                                                                @endforeach 
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </td> 
                                                <td class="text-center" width="10%">{{ number_format($plan_price, 2) }}</td>
                                                <td class="text-center" width="8%">{{number_format($datapay, 2)}}</td>                                        
                                                <td class="text-center" width="8%">{{ number_format(($plan_price)-($datapay), 2) }}</td>

                                                 
                                                <td width="5%">
                                                    <div class="dropdown">
                                                        <button class="btn btn-outline-primary dropdown-toggle menu btn-sm"
                                                            type="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">ทำรายการ</button>
                                                        <ul class="dropdown-menu">
                                                                <button type="button" class="dropdown-item menu btn btn-outline-info btn-sm ojectModal_"  value="{{ $va->plan_control_id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="วัตถุประสงค์"> 
                                                                    <i class="fa-brands fa-opera me-3 mb-1" style="font-size:17px;color: rgb(40, 177, 246)"></i> 
                                                                    <label for=""
                                                                    style="color: rgb(34, 148, 255);font-size:13px">วัตถุประสงค์</label> 
                                                                </button>
                                                                <button type="button" class="dropdown-item menu btn btn-outline-info btn-sm kpiModal_"  value="{{ $va->plan_control_id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="ตัวชี้วัด"> 
                                                                    <i class="fa-brands fa-korvue me-3 mb-1" style="font-size:17px;color: rgb(34, 148, 255)"></i>  
                                                                    <label for=""
                                                                    style="color: rgb(34, 148, 255);font-size:13px">ตัวชี้วัด KPI</label>
                                                                </button>
                                                            
                                                                {{-- <button type="button" class="dropdown-item menu btn btn-outline-info btn-sm MoneyModal_"  value="{{ $va->plan_control_id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="เบิกเงิน"> 
                                                                    <i class="fa-brands fa-bitcoin me-3 mb-1" style="font-size:17px;color: rgb(20, 199, 190)"></i> 
                                                                    <label for=""
                                                                    style="color: rgb(20, 199, 190);font-size:13px">เบิกเงิน</label>
                                                                </button>  --}}
                                                                <a type="button" href="{{ url('plan_control_subhosactivity/' . $id.'/'. $va->plan_control_id) }}"
                                                                    class="dropdown-item menu btn btn-outline-warning btn-sm" data-bs-toggle="tooltip"
                                                                    data-bs-placement="left" title="แผนงาน/กิจกรรม" target="_blank">
                                                                    <i class="fa-solid fa-people-robbery me-3 mb-1" style="color: rgb(211, 31, 172);font-size:13px"></i>
                                                                        <label for=""
                                                                        style="color: rgb(211, 31, 172);font-size:13px">แผนงาน/กิจกรรม</label> 
                                                                </a>
                                                                {{-- <a class="dropdown-item menu btn btn-outline-info btn-sm" href="javascript:void(0)"
                                                                    onclick="plan_control_ssj({{ $va->plan_control_id}})"
                                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                                    data-bs-custom-class="custom-tooltip" title="เสนอ สสจ. อนุมัติ">
                                                                    <i class="fa-solid fa-signature me-3 mb-1"></i>
                                                                    <label for="" style="color: rgb(7, 166, 194);font-size:13px">เสนอ สสจ. อนุมัติ</label>
                                                                </a> --}}
                                                                <a class="dropdown-item menu btn btn-outline-primary btn-sm" href="javascript:void(0)"
                                                                    onclick="plan_control_po({{ $va->plan_control_id}})"
                                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                                    data-bs-custom-class="custom-tooltip" title="เสนอ ผอ. อนุมัติ"> 
                                                                    <i class="fa-solid fa-signature me-3 mb-1" ></i>
                                                                    <label for="" style="color: rgb(7, 110, 194);font-size:13px">เสนอ ผอ. อนุมัติ</label>
                                                                </a>
                                                                <a type="button" href="{{ url('plan_control_subhos_edit/' . $va->plan_control_id) }}"
                                                                    class="dropdown-item menu btn btn-outline-warning btn-sm" data-bs-toggle="tooltip"
                                                                    data-bs-placement="left" title="แก้ไข" target="_blank">
                                                                    <i class="fa-solid fa-pen-to-square me-3 mb-1" style="color: rgb(252, 185, 0);font-size:13px"></i>
                                                                        <label for=""
                                                                        style="color: rgb(252, 185, 0);font-size:13px">แก้ไข</label>
                                                                </a>
 
                                                                <a class="dropdown-item menu btn btn-outline-danger btn-sm" href="javascript:void(0)"
                                                                    onclick="plan_control_destroy({{ $va->plan_control_id}})"
                                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                                    data-bs-custom-class="custom-tooltip" title="ลบ">
                                                                    <i class="fa-solid fa-trash-can me-3 mb-1"></i>
                                                                    <label for=""
                                                                        style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
                                                                </a>
                                                        </ul>
                                                    </div>
                                                
                                                </td>
                
                                            </tr>
    
                                            <div class="modal fade" id="UpdateModal{{ $va->plan_control_id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myExtraLargeModalLabel">
                                                                แก้ไขทะเบียนควบคุมแผนงานโครงการ</h5>
                                                            <h6 class="mt-2">{{ $va->billno }} </h6>
                                                            <input id="billno" class="form-control form-control-sm"
                                                                name="billno" type="hidden" value="{{ $va->billno }}">
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12 ">
                                                                    <label for="">ชื่อโครงการ</label>
                                                                    <div class="form-group">
                                                                        <input id="plan_name"
                                                                            class="form-control form-control-sm"
                                                                            name="plan_name">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-md-3 ">
                                                                    <label for="">ระยะเวลา วันที่</label>
                                                                    <div class="form-group"> 
                                                                        <div class="input-daterange input-group"
                                                                            id="datepicker1" data-date-format="dd M, yyyy"
                                                                            data-date-autoclose="true"
                                                                            data-provide="datepicker"
                                                                            data-date-container='#datepicker1'>
                                                                            <input type="text" class="form-control"
                                                                                name="startdate" id="startdate"
                                                                                placeholder="Start Date"
                                                                                data-date-container='#datepicker1'
                                                                                data-provide="datepicker"
                                                                                data-date-autoclose="true" autocomplete="off"
                                                                                data-date-language="th-th"
                                                                                value="{{ $datenow }}" required />

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 ">
                                                                    <label for="">ถึง </label>
                                                                    <div class="form-group">
                                                                        {{-- <input id="plan_endtime" class="form-control form-control-sm" name="plan_endtime"> --}}
                                                                        <div class="input-daterange input-group"
                                                                            id="datepicker1" data-date-format="dd M, yyyy"
                                                                            data-date-autoclose="true"
                                                                            data-provide="datepicker"
                                                                            data-date-container='#datepicker1'>

                                                                            <input type="text" class="form-control"
                                                                                name="enddate" placeholder="End Date"
                                                                                id="enddate"
                                                                                data-date-container='#datepicker1'
                                                                                data-provide="datepicker"
                                                                                data-date-autoclose="true" autocomplete="off"
                                                                                data-date-language="th-th"
                                                                                value="{{ $datenow }}" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 ">
                                                                    <label for="">งบประมาณ </label>
                                                                    <div class="form-group">
                                                                        <input id="edit_plan_price"
                                                                            class="form-control form-control-sm"
                                                                            name="plan_price">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 ">
                                                                    <label for="">แหล่งงบ </label>
                                                                    <div class="form-group">
                                                                        <select name="edit_plan_type" id="edit_plan_type"
                                                                            class="form-control form-control-sm"
                                                                            style="width: 100%">
                                                                            @foreach ($plan_control_type as $item2)
                                                                                <option
                                                                                    value="{{ $item2->plan_control_type_id }}">
                                                                                    {{ $item2->plan_control_typename }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-md-8 ">
                                                                    <label for="">กลุ่มงาน </label>
                                                                    <div class="form-group">
                                                                        <select name="department" id="department"
                                                                            class="form-control form-control-sm"
                                                                            style="width: 100%">
                                                                            {{-- <option value="">=เลือก=</option> --}}
                                                                            @foreach ($department_sub_sub as $item)
                                                                                @if ($iddep == $item->DEPARTMENT_SUB_SUB_ID)
                                                                                    <option
                                                                                        value="{{ $item->DEPARTMENT_SUB_SUB_ID }}"
                                                                                        selected>
                                                                                        {{ $item->DEPARTMENT_SUB_SUB_NAME }}
                                                                                    </option>
                                                                                @else
                                                                                    <option
                                                                                        value="{{ $item->DEPARTMENT_SUB_SUB_ID }}">
                                                                                        {{ $item->DEPARTMENT_SUB_SUB_NAME }}
                                                                                    </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4 ">
                                                                    <label for="">ผู้รับผิดชอบ </label>
                                                                    <div class="form-group">
                                                                        <select name="user_id" id="user_id"
                                                                            class="form-control form-control-sm"
                                                                            style="width: 100%">
                                                                            @foreach ($users as $item3)
                                                                                <option value="{{ $item3->id }}">
                                                                                    {{ $item3->fname }} {{ $item3->lname }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <div class="col-md-12 text-end">
                                                                <div class="form-group">
                                                                    <button type="button" id="SaveBtn"
                                                                        class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-info">
                                                                        <i class="fa-solid fa-floppy-disk me-2"></i>
                                                                        บันทึกข้อมูล
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-danger"
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
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ObjModalModal" tabindex="-1"
        role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h2>เพิ่มวัตถุประสงค์</h2>
                    
                </div>
                <input id="obj_billno" class="form-control form-control-sm" name="obj_billno" type="hidden" >
                <input id="obj_plan_control_id" class="form-control form-control-sm" name="obj_plan_control_id" type="hidden" >

                <div class="modal-body">
                    <div class="row mt-3">
                                    
                        <div class="col-md-2 text-end mt-2"> 
                            <p for="">วัตถุประสงค์</p> 
                        </div>
                        <div class="col-md-9 "> 
                            <div class="form-group">
                                <input id="plan_control_obj_name" class="form-control form-control-sm" name="plan_control_obj_name">
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

    <div class="modal fade" id="kpiModalModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h2>เพิ่มตัวชี้วัด</h2>                
                </div>
                <input id="kpi_billno" class="form-control form-control-sm" name="kpi_billno" type="hidden" >
                <input id="kpi_plan_control_id" class="form-control form-control-sm" name="kpi_plan_control_id" type="hidden" >
                <div class="modal-body">
                    <div class="row mt-3">
                                    
                        <div class="col-md-2 text-end mt-2"> 
                            <p for="">ตัวชี้วัด</p> 
                        </div>
                        <div class="col-md-9 "> 
                            <div class="form-group">
                                <input id="plan_control_kpi_name" class="form-control form-control-sm" name="plan_control_kpi_name">
                            </div>
                        </div>
                        <div class="col"></div>                  
                    </div>
                    
                </div>  
                <div class="modal-footer">
                
                        <button type="button" id="SaveKpiBtn"
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

    <div class="modal fade" id="MoneyModal" tabindex="-1"
        role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            {{-- <div class="modal-dialog modal-dialog-slideout"> --}}
            <div class="modal-content">
                <div class="modal-header">
                    
                    {{-- <div class="row"> --}}
                        {{-- <div class="col-md-12 text-start"> --}}
                            <h2>เบิกเงินทะเบียนควบคุมแผนงานโครงการ</h2>
                         {{-- </div> --}}
                        {{-- <div class="col"></div> --}}
                        {{-- <div class="col-md-3 text-end">
                            <button class="btn-icon btn-shadow btn-dashed btn btn-outline-success"> 
                                ครั้งที่  {{$maxno}} 
                            </button>
                        </div> --}}
                    {{-- </div> --}}
                
                </div>
                <input id="plan_control_money_no" class="form-control form-control-sm" name="plan_control_money_no" type="hidden" >
                <input id="update_plan_control_id" class="form-control form-control-sm" name="update_plan_control_id" type="hidden" >

                <div class="modal-body">
                    <div class="row mt-5">
                        <div class="col-md-2 text-end mt-2"> 
                            <p for="">วันที่</p>
                             
                        </div>
                        <div class="col-md-3"> 
                            <input type="text" id="plan_control_moneydate" class="form-control" data-toggle="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker" data-date-language="th-th" autocomplete="off" value="{{ $datenow }}">
           
                        </div>
                        <div class="col-md-1 text-start"><i class="fa-solid fa-calendar-days mt-2"></i> </div>
                        <div class="col-md-2 text-end mt-2"> 
                            <p for="">ยอดเบิก</p>
                             
                        </div>
                        <div class="col-md-3 "> 
                            <div class="form-group">
                                <input id="plan_control_moneyprice"
                                    class="form-control form-control-sm"
                                    name="plan_control_moneyprice">
                            </div>
                        </div>
                        <div class="col-md-1 text-start mt-2"> <p for="">บาท</p> </div>
                      
                    </div>
                     <div class="row mt-2">
                        <div class="col-md-2 text-end"> <p for="">ผู้เบิก </p> </div>
                        <div class="col-md-10"> 
                            <div class="form-group">
                                <select name="plan_control_moneyuser_id" id="plan_control_moneyuser_id"
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
                        <div class="col-md-2 text-end"> <p for="">หมายเหตุ </p> </div>
                        <div class="col-md-10"> 
                            <textarea name="plan_control_moneycomment" id="plan_control_moneycomment" class="form-control form-control-sm" rows="4"></textarea>
                        </div>
                    </div>
                  
                </div>

                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="button" id="SaveMoneyBtn"
                                class="btn-icon btn-shadow btn-dashed btn btn-outline-info me-2">
                                {{-- <i class="fa-solid fa-floppy-disk me-2"></i> --}}
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

    <!--  Modal content for the insert example -->
    <div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">เพิ่มทะเบียนควบคุมแผนงานโครงการ</h5>
                    <h6 class="mt-2">{{ $refnumber }} </h6>
                    <input id="billno" class="form-control form-control-sm" name="billno" type="hidden"
                        value="{{ $refnumber }}">
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 ">
                            <label for="">ชื่อโครงการ</label>
                            <div class="form-group">
                                <input id="plan_name" class="form-control form-control-sm" name="plan_name">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3 ">
                            <label for="">ระยะเวลา วันที่</label>
                            <div class="form-group">
                                {{-- <input id="plan_starttime" class="form-control form-control-sm" name="plan_starttime"> --}}
                                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                    data-date-autoclose="true" data-provide="datepicker"
                                    data-date-container='#datepicker1'>
                                    <input type="text" class="form-control" name="startdate" id="startdate"
                                        placeholder="Start Date" data-date-container='#datepicker1'
                                        data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                        data-date-language="th-th" value="{{ $datenow }}" required />

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 ">
                            <label for="">ถึง </label>
                            <div class="form-group">
                                {{-- <input id="plan_endtime" class="form-control form-control-sm" name="plan_endtime"> --}}
                                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                    data-date-autoclose="true" data-provide="datepicker"
                                    data-date-container='#datepicker1'>

                                    <input type="text" class="form-control" name="enddate" placeholder="End Date"
                                        id="enddate" data-date-container='#datepicker1' data-provide="datepicker"
                                        data-date-autoclose="true" autocomplete="off" data-date-language="th-th"
                                        value="{{ $datenow }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 ">
                            <label for="">งบประมาณ </label>
                            <div class="form-group">
                                <input id="plan_price" class="form-control form-control-sm" name="plan_price">
                            </div>
                        </div>
                        <div class="col-md-3 ">
                            <label for="">แหล่งงบ </label>
                            <div class="form-group">
                                <select name="plan_type" id="plan_type" class="form-control form-control-sm"
                                    style="width: 100%">
                                    @foreach ($plan_control_type as $item2)
                                        <option value="{{ $item2->plan_control_type_id }}">
                                            {{ $item2->plan_control_typename }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row mt-2">
                        <div class="col-md-8 ">
                            <label for="">กลุ่มงาน </label>
                            <div class="form-group">
                                <select name="department" id="department" class="form-control form-control-sm"
                                    style="width: 100%">
                                    {{-- <option value="">=เลือก=</option> --}}
                                    @foreach ($department_sub_sub as $item)
                                        @if ($iddep == $item->DEPARTMENT_SUB_SUB_ID)
                                            <option value="{{ $item->DEPARTMENT_SUB_SUB_ID }}" selected>
                                                {{ $item->DEPARTMENT_SUB_SUB_NAME }}</option>
                                        @else
                                            <option value="{{ $item->DEPARTMENT_SUB_SUB_ID }}">
                                                {{ $item->DEPARTMENT_SUB_SUB_NAME }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 ">
                            <label for="">ผู้รับผิดชอบ </label>
                            <div class="form-group">
                                <select name="user_id" id="user_id" class="form-control form-control-sm"
                                    style="width: 100%">
                                    @foreach ($users as $item3)
                                        <option value="{{ $item3->id }}">{{ $item3->fname }} {{ $item3->lname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="button" id="SaveBtn"
                                class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-info">
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                บันทึกข้อมูล
                            </button>
                            <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-danger"
                                data-bs-dismiss="modal"><i class="fa-solid fa-xmark me-2"></i>Close</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('footer')
    <script>
        function details(id){
                $.ajax({
                        url:"{{route('p.detail_plan')}}",
                        method:"GET",
                        data:{id:id},
                        success:function(result){
                            $('#details').html(result); 
                        } 
                }) 
            }
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
           
            $('#startdate').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#enddate').datepicker({
                format: 'yyyy-mm-dd'
            });
           
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
           
            $('[data-toggle="datepicker"]').datepicker({ 
                autoHide: true,
                zIndex: 2048,
            });
             
            $('select').select2();
            $('#plan_control_moneyuser_id').select2({
                dropdownParent: $('#MoneyModal')
            });

            $('#edit_plan_type').select2({
                dropdownParent: $('#UpdateModal')
            });
            
          
            $('#plan_type').select2({
                dropdownParent: $('#insertModal')
            });
            $('#department').select2({
                dropdownParent: $('#insertModal')
            });
            $('#user_id').select2({
                dropdownParent: $('#insertModal')
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#SaveBtn').click(function() {
                var plan_name = $('#plan_name').val();
                var datepicker1 = $('#startdate').val();
                var datepicker2 = $('#enddate').val();
                var plan_price = $('#plan_price').val();
                var department = $('#department').val();
                var plan_type = $('#plan_type').val();
                var user_id = $('#user_id').val();
                var billno = $('#billno').val();
                // alert(datepicker1);
                $.ajax({
                    url: "{{ route('p.plan_control_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        plan_name,
                        datepicker1,
                        datepicker2,
                        plan_price,
                        department,
                        plan_type,
                        user_id,
                        billno
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

                                    window.location
                                        .reload();
                                }
                            })
                        } else {

                        }

                    },
                });
            });

            $(document).on('click', '.edit_data', function() {
                var audiovisual_id = $(this).val();
                $('#UpdateModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('audiovisual_work_detail') }}" + '/' + audiovisual_id,
                    success: function(data) {
                        $('#edit_ptname').val(data.work.ptname)
                        $('#edit_tel').val(data.work.tel)
                        $('#edit_work_order_date').val(data.work.work_order_date)
                        $('#edit_job_request_date').val(data.work.job_request_date)
                        $('#edit_department').val(data.work.department)
                        $('#edit_audiovisual_type').val(data.work.audiovisual_type)
                        $('#edit_audiovisual_name').val(data.work.audiovisual_name)
                        $('#edit_audiovisual_qty').val(data.work.audiovisual_qty)
                        $('#edit_audiovisual_detail').val(data.work.audiovisual_detail)
                        $('#edit_audiovisual_id').val(data.work.audiovisual_id)
                    },
                });
            });

            $(document).on('click', '.MoneyModal_', function() {
                var plan_control_id = $(this).val();
                $('#plan_control_moneydate').datepicker();
                // alert(plan_control_id);
                $('#MoneyModal').modal('show');
                
                $.ajax({
                    type: "GET",
                    url: "{{ url('plan_control_moneyedit') }}" + '/' + plan_control_id,
                    success: function(data) { 
                        $('#update_plan_control_id').val(data.data_show.plan_control_id)
                        $('#data_sub_count').val(data.data_show.plan_control_money_no)
                    },
                });
            });

            $('#SaveMoneyBtn').click(function() {
                var plan_control_money_no = $('#plan_control_money_no').val();
                var plan_control_moneydate = $('#plan_control_moneydate').val();
                var plan_control_moneyprice = $('#plan_control_moneyprice').val();
                var plan_control_moneyuser_id = $('#plan_control_moneyuser_id').val();
                var plan_control_moneycomment = $('#plan_control_moneycomment').val();
                var update_plan_control_id = $('#update_plan_control_id').val();
                
                $.ajax({
                    url: "{{ route('p.plan_control_repmoney') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        plan_control_money_no,
                        plan_control_moneydate,
                        plan_control_moneyprice,
                        plan_control_moneyuser_id,
                        plan_control_moneycomment ,
                        update_plan_control_id
                    },
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

            $(document).on('click', '.kpiModal_', function() {
                var plan_control_id = $(this).val(); 
                $('#kpiModalModal').modal('show');
                
                $.ajax({
                    type: "GET",
                    url: "{{ url('plan_control_moneyedit') }}" + '/' + plan_control_id,
                    success: function(data) { 
                        $('#kpi_plan_control_id').val(data.data_show.plan_control_id)
                        $('#kpi_billno').val(data.data_show.billno)
                    },
                });
            });
            $('#SaveKpiBtn').click(function() { 
                var plan_control_kpi_name    = $('#plan_control_kpi_name').val();
                var kpi_plan_control_id      = $('#kpi_plan_control_id').val();
                var kpi_billno               = $('#kpi_billno').val();
                // alert(kpi_billno);
                $.ajax({
                    url: "{{ route('p.plan_control_kpi_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: { kpi_plan_control_id, plan_control_kpi_name,kpi_billno},
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'เพิ่มตัวชี้วัดสำเร็จ',
                                text: "You Insert KPI success",
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

            $(document).on('click', '.ojectModal_', function() {
                var plan_control_id = $(this).val(); 
                $('#ObjModalModal').modal('show');
                
                $.ajax({
                    type: "GET",
                    url: "{{ url('plan_control_moneyedit') }}" + '/' + plan_control_id,
                    success: function(data) { 
                        $('#obj_plan_control_id').val(data.data_show.plan_control_id)
                        $('#obj_billno').val(data.data_show.billno)
                    },
                });
            });
            $('#SaveObjectBtn').click(function() { 
                var plan_control_obj_name    = $('#plan_control_obj_name').val();
                var obj_plan_control_id      = $('#obj_plan_control_id').val();
                var obj_billno               = $('#obj_billno').val();
                // alert(obj_billno);
                $.ajax({
                    url: "{{ route('p.plan_control_obj_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: { obj_plan_control_id, plan_control_obj_name,obj_billno},
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'เพิ่มวัตถุประสงค์สำเร็จ',
                                text: "You Insert Obj success",
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
