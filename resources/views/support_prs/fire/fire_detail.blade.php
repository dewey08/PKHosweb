
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>รายละเอียดถังดับเพลิง</title>



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
{{-- <link rel="stylesheet" href="{{ asset('css/dacccss.css') }}"> --}}
<style>
    body {
        font-family: 'Kanit', sans-serif;
        font-size: 14px;   
        }
        .cardfire{
    border-radius: 2em 2em 2em 2em;
    box-shadow: 0 0 15px pink;
    border:solid 1px #80acfd;
    /* box-shadow: 0 0 10px rgb(232, 187, 243); */
}
</style>
<?php

    use SimpleSoftwareIO\QrCode\Facades\QrCode;

    ?>
    {{-- <body onload="window.print()"> --}}
    </head>
    <body>
        
   
 <div class="container-fluid mt-3">
    <div class="row text-center">
        <div class="col"></div>
        <div class="col-md-3"><h2>รายละเอียดถังดับเพลิง</h2></div>
        <div class="col"></div>
    </div>
    <div class="row mt-2">
        <div class="col-sm-12">
            <div class="card cardfire">
                <div class="card-body">  
                        <div class="row">
                            <div class="col text-start">
                                @if ( $data_detail_->fire_imgname == Null )
                                <img src="{{asset('assets/images/defailt_img.jpg')}}" height="120px" width="90px" alt="Image" class="img-thumbnail"> 
                                @else
                                <img src="{{asset('storage/fire/'.$data_detail_->fire_imgname)}}" height="120px" width="90px" alt="Image" class="img-thumbnail">                                
                                @endif
                            </div> 
                            <div class="col-9">
                                <p>รหัส : {{$data_detail_->fire_num}}</p> 
                                <p>ชื่อ  : {{$data_detail_->fire_name}}</p> 
                                <p>วันหมดอายุ  : {{DateThai($data_detail_->fire_date_exp)}}</p> 
                                
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col text-start">
                                <p>ที่ตั้ง : {{$data_detail_->fire_location}}</p> 
                            </div>
                        </div>
                       
                        @foreach ($data_detail as $item) 
                                @if ($item->active == 'Y')
                                        <div class="row">
                                            <div class="col text-start">
                                                <p>สถานะ :  
                                                    @if ($item->active == 'Y')
                                                        พร้อมใช้
                                                    @else
                                                        ไม่พร้อมใช้
                                                    @endif
                                                    </p> 
                                                   
                                            </div>
                                           
                                        </div>
                                        <div class="row"> 
                                            <div class="col"> 
                                                <p>ผู้ตรวจ : {{ $item->fname }} {{ $item->lname }}</p> 
                                                <p>วันที่ตรวจ : {{dateThaifromFull($item->check_date)}}</p>  
                                            </div> 
                                            <div class="col-3">
                                                @if ($item->img == null)
                                                    <img src="{{ asset('assets/images/default-image.jpg') }}" height="60px" width="60px" alt="Header Avatar" class="rounded-circle">
                                                @else
                                                    <img src="{{ asset('storage/person/'.$item->img) }}" height="60px" width="60px" alt="Header Avatar" class="rounded-circle">
                                                @endif
                                            </div>
                                        </div>
                                @else
                                <div class="row">
                                    <div class="col text-start">
                                      
                                            @if ($item->active != 'Y')
                                            <p style="color: red">สถานะ : 
                                            ไม่พร้อมใช้  </p> 
                                                @else
                                                
                                            @endif 
                                        
                                    </div>
                                    {{-- <div class="col-9 text-start"> 
                                        @if ($item->active == 'Y')
                                            พร้อมใช้
                                        @else
                                        <p style="color: red"> ไม่พร้อมใช้</p> 
                                    @endif 
                                    </div>  --}}
                                   
                                </div>
                                {{-- rounded-circle header-profile-user --}}
                                <div class="row">
                                    <div class="col text-start">
                                        
                                            @if ($item->active != 'Y')
                                                <p style="color: red">การแก้ไข : 
                                                    @if ($item->fire_edit == 'Chang')
                                                        เปลี่ยนถังสำรอง
                                                    @elseif($item->fire_edit == 'Repaire')
                                                        ส่งซ่อม/เติมน้ำยา
                                                    @elseif($item->fire_edit == 'Dispose')
                                                        จำหน่าย
                                                    @else
                                                        
                                                    @endif
                                                </p> 
                                                <p style="color: red">รายการชำรุด  : 
                                                    @if ($item->fire_check_injection == '1')
                                                    สายฉีด,                                                                                                 
                                                    @endif
                                                    @if ($item->fire_check_joystick == '1')
                                                    คันบังคับ,
                                                    @endif
                                                    @if ($item->fire_check_body == '1')
                                                    ตัวถัง,
                                                    @endif
                                                    @if ($item->fire_check_gauge == '1')
                                                    เกจความดัน,
                                                    @endif
                                                    @if ($item->fire_check_drawback == '1')
                                                    สิ่งกีดขวาง,
                                                    @endif
                                                
                                                </p> 
                                            @else
                                                 
                                            @endif
                                          
                                          
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col text-start"> 
                                        <p>ผู้ตรวจ : {{ $item->fname }} {{ $item->lname }}</p> 
                                        <p>วันที่ตรวจ : {{dateThaifromFull($item->check_date)}}</p>    
                                    </div> 
                                    <div class="col-3">
                                        @if ($item->img == null)
                                            <img src="{{ asset('assets/images/default-image.jpg') }}" height="60px" width="60px" alt="Header Avatar" class="rounded-circle">
                                        @else
                                            <img src="{{ asset('storage/person/'.$item->img) }}" height="60px" width="60px" alt="Header Avatar" class="rounded-circle">
                                        @endif
                                    </div>
                                </div>
                                    
                                @endif
                       
                        {{-- <div class="row"> 
                            <div class="col text-start">  
                                <p>วันที่ตรวจ : {{dateThaifromFull($item->check_date)}}</p>  
                            </div> 
                        </div> --}}
                        @endforeach
                    
                </div> 
            </div>
            {{-- @foreach ($data_detail as $item)
                <div class="card cardfire">
                    <div class="card-body">  
                        <div class="row"> 
                            <div class="col">
                                <p>วันที่ตรวจ : {{dateThaifromFull($item->check_date)}}</p> 
                                <p>รายการชำรุด  : 
                                    @if ($item->fire_check_injection == '1')
                                    สายฉีด,                                                                                                 
                                    @endif
                                    @if ($item->fire_check_joystick == '1')
                                    คันบังคับ,
                                    @endif
                                    @if ($item->fire_check_body == '1')
                                    ตัวถัง,
                                    @endif
                                    @if ($item->fire_check_gauge == '1')
                                    เกจความดัน,
                                    @endif
                                    @if ($item->fire_check_drawback == '1')
                                    สิ่งกีดขวาง,
                                    @endif
                                
                                </p> 
                                <p>การแก้ไข : {{$item->fire_location}}</p> 
                                <p>สถานะ :  
                                @if ($item->active == 'Y')
                                    พร้อมใช้
                                @else
                                    ไม่พร้อมใช้
                                @endif
                                </p> 
                                <p>ผู้ตรวจ : {{ $item->fname }}-{{ $item->lname }}</p> 
                            </div> 
                        </div>  
                    </div> 
                </div>
            @endforeach --}}
           
        </div> 
    </div>
</div>
</body>
</html>
    
     
     
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
     <script>
        $(document).ready(function() {
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
 
            
        });
    </script>
</body>
        
                     
