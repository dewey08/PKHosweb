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
                        <h4 class="mb-sm-0">ทะเบียนควบคุมแผนงานโครงการ</h4>
        
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">ทะเบียนควบคุมแผนงานโครงการ</a></li>
                                <li class="breadcrumb-item active">ทะเบียน</li>
                            </ol>
                        </div>
        
                    </div>
                </div>
            </div> 
        </div> 
        <div class="row"> 
            <div class="col-xl-6">
                <div class="row"> 
                    <div class="col"></div>
                    <div class="col-xl-6">
                        <a href="{{url('plan_control_sub')}}" target="_blank">
                            <div class="card cardplan"> 
                                <div class="card-body p-3">
                                    <img src="{{ asset('images/cpso.png') }}" height="100px" width="100px" class="rounded-circle me-3"> 
                                    คปสอ.ภูเขียว
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col"></div>
                </div>
                {{-- <div class="row"> 
                    <div class="col-xl-3">
                        <a href="{{url('plan_control_sub/1')}}" target="_blank">
                            <div class="card cardplan"> 
                                <div class="card-body p-3">
                                    <img src="{{ asset('images/cpso.png') }}" height="70px" width="70px" class="rounded-circle me-3"> 
                                    PP
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3">
                        <a href="{{url('plan_control_sub/2')}}" target="_blank">
                            <div class="card cardplan"> 
                                <div class="card-body p-3">
                                    <img src="{{ asset('images/cpso.png') }}" height="70px" width="70px" class="rounded-circle me-3"> 
                                    UC
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3">
                        <a href="{{url('plan_control_sub/3')}}" target="_blank">
                            <div class="card cardplan"> 
                                <div class="card-body p-3">
                                    <img src="{{ asset('images/cpso.png') }}" height="70px" width="70px" class="rounded-circle me-3"> 
                                    อปท
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3">
                        <a href="{{url('plan_control_sub/4')}}" target="_blank">
                            <div class="card cardplan"> 
                                <div class="card-body p-3">
                                    <img src="{{ asset('images/cpso.png') }}" height="70px" width="70px" class="rounded-circle me-3"> 
                                    อื่น ๆ
                                </div>
                            </div>
                        </a>
                    </div>
                </div>     --}}
                <div class="row"> 
                    @foreach ($plan_strategic as $item)
                        <div class="col-xl-12">
                            <a href="{{url('plan_control_sub/'.$item->plan_strategic_id)}}" target="_blank">
                                <div class="card cardplan"> 
                                    <div class="card-body p-3">
                                        <img src="{{ asset('images/cpso.png') }}" height="70px" width="70px" class="rounded-circle me-3"> 
                                        {{$item->plan_strategic_name}}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach                    
                </div>  
                
            </div>
            <div class="col-xl-6">
                <div class="row"> 
                    <div class="col"></div>
                    <div class="col-xl-6">
                        <a href="{{url('plan_control_subhos')}}" target="_blank">
                            <div class="card cardplan"> 
                                <div class="card-body p-3">
                                    <img src="{{ asset('images/hos.png') }}" height="100px" width="100px" class="rounded-circle me-3"> 
                                Hospital
                                    
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col"></div>
                </div>
                <div class="row"> 
                    @foreach ($plan_strategic as $item)
                    <div class="col-xl-12">
                        <a href="{{url('plan_control_sub/'.$item->plan_strategic_id)}}" target="_blank">
                            <div class="card cardplan"> 
                                <div class="card-body p-3">
                                    <img src="{{ asset('images/hos.png') }}" height="70px" width="70px" class="rounded-circle me-3"> 
                                    {{$item->plan_strategic_name}}
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach     
                    {{-- <div class="col-xl-3">
                        <a href="{{url('plan_control_subhos_pp')}}" target="_blank">
                            <div class="card cardplan"> 
                                <div class="card-body p-3">
                                    <img src="{{ asset('images/hos.png') }}" height="70px" width="70px" class="rounded-circle me-3"> 
                                    PP
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3">
                        <a href="{{url('plan_control_subhos_uc')}}" target="_blank">
                            <div class="card cardplan"> 
                                <div class="card-body p-3">
                                    <img src="{{ asset('images/hos.png') }}" height="70px" width="70px" class="rounded-circle me-3"> 
                                    UC
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3">
                        <a href="{{url('plan_control_subhos_lgo')}}" target="_blank">
                            <div class="card cardplan"> 
                                <div class="card-body p-3">
                                    <img src="{{ asset('images/hos.png') }}" height="70px" width="70px" class="rounded-circle me-3"> 
                                    อปท
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3">
                        <a href="{{url('plan_control_subhos_orther')}}" target="_blank">
                            <div class="card cardplan"> 
                                <div class="card-body p-3">
                                    <img src="{{ asset('images/hos.png') }}" height="70px" width="70px" class="rounded-circle me-3"> 
                                    อื่น ๆ
                                </div>
                            </div>
                        </a>
                    </div> --}}
                </div> 
            </div> 
        </div>
        {{-- <div class="row">
            <div class="col"></div>
            <div class="col-xl-4">
                <a href="{{url('plan_control_sub')}}" target="_blank">
                    <div class="card cardplan"> 
                        <div class="card-body p-3">
                            <img src="{{ asset('images/cpso.png') }}" height="100px" width="100px" class="rounded-circle me-3"> 
                            คปสอ.ภูเขียว
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4">
                <a href="{{url('plan_control_subhos')}}" target="_blank">
                    <div class="card cardplan"> 
                        <div class="card-body p-3">
                            <img src="{{ asset('images/hos.png') }}" height="100px" width="100px" class="rounded-circle me-3"> 
                        Hospital
                            
                        </div>
                    </div>
                </a>
            </div>
            <div class="col"></div>
        </div> --}}
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
                alert(obj_billno);
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
