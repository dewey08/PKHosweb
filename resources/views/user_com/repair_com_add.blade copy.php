@extends('layouts.user')
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
                        <div class="card-body ">

                            <div class="row ">
                                <div class="col-md-2">
                                    <label for="com_repaire_no">รหัสแจ้งซ่อม </label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input id="com_repaire_no" type="text" class="form-control form-control-sm"
                                            name="com_repaire_no" value="{{ $refnumber }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="com_repaire_year">ปีงบประมาณ </label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="com_repaire_year" name="com_repaire_year"
                                            class="form-control form-control-sm">
                                            @foreach ($budget_year as $year)
                                                <option value="{{ $year->leave_year_id }}">{{ $year->leave_year_id }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="com_repaire_date">วันที่แจ้ง </label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input id="" type="text" class="form-control form-control-sm"
                                            name="" value="{{ DateThai($date) }}" readonly>
                                        <input id="com_repaire_date" type="hidden" class="form-control form-control-sm"
                                            name="com_repaire_date" value="{{ $date }}">
                                    </div>
                                </div>

                            </div>

                            <div class="row ">
                                <div class="col-md-2 mt-2">
                                    <label for="com_repaire_user_id">ผู้แจ้ง </label>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <div class="form-group">
                                        <input id="com_repaire_user_id" type="text" class="form-control form-control-sm"
                                            name="com_repaire_user_id"
                                            value="{{ Auth::user()->fname }} {{ Auth::user()->lname }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <label for="com_repaire_date">หน่วยงาน </label>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <input id="com_repaire_debsubsub_id" type="text"
                                            class="form-control form-control-sm" name="com_repaire_debsubsub_id"
                                            value="{{ Auth::user()->dep_subsubtruename }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-1 mt-2">
                                    <label for="com_repaire_time">เวลา </label>
                                </div>
                                <div class="col-md-1 mt-2">
                                    <div class="form-group">
                                        <input id="com_repaire_time" type="text" class="form-control form-control-sm"
                                            name="com_repaire_time" value="{{ formatetime($datetime) }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 mt-2">
                                    <label for="com_repaire_speed">ความเร่งด่วน </label>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <div class="form-group">
                                        <select id="com_repaire_speed" name="com_repaire_speed"
                                            class="form-control form-control-sm" style="width: 100%">
                                            <option value=""></option>
                                            @foreach ($com_repaire_speed as $items)
                                                <option value="{{ $items->status_id }}">{{ $items->status_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <label for="article_id">ครุภัณฑ์ที่แจ้งซ่อม </label>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        <select id="article_id" name="article_id" class="form-control form-control-sm"
                                            style="width: 100%">
                                            <option value=""></option>
                                            @foreach ($article_data as $itemsar)
                                                <option value="{{ $itemsar->article_id }}">{{ $itemsar->article_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 mt-2">
                                    <label for="com_repaire_detail">รายละเอียดแจ้งซ่อม </label>
                                </div>
                                <div class="col-md-10 mt-2">
                                    <div class="form-group">
                                        <textarea class="form-control" id="com_repaire_detail" name="com_repaire_detail" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col mt-2 ms-3">
                                </div>

                                <div class="col-md-8 mt-3">
                                    <h3 class="mt-1 text-center">Digital Signature</h3>
                                    <div id="signature-pad" class="mt-2 text-center">
                                        <div style="border:solid 1px teal;height:120px;">
                                            <div id="note" onmouseover="my_function();" class="text-center">The
                                                signature should be inside box</div>
                                            <canvas id="the_canvas" width="320px" height="120px"></canvas>
                                        </div>

                                        <input type="hidden" id="signature" name="signature">
                                        <input type="hidden" id="user_id" name="user_id"
                                            value=" {{ Auth::user()->id }}">
                                        <input type="hidden" name="store_id" id="store_id"
                                            value=" {{ Auth::user()->store_id }}">

                                        <button type="button" id="clear_btn"
                                            class="btn btn-secondary btn-sm mt-3 ms-3 me-2" data-action="clear"><span
                                                class="glyphicon glyphicon-remove"></span>
                                            Clear</button>

                                        <button type="button" id="save_btn"
                                            class="btn btn-info btn-sm mt-3 me-2 text-white" data-action="save-png"
                                            onclick="create()"><span class="glyphicon glyphicon-ok"></span>
                                            Create</button>

                                        {{-- <button type="button" id="saveBtn" class="btn btn-success btn-sm mt-3 me-2">
                                        <i class="fa-solid fa-circle-check text-white me-2"></i>
                                        บันทึกข้อมูล
                                    </button>
                                    <a href="{{url('user_com/repair_com/'.Auth::user()->id )}}" class="btn btn-danger btn-sm mt-3 me-2" >
                                        <i class="fa-solid fa-xmark me-2"></i>
                                        ปิด
                                    </a> --}}

                                    </div>
                                </div>

                                <div class="col mt-3 ">
                                </div>

                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="button" id="saveBtn" class="btn btn-success btn-sm me-2">
                                <i class="fa-solid fa-circle-check text-white me-2"></i>
                                บันทึกข้อมูล
                            </button>
                            <a href="{{ url('user_com/repair_com') }}" class="btn btn-danger btn-sm me-2">
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
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#saveBtn').click(function() {
                // alert('okkkkk'); 
                // var userid = $('#user_id').val();
                var com_repaire_no = $('#com_repaire_no').val();
                var com_repaire_date = $('#com_repaire_date').val();
                var com_repaire_time = $('#com_repaire_time').val();
                var com_repaire_year = $('#com_repaire_year').val();
                var com_repaire_debsubsub_id = $('#com_repaire_debsubsub_id').val();
                var com_repaire_speed = $('#com_repaire_speed').val();
                var com_repaire_detail = $('#com_repaire_detail').val();
                var signature = $('#signature').val();
                var user_id = $('#user_id').val();
                var article_id = $('#article_id').val();
                // alert(signature);
                $.ajax({
                    url: "{{ route('user.repair_com_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        com_repaire_no,
                        com_repaire_date,
                        com_repaire_time,
                        com_repaire_debsubsub_id,
                        com_repaire_speed,
                        com_repaire_detail,
                        signature,
                        com_repaire_year,
                        user_id,
                        article_id
                    },
                    success: function(data) {
                        if (data.status == 0) {

                        } else if (data.status == 50) {
                            Swal.fire(
                                'กรุณาลงลายชื่อ !',
                                'You clicked the button !',
                                'warning'
                            )
                        } else {
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
                                    window.location =
                                        "{{ url('user_com/repair_com') }}"; // กรณี add page new  
                                }
                            })
                        }
                    },
                });
            });

        });
    </script>



@endsection
