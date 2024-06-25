@extends('layouts.mobile')
@section('title', 'PK-OFFICER || Air-Service')

@section('content')
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            font-size: 14px;
        }

        .cardfire {
            border-radius: 1em 1em 1em 1em;
            box-shadow: 0 0 15px pink;
            border: solid 1px #80acfd;
            /* box-shadow: 0 0 10px rgb(232, 187, 243); */
        }
    </style>
    <?php
    
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    
    ?>



    <div class="container-fluid mt-3">
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
        <div class="row text-center">
            <div class="col"></div>
            <div class="col-md-8 text-center">
                <h2>แก้ไขทะเบียนซ่อม-เครื่องปรับอากาศ</h2>
            </div>
            <div class="col"></div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-12">
                <form action="{{ route('prs.air_repiare_update') }}" id="insert_Form" method="POST">
                    @csrf

                    <div class="card cardfire">
                        <div class="card-body">
                            <div class="row">
                                <div class="col text-start"> 
                                    <p style="color:red">ส่วนที่ 1 : รายละเอียด </p>
                                </div>
                            </div>
                            <div class="row">
                            
                                <div class="col text-start">
                                    @if ($data_detail_->air_imgname == null)
                                        <img src="{{ asset('assets/images/defailt_img.jpg') }}" height="190px"
                                            width="220px" alt="Image" class="img-thumbnail">
                                    @else
                                        <img src="{{ asset('storage/air/' . $data_detail_->air_imgname) }}" height="170px"
                                            width="220px" alt="Image" class="img-thumbnail">
                                    @endif
                                </div>
                                <div class="col-7">
                                    <p>รหัส : {{ $data_detail_->air_list_num }}</p>
                                    <p>ชื่อ : {{ $data_detail_->air_list_name }}</p>
                                    <p>Btu : {{ $data_detail_->btu }}</p>
                                    <p>serial_no : {{ $data_detail_->serial_no }}</p>
                                    <p>ที่ตั้ง : {{ $data_detail_->air_location_name }}</p>
                                </div>
                              
                            </div>

                            <hr style="color:red">
                            <div class="row">
                                <div class="col text-start">
                                    <p style="color:red">ส่วนที่ 2 : ช่างซ่อม(นอก รพ.) </p>
                                </div>
                                <div class="col-2 text-start"> 
                                    <p style="color:rgb(22, 61, 236)">เลขที่แจ้งซ่อม : </p> 
                                </div>
                                <div class="col-6 text-start">
                                    <select class="custom-select custom-select-sm" id="air_repaire_no" name="air_repaire_no"
                                        style="width: 100%">
                                        @foreach ($air_no as $item_no) 
                                            @if ($data_edit->air_repaire_no == $item_no->REPAIR_ID)
                                            
                                                <option value="{{ $item_no->ID }}" class="text-center" selected> {{ $item_no->REPAIR_ID }} {{ $item_no->REPAIR_NAME }}</option>
                                            @else
                                                <option value="{{ $item_no->ID }}" class="text-center"> {{ $item_no->REPAIR_ID }} {{ $item_no->REPAIR_NAME }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col text-start">
                                    <p style="color:rgb(9, 119, 209)">- รายการซ่อม(ตามปัญหา) </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3 text-start">
                                    <div class="input-group">
                                        @if ($data_edit->air_problems_1 == 'on')
                                            <input type="checkbox" class="discheckbox" id="air_problems_1" name="air_problems_1" checked />
                                        @else
                                            <input type="checkbox" class="discheckbox" id="air_problems_1" name="air_problems_1" />
                                        @endif
                                        &nbsp;&nbsp;<p>น้ำหยด</p>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="input-group">
                                        @if ($data_edit->air_problems_2 == 'on')
                                            <input type="checkbox" class="discheckbox" id="air_problems_2"
                                                name="air_problems_2" checked />
                                        @else
                                            <input type="checkbox" class="discheckbox" id="air_problems_2"
                                                name="air_problems_2" />
                                        @endif
                                        &nbsp;&nbsp;<p>ไม่เย็นมีแต่ลม</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group">
                                        @if ($data_edit->air_problems_3 == 'on')
                                            <input type="checkbox" class="discheckbox" id="air_problems_3"
                                                name="air_problems_3" checked />
                                        @else
                                            <input type="checkbox" class="discheckbox" id="air_problems_3"
                                                name="air_problems_3" />
                                        @endif
                                        &nbsp;&nbsp;<p> มีกลิ่นเหม็น</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3 text-start">
                                    <div class="input-group">

                                        @if ($data_edit->air_problems_4 == 'on')
                                            <input type="checkbox" class="discheckbox" id="air_problems_4"
                                                name="air_problems_4" checked />
                                        @else
                                            <input type="checkbox" class="discheckbox" id="air_problems_4"
                                                name="air_problems_4" />
                                        @endif
                                        &nbsp;&nbsp;<p>เสียงดัง</p>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="input-group">

                                        @if ($data_edit->air_problems_5 == 'on')
                                            <input type="checkbox" class="discheckbox" id="air_problems_5"
                                                name="air_problems_5" checked />
                                        @else
                                            <input type="checkbox" class="discheckbox" id="air_problems_5"
                                                name="air_problems_5" />
                                        @endif
                                        &nbsp;&nbsp;<p>ไม่ติด/ติดๆ ดับๆ</p>
                                    </div>
                                </div>
                                <div class="col text-start">
                                </div>
                            </div>

                            <hr style="color:rgb(7, 114, 141)">
                            <div class="row">
                                <div class="col text-start">
                                    <p style="color:rgb(9, 119, 209)">- การบำรุงรักษา ประจำปี ครั้ง 1 </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-start">
                                    <div class="input-group"> 
                                        @if ($data_edit->air_problems_6 == 'on')
                                            <input type="checkbox" class="discheckbox" id="air_problems_6"
                                                name="air_problems_6" checked />
                                        @else
                                            <input type="checkbox" class="discheckbox" id="air_problems_6"
                                                name="air_problems_6" />
                                        @endif
                                        &nbsp;&nbsp;<p>ถอดล้างพัดลมกรงกระรอก</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">

                                        @if ($data_edit->air_problems_7 == 'on')
                                            <input type="checkbox" class="discheckbox" id="air_problems_7"
                                                name="air_problems_7" checked />
                                        @else
                                            <input type="checkbox" class="discheckbox" id="air_problems_7"
                                                name="air_problems_7" />
                                        @endif
                                        &nbsp;&nbsp;<p>ล้างถาดหลังแอร์</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 text-start">
                                    <div class="input-group">

                                        @if ($data_edit->air_problems_8 == 'on')
                                            <input type="checkbox" class="discheckbox" id="air_problems_8"
                                                name="air_problems_8" checked />
                                        @else
                                            <input type="checkbox" class="discheckbox" id="air_problems_8"
                                                name="air_problems_8" />
                                        @endif
                                        &nbsp;&nbsp;<p>ล้างแผงคอยล์เย็น</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">

                                        @if ($data_edit->air_problems_9 == 'on')
                                            <input type="checkbox" class="discheckbox" id="air_problems_9"
                                                name="air_problems_9" checked />
                                        @else
                                            <input type="checkbox" class="discheckbox" id="air_problems_9"
                                                name="air_problems_9" />
                                        @endif
                                        &nbsp;&nbsp;<p>ล้างแผงคอยล์ร้อน</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-start">
                                    <div class="input-group">
                                        @if ($data_edit->air_problems_10 == 'on')
                                            <input type="checkbox" class="discheckbox" id="air_problems_10"
                                                name="air_problems_10" checked />
                                        @else
                                            <input type="checkbox" class="discheckbox" id="air_problems_10"
                                                name="air_problems_10" />
                                        @endif
                                        &nbsp;&nbsp;<p>ตรวจเช็คน้ำยา</p>
                                    </div>
                                </div>
                            </div>

                            <hr style="color:rgb(7, 114, 141)">
                            <div class="row">
                                <div class="col text-start">
                                    <p style="color:rgb(9, 119, 209)">- การบำรุงรักษา ประจำปี ครั้ง 2 </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-start">
                                    <div class="input-group">
                                        @if ($data_edit->air_problems_11 == 'on')
                                            <input type="checkbox" class="discheckbox" id="air_problems_11"
                                                name="air_problems_11" checked />
                                        @else
                                            <input type="checkbox" class="discheckbox" id="air_problems_11"
                                                name="air_problems_11" />
                                        @endif
                                        &nbsp;&nbsp;<p>ถอดล้างพัดลมกรงกระรอก</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        @if ($data_edit->air_problems_12 == 'on')
                                            <input type="checkbox" class="discheckbox" id="air_problems_12"
                                                name="air_problems_12" checked />
                                        @else
                                            <input type="checkbox" class="discheckbox" id="air_problems_12"
                                                name="air_problems_12" />
                                        @endif
                                        &nbsp;&nbsp;<p>ล้างถาดหลังแอร์</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-start">
                                    <div class="input-group">
                                        @if ($data_edit->air_problems_13 == 'on')
                                            <input type="checkbox" class="discheckbox" id="air_problems_13"
                                                name="air_problems_13" checked />
                                        @else
                                            <input type="checkbox" class="discheckbox" id="air_problems_13"
                                                name="air_problems_13" />
                                        @endif
                                        &nbsp;&nbsp;<p>ล้างแผงคอยล์เย็น</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        @if ($data_edit->air_problems_14 == 'on')
                                            <input type="checkbox" class="discheckbox" id="air_problems_14"
                                                name="air_problems_14" checked />
                                        @else
                                            <input type="checkbox" class="discheckbox" id="air_problems_14"
                                                name="air_problems_14" />
                                        @endif
                                        &nbsp;&nbsp;<p>ล้างแผงคอยล์ร้อน</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-start">
                                    <div class="input-group">
                                        @if ($data_edit->air_problems_15 == 'on')
                                            <input type="checkbox" class="discheckbox" id="air_problems_15"
                                                name="air_problems_15" checked />
                                        @else
                                            <input type="checkbox" class="discheckbox" id="air_problems_15"
                                                name="air_problems_15" />
                                        @endif
                                        &nbsp;&nbsp;<p>ตรวจเช็คน้ำยา</p>
                                    </div>
                                </div>
                            </div>

                            <hr style="color:rgb(7, 114, 141)">
                            <div class="row">
                                <div class="col text-start">
                                    <p style="color:rgb(9, 119, 209)">- การบำรุงรักษา ประจำปี ครั้ง 3 </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-start">
                                    <div class="input-group">
                                        @if ($data_edit->air_problems_16 == 'on')
                                            <input type="checkbox" class="discheckbox" id="air_problems_16"
                                                name="air_problems_16" checked />
                                        @else
                                            <input type="checkbox" class="discheckbox" id="air_problems_16"
                                                name="air_problems_16" />
                                        @endif
                                        &nbsp;&nbsp;<p>ถอดล้างพัดลมกรงกระรอก</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        @if ($data_edit->air_problems_17 == 'on')
                                            <input type="checkbox" class="discheckbox" id="air_problems_17"
                                                name="air_problems_17" checked />
                                        @else
                                            <input type="checkbox" class="discheckbox" id="air_problems_17"
                                                name="air_problems_17" />
                                        @endif
                                        &nbsp;&nbsp;<p>ล้างถาดหลังแอร์</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 text-start">
                                    <div class="input-group">
                                        @if ($data_edit->air_problems_18 == 'on')
                                            <input type="checkbox" class="discheckbox" id="air_problems_18"
                                                name="air_problems_18" checked />
                                        @else
                                            <input type="checkbox" class="discheckbox" id="air_problems_18"
                                                name="air_problems_18" />
                                        @endif
                                        &nbsp;&nbsp;<p>ล้างแผงคอยล์เย็น</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        @if ($data_edit->air_problems_19 == 'on')
                                            <input type="checkbox" class="discheckbox" id="air_problems_19"
                                                name="air_problems_19" checked />
                                        @else
                                            <input type="checkbox" class="discheckbox" id="air_problems_19"
                                                name="air_problems_19" />
                                        @endif
                                        &nbsp;&nbsp;<p>ล้างแผงคอยล์ร้อน</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-start">
                                    <div class="input-group">
                                        @if ($data_edit->air_problems_20 == 'on')
                                            <input type="checkbox" class="discheckbox" id="air_problems_20"
                                                name="air_problems_20" checked />
                                        @else
                                            <input type="checkbox" class="discheckbox" id="air_problems_20"
                                                name="air_problems_20" />
                                        @endif
                                        &nbsp;&nbsp;<p>ตรวจเช็คน้ำยา</p>
                                    </div>
                                </div>
                            </div>

                            <hr style="color:rgb(7, 114, 141)">
                            <div class="row">
                                <div class="col text-start">
                                    <p>สถานะซ่อม :</p>
                                </div>
                                <div class="col-8">
                                    <select class="custom-select custom-select-sm" id="air_status_techout"
                                        name="air_status_techout" style="width: 100%">
                                        @if ($data_edit->air_status_techout == 'Y')
                                            <option value="Y" class="text-center" selected>- พร้อมใช้งาน -</option>
                                            <option value="N" class="text-center">- ไม่พร้อมใช้งาน -</option>
                                        @else
                                            <option value="Y" class="text-center">- พร้อมใช้งาน -</option>
                                            <option value="N" class="text-center">- ไม่พร้อมใช้งาน -</option>
                                        @endif

                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-start">
                                    <p>ชื่อ-นามสกุล :</p>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="air_techout_name"
                                        name="air_techout_name" value="{{ $data_edit->air_techout_name }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-2"> <img src="data:image/png;base64,{{ $signature }}" alt=""></div>
                                <div class="col-6">
                                    <div id="signature-pad" class="mt-2 text-center">
                                        <div style="border:solid 1px teal;height:120px;">
                                            <div id="note" onmouseover="my_function();" class="text-center">The
                                                signature should be inside box</div>
                                            <canvas id="the_canvas" width="320px" height="120px"> </canvas>
                                        </div>

                                        <input type="hidden" id="signature" name="signature">

                                        <button type="button" id="clear_btn"
                                            class="btn btn-secondary btn-sm mt-3 ms-2 me-2" data-action="clear"><span
                                                class="glyphicon glyphicon-remove"></span>
                                            Clear</button>

                                        <button type="button" id="save_btn"
                                            class="btn btn-info btn-sm mt-3 me-2 text-white" data-action="save-png"
                                            onclick="create()"><span class="glyphicon glyphicon-ok"></span>
                                            Create
                                        </button>
                                    </div>
                                </div>
                                {{-- <div class="col"> </div> --}}
                            </div>



                            <hr style="color:red">
                            <div class="row">
                                <div class="col text-start">
                                    <p style="color:red">ส่วนที่ 3 : เจ้าหน้าที่ </p>
                                </div>
                                <div class="col-6"> </div>
                            </div>
                            <div class="row">
                                <div class="col text-start">
                                    <p>สถานะซ่อม :</p>
                                </div>
                                <div class="col-8">
                                    <select class="custom-select custom-select-sm" id="air_status_staff"
                                        name="air_status_staff" style="width: 100%">
                                        @if ($data_edit->air_status_staff == 'Y')
                                            <option value="Y" class="text-center" selected>- พร้อมใช้งาน -</option>
                                            <option value="N" class="text-center">- ไม่พร้อมใช้งาน -</option>
                                        @else
                                            <option value="Y" class="text-center">- พร้อมใช้งาน -</option>
                                            <option value="N" class="text-center">- ไม่พร้อมใช้งาน -</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-start">
                                    <p>ชื่อ-นามสกุล :</p>
                                </div>
                                <div class="col-8">
                                    <select class="custom-select custom-select-sm" id="air_staff_id" name="air_staff_id"
                                        style="width: 100%">
                                        @foreach ($users as $item_u)
                                            @if ($data_edit->air_staff_id == $item_u->id)
                                                <option value="{{ $item_u->id }}" class="text-center" selected>
                                                    {{ $item_u->fname }} {{ $item_u->lname }}</option>
                                            @else
                                                <option value="{{ $item_u->id }}" class="text-center">
                                                    {{ $item_u->fname }} {{ $item_u->lname }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-2"> <img src="data:image/png;base64,{{ $signature2 }}"
                                        alt=""></div>
                                <div class="col-6">
                                    <div id="signature-pad2" class="mt-2 text-center">
                                        <div style="border:solid 1px teal;height:120px;">
                                            <div id="note2" onmouseover="my_function2();" class="text-center">The
                                                signature should be inside box</div>
                                            <canvas id="the_canvas2" width="320px" height="120px"> </canvas>
                                        </div>

                                        <input type="hidden" id="signature2" name="signature2">
                                        <button type="button" id="clear_btn2"
                                            class="btn btn-secondary btn-sm mt-3 ms-2 me-2" data-action="clear2"><span
                                                class="glyphicon glyphicon-remove"></span>
                                            Clear</button>

                                        <button type="button" id="save_btn2"
                                            class="btn btn-info btn-sm mt-3 me-2 text-white" data-action="save-png2"
                                            onclick="create2()"><span class="glyphicon glyphicon-ok"></span>
                                            Create
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <hr style="color:red">
                            <div class="row">
                                <div class="col text-start">
                                    <p style="color:red">ส่วนที่ 4 : ช่างซ่อม(รพ.) </p>
                                </div>
                                <div class="col-6"> </div>
                            </div>
                            <div class="row">
                                <div class="col text-start">
                                    <p>สถานะซ่อม :</p>
                                </div>
                                <div class="col-8">
                                    <select class="custom-select custom-select-sm" id="air_status_tech"
                                        name="air_status_tech" style="width: 100%">
                                        @if ($data_edit->air_status_tech == 'Y')
                                            <option value="Y" class="text-center" selected>- พร้อมใช้งาน -</option>
                                            <option value="N" class="text-center">- ไม่พร้อมใช้งาน -</option>
                                        @else
                                            <option value="Y" class="text-center">- พร้อมใช้งาน -</option>
                                            <option value="N" class="text-center">- ไม่พร้อมใช้งาน -</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-start">
                                    <p>ชื่อ-นามสกุล :</p>
                                </div>
                                <div class="col-8">
                                    <select class="custom-select custom-select-sm" id="air_tech_id" name="air_tech_id"
                                        style="width: 100%">
                                        @foreach ($users as $item_ut)
                                            @if ($data_edit->air_tech_id == $item_ut->id)
                                                <option value="{{ $item_ut->id }}" class="text-center" selected>
                                                    {{ $item_ut->fname }} {{ $item_ut->lname }}</option>
                                            @else
                                                <option value="{{ $item_ut->id }}" class="text-center">
                                                    {{ $item_ut->fname }} {{ $item_ut->lname }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-2"> <img src="data:image/png;base64,{{ $signature3 }}"
                                        alt=""></div>
                                <div class="col-6">
                                    <div id="signature-pad3" class="mt-2 text-center">
                                        <div style="border:solid 1px teal;height:120px;">
                                            <div id="note3" onmouseover="my_function3();" class="text-center">The
                                                signature should be inside box</div>
                                            <canvas id="the_canvas3" width="320px" height="120px"> </canvas>
                                        </div>

                                        <input type="hidden" id="signature3" name="signature3">
                                        <button type="button" id="clear_btn3"
                                            class="btn btn-secondary btn-sm mt-3 ms-2 me-2" data-action="clear3"><span
                                                class="glyphicon glyphicon-remove"></span>
                                            Clear</button>

                                        <button type="button" id="save_btn3"
                                            class="btn btn-info btn-sm mt-3 me-2 text-white" data-action="save-png3"
                                            onclick="create3()"><span class="glyphicon glyphicon-ok"></span>
                                            Create
                                        </button> 
                                    </div>
                                </div>

                            </div>

                            <input type="hidden" name="air_repaire_id" id="air_repaire_id"
                                value="{{ $data_edit->air_repaire_id }}">
                            <input type="hidden" name="air_list_id" id="air_list_id"
                                value="{{ $data_detail_->air_list_id }}">
                            <input type="hidden" name="air_list_num" id="air_list_num"
                                value="{{ $data_detail_->air_list_num }}">
                            <input type="hidden" name="air_list_name" id="air_list_name"
                                value="{{ $data_detail_->air_list_name }}">
                            <input type="hidden" name="btu" id="btu" value="{{ $data_detail_->btu }}">
                            <input type="hidden" name="serial_no" id="serial_no"
                                value="{{ $data_detail_->serial_no }}">
                            <input type="hidden" name="air_location_id" id="air_location_id"
                                value="{{ $data_detail_->air_location_id }}">
                            <input type="hidden" name="air_location_name" id="air_location_name"
                                value="{{ $data_detail_->air_location_name }}">

                            <hr style="color:red">
                            <div class="row mt-3">
                                <div class="col text-center">
                                    <button type="submit" class="ladda-button btn-pill btn btn-success">
                                        <i class="fa-solid fa-circle-check text-white me-2"></i>
                                        แก้ไขข้อมูล
                                    </button>
                                    {{-- <button type="button" id="updateBtn" class="ladda-button btn-pill btn btn-success">
                                        <i class="fa-solid fa-circle-check text-white me-2"></i>
                                        แก้ไขข้อมูล
                                    </button> --}}
                                </div>
                            </div>


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="{{ asset('js/gcpdfviewer.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('select').select2();
        });
    </script>
    <script>
        //ช่างซ่อมนอก
        var wrapper = document.getElementById("signature-pad");
        var clearButton = wrapper.querySelector("[data-action=clear]");
        var savePNGButton = wrapper.querySelector("[data-action=save-png]");
        var canvas = wrapper.querySelector("canvas");
        var el_note = document.getElementById("note");
        var signaturePad;
        signaturePad = new SignaturePad(canvas);
        clearButton.addEventListener("click", function(event) {
            document.getElementById("note").innerHTML = "The signature should be inside box";
            signaturePad.clear();
        });
        savePNGButton.addEventListener("click", function(event) {
            if (signaturePad.isEmpty()) {
                // alert("Please provide signature first.");
                Swal.fire(
                    'กรุณาลงลายเซนต์ก่อน !',
                    'You clicked the button !',
                    'warning'
                )
                event.preventDefault();
            } else {
                var canvas = document.getElementById("the_canvas");
                var dataUrl = canvas.toDataURL();
                document.getElementById("signature").value = dataUrl;

                // ข้อความแจ้ง
                Swal.fire({
                    position: "top-end",
                    title: 'สร้างสำเร็จ',
                    text: "You create success",
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#06D177',
                    confirmButtonText: 'เรียบร้อย'
                }).then((result) => {
                    if (result.isConfirmed) {}
                })
            }
        });

        function my_function() {
            document.getElementById("note").innerHTML = "";
        }

        // เจ้าหน้าที่
        var wrapper = document.getElementById("signature-pad2");
        var clearButton2 = wrapper.querySelector("[data-action=clear2]");
        var savePNGButton2 = wrapper.querySelector("[data-action=save-png2]");
        var canvas2 = wrapper.querySelector("canvas");
        var el_note = document.getElementById("note2");
        var signaturePad2;
        signaturePad2 = new SignaturePad(canvas2);
        clearButton2.addEventListener("click", function(event) {
            document.getElementById("note2").innerHTML = "The signature should be inside box";
            signaturePad2.clear();
        });
        savePNGButton2.addEventListener("click", function(event) {
            if (signaturePad2.isEmpty()) {
                // alert("Please provide signature first.");
                Swal.fire(
                    'กรุณาลงลายเซนต์ก่อน !',
                    'You clicked the button !',
                    'warning'
                )
                event.preventDefault();
            } else {
                var canvas = document.getElementById("the_canvas2");
                var dataUrl = canvas.toDataURL();
                document.getElementById("signature2").value = dataUrl;

                // ข้อความแจ้ง
                Swal.fire({
                    position: "top-end",
                    title: 'สร้างสำเร็จ',
                    text: "You create success",
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#06D177',
                    confirmButtonText: 'เรียบร้อย'
                }).then((result) => {
                    if (result.isConfirmed) {}
                })
            }
        });

        function my_function2() {
            document.getElementById("note2").innerHTML = "";
        }

        // ช่างซ่อมใน รพ 
        var wrapper = document.getElementById("signature-pad3");
        var clearButton3 = wrapper.querySelector("[data-action=clear3]");
        var savePNGButton3 = wrapper.querySelector("[data-action=save-png3]");
        var canvas3 = wrapper.querySelector("canvas");
        var el_note = document.getElementById("note3");
        var signaturePad3;
        signaturePad3 = new SignaturePad(canvas3);
        clearButton3.addEventListener("click", function(event) {
            document.getElementById("note3").innerHTML = "The signature should be inside box";
            signaturePad3.clear();
        });
        savePNGButton3.addEventListener("click", function(event) {
            if (signaturePad3.isEmpty()) {
                // alert("Please provide signature first.");
                Swal.fire(
                    'กรุณาลงลายเซนต์ก่อน !',
                    'You clicked the button !',
                    'warning'
                )
                event.preventDefault();
            } else {
                var canvas = document.getElementById("the_canvas3");
                var dataUrl = canvas.toDataURL();
                document.getElementById("signature3").value = dataUrl;

                // ข้อความแจ้ง
                Swal.fire({
                    position: "top-end",
                    title: 'สร้างสำเร็จ',
                    text: "You create success",
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#06D177',
                    confirmButtonText: 'เรียบร้อย'
                }).then((result) => {
                    if (result.isConfirmed) {}
                })
            }
        });

        function my_function3() {
            document.getElementById("note3").innerHTML = "";
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#spinner-div").hide(); //Request is complete so hide spinner

            $('#insert_Form').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    success: function(data) {
                        //   if (data.status == 0 ) {

                        //   } else {          
                        //     Swal.fire({
                        //         position: "top-end",
                        //       title: 'แก้ไขข้อมูลสำเร็จ',
                        //       text: "You Update data success",
                        //       icon: 'success',
                        //       showCancelButton: false,
                        //       confirmButtonColor: '#06D177', 
                        //       confirmButtonText: 'เรียบร้อย'
                        //     }).then((result) => {
                        //       if (result.isConfirmed) {                  
                        //         // window.location="{{ url('setting/permiss') }}";
                        //         window.location.reload();
                        //       }
                        //     })      
                        //   }

                        if (data.status == 0) {

                        } else if (data.status == 50) {
                            Swal.fire(
                                'กรุณาลงลายชื่อช่างภายนอก !',
                                'You clicked the button !',
                                'warning'
                            )
                        } else if (data.status == 60) {
                            Swal.fire(
                                'กรุณาลงลายชื่อเจ้าหน้าที่ !',
                                'You clicked the button !',
                                'warning'
                            )
                        } else if (data.status == 70) {
                            Swal.fire(
                                'กรุณาลงลายชื่อช่าง รพ !',
                                'You clicked the button !',
                                'warning'
                            )
                        } else {
                            Swal.fire({
                                position: "top-end",
                                title: 'แก้ไขข้อมูลสำเร็จ',
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
                                    window.location.reload();
                                    // window.location = "{{ url('air_main_repaire') }}";
                                    $('#spinner')
                                .hide(); //Request is complete so hide spinner
                                    setTimeout(function() {
                                        $("#overlay").fadeOut(300);
                                    }, 500);
                                }
                            })
                        }
                    }
                });
            });

            // $('#updateBtn').click(function() {

            //     var air_problems_1 = $('#air_problems_1').val();
            //     var air_problems_2 = $('#air_problems_2').val();
            //     var air_problems_3 = $('#air_problems_3').val();
            //     var air_problems_4 = $('#air_problems_4').val();
            //     var air_problems_5 = $('#air_problems_5').val();
            //     var air_problems_6 = $('#air_problems_6').val();
            //     var air_problems_7 = $('#air_problems_7').val();
            //     var air_problems_8 = $('#air_problems_8').val();
            //     var air_problems_9 = $('#air_problems_9').val();
            //     var air_problems_10 = $('#air_problems_10').val();
            //     var air_problems_11 = $('#air_problems_11').val();
            //     var air_problems_12 = $('#air_problems_12').val();
            //     var air_problems_13 = $('#air_problems_13').val();
            //     var air_problems_14 = $('#air_problems_14').val();
            //     var air_problems_15 = $('#air_problems_15').val();
            //     var air_problems_16 = $('#air_problems_16').val();
            //     var air_problems_17 = $('#air_problems_17').val();
            //     var air_problems_18 = $('#air_problems_18').val();
            //     var air_problems_19 = $('#air_problems_19').val();
            //     var air_problems_20 = $('#air_problems_20').val();
            //     var air_status_techout = $('#air_status_techout').val();
            //     var air_techout_name = $('#air_techout_name').val();
            //     var air_status_staff = $('#air_status_staff').val();
            //     var air_staff_id = $('#air_staff_id').val();
            //     var air_status_tech = $('#air_status_tech').val();
            //     var air_tech_id = $('#air_tech_id').val();
            //     var signature = $('#signature').val(); //ช่างนอก
            //     var signature2 = $('#signature2').val(); //เจ้าหน้าที่
            //     var signature3 = $('#signature3').val(); //ช่าง รพ
            //     var air_list_id = $('#air_list_id').val();
            //     var air_list_num = $('#air_list_num').val();
            //     var air_list_name = $('#air_list_name').val();
            //     var btu = $('#btu').val();
            //     var serial_no = $('#serial_no').val();
            //     var air_location_id = $('#air_location_id').val();
            //     var air_location_name = $('#air_location_name').val();
            //     var air_repaire_id = $('#air_repaire_id').val();
            //     var air_repaire_no = $('#air_repaire_no').val();
            //     alert(air_problems_1);
            //     Swal.fire({
            //         position: "top-end",
            //         title: 'ต้องการบันทึกข้อมูลใช่ไหม ?',
            //         text: "You Warn Save Data!",
            //         icon: 'warning',
            //         showCancelButton: true,
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#d33',
            //         confirmButtonText: 'Yes, Save it!'
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             $("#overlay").fadeIn(300);
            //             $("#spinner").show(); //Load button clicked show spinner 

            //             $.ajax({
            //                 url: "{{ route('prs.air_repiare_update') }}",
            //                 type: "POST",
            //                 dataType: 'json',
            //                 data: {
            //                     "_token": "{{ csrf_token() }}",
            //                     air_repaire_id,
            //                     air_problems_1,
            //                     air_problems_2,
            //                     air_problems_3,
            //                     air_problems_4,
            //                     air_problems_5,
            //                     air_problems_6,
            //                     air_problems_7,
            //                     air_problems_8,
            //                     air_problems_9,
            //                     air_problems_10,
            //                     air_problems_11,
            //                     air_problems_12,
            //                     air_problems_13,
            //                     air_problems_14,
            //                     air_problems_15,
            //                     air_problems_16,
            //                     air_problems_17,
            //                     air_problems_18,
            //                     air_problems_19,
            //                     air_problems_20,
            //                     air_status_techout,
            //                     air_techout_name,
            //                     air_status_staff,
            //                     air_staff_id,
            //                     air_status_tech,
            //                     air_tech_id,
            //                     signature,
            //                     signature2,
            //                     signature3,
            //                     air_list_id,
            //                     air_list_num,
            //                     air_list_name,
            //                     btu,
            //                     serial_no,
            //                     air_location_id,
            //                     air_location_name,
            //                     air_repaire_no
            //                 },
            //                 success: function(data) {
            //                     if (data.status == 0) {

            //                     } else if (data.status == 50) {
            //                         Swal.fire(
            //                             'กรุณาลงลายชื่อช่างภายนอก !',
            //                             'You clicked the button !',
            //                             'warning'
            //                         )
            //                     } else if (data.status == 60) {
            //                         Swal.fire(
            //                             'กรุณาลงลายชื่อเจ้าหน้าที่ !',
            //                             'You clicked the button !',
            //                             'warning'
            //                         )
            //                     } else if (data.status == 70) {
            //                         Swal.fire(
            //                             'กรุณาลงลายชื่อช่าง รพ !',
            //                             'You clicked the button !',
            //                             'warning'
            //                         )
            //                     } else {
            //                         Swal.fire({
            //                             position: "top-end",
            //                             title: 'แก้ไขข้อมูลสำเร็จ',
            //                             text: "You Update data success",
            //                             icon: 'success',
            //                             showCancelButton: false,
            //                             confirmButtonColor: '#06D177',
            //                             confirmButtonText: 'เรียบร้อย'
            //                         }).then((result) => {
            //                             if (result
            //                                 .isConfirmed) {
            //                                 console.log(
            //                                     data);
            //                                 // window.location.reload();
            //                                 window.location =
            //                                     "{{ url('air_main_repaire') }}";
            //                                 $('#spinner')
            //                             .hide(); //Request is complete so hide spinner
            //                                 setTimeout(function() {
            //                                     $("#overlay").fadeOut(
            //                                         300);
            //                                 }, 500);
            //                             }
            //                         })
            //                     }
            //                 },
            //             });
            //         }
            //     })
            // });

        });
    </script>
@endsection
