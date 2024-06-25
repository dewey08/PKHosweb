    {{-- <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />  --}}
    {{-- <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'> --}}
     <!-- DataTables -->
     {{-- <link href="{{ asset('pkclaim/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
     type="text/css" />
 <link href="{{ asset('pkclaim/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
     type="text/css" />
 <link href="{{ asset('pkclaim/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet"
     type="text/css" /> --}}

 <!-- Responsive datatable examples -->
 {{-- <link href="{{ asset('pkclaim/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
     rel="stylesheet" type="text/css" /> --}}
    <!-- Bootstrap Css -->
    {{-- <link href="{{ asset('pkclaim/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />  --}}
    <!-- App Css-->
    {{-- <link href="{{ asset('pkclaim/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" /> --}}
    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Font Awesome -->
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Srisakdi&display=swap" rel="stylesheet"> --}}
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('pkclaim/images/logo150.ico') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- <link href="{{ asset('pkclaim/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"> --}}
    <link href="{{ asset('pkclaim/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('pkclaim/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('pkclaim/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">

    <!-- jquery.vectormap css -->
    <link href="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{ asset('pkclaim/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('pkclaim/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('pkclaim/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('pkclaim/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('pkclaim/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('pkclaim/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('pkclaim/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
    <!-- select2 -->
    <link rel="stylesheet" href="{{ asset('asset/js/plugins/select2/css/select2.min.css') }}">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <link rel="stylesheet"
        href="{{ asset('disacc/vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css') }}">
    <link href="{{ asset('acccph/styles/css/base.css') }}" rel="stylesheet"> --}}

    <link rel="stylesheet" href="{{ asset('disacc/vendors/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('disacc/vendors/ionicons-npm/css/ionicons.css') }}">
    <link rel="stylesheet" href="{{ asset('disacc/vendors/linearicons-master/dist/web-font/style.css') }}">
    <link rel="stylesheet"
        href="{{ asset('disacc/vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css') }}">
    <link href="{{ asset('disacc/styles/css/base.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dacccss.css') }}">
 
