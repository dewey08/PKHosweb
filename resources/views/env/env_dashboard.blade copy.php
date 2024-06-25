@extends('layouts.envnew')
@section('title', 'PK-OFFICER || ENV')

     

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
            border-top: 10px rgb(11, 170, 165) solid;
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
     use App\Http\Controllers\StaticController;
     use Illuminate\Support\Facades\DB;   
     $count_meettingroom = StaticController::count_meettingroom();

     //********************* */ แสดงผล  ***********************************
 ?>
    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="block-header block-header-default">
                    <h4 class="text-center mb-sm-0">ข้อมูลสิ่งแวดล้อมและความปลอดภัย</h4>                        
                </div>
            </div>
        </div>

        <div class="row mt-3">            
                <div class="col-xl-6 col-md-3">
                    <div class="main-card card" style="height: 150px">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12" style="background-color: rgb(165, 226, 255)">
                                    <div class="widget-chart widget-chart-hover">
                                        <div class="d-flex" style="background-color: rgb(165, 226, 255)">
                                            <div class="flex-grow-1" >
                                                <p class="text-white mb-2"> ระบบบำบัดน้ำเสีย <br><span>(จำนวนนับรวมเช็ค 1 วัน)</span></p>
                                                <p class="text-white mb-0" style="font-size: 2.25rem;">
                                                        {{-- {{$param_haveworkinday}} <span class="fs-20">{{number_format($param_perworkyear,2)}}%</span> --}}
                                                </p>                                                
                                            </div>
                                            
                                            {{-- <div class="avatar-sm me-2" style="height: 120px">
                                                <a href="1"
                                                    target="_blank">
                                                    <span class="avatar-title bg-light rounded-3 mt-3" style="height: 70px">
                                                        <p style="font-size: 10px;">
                                                            <button type="button" style="height: 100px;width: 100px"
                                                                class="mt-4 me-4 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3">
                                                            
                                                                    <i class="fa-solid fa-people-group font-size-24"></i>   <br> 
                                                                Detail
                                                            </button>
                                                        </p>
                                                    </span>
                                                </a>
                                            </div> --}}
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-3">
                    <div class="main-card card" style="height: 150px">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12" style="background-color: rgb(145, 228, 163)">
                                    <div class="widget-chart widget-chart-hover">
                                        <div class="d-flex" style="background-color: rgb(145, 228, 163)">
                                            <div class="flex-grow-1">
                                                <p class="text-start mb-2" style="font-size: 17px">ระบบบริหารจัดการขยะ</p>
                                                {{-- <h3 class="text-start mb-2 text-primary">1 / 1 คน</h3> --}}
                                            </div>
                                            {{-- <div class="avatar-sm me-2" style="height: 120px">
                                                <a href="1"
                                                    target="_blank">
                                                    <span class="avatar-title bg-light rounded-3 mt-3" style="height: 70px">
                                                        <p style="font-size: 10px;">
                                                            <button type="button" style="height: 100px;width: 100px"
                                                                class="mt-4 me-4 btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-light text-primary rounded-3">
                                                            
                                                                    <i class="fa-solid fa-people-group font-size-24"></i>   <br> 
                                                                Detail
                                                            </button>
                                                        </p>
                                                    </span>
                                                </a>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
        </div>

        <div class="row mt-3">            
            <div class="col-xl-6 col-md-3">
                <div class="main-card card" style="height: 150px">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12" style="background-color: rgb(165, 226, 255)">
                                <div class="widget-chart widget-chart-hover" style="background-color: rgb(165, 226, 255)">
                                    <div class="d-flex">
                                    อัตราส่วนน้ำบ่อบำบัด
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-3">
                <div class="main-card card" style="height: 150px">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12" style="background-color: rgb(145, 228, 163)">
                                <div class="widget-chart widget-chart-hover" style="background-color: rgb(145, 228, 163)">
                                    <div class="d-flex">
                                     อัตราส่วนประเภทขยะ           
                                    </div>
                                </div>
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
            // if($(this).is(':checked',true))  
            // {
            //     $(".sub_chk").prop('checked', true);  
            // } else {  
            //     $(".sub_chk").prop('checked',false);  
            // }  
            // }); 
            // $.ajaxSetup({
            //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            // });
            
           
            
             

            $("#spinner-div").hide(); //Request is complete so hide spinner

            $('#Save_opd222').click(function() {
                var datepicker = $('#datepicker').val(); 
                var datepicker2 = $('#datepicker2').val(); 
                //    alert(datepicker);
                $.ajax({
                    url: "{{ route('acc.account_pksave') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        datepicker,
                        datepicker2                        
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'ดึงข้อมูลสำเร็จ',
                                text: "You Pull data success",
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
                                    // window.location="{{url('warehouse/warehouse_index')}}";
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
