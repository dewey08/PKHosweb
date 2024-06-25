@extends('layouts.com')
@section('title', 'PK-OFFICER || แจ้งซ่อมคอมพิวเตอร์')
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
    use App\Http\Controllers\UsercomController;
    use App\Http\Controllers\StaticController;
    use App\Models\Products_request_sub;
    
    $refnumber = UsercomController::refnumber();
    $checkhn = StaticController::checkhn($iduser);
    $checkhnshow = StaticController::checkhnshow($iduser);
    $count_suprephn = StaticController::count_suprephn($iduser);
    $count_bookrep_po = StaticController::count_bookrep_po();
    $date = date('Y-m-d');
    $datetime = date('H:i:s');
    
    ?>
    <style>
        @media (min-width: 950px) {
            .modal {
                --bs-modal-width: 950px;
            }
        }

        @media (min-width: 1500px) {
            .modal-xls {
                --bs-modal-width: 1500px;
            }
        }

        @media (min-width: 1500px) {
            .container-fluids {
                width: 1500px;
                margin-left: auto;
                margin-right: auto;
                margin-top: auto;
            }

            .dataTables_wrapper .dataTables_filter {
                float: right
            }

            .dataTables_wrapper .dataTables_length {
                float: left
            }

            .dataTables_info {
                float: left;
            }

            .dataTables_paginate {
                float: right
            }

            .custom-tooltip {
                --bs-tooltip-bg: var(--bs-primary);


            }

            .table thead tr th {
                font-size: 14px;
            }

            .table tbody tr td {
                font-size: 13px;
            }

            .menu {
                font-size: 13px;
            }
        }

        .hrow {
            height: 2px;
            margin-bottom: 9px;
        }
    </style>
    <div class="container-fluids">
        <div class="row justify-content-center">
            <div class="row invoice-card-row">
                <div class="col-md-12">

                    <div class="card shadow">
                        <div class="card-header ">
                            <div class="d-flex">
                                <div class="p-2">
                                    <label for="">แจ้งซ่อมคอมพิวเตอร์</label>
                                </div>
                                <div class="ms-auto p-2">

                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-md-2 mt-2 ms-2">
                                    <label for="com_repaire_no">รหัสแจ้งซ่อม </label>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <div class="form-group">
                                        <input id="com_repaire_no" type="text" class="form-control form-control-sm"
                                            name="com_repaire_no" value="{{ $dataedits->com_repaire_no }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2 mt-2 ms-2">
                                    <label for="com_repaire_date">วันที่แจ้ง </label>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <div class="form-group">
                                        <input id="" type="text" class="form-control form-control-sm"
                                            name="" value="{{ DateThai($dataedits->com_repaire_date) }}" readonly>
                                        <input id="com_repaire_date" type="hidden" class="form-control form-control-sm"
                                            name="com_repaire_date" value="{{ $dataedits->com_repaire_date }}">
                                    </div>
                                </div>
                                <div class="col-md-2 mt-2 ms-2">
                                    <label for="com_repaire_time">เวลา </label>
                                </div>
                                <div class="col-md-1 mt-2 ">
                                    <div class="form-group">
                                        <input id="com_repaire_time" type="text" class="form-control form-control-sm"
                                            name="com_repaire_time" value="{{ formatetime($dataedits->com_repaire_time) }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 mt-2 ms-2">
                                    <label for="com_repaire_user_id">ผู้แจ้ง </label>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <div class="form-group">
                                        <input id="com_repaire_user_id" type="text" class="form-control form-control-sm"
                                            name="com_repaire_user_id" value="{{ $dataedits->com_repaire_user_name }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-2 mt-2 ms-2">
                                    <label for="com_repaire_date">หน่วยงาน </label>
                                </div>
                                <div class="col-md-5 mt-2">
                                    <div class="form-group">
                                        <input id="com_repaire_debsubsub_id" type="text"
                                            class="form-control form-control-sm" name="com_repaire_debsubsub_id"
                                            value="{{ $dataedits->com_repaire_debsubsub_name }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 mt-3 ms-2">
                                    <label for="com_repaire_speed">ความเร่งด่วน </label>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <div class="form-group">
                                        <input id="com_repaire_year" type="text" class="form-control form-control-sm"
                                            name="com_repaire_year" value="{{ $dataedits->status_name }}" readonly>

                                    </div>
                                </div>
                                <div class="col-md-2 mt-2 ms-2">
                                    <label for="com_repaire_year">ปีงบประมาณ </label>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <div class="form-group">
                                        <input id="com_repaire_year" type="text" class="form-control form-control-sm"
                                            name="com_repaire_year" value="{{ $dataedits->com_repaire_year }}" readonly>

                                    </div>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 mt-2 ms-2">
                                    <label for="com_repaire_detail">รายละเอียดแจ้งซ่อม </label>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <textarea class="form-control" id="com_repaire_detail" name="com_repaire_detail" rows="3" readonly>{{ $dataedits->com_repaire_detail }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-2 mt-2 ms-2">
                                    <label for="">ลงชื่อผู้แจ้ง </label>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <div class="form-group">
                                        <img src="data:image/png;base64,{{ $signature }}" alt="">
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row ">
                                <div class="col-md-2 mt-2 ms-2">
                                    <label for="com_repaire_no">รหัสแจ้งซ่อม </label>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <div class="form-group">
                                        <input id="com_repaire_no" type="text" class="form-control form-control-sm"
                                            name="com_repaire_no" value="{{ $dataedits->com_repaire_no }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2 mt-2 ms-2">
                                    <label for="com_repaire_work_date">วันที่ซ่อม </label>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <div class="form-group">
                                        <input id="" type="text" class="form-control form-control-sm"
                                            name="" value="{{ DateThai($date) }}" readonly>
                                        <input id="com_repaire_work_date" type="hidden"
                                            class="form-control form-control-sm" name="com_repaire_work_date"
                                            value="{{ $date }}">
                                    </div>
                                </div>
                                <div class="col-md-2 mt-2 ms-2">
                                    <label for="com_repaire_work_time">เวลา </label>
                                </div>
                                <div class="col-md-1 mt-2 ">
                                    <div class="form-group">
                                        <input id="com_repaire_work_time" type="text"
                                            class="form-control form-control-sm" name="com_repaire_work_time"
                                            value="{{ formatetime($datetime) }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 mt-3 ms-2">
                                    <label for="com_repaire_article_id">รายการครุภัณฑ์ </label>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-group text-center">
                                        <select id="com_repaire_article_id" name="com_repaire_article_id"
                                            class="form-control" style="width: 100%">
                                            <option value=""></option>
                                            @foreach ($article_data as $ite)
                                                @if ($dataedits->com_repaire_article_id == $ite->article_id)
                                                    <option value="{{ $ite->article_id }}" selected>
                                                        {{ $ite->article_num }} {{ $ite->article_name }}</option>
                                                @else
                                                    <option value="{{ $ite->article_id }}">{{ $ite->article_num }}
                                                        {{ $ite->article_name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1 mt-2 ms-2">
                                    <label for="com_repaire_tec_id">ช่างซ่อม </label>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <div class="form-group">
                                        <select id="com_repaire_tec_id" name="com_repaire_tec_id" class="form-control">
                                            <option value=""></option>
                                            @foreach ($com_tec as $tec)
                                                @if ($dataedits->com_repaire_tec_id == $tec->com_tec_user_id)
                                                    <option value="{{ $tec->com_tec_user_id }}" selected>
                                                        {{ $tec->com_tec_user_name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $tec->com_tec_user_id }}">
                                                        {{ $tec->com_tec_user_name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-2 mt-3 ms-2">
                                    <label for="com_repaire_detail_tech">รายการละเอียดการซ่อม </label>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-group text-center">
                                        <textarea class="form-control" id="com_repaire_detail_tech" name="com_repaire_detail_tech" rows="2">
                                                {{ $dataedits->com_repaire_detail_tech }} 
                                            </textarea>
                                    </div>
                                </div>
                                <div class="col-md-1 mt-2 ms-2">
                                    <label for="com_repaire_rep_id">ผู้รับงาน </label>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <div class="form-group">
                                        <select id="com_repaire_rep_id" name="com_repaire_rep_id" class="form-control">
                                            <option value=""></option>
                                            @foreach ($users as $use)
                                                @if ($dataedits->com_repaire_rep_id== $use->id)
                                                    <option value="{{ $use->id }}" selected>{{ $use->fname }}
                                                        {{ $use->lname }}
                                                    </option>
                                                @else
                                                    <option value="{{ $use->id }}">{{ $use->fname }}
                                                        {{ $use->lname }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                            </div>



                            <div class="row mb-3">
                                <div class="col-md-2 mt-2 ms-2">
                                </div>

                                <div class="col-md-4 mt-3">
                                    <h3 class="mt-1 text-center">ผู้รับงาน(หน่วยงานที่แจ้งซ่อม)</h3>
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
                                <div class="col-md-4 mt-3">
                                    
                                    <h3 class="mt-1 text-center">ผู้ส่งงาน(ช่าง)</h3>
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
                                            Create</button>

                                    </div>

                                    <input type="hidden" id="user_id" name="user_id"
                                        value=" {{ Auth::user()->id }}">
                                    <input type="hidden" name="store_id" id="store_id"
                                        value=" {{ Auth::user()->store_id }}">
                                    <input type="hidden" id="com_repaire_id" name="com_repaire_id"
                                        value=" {{ $dataedits->com_repaire_id }}">

                                    {{-- <div class="footer mt-3 text-center">
                                        <button type="button" id="saveBtn" class="btn btn-primary btn-sm me-2">
                                            <i class="fa-solid fa-circle-check text-white me-2"></i>
                                            บันทึกข้อมูล
                                        </button>
                                        <a href="{{ url('computer/com_staff_index') }}"
                                            class="btn btn-danger btn-sm me-2">
                                            <i class="fa-solid fa-xmark me-2"></i>
                                            ปิด
                                        </a>
                                    </div> --}}

                                </div>
                            </div>
                        </div>
                            <div class="card-footer text-end">
                                <button type="button" id="saveBtn" class="btn btn-primary btn-sm me-2">
                                    <i class="fa-solid fa-circle-check text-white me-2"></i>
                                    บันทึกข้อมูล
                                </button>
                                <a href="{{ url('computer/com_staff_index') }}"
                                    class="btn btn-danger btn-sm me-2">
                                    <i class="fa-solid fa-xmark me-2"></i>
                                    ปิด
                                </a>
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

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="{{ asset('js/gcpdfviewer.js') }}"></script>


    <script>
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

        // ผู้ส่งงาน
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
    </script>
    <script>
        $(document).ready(function() {
            $('#saveBtn').click(function() {
                // alert('okkkkk'); 
                var com_repaire_id = $('#com_repaire_id').val();
                var com_repaire_no = $('#com_repaire_no').val();

                var com_repaire_work_date = $('#com_repaire_work_date').val();
                var com_repaire_work_time = $('#com_repaire_work_time').val();
                var com_repaire_article_id = $('#com_repaire_article_id').val();
                var com_repaire_tec_id = $('#com_repaire_tec_id').val();
                var com_repaire_detail_tech = $('#com_repaire_detail_tech').val();
                var com_repaire_rep_id = $('#com_repaire_rep_id').val();
                var signature = $('#signature').val(); //ผู้รับงาน
                var signature2 = $('#signature2').val(); //ผู้ส่งงาน
                // var user_id = $('#user_id').val();
                // alert(signature);
                $.ajax({
                    url: "{{ route('com.com_staff_index_update') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        com_repaire_id,
                        com_repaire_no,
                        com_repaire_work_date,
                        com_repaire_work_time,
                        com_repaire_article_id,
                        com_repaire_tec_id,
                        com_repaire_detail_tech,
                        com_repaire_rep_id,
                        signature,
                        signature2
                    },
                    success: function(data) {
                        if (data.status == 0) {

                        } else if (data.status == 50) {
                            Swal.fire(
                                'กรุณาลงลายชื่อผู้รับงาน !',
                                'You clicked the button !',
                                'warning'
                            )
                        } else if (data.status == 60) {
                            Swal.fire(
                                'กรุณาลงลายชื่อผู้ส่งงาน !',
                                'You clicked the button !',
                                'warning'
                            )
                        } else {
                            Swal.fire({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Edit data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    window.location =
                                        "{{ url('computer/com_staff_index') }}"; // กรณี add page new  
                                }
                            })
                        }
                    },
                });
            });

        });
    </script>



@endsection
