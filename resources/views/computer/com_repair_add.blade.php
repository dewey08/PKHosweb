<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>แจ้งซ่อมคอมพิวเตอร์</title>
   <!-- Font Awesome -->
   <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">
   <!-- App favicon -->
   <link rel="shortcut icon" href="{{ asset('apkclaim/images/logo150.ico') }}"> 
    
   <link href="{{ asset('apkclaim/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
   <link href="{{ asset('apkclaim/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
   <link href="{{ asset('apkclaim/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">
   <!-- jquery.vectormap css -->
   <link href="{{ asset('apkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
       rel="stylesheet" type="text/css" />

   <!-- DataTables -->
   <link href="{{ asset('apkclaim/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
       type="text/css" />

   <!-- Responsive datatable examples -->
   <link href="{{ asset('apkclaim/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
       rel="stylesheet" type="text/css" />
       <link href="{{ asset('css/tablecom.css') }}" rel="stylesheet">
   <!-- Bootstrap Css -->
   <link href="{{ asset('bt52/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" /> 
   <!-- Icons Css -->
   <link href="{{ asset('apkclaim/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
   <!-- App Css-->
   <link href="{{ asset('apkclaim/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" /> 
   <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet"> 
    <link rel="stylesheet" href="{{asset('asset/js/plugins/select2/css/select2.min.css')}}">
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            font-size: 15px;
    
        }
    
        label {
            font-family: 'Kanit', sans-serif;
            font-size: 15px;
    
        }
    
    </style>
    <?php
    use App\Http\Controllers\RepaireScanController;
    use App\Models\Products_request_sub;
    
    $refnumber = RepaireScanController::refnumber();
    $date = date('Y-m-d');
    $datetime = date('H:i:s');

    ?>
    <body data-topbar="light" data-layout="horizontal">

         <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <i class="ri-loader-line spin-icon"></i>
            </div>
        </div>
    </div>

        <!-- Begin page -->
        <div id="layout-wrapper"> 
            <header id="page-topbar" >
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">                       
                        </div>
                        <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item"
                            data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                            <i class="ri-menu-2-line align-middle"></i>
                        </button>
    
                        <div class="dropdown dropdown-mega d-none d-lg-block ">
                            <img src="{{ asset('apkclaim/images/logo150.png') }}" alt="logo-sm-light" height="40">
                            <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown"
                                aria-haspopup="false" aria-expanded="false">
                                <h4 style="color:rgb(109, 14, 172)" class="mt-3">PK-OFFICER</h4>
    
                            </button>
                        </div>
    
                    </div>
                    
                    <div class="d-flex">                      
                        <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                                <i class="ri-fullscreen-line" style="color: rgb(255, 255, 255)"></i>
                            </button>
                        </div>
    
                        <div class="dropdown d-inline-block user-dropdown">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               
                                    <img src="{{ asset('assets/images/default-image.jpg') }}" height="32px" width="32px"
                                        alt="Header Avatar" class="rounded-circle header-profile-user">
                                
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                              
                               
                            </div>
                        </div>
    
                        <div class="dropdown d-inline-block user-dropdown">
                        </div>
            
                    </div>
                </div>
            </header>
     
   <br> <br> <br>
            <div class="container-fluid mt-4">
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
                                                <input id="com_repaire_no" type="text" class="form-control"
                                                    name="com_repaire_no" value="{{ $refnumber }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="com_repaire_year">ปีงบประมาณ </label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <select id="com_repaire_year" name="com_repaire_year"
                                                    class="form-control">
                                                    @foreach ($budget_year as $year)
                                                        <option value="{{ $year->leave_year_id }}">{{ $year->leave_year_id }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-2">
                                            <label for="com_repaire_date">วันที่แจ้ง </label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input id="" type="text" class="form-control"
                                                    name="" value="{{ DateThai($date) }}" readonly>
                                                <input id="com_repaire_date" type="hidden" class="form-control"
                                                    name="com_repaire_date" value="{{ $date }}">
                                            </div>
                                        </div> --}}
                                        <div class="col-md-2">
                                            <label for="com_repaire_speed">ความเร่งด่วน </label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <select id="com_repaire_speed" name="com_repaire_speed"
                                                    class="form-control" style="width: 100%">
                                                    <option value="">==เลือก==</option>
                                                    @foreach ($com_repaire_speed as $items)
                                                        <option value="{{ $items->status_id }}">{{ $items->status_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row ">
                                        <div class="col-md-2 mt-4">
                                            <label for="com_repaire_user_id">ผู้แจ้งซ่อม </label>
                                        </div>
                                        <div class="col-md-2 mt-4">
                                            <div class="form-group"> 
                                                <select id="com_repaire_user_id" name="com_repaire_user_id" class="form-control"
                                                    style="width: 100%">
                                                    <option value="">==เลือก==</option>
                                                    @foreach ($users as $itemu)
                                                        <option value="{{ $itemu->id }}">{{ $itemu->fname }} {{ $itemu->lname }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mt-4">
                                            <label for="com_repaire_date">วันที่แจ้ง </label>
                                        </div>
                                        <div class="col-md-2 mt-4">
                                            <div class="form-group">
                                                <input id="" type="text" class="form-control"
                                                    name="" value="{{ DateThai($date) }}" readonly>
                                                <input id="com_repaire_date" type="hidden" class="form-control"
                                                    name="com_repaire_date" value="{{ $date }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2 mt-4">
                                            <label for="com_repaire_time">เวลา </label>
                                        </div>
                                        <div class="col-md-2 mt-4">
                                            <div class="form-group">
                                                <input id="com_repaire_time" type="text" class="form-control"
                                                    name="com_repaire_time" value="{{ formatetime($datetime) }}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row "> 
                                       <div class="col-md-2 mt-4">
                                            <label for="com_repaire_date">หน่วยงาน </label>
                                        </div>
                                        <div class="col-md-10 mt-4">
                                            <div class="form-group"> 
                                                <select id="com_repaire_debsubsub_id" name="com_repaire_debsubsub_id" class="form-control"
                                                    style="width: 100%">
                                                    <option value="">==เลือก==</option>
                                                    @foreach ($department_sub_sub as $itemdebsubsub)
                                                        <option value="{{ $itemdebsubsub->DEPARTMENT_SUB_SUB_ID }}">{{ $itemdebsubsub->DEPARTMENT_SUB_SUB_NAME }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row "> 
                                        <div class="col-md-2 mt-4">
                                            <label for="article_id">ครุภัณฑ์ที่แจ้งซ่อม </label>
                                        </div>
                                        <div class="col-md-10 mt-4">
                                            <div class="form-group">
                                                <select id="article_id" name="article_id" class="form-control"
                                                    style="width: 100%">
                                                    <option value="">==เลือก==</option>
                                                    @foreach ($article_data as $itemsar)
                                                    @if ( $dataedits->article_id == $itemsar->article_id)
                                                    <option value="{{ $itemsar->article_id }}" selected>{{ $itemsar->article_name }} </option>
                                                    @else
                                                    <option value="{{ $itemsar->article_id }}">{{ $itemsar->article_name }} </option>
                                                    @endif
                                                       
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row ">
                                        <div class="col-md-2 mt-4">
                                            <label for="com_repaire_detail">รายละเอียดแจ้งซ่อม </label>
                                        </div>
                                        <div class="col-md-10 mt-4">
                                            <div class="form-group">
                                                <textarea class="form-control" id="com_repaire_detail" name="com_repaire_detail" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col mt-4 ms-3">
                                        </div>

                                        <div class="col-md-8 mt-4">
                                            <h3 class="mt-1 text-center">Digital Signature</h3>
                                            <div id="signature-pad" class="mt-2 text-center">
                                                <div style="border:solid 1px teal;height:120px;">
                                                    <div id="note" onmouseover="my_function();" class="text-center">The
                                                        signature should be inside box</div>
                                                    <canvas id="the_canvas" width="220px" height="120px"></canvas>
                                                </div>

                                                <input type="hidden" id="signature" name="signature">
                                                {{-- <input type="hidden" id="user_id" name="user_id" > --}}
                                                {{-- <input type="hidden" name="store_id" id="store_id" > --}}

                                                <button type="button" id="clear_btn"
                                                    class="btn btn-secondary mt-3 ms-3 me-2" data-action="clear"><span
                                                        class="glyphicon glyphicon-remove"></span>
                                                    Clear</button>

                                                <button type="button" id="save_btn"
                                                    class="btn btn-info mt-3 me-2 text-white" data-action="save-png"
                                                    onclick="create()"><span class="glyphicon glyphicon-ok"></span>
                                                    Create</button>
        
                                            </div>
                                        </div>

                                        <div class="col mt-4">
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer text-end mb-2">
                                    <button type="button" id="saveBtn" class="btn btn-success me-2">
                                        <i class="fa-solid fa-circle-check text-white me-2"></i>
                                        บันทึกข้อมูล
                                    </button>
                                    <a href="{{ url('user_com/repair_com') }}" class="btn btn-danger me-2">
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
 

        <br> <br> <br>
<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
 
 <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
 <script src="{{ asset('apkclaim/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 <script src="{{ asset('apkclaim/libs/metismenu/metisMenu.min.js') }}"></script>
 <script src="{{ asset('apkclaim/libs/simplebar/simplebar.min.js') }}"></script>
 <script src="{{ asset('apkclaim/libs/node-waves/waves.min.js') }}"></script>
 
 <script src="{{ asset('apkclaim/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
 <script src="{{ asset('apkclaim/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
 <script src="{{ asset('apkclaim/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
 <script src="{{ asset('apkclaim/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js') }}"></script>
 <script src="{{ asset('apkclaim/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

 <!-- jquery.vectormap map -->
 <script src="{{ asset('apkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
 <script src="{{ asset('apkclaim/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}">
 </script>

 <!-- Required datatable js -->
 <script src="{{ asset('apkclaim/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('apkclaim/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

   <!-- Buttons examples -->
   <script src="{{ asset('apkclaim/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
   <script src="{{ asset('apkclaim/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
   <script src="{{ asset('apkclaim/libs/jszip/jszip.min.js') }}"></script>
   <script src="{{ asset('apkclaim/libs/pdfmake/build/pdfmake.min.js') }}"></script>
   <script src="{{ asset('apkclaim/libs/pdfmake/build/vfs_fonts.js') }}"></script>
   <script src="{{ asset('apkclaim/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
   <script src="{{ asset('apkclaim/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
   <script src="{{ asset('apkclaim/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

   <script src="{{ asset('apkclaim/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
 <script src="{{ asset('apkclaim/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>

 <!-- Responsive examples -->
 <script src="{{ asset('apkclaim/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
 <script src="{{ asset('apkclaim/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

  <!-- Datatable init js --> 
  <script src="{{ asset('apkclaim/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script> 
  <script src="{{ asset('apkclaim/libs/twitter-bootstrap-wizard/prettify.js') }}"></script>


  <script src="{{ asset('apkclaim/js/pages/form-wizard.init.js') }}"></script> 
 <script src="{{asset('asset/js/plugins/select2/js/select2.full.min.js')}}"></script>
 <script type="text/javascript" src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
 <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
 <script type="text/javascript" src="{{ asset('fullcalendar/lang/th.js') }}"></script> 
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 <!-- App js -->
 <script src="{{ asset('apkclaim/js/app.js') }}"></script>
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
            $('select').select2();
            // com_repaire_user_id
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
                var com_repaire_user_id = $('#com_repaire_user_id').val();
                var article_id = $('#article_id').val();
                // alert(signature);
                $.ajax({
                    url: "{{ route('com_repairscan_save') }}",
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
                        com_repaire_user_id,
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
                                        window.location.reload();
                                }
                            })
                        }
                    },
                });
            });

        });
    </script>

</body>
</html>


 
