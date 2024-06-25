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
    <form action="{{ url('air_report_building') }}" method="GET">
        @csrf
        <div class="row"> 
            <div class="col-md-6">
                <h4 style="color:rgb(10, 151, 85)">รายงานการข้อมูลเครื่องปรับอากาศ โรงพยาบาลภูเขียวเฉลิมพระเกียรติ ปีงบประมาณ </h4>
                {{-- <p class="card-title-desc">รายงานถังดับเพลิง</p> --}}
            </div>
             
            <div class="col"></div>
            <div class="col-md-2 text-end"> 
                {{-- <a href="{{url('air_report_building_excel')}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">
                    <i class="fa-solid fa-file-excel me-2"></i>
                    Export To Excel
                </a> --}}
                <a href="{{url('air_report_building_excel')}}" class="ladda-button btn-pill btn btn-success card_prs_4">
                    <span class="ladda-label"> <i class="fa-solid fa-file-excel text-white me-2"></i>Export To Excel</span>  
                </a>
            
            </div>
        </div>  
    </form>
 
<div class="row mt-3">
    <div class="col-xl-12">
        <div class="card card_prs_4">
            <div class="card-body">    
                

                <p class="mb-0">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">                        
                            <thead>                             
                                    <tr style="font-size:13px"> 
                                        <th rowspan="2" width="3%" class="text-center" style="background-color: rgb(255, 251, 228);width: 5%">ลำดับ</th>  
                                        <th rowspan="2" class="text-center" style="background-color: rgb(199, 253, 237)">อาคาร</th>  
                                        <th rowspan="2" class="text-center" style="background-color: rgb(199, 253, 237);width: 7%">เลขอาคาร</th>  
                                        <th rowspan="2" class="text-center" style="background-color: rgb(199, 253, 237);width: 7%">จำนวน</th>  
                                        <th colspan="6" class="text-center" style="background-color: rgb(239, 228, 255);width: 40%">ขนาด(btu)</th>   
                                    </tr> 
                                    <tr style="font-size:13px">  
                                        <th class="text-center" >ต่ำกว่า 10000</th> 
                                        <th class="text-center" >10001-20000</th>   
                                        <th class="text-center" >20001-30000</th> 
                                        <th class="text-center" >30001-40000</th>
                                        <th class="text-center" >40001-50000</th>
                                        <th class="text-center" >50000 ขึ้นไป</th>
                                    </tr> 
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($datashow as $item) 
                                <?php $i++ ?>                               
                                    <tr>                                                  
                                        <td class="text-center" style="font-size:13px;width: 5%;color: rgb(13, 134, 185)">{{$i}}</td>
                                        <td class="text-start" style="font-size:14px;color: rgb(2, 95, 182)">{{$item->building_name}}</td>
                                        <td class="text-center" style="font-size:13px;width: 7%;color: rgb(4, 117, 117)">{{$item->building_id}}</td>
                                        <td class="text-center" style="font-size:13px;width: 7%;color: rgb(228, 15, 86)">
                                           <a href="{{url('air_report_building_sub/'.$item->building_id)}}" class="ladda-button btn-pill btn card_prs_4" style="background-color: rgb(202, 236, 181);width: 70%;">
                                                <span class="ladda-label"> <i class="fa-solid fa-fan opacity-6 me-2" style="color: #c0076d"></i>{{$item->qtyall}}</span>  
                                            </a> 
                                        </td>
                                        <td class="text-center" style="font-size:13px;width: 7%;color: rgb(50, 3, 68)">{{$item->less_10000}}</td>
                                        <td class="text-center" style="font-size:13px;width: 7%;color: rgb(50, 3, 68)">{{$item->one_two}}</td>
                                        <td class="text-center" style="font-size:13px;width: 7%;color: rgb(50, 3, 68)">{{$item->two_tree}}</td>
                                        <td class="text-center" style="font-size:13px;width: 7%;color: rgb(50, 3, 68)">{{$item->tree_four}}</td>
                                        <td class="text-center" style="font-size:13px;width: 7%;color: rgb(50, 3, 68)">{{$item->four_five}}</td>
                                        <td class="text-center" style="font-size:13px;width: 7%;color: rgb(50, 3, 68)">{{$item->more_five}}</td>
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
