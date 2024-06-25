@extends('layouts.support_prs')
@section('title', 'PK-OFFICER || Fire')
 
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
    ?>
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
    </style>
    
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
       
        <div class="row"> 
            <div class="col-md-6">
                <h4 class="card-title" style="color:rgb(10, 151, 85)">REPORT FIRE </h4>
                <p class="card-title-desc">แบบประเมินความพึงพอใจการใช้งานระบบสารสนเทศตรวจดูผลการเช็คถังดับเพลิง(สำหรับผู้ใช้งานทั่วไป)
                    โรงพยาบาลภูเขียวเฉลิมพระเกียรติ จังหวัดชัยภูมิ
                    </p>
            </div>
            <div class="col"></div>
            <div class="col-md-4 text-end">
                <form action="{{ url('fire_report_day') }}" method="GET">
                    @csrf
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control cardacc" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control cardacc" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>  
                        <button type="submit" class="ladda-button btn-pill btn btn-primary cardacc" data-style="expand-left">
                            <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span> 
                        </button> 
                    </form>
                 
                </div> 
            </div>
    </div>  
        
        <div class="row">
            <div class="col-xl-12">
                <div class="card cardacc">
                    <div class="card-body">    
                        <div class="row mb-3">
                           
                            <div class="col"></div>
                            <div class="col-md-5 text-end">
                              
                            </div>
                        </div>

                        <p class="mb-0">
                            <div class="table-responsive">
                                {{-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr> 
                                            <th width="5%" class="text-center">ลำดับ</th>  
                                            <th class="text-center" >วันที่ตรวจ</th>  
                                            <th class="text-center" >รหัสถังดับเพลิง</th>  
                                            <th class="text-center" >สายฉีด</th>
                                            <th class="text-center" >คันบังคับ</th> 
                                            <th class="text-center" >ตัวถัง</th>  
                                            <th class="text-center" >เกจความดัน</th>  
                                            <th class="text-center" >สิ่งกีดขวาง</th> 
                                            <th class="text-center" >รายการชำรุด</th> 
                                            <th class="text-center" >ผู้ตรวจ</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        {{-- @foreach ($datashow as $item) 
                                            <tr id="tr_{{$item->fire_num}}">                                                  
                                                <td class="text-center" width="5%">{{ $i++ }}</td>  
                                                <td class="text-center" width="8%">{{ Datethai($item->check_date) }}</td> 
                                                <td class="text-center" width="8%">{{ $item->fire_num }}</td>  
                                                <td class="text-center" width="7%"> 
                                                    @if ($item->fire_check_injection == '0')
                                                         <p style="color: #08d6aa">ปกติ</p>
                                                    @else
                                                        <p style="color: #fc2424">ชำรุด</p>
                                                    @endif
                                                </td>  
                                                <td class="text-center" width="7%"> 
                                                    @if ($item->fire_check_joystick == '0')
                                                        <p style="color: #08d6aa">ปกติ</p>
                                                    @else
                                                        <p style="color: #fc2424">ชำรุด</p>
                                                    @endif
                                                </td>   
                                                <td class="text-center" width="7%"> 
                                                    @if ($item->fire_check_body == '0')
                                                        <p style="color: #08d6aa">ปกติ</p>
                                                    @else
                                                        <p style="color: #fc2424">ชำรุด</p>
                                                    @endif
                                                </td>   
                                                <td class="text-center" width="7%"> 
                                                    @if ($item->fire_check_gauge == '0')
                                                        <p style="color: #08d6aa">ปกติ</p>
                                                    @else
                                                        <p style="color: #fc2424">ชำรุด</p>
                                                    @endif
                                                </td> 
                                                <td class="text-center" width="7%"> 
                                                    @if ($item->fire_check_drawback == '0')
                                                        <p style="color: #08d6aa">ปกติ</p>
                                                    @else
                                                        <p style="color: #fc2424">ชำรุด</p>
                                                    @endif
                                                </td> 
                                                <td class="p-2" style="color:rgb(73, 147, 231)">
                                                    <p style="color: #fc2424">
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
                                                </td>   
                                                <td class="text-center" width="12%">{{ $item->ptname }}</td>                                              
                                            </tr>
                                        @endforeach --}}
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

            $('#stamp').on('click', function(e) {
                    if($(this).is(':checked',true))  
                    {
                        $(".sub_chk").prop('checked', true);  
                    } else {  
                        $(".sub_chk").prop('checked',false);  
                    }  
            });             
            $('#Process').click(function() {
                var startdate = $('#datepicker').val(); 
                var enddate = $('#datepicker2').val(); 
                Swal.fire({
                        title: 'ต้องการประมวลผลข้อมูลใช่ไหม ?',
                        text: "You Want Process Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Want Process it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(200);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('tec.cctv_report_process') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {startdate,enddate},
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'ประมวลผลข้อมูลสำเร็จ',
                                                text: "You Process data success",
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
                                                    $('#spinner').hide();//Request is complete so hide spinner
                                                        setTimeout(function(){
                                                            $("#overlay").fadeOut(200);
                                                        },400);
                                                }
                                            })
                                        } else if (data.status == 100) {
                                            const Toast = Swal.mixin({
                                                toast: true,
                                                position: "top-end",
                                                showConfirmButton: false,
                                                timer: 3000,
                                                timerProgressBar: true,
                                                didOpen: (toast) => {
                                                    toast.onmouseenter = Swal.stopTimer;
                                                    toast.onmouseleave = Swal.resumeTimer;
                                                }
                                                });
                                                Toast.fire({
                                                icon: "error",
                                                title: "กรุณาเลือกวันที่"
                                                });
                                                $('#spinner').hide();//Request is complete so hide spinner
                                                    setTimeout(function(){
                                                        $("#overlay").fadeOut(200);
                                                    },400);
                                        } else {
                                             
                                        }
                                    },
                                });
                                
                            }
                })
        });
             
            $("#spinner-div").hide(); //Request is complete so hide spinner
         
            
        });
    </script>
    @endsection