</head>
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            font-size: 14px;   
            }
            .card_fire{
                border-radius: 2em 2em 2em 2em;
                box-shadow: 0 0 10px pink;
            }
            .checkboxs{
            width: 25px;
            height: 25px;
           }
    </style>
    <?php
        use SimpleSoftwareIO\QrCode\Facades\QrCode;
    ?> 
    <body> 
        <div class="container-fluid p-5">
            <div class="row mt-3">
                <div class="card card_fire">
                    <div class="card-header card_fire text-center mt-2">
                        <h3>แบบประเมินความพึงพอใจการใช้งานระบบสารสนเทศตรวจดูผลการเช็คถังดับเพลิง(สำหรับผู้ใช้งานทั่วไป)<br>
                            โรงพยาบาลภูเขียวเฉลิมพระเกียรติ จังหวัดชัยภูมิ
                            </h3>
                    </div>
                    <div class="card-body"> 
                        <div class="row">
                            <div class="col">
                                <h5>
                                    คำชี้แจง แบบสอบถามชุดนี้จัดทำขึ้นเพื่อประเมินความพึงพอใจ/ไม่พึงพอใจ ความต้องการและความคาดหวังของผู้รับบริการต่อการใช้งานระบบสารสนเทศตรวจดูผลเช็คถังดับเพลิง(สำหรับผู้ใช้งานทั่วไป)  
                                    ซึ่งข้อมูลที่ได้จะเป็นประโยชน์อย่างยิ่งต่อการพัฒนาระบบให้มีประสิทธิภาพต่อไป
                                </h5>
                                <h4>
                                    กรุณาทำเครื่องหมาย  <img src="{{ asset('images/true.png') }}" alt="" height="30"> ในช่องที่ท่านเลือก 
                                </h4>
                                <h3 style="color: rgb(6, 151, 103)"> 
                                    ตอนที่ 1  ข้อมูลทั่วไปของผู้ตอบแบบสอบถาม 
                                </h3> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <h5>1. เพศ </h5>
                            </div>
                            <div class="col-3">
                                <div class="form-check">
                                    <input class="form-check-input checkboxs mt-2" type="radio" name="flexRadioDefault" id="sex_man" checked>
                                    <label class="form-check-label mt-2 ms-2" for="sex_man">
                                        ชาย
                                    </label>
                                  </div>  
                            </div>
                            <div class="col-3">
                                <div class="form-check">
                                    <input class="form-check-input checkboxs mt-2" type="radio" name="flexRadioDefault" id="sex_men">
                                    <label class="form-check-label mt-2 ms-2" for="sex_men">
                                      หญิง
                                    </label>
                                  </div>
                            </div>
                            <div class="col"></div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <h5>2. ประเภทผู้ใช้บริการ </h5>
                            </div>
                            <div class="col-3">
                                <div class="form-check">
                                    <input class="form-check-input checkboxs mt-2" type="radio" name="flexRadioType" id="user_type_a">
                                    <label class="form-check-label mt-2 ms-2" for="user_type_a">
                                        ผู้รับบริการ
                                    </label>
                                  </div>  
                            </div>
                            <div class="col-3">
                                <div class="form-check">
                                    <input class="form-check-input checkboxs mt-2" type="radio" name="flexRadioType" id="user_type_b" checked>
                                    <label class="form-check-label mt-2 ms-2" for="user_type_b">
                                        บุคลากร รพ.
                                    </label>
                                  </div>
                            </div>
                            <div class="col"></div>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <h5>3. อายุ </h5>
                            </div>
                            <div class="col-3">
                                <div class="form-check">
                                    <input class="form-check-input checkboxs mt-2" type="radio" name="flexRadioAge" id="age_1">
                                    <label class="form-check-label mt-2 ms-2" for="age_1">
                                        ต่ำกว่า 19 ปี
                                    </label>
                                  </div>  
                            </div>
                            <div class="col-2">
                                <div class="form-check">
                                    <input class="form-check-input checkboxs mt-2" type="radio" name="flexRadioAge" id="age_2">
                                    <label class="form-check-label mt-2 ms-2" for="age_2">
                                        19-24 ปี
                                    </label>
                                  </div>  
                            </div>
                            <div class="col-2">
                                <div class="form-check">
                                    <input class="form-check-input checkboxs mt-2" type="radio" name="flexRadioAge" id="age_3">
                                    <label class="form-check-label mt-2 ms-2" for="age_3">
                                        25-40 ปี	
                                    </label>
                                  </div>
                            </div>
                            <div class="col-3">
                                <div class="form-check">
                                    <input class="form-check-input checkboxs mt-2" type="radio" name="flexRadioAge" id="age_4">
                                    <label class="form-check-label mt-2 ms-2" for="age_4">
                                        40 ปีขึ้นไป	
                                    </label>
                                  </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col"> 
                                <h3 style="color: rgb(6, 151, 103)"> 
                                    ตอนที่ 2  ระดับความพึงพอใจในการใช้งานระบบสารสนเทศ  
                                </h3> 
                                <h4 style="color: rgb(6, 151, 103)"> 
                                    โดยมีเกณฑ์วัดระดับดังนี้    5 = มากที่สุด 4 = มาก 3 = ปานกลาง  2 = น้อย 1 = น้อยที่สุด 0 = ไม่พึงพอใจ
                                </h4> 
                            </div> 
                        </div>
                        {{-- <div class="row">
                            <div class="col">  
                                <h4 style="color: rgb(6, 151, 103)"> 
                                      1 = น้อยที่สุด 0 = ไม่พึงพอใจ
                                </h4> 
                            </div> 
                        </div> --}}
<form>
                        <div class="row">
                            <div class="col">  
                               <table class="table table-bordered table-striped table-hover" style="width: 100%">
                                    <thead> 
                                        <tr>
                                            <th colspan="1" class="text-center" style="width: 50%">ประเด็นวัดความพึงพอใจ</th>
                                            <th colspan="5" class="text-center" style="width: 25%">ระดับความพึงพอใจ</th>
                                            <th class="text-center" style="width: 15%">ไม่พึงพอใจ</th>
                                        </tr>
                                        <tr>
                                            <th colspan="1" class="text-center" style="width: 50%"></th>
                                            <th class="text-center">5</th>
                                            <th class="text-center">4</th>
                                            <th class="text-center">3</th>
                                            <th class="text-center">2</th>
                                            <th class="text-center">1</th>
                                            <th class="text-center">0</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datashow as $item)
                                            <tr id="tr_{{$item->fire_pramuan_id}}">
                                                <td colspan="1" class="text-start">
                                                    <input class="form-check-input checkboxs sub_chk" type="hidden" name="fire_pramuan_id" value="{{$item->fire_pramuan_id}}" data-id="{{$item->fire_pramuan_id}}" checked>
                                                    <input class="form-check-input" type="hidden" name="fire_pramuan_name" value="{{$item->fire_pramuan_name}}">
                                                    {{$item->fire_pramuan_name}}
                                                </td> 
                                                <td class="text-center">
                                                    <input class="form-check-input checkboxs sub_chk" type="radio" name="pramuan5" value="5" data-id="{{$item->fire_pramuan_id}}">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input checkboxs sub_chk" type="radio" name="pramuan4" value="4" data-id="{{$item->fire_pramuan_id}}">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input checkboxs sub_chk" type="radio" name="pramuan3" value="3" data-id="{{$item->fire_pramuan_id}}">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input checkboxs sub_chk" type="radio" name="{{$item->fire_pramuan_id}}" value="2">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input checkboxs sub_chk" type="radio" name="{{$item->fire_pramuan_id}}" value="1">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input checkboxs sub_chk" type="radio" name="{{$item->fire_pramuan_id}}" value="0">
                                                </td>
                                            </tr>
                                        @endforeach
                                        
                                    
                                    </tbody>
                               </table>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="button" class="ladda-button me-2 btn-pill btn btn-primary cardacc Savestamp_2" data-url="{{url('fire_pramuan_save')}}">
                                {{-- <button type="submit" class="ladda-button me-2 btn-pill btn btn-primary cardacc Savestamp"> --}}
                                    <i class="fa-solid fa-file-waveform me-2"></i>
                                    บันทึกข้อมูล
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>  
        </div>
    </div>
