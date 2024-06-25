@extends('layouts.support_prs')
@section('title', 'PK-OFFICER || Air-Service')

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
        function air_main_repaire_destroy(air_repaire_id) {
            Swal.fire({
                position: "top-end",
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
                        url: "{{ url('air_main_repaire_destroy') }}" + '/' + air_repaire_id,
                        type: 'POST',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            if (response.status == 200 ) {
                                Swal.fire({
                                    position: "top-end",
                                    title: 'ลบข้อมูล!',
                                    text: "You Delet data success",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#06D177',
                                    // cancelButtonColor: '#d33',
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $("#sid" + air_repaire_id).remove();
                                        window.location.reload();
                                        // window.location = "{{ url('air_main') }}";
                                    }
                                })
                            } else {  
                            }
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
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    
    ?>

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
            border: 5px #ddd solid;
            border-top: 10px #12c6fd solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }

        .is-hide {
            display: none;
        }
    </style>

    <?php
    $ynow = date('Y') + 543;
    $yb = date('Y') + 542;
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
    <form action="{{ url('air_report_type') }}" method="GET">
        @csrf
        <div class="row"> 
            <div class="col-md-6">
                <h4 style="color:rgb(10, 151, 85)">รายงานการบำรุงรักษาเครื่องปรับอากาศ แยกตามประเภทการซ่อมและบำรุงรักษาประจำปี</h4>
                {{-- <p class="card-title-desc">รายงานถังดับเพลิง</p> --}}
            </div>
            <div class="col-md-2 text-center">
                <select class="form-control cardacc" id="air_repaire_type" name="air_repaire_type" style="width: 100%" required>
                    <option value="" class="text-center">--เลือกประเภท--</option>
                        @foreach ($air_repaire_type as $item_t)
                        @if ($repaire_type == $item_t->air_repaire_type_id)
                            <option value="{{ $item_t->air_repaire_type_id }}" class="text-center" selected> {{ $item_t->air_repaire_typename }}</option>
                        @else
                            <option value="{{ $item_t->air_repaire_type_id }}" class="text-center"> {{ $item_t->air_repaire_typename }}</option>
                        @endif 
                        @endforeach 
                </select>
            </div>
         
            <div class="col-md-4 text-end"> 
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control cardacc" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control cardacc" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>  
                        <button type="submit" class="ladda-button btn-pill btn btn-primary cardacc" data-style="expand-left">
                            <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span> 
                        </button> 
                  
                </div> 
            </div>
        </div>  
    </form>
<div class="row mt-4">
    <div class="col-xl-12">
        <div class="card card_prs_4">
            <div class="card-body">    
                <div class="row mb-3">
                    <div class="col"></div> 
                    @if ($repaire_type =='1')
                        <div class="col-md-5 text-end">  
                            <button class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(236, 232, 181)"><i class="fa-solid fa-glass-water-droplet me-2" style="color: #B216F0"></i> น้ำหยด</button>                   
                            <button class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(202, 236, 181)"><i class="fab fa-slack me-2" style="color: #07c095"></i> ไม่เย็นมีแต่ลม</button>
                            <button class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(181, 203, 236)"><i class="fa-solid fa-volume-high me-2" style="color: #0760c0"></i> เสียงดัง</button>
                            <button class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(236, 181, 181)"><i class="fa-solid fa-soap me-2" style="color: #c0072f"></i> กลิ่นเหม็น</button>
                            <button class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(209, 181, 236)"><i class="fa-solid fa-tenge-sign me-2" style="color: #8c07c0"></i> ไม่ติด/ติดๆ/ดับๆ</button> 
                        </div> 
                    @else
                        <div class="col-md-6 text-end">
                            <button class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(236, 232, 181)"><i class="fa-solid fa-fan me-2" style="color: #B216F0"></i> ถอดล้างพัดลมกรงกระรอก</button>                   
                            <button class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(202, 236, 181)"><i class="fa-solid fa-hard-drive me-2" style="color: #07c095"></i> ล้างถาดหลังแอร์</button>
                            <button class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(181, 203, 236)"><i class="fa-solid fa-solar-panel me-2" style="color: #0760c0"></i> ล้างแผงคอยล์เย็น</button>
                            <button class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(236, 181, 181)"><i class="fa-solid fa-solar-panel me-2" style="color: #c0072f"></i> ล้างแผงคอยล์ร้อน</button>
                            <button class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(209, 181, 236)"><i class="fa-solid fa-flask-vial me-2" style="color: #8c07c0"></i> ตรวจเช็คน้ำยา</button> 
                        </div> 
                    @endif
                    
                </div>

                <p class="mb-0">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        {{-- <table id="example" class="table table-hover table-sm dt-responsive nowrap" style=" border-spacing: 0; width: 100%;"> --}}
                            <thead>
                                @if ($repaire_type =='1')
                                    <tr style="font-size:13px"> 
                                        <th width="3%" class="text-center">ลำดับ</th>   
                                        {{-- <th class="text-center" width="5%">วันที่ซ่อม</th>    --}}
                                        <th class="text-center" >รายการ</th>  
                                        <th class="text-center" >ขนาด(btu)</th>  
                                        <th class="text-center" >อาคารที่ตั้ง</th>  
                                        <th class="text-center" >หน่วยงาน</th>  
                                        <th class="text-center"><button class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(236, 232, 181)"><i class="fa-solid fa-glass-water-droplet" style="color: #B216F0"></i></button></th> 
                                        <th class="text-center"><button class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(202, 236, 181)"><i class="fab fa-slack" style="color: #07c095"></i> </button></th>
                                        <th class="text-center"> <button class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(181, 203, 236)"><i class="fa-solid fa-volume-high" style="color: #0760c0"></i> </button></th>
                                        <th class="text-center"><button class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(236, 181, 181)"><i class="fa-solid fa-soap" style="color: #c0072f"></i></button></th>
                                        <th class="text-center"><button class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(209, 181, 236)"><i class="fa-solid fa-tenge-sign" style="color: #8c07c0"></i></button> </th>
                                        <th class="text-center">เจ้าหน้าที่</th>
                                        <th class="text-center">ช่างซ่อม(รพ)</th>
                                        <th class="text-center">ช่างแอร์</th>
                                    </tr>
                                @else
                                    <tr style="font-size:13px"> 
                                        <th width="3%" class="text-center">ลำดับ</th>   
                                        {{-- <th class="text-center" width="5%">วันที่ซ่อม</th>    --}}
                                        <th class="text-center" >รายการ</th>  
                                        <th class="text-center" >ขนาด(btu)</th>  
                                        <th class="text-center" >อาคารที่ตั้ง</th>  
                                        <th class="text-center" >หน่วยงาน</th>  
                                        <th class="text-center"><button class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(236, 232, 181)"><i class="fa-solid fa-fan" style="color: #B216F0"></i></button></th> 
                                        <th class="text-center"><button class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(202, 236, 181)"><i class="fa-solid fa-hard-drive" style="color: #07c095"></i> </button></th>
                                        <th class="text-center"> <button class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(181, 203, 236)"><i class="fa-solid fa-solar-panel" style="color: #0760c0"></i> </button></th>
                                        <th class="text-center"><button class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(236, 181, 181)"><i class="fa-solid fa-solar-panel" style="color: #c0072f"></i></button></th>
                                        <th class="text-center"><button class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(209, 181, 236)"><i class="fa-solid fa-flask-vial" style="color: #8c07c0"></i></button> </th>
                                        <th class="text-center">เจ้าหน้าที่</th>
                                        <th class="text-center">ช่างซ่อม(รพ)</th>
                                        <th class="text-center">ช่างแอร์</th>
                                    </tr> 
                                @endif
                               
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow as $item) 
                                
                                    <tr id="tr_{{$item->air_repaire_id}}">                                                  
                                        <td class="text-center" width="3%">{{ $i++ }}</td>   
                                        {{-- <td class="text-center" width="8%">{{ DateThai($item->repaire_date )}}</td>      --}}
                                        {{-- @if ($repaire_type =='1') --}}
                                        <td class="p-2">
                                           <a href="{{url('air_report_typesub/'.$item->air_repaire_id.'/'.$repaire_type.'/'.$startdate.'/'.$enddate)}}">{{ $item->air_list }}</a> 
                                        </td> 
                                        {{-- @else --}}
                                            
                                        {{-- @endif --}}
                                          
                                        <td class="p-2" width="5%">{{ $item->btu }}</td>  
                                        <td class="p-2" width="10%">{{ $item->air_location_name }}</td>  
                                        <td class="p-2" width="10%">{{ $item->debsubsub }}</td>  
                                        <td class="text-center" width="3%"> 
                                            {{-- @if ($item->problems_1 == 'on')
                                            <img src="{{ asset('images/true_sm_50.png') }}" height="5px" width="5px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                            @else 
                                            @endif --}}
                                            @if ($repaire_type =='1')
                                                <?php 
                                                    $datas_count_1= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_1 ="on"');
                                                    foreach ($datas_count_1 as $key => $value) { $count_p1 = $value->c_air_list_num; }
                                                ?> 
                                                 @if ($count_p1 < 1)
                                                    <label for="" style="font-size: 14px;color:rgb(6, 149, 168)">{{$count_p1}}</label>
                                                @else
                                                    <label for="" style="font-size: 14px;color:red">{{$count_p1}}</label>
                                                @endif
                                            @elseif ($repaire_type =='2')
                                                <?php 
                                                    $datas_count_6= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_6 ="on"');
                                                    foreach ($datas_count_6 as $key => $value6) { $count_p6 = $value6->c_air_list_num; }
                                                ?> 
                                                @if ($count_p6 < 1)
                                                    <label for="" style="font-size: 14px;color:rgb(6, 149, 168)">{{$count_p6}}</label>
                                                @else
                                                    <label for="" style="font-size: 14px;color:red">{{$count_p6}}</label>
                                                @endif
                                            @elseif ($repaire_type =='3')
                                                <?php 
                                                    $datas_count_11= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_11 ="on"');
                                                    foreach ($datas_count_11 as $key => $value11) { $count_p11 = $value11->c_air_list_num; }
                                                ?> 
                                                @if ($count_p11 < 1)
                                                    <label for="" style="font-size: 14px;color:rgb(6, 149, 168)">{{$count_p11}}</label>
                                                @else
                                                    <label for="" style="font-size: 14px;color:red">{{$count_p11}}</label>
                                                @endif
                                            @elseif ($repaire_type =='4')
                                                <?php 
                                                    $datas_count_16= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_16 ="on"');
                                                    foreach ($datas_count_16 as $key => $value16) { $count_p16 = $value16->c_air_list_num; }
                                                ?> 
                                                @if ($count_p16 < 1)
                                                    <label for="" style="font-size: 14px;color:rgb(6, 149, 168)">{{$count_p16}}</label>
                                                @else
                                                    <label for="" style="font-size: 14px;color:red">{{$count_p16}}</label>
                                                @endif

                                            @endif
                                        </td> 
                                        <td class="text-center" width="5%"> 
                                            {{-- @if ($item->problems_2 == 'on')
                                            <img src="{{ asset('images/true_sm_50.png') }}" height="5px" width="5px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                            @else 
                                            @endif --}}
                                            @if ($repaire_type =='1')
                                                <?php 
                                                    $datas_count_2= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_2 ="on"');
                                                    foreach ($datas_count_2 as $key => $value2) {$count_p2 = $value2->c_air_list_num; }
                                                ?>
                                                @if ($count_p2 < 1)
                                                    <label for="" style="font-size: 14px;color:rgb(6, 149, 168)">{{$count_p2}}</label>
                                                @else
                                                    <label for="" style="font-size: 14px;color:red">{{$count_p2}}</label>
                                                @endif
                                            @elseif ($repaire_type =='2')
                                                <?php 
                                                    $datas_count_7= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_7 ="on"');
                                                    foreach ($datas_count_7 as $key => $value7) { $count_p7 = $value7->c_air_list_num; }
                                                ?> 
                                                @if ($count_p7 < 1)
                                                    <label for="" style="font-size: 14px;color:rgb(6, 149, 168)">{{$count_p7}}</label>
                                                @else
                                                    <label for="" style="font-size: 14px;color:red">{{$count_p7}}</label>
                                                @endif
                                            @elseif ($repaire_type =='3')
                                                <?php 
                                                    $datas_count_12= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_12 ="on"');
                                                    foreach ($datas_count_12 as $key => $value12) { $count_p12 = $value12->c_air_list_num; }
                                                ?> 
                                                @if ($count_p12 < 1)
                                                    <label for="" style="font-size: 14px;color:rgb(6, 149, 168)">{{$count_p12}}</label>
                                                @else
                                                    <label for="" style="font-size: 14px;color:red">{{$count_p12}}</label>
                                                @endif
                                            @elseif ($repaire_type =='4')
                                                <?php 
                                                    $datas_count_17= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_17 ="on"');
                                                    foreach ($datas_count_17 as $key => $value17) { $count_p17 = $value17->c_air_list_num; }
                                                ?> 
                                                @if ($count_p17 < 1)
                                                    <label for="" style="font-size: 14px;color:rgb(6, 149, 168)">{{$count_p17}}</label>
                                                @else
                                                    <label for="" style="font-size: 14px;color:red">{{$count_p17}}</label>
                                                @endif
                                                 
                                            @endif
                                        </td>
                                        <td class="text-center" width="5%"> 
                                            {{-- @if ($item->problems_3 == 'on')
                                            <img src="{{ asset('images/true_sm_50.png') }}" height="5px" width="5px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                            @else 
                                            @endif --}}
                                            @if ($repaire_type =='1')
                                                <?php 
                                                    $datas_count_3= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_3 ="on"');
                                                    foreach ($datas_count_3 as $key => $value3) {$count_p3 = $value3->c_air_list_num; }
                                                ?>
                                                @if ($count_p3 < 1)
                                                    <label for="" style="font-size: 14px;color:rgb(6, 149, 168)">{{$count_p3}}</label>
                                                @else
                                                    <label for="" style="font-size: 14px;color:red">{{$count_p3}}</label>
                                                @endif
                                            @elseif ($repaire_type =='2')
                                                <?php 
                                                    $datas_count_8= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_8 ="on"');
                                                    foreach ($datas_count_8 as $key => $value8) { $count_p8 = $value8->c_air_list_num; }
                                                ?> 
                                                @if ($count_p8 < 1)
                                                    <label for="" style="font-size: 14px;color:rgb(6, 149, 168)">{{$count_p8}}</label>
                                                @else
                                                    <label for="" style="font-size: 14px;color:red">{{$count_p8}}</label>
                                                @endif
                                            @elseif ($repaire_type =='3')
                                                <?php 
                                                    $datas_count_13= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_13 ="on"');
                                                    foreach ($datas_count_13 as $key => $value13) { $count_p13 = $value13->c_air_list_num; }
                                                ?> 
                                                @if ($count_p13 < 1)
                                                    <label for="" style="font-size: 14px;color:rgb(6, 149, 168)">{{$count_p13}}</label>
                                                @else
                                                    <label for="" style="font-size: 14px;color:red">{{$count_p13}}</label>
                                                @endif
                                            @elseif ($repaire_type =='4')
                                                <?php 
                                                    $datas_count_18= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_18 ="on"');
                                                    foreach ($datas_count_18 as $key => $value18) { $count_p18 = $value18->c_air_list_num; }
                                                ?> 
                                                @if ($count_p18 < 1)
                                                    <label for="" style="font-size: 14px;color:rgb(6, 149, 168)">{{$count_p18}}</label>
                                                @else
                                                    <label for="" style="font-size: 14px;color:red">{{$count_p18}}</label>
                                                @endif
                                                 
                                            @endif
                                        </td>
                                        <td class="text-center" width="5%"> 
                                            {{-- @if ($item->problems_4 == 'on')
                                            <img src="{{ asset('images/true_sm_50.png') }}" height="5px" width="5px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                            @else 
                                            @endif --}}
                                            @if ($repaire_type =='1')
                                                <?php 
                                                    $datas_count_4= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_4 ="on"');
                                                    foreach ($datas_count_4 as $key => $value4) {$count_p4 = $value4->c_air_list_num; }
                                                ?>
                                                @if ($count_p4 < 1)
                                                    <label for="" style="font-size: 14px;color:rgb(6, 149, 168)">{{$count_p4}}</label>
                                                @else
                                                    <label for="" style="font-size: 14px;color:red">{{$count_p4}}</label>
                                                @endif
                                            @elseif ($repaire_type =='2')
                                                <?php 
                                                    $datas_count_9= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_9 ="on"');
                                                    foreach ($datas_count_9 as $key => $value9) { $count_p9 = $value9->c_air_list_num; }
                                                ?> 
                                                @if ($count_p9 < 1)
                                                    <label for="" style="font-size: 14px;color:rgb(6, 149, 168)">{{$count_p9}}</label>
                                                @else
                                                    <label for="" style="font-size: 14px;color:red">{{$count_p9}}</label>
                                                @endif
                                            @elseif ($repaire_type =='3')
                                                <?php 
                                                    $datas_count_14= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_14 ="on"');
                                                    foreach ($datas_count_14 as $key => $value14) { $count_p14 = $value14->c_air_list_num; }
                                                ?> 
                                                @if ($count_p14 < 1)
                                                    <label for="" style="font-size: 14px;color:rgb(6, 149, 168)">{{$count_p14}}</label>
                                                @else
                                                    <label for="" style="font-size: 14px;color:red">{{$count_p14}}</label>
                                                @endif
                                            @elseif ($repaire_type =='4')
                                                <?php 
                                                    $datas_count_19= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_19 ="on"');
                                                    foreach ($datas_count_19 as $key => $value19) { $count_p19 = $value19->c_air_list_num; }
                                                ?> 
                                                @if ($count_p19 < 1)
                                                    <label for="" style="font-size: 14px;color:rgb(6, 149, 168)">{{$count_p19}}</label>
                                                @else
                                                    <label for="" style="font-size: 14px;color:red">{{$count_p19}}</label>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-center" width="5%"> 
                                            {{-- @if ($item->problems_5 == 'on')
                                            <img src="{{ asset('images/true_sm_50.png') }}" height="5px" width="5px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                            @else 
                                            @endif --}}
                                            @if ($repaire_type =='1')
                                                <?php 
                                                    $datas_count_5= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_5 ="on"');
                                                    foreach ($datas_count_5 as $key => $value5) {$count_p5 = $value5->c_air_list_num; }
                                                ?>
                                                @if ($count_p5 < 1)
                                                    <label for="" style="font-size: 14px;color:rgb(6, 149, 168)">{{$count_p5}}</label>
                                                @else
                                                    <label for="" style="font-size: 14px;color:red">{{$count_p5}}</label>
                                                @endif
                                            @elseif ($repaire_type =='2')
                                                <?php 
                                                    $datas_count_10= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_10 ="on"');
                                                    foreach ($datas_count_10 as $key => $value10) { $count_p10 = $value10->c_air_list_num; }
                                                ?> 
                                                @if ($count_p10 < 1)
                                                    <label for="" style="font-size: 14px;color:rgb(6, 149, 168)">{{$count_p10}}</label>
                                                @else
                                                    <label for="" style="font-size: 14px;color:red">{{$count_p10}}</label>
                                                @endif
                                            @elseif ($repaire_type =='3')
                                                <?php 
                                                    $datas_count_15= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_15 ="on"');
                                                    foreach ($datas_count_15 as $key => $value15) { $count_p15 = $value15->c_air_list_num; }
                                                ?> 
                                                @if ($count_p15 < 1)
                                                    <label for="" style="font-size: 14px;color:rgb(6, 149, 168)">{{$count_p15}}</label>
                                                @else
                                                    <label for="" style="font-size: 14px;color:red">{{$count_p15}}</label>
                                                @endif
                                            @elseif ($repaire_type =='4')
                                                <?php 
                                                    $datas_count_20= DB::select('SELECT COUNT(air_repaire_id) c_air_list_num FROM air_repaire WHERE air_list_num = "'.$item->air_list_num.'" AND air_problems_20 ="on"');
                                                    foreach ($datas_count_20 as $key => $value20) { $count_p20 = $value20->c_air_list_num; }
                                                ?> 
                                                @if ($count_p20 < 1)
                                                    <label for="" style="font-size: 14px;color:rgb(6, 149, 168)">{{$count_p20}}</label>
                                                @else
                                                    <label for="" style="font-size: 14px;color:red">{{$count_p20}}</label>
                                                @endif

                                            @endif
                                        </td> 
                                        <td class="p-2" width="10%">{{ $item->staff_name }}</td> 
                                        <td class="p-2" width="10%">{{ $item->tect_name }}</td> 
                                        <td class="p-2" width="10%">{{ $item->air_techout_name }}</td> 
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </p>
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
           
            // $('select').select2();
     
        
            $('#example2').DataTable();
            var table = $('#example').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10,25,30,31,50,100,150,200,300],
            });
        
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#datepicker3').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker4').datepicker({
                format: 'yyyy-mm-dd'
            });

        });
    </script>

@endsection