</form>
     <!-- JAVASCRIPT -->
     {{-- <script src="{{ asset('pkclaim/libs/jquery/jquery.min.js') }}"></script>
     <script src="{{ asset('pkclaim/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>  --}}
     <!-- JAVASCRIPT -->
    <script src="{{ asset('pkclaim/libs/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('pkclaim/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/node-waves/waves.min.js') }}"></script>

    <script src="{{ asset('js/select2.min.js') }}"></script>
    {{-- <script src="{{ asset('pkclaim/libs/select2/js/select2.min.js') }}"></script> --}}
    <script src="{{ asset('pkclaim/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
 
    <script type="text/javascript" src="{{ asset('acccph/vendors/jquery-circle-progress/dist/circle-progress.min.js') }}"></script>  
    <script type="text/javascript" src="{{ asset('acccph/vendors/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('acccph/vendors/toastr/build/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('acccph/vendors/jquery.fancytree/dist/jquery.fancytree-all-deps.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('acccph/vendors/apexcharts/dist/apexcharts.min.js') }}"></script>

    <script src="{{ asset('pkclaim/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"
        integrity="sha512-cp+S0Bkyv7xKBSbmjJR0K7va0cor7vHYhETzm2Jy//ZTQDUvugH/byC4eWuTii9o5HN9msulx2zqhEXWau20Dg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- jquery.vectormap map -->
    <script src="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}">
    </script>

    <!-- Required datatable js -->
    <script src="{{ asset('pkclaim/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
     <!-- Buttons examples -->
    <script src="{{ asset('pkclaim/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('pkclaim/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('pkclaim/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->
    <script src="{{ asset('pkclaim/js/pages/datatables.init.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>

    <script src="{{ asset('pkclaim/libs/twitter-bootstrap-wizard/prettify.js') }}"></script>


    <script src="{{ asset('pkclaim/js/pages/form-wizard.init.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lang/th.js') }}"></script>
     <script>
            $(document).ready(function() {
                    $('#example').DataTable();
                    $('#example2').DataTable();
                    $('#datepicker').datepicker({
                        format: 'yyyy-mm-dd'
                    });
                    $('#datepicker2').datepicker({
                        format: 'yyyy-mm-dd'
                    });
                    // $('#stamp').on('click', function(e) {
                    //     if($(this).is(':checked',true))  
                    //     {
                    //         $(".sub_chk").prop('checked', true);  
                    //     } else {  
                    //         $(".sub_chk").prop('checked',false);  
                    //     }  
                    // }); 
                    $("#spinner-div").hide(); //Request is complete so hide spinner
                    $('.Savestamp_2').on('click', function(e) {
                        // alert('##Savestamp');
                        var allValls = [];
                        var pramuan = [];
                        // var value = [];
                        $(".sub_chk:checked").each(function () {
                            allValls.push($(this).attr('data-id'));
                            // names.push($(this).attr('data-name'));
                            // values.push($(this).attr('value'));
                            $('input[name^="pramuan5"]').each(function () {
                                pramuan5.push($(this).val());
                         });
                            // alert(allValls);
                            // alert(names);
                            alert(pramuan5);
                        });
                        if (allValls.length <= 0) {
                            // alert("SSSS");
                            Swal.fire({
                                title: 'คุณยังไม่ได้เลือกรายการ ?',
                                text: "กรุณาเลือกรายการก่อน",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33', 
                                }).then((result) => {
                                
                                })
                        } else {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "คุณต้องการตั้งลูกหนี้รายการนี้ใช่ไหม!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, Debtor it.!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        var check = true;
                                        if (check == true) {
                                            var join_selected_values = allValls.join(",");
                                            // var join_selected_name = names.join(",");
                                            var join_selected_name = names.push($(this).attr('data-name'));
                                            // alert(join_selected_values);
                                            $("#overlay").fadeIn(300);　
                                            $("#spinner").show(); //Load button clicked show spinner 

                                            $.ajax({
                                                url:$(this).data('url'),
                                                type: 'POST',
                                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                data: {join_selected_values,join_selected_name}, 
                                                // data: 'ids='+join_selected_values, 
                                                success:function(data){ 
                                                        // if (data.status == 200) {
                                                        //     $(".sub_chk:checked").each(function () {
                                                        //         $(this).parents("tr").remove();
                                                        //     });
                                                        //     Swal.fire({
                                                        //         title: 'ตั้งลูกหนี้สำเร็จ',
                                                        //         text: "You Debtor data success",
                                                        //         icon: 'success',
                                                        //         showCancelButton: false,
                                                        //         confirmButtonColor: '#06D177',
                                                        //         confirmButtonText: 'เรียบร้อย'
                                                        //     }).then((result) => {
                                                        //         if (result
                                                        //             .isConfirmed) {
                                                        //             console.log(
                                                        //                 data);
                                                        //             window.location.reload();
                                                        //             $('#spinner').hide();//Request is complete so hide spinner
                                                        //         setTimeout(function(){
                                                        //             $("#overlay").fadeOut(300);
                                                        //         },500);
                                                        //         }
                                                        //     })
                                                        // } else {
                                                            
                                                        // } 
                                                
                                                }
                                            });
                                            $.each(allValls,function (index,value) {
                                                $('table tr').filter("[data-row-id='"+value+"']").remove();
                                            });
                                        }
                                    }
                                }) 
                            // var check = confirm("Are you want ?");  
                        }
                    }); 
                    
                    $('.Savestamp').on('click', function(e) {
                         e.preventDefault();
                         const fire_pramuan_id   = [];
                         const fire_pramuan_name = [];
                         const pramuan_5         = [];
                         const pramuan_4         = [];
                         const pramuan_3         = [];
                         const pramuan_2         = [];
                         const pramuan_1         = [];
                         const pramuan_0         = [];
                         alert(fire_pramuan_id);
                         $('.fire_pramuan_id').each(function () {
                            if ($(this).is(":checked")) {
                                fire_pramuan_id.push($(this).val());
                            }
                         });
                         $('input[name^="fire_pramuan_name"]').each(function () {
                            fire_pramuan_name.push($(this).val());
                         });
                         $('input[name^="pramuan_5"]').each(function () {
                                pramuan_5.push($(this).val());
                         });
                         $('input[name^="pramuan_4"]').each(function () {
                                pramuan_4.push($(this).val());
                         });
                         $('input[name^="pramuan_3"]').each(function () {
                                pramuan_3.push($(this).val());
                         });
                         $('input[name^="pramuan_2"]').each(function () {
                                pramuan_2.push($(this).val());
                         });
                         $('input[name^="pramuan_1"]').each(function () {
                                pramuan_1.push($(this).val());
                         });
                         $('input[name^="pramuan_0"]').each(function () {
                                pramuan_0.push($(this).val());
                         });
                         alert(pramuan_0);
                         $.ajax({
                            url:'{{route('prs.fire_pramuan_save')}}',
                            type:'POST',
                            data:{
                                "_token":"{{csrf_token()}}",
                                fire_pramuan_id:fire_pramuan_id,
                                fire_pramuan_name:fire_pramuan_name,
                                pramuan_5:pramuan_5,
                                pramuan_4:pramuan_4,
                                pramuan_3:pramuan_3,
                                pramuan_2:pramuan_2,
                                pramuan_1:pramuan_1,
                                pramuan_0:pramuan_0
                            },
                            success:function(response){
                                // if (response.status =='200') {
                                //     Swal.fire({
                                //     position: "top-end",
                                //     title: 'บันทึกข้อมูลสำเร็จ!',
                                //     text: "You Save data success",
                                //     icon: 'success',
                                //     showCancelButton: false,
                                //     confirmButtonColor: '#06D177',
                                //     // cancelButtonColor: '#d33',
                                //     confirmButtonText: 'เรียบร้อย'
                                // }).then((result) => {
                                //     if (result.isConfirmed) {
                                //         $("#sid" + fire_id).remove(); 
                                //         window.location = "{{ url('fire_pramuan') }}";
                                //     }
                                // }) 
                                // }
                            }
                         });

                        
                    }); 
            }); 
     </script>
    </body>
        
                     
