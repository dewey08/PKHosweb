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
    <form action="{{ url('air_report_problems') }}" method="GET">
        @csrf
        <div class="row"> 
            <div class="col-md-7">
                <h5 style="color:rgb(10, 151, 85)">รายงานปัญหาที่มีการแจ้งซ่อมเครื่องปรับอากาศ แยกตามปัญหาที่พบ(ไม่ใช่การล้างประจำปี) </h5> 
            </div>
             
            {{-- <div class="col"></div> --}}
            <div class="col-md-5 text-end"> 
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control card_prs_4" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control card_prs_4" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>  
                        <button type="submit" class="ladda-button btn-pill btn btn-primary card_prs_4" data-style="expand-left">
                            <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span> 
                        </button> 
                        {{-- <a href="{{url('air_report_problems_excel')}}" class="ladda-button btn-pill btn btn-success card_prs_4">
                            <span class="ladda-label"> <i class="fa-solid fa-file-excel text-white me-2"></i>Excel</span>  
                        </a> --}}
                </div> 
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
                                        <th width="3%" class="text-center" style="background-color: rgb(199, 253, 237);width: 5%">ลำดับ</th>  
                                        <th class="text-center" style="background-color: rgb(199, 253, 237)">รายการปัญหาที่พบ</th>  
                                        <th class="text-center" style="background-color: rgb(199, 253, 237);width: 10%">จำนวน/เครื่อง</th>  
                                        {{-- <th class="text-center" style="background-color: rgb(199, 253, 237);width: 10%">จำนวน/ครั้ง</th>   --}}
                                        <th class="text-center" style="background-color: rgb(252, 144, 159);width: 20%">ปัญหาเดิม 2 ครั้งขึ้นไป</th>   
                                    </tr>  
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($datashow as $item) 
                                <?php $i++ ?>    
                                        <?php  
                                                $datacheck_1 = DB::select('SELECT COUNT(air_list_id) count_id FROM air_repaire WHERE air_problems_1 = "on" ');
                                                foreach ($datacheck_1 as $key => $value) {
                                                    $datacheck1 = $value->count_id;
                                                }                                   
                                                $datacheck_2 = DB::select('SELECT COUNT(air_list_id) count_id FROM air_repaire WHERE air_problems_2 = "on" ');
                                                foreach ($datacheck_2 as $key => $value2) {
                                                    $datacheck2 = $value2->count_id;
                                                }
                                                $datacheck_3 = DB::select('SELECT COUNT(air_list_id) count_id FROM air_repaire WHERE air_problems_3 = "on" ');
                                                foreach ($datacheck_3 as $key => $value3) {
                                                    $datacheck3 = $value3->count_id;
                                                }
                                                $datacheck_4 = DB::select('SELECT COUNT(air_list_id) count_id FROM air_repaire WHERE air_problems_4 = "on" ');
                                                foreach ($datacheck_4 as $key => $value4) {
                                                    $datacheck4 = $value4->count_id;
                                                }
                                                $datacheck_5 = DB::select('SELECT COUNT(air_list_id) count_id FROM air_repaire WHERE air_problems_5 = "on" ');
                                                foreach ($datacheck_5 as $key => $value5) {
                                                    $datacheck5 = $value5->count_id;
                                                }
                                                $datacheck_6 = DB::select('SELECT COUNT(air_list_id) count_id FROM air_repaire WHERE air_problems_orther = "on" ');
                                                foreach ($datacheck_6 as $key => $value6) {
                                                    $datacheck6 = $value6->count_id;
                                                } 

                                                $datacheck_7 = DB::select('SELECT air_list_num,repaire_date_start,repaire_date_end,COUNT(air_repaire_ploblem_id) as air_repaire_ploblem_id FROM air_repaire_ploblemsub WHERE air_repaire_ploblem_id ="'.$item->air_repaire_ploblem_id.'"');
                                                foreach ($datacheck_7 as $key => $value7) {
                                                    $datacheck7         = $value7->air_repaire_ploblem_id;
                                                    $date_start         = $value7->repaire_date_start;
                                                    $date_end           = $value7->repaire_date_end;
                                                    $air_list_num       = $value7->air_list_num;
                                                } 
                                        ?>                           
                                    <tr>                                                  
                                        <td class="text-center" style="font-size:13px;width: 5%;color: rgb(13, 134, 185)">{{$i}}</td>
                                        <td class="text-start" style="font-size:14px;color: rgb(2, 95, 182)">{{$item->air_repaire_ploblemname}}</td>
                                       
                                        @if ($item->air_repaire_ploblem_id == '1')
                                            <td class="text-center" style="font-size:13px;width: 10%;color: rgb(4, 117, 117)">
                                                <a href="{{url('air_report_problemsub/'.$item->air_repaire_ploblem_id)}}" class="ladda-button btn-pill btn card_prs_4" style="background-color: rgb(236, 232, 181);width: 70%;">
                                                    <span class="ladda-label"> <i class="fa-solid fa-glass-water-droplet me-2" style="color: #B216F0"></i>{{$datacheck1}}</span>  
                                                </a> 
                                            </td>
                                            <td class="text-center" style="font-size:13px;width: 20%;color: rgb(50, 3, 68)">
                                                <a href="{{url('air_report_problem_detail/'.$item->air_repaire_ploblem_id)}}" class="ladda-button btn-pill btn card_prs_4" style="background-color: rgb(236, 232, 181);width: 50%;">
                                                    <span class="ladda-label"> <i class="fa-solid fa-glass-water-droplet me-2" style="color: #B216F0"></i>{{$datacheck7}}</span>  
                                                </a> 
                                            </td>
                                        @elseif ($item->air_repaire_ploblem_id == '2')
                                            <td class="text-center" style="font-size:13px;width: 10%;color: rgb(4, 117, 117)">
                                                <a href="{{url('air_report_problemsub/'.$item->air_repaire_ploblem_id)}}" class="ladda-button btn-pill btn card_prs_4" style="background-color: rgb(202, 236, 181);width: 70%;">
                                                    <span class="ladda-label"> <i class="fab fa-slack me-2" style="color: #07c095"></i>{{$datacheck2}}</span>  
                                                </a> 
                                            </td>
                                            <td class="text-center" style="font-size:13px;width: 20%;color: rgb(50, 3, 68)">
                                                <a href="{{url('air_report_problem_detail/'.$item->air_repaire_ploblem_id)}}" class="ladda-button btn-pill btn card_prs_4" style="background-color: rgb(202, 236, 181);width: 50%;">
                                                    <span class="ladda-label"> <i class="fab fa-slack me-2" style="color: #07c095"></i>{{$datacheck7}}</span>  
                                                </a> 
                                            </td>
                                        @elseif ($item->air_repaire_ploblem_id == '3')
                                            <td class="text-center" style="font-size:13px;width: 10%;color: rgb(4, 117, 117)">
                                                <a href="{{url('air_report_problemsub/'.$item->air_repaire_ploblem_id)}}" class="ladda-button btn-pill btn card_prs_4" style="background-color: rgb(236, 181, 181);width: 70%;">
                                                    <span class="ladda-label"> <i class="fa-solid fa-soap me-2" style="color: #c0072f"></i>{{$datacheck3}}</span>  
                                                </a> 
                                            </td>
                                            <td class="text-center" style="font-size:13px;width: 20%;color: rgb(50, 3, 68)">
                                                <a href="{{url('air_report_problem_detail/'.$item->air_repaire_ploblem_id)}}" class="ladda-button btn-pill btn card_prs_4" style="background-color: rgb(236, 181, 181);width: 50%;">
                                                    <span class="ladda-label"> <i class="fa-solid fa-soap me-2" style="color: #c0072f"></i>{{$datacheck7}}</span>  
                                                </a> 
                                            </td>
                                        @elseif ($item->air_repaire_ploblem_id == '4')
                                            <td class="text-center" style="font-size:13px;width: 10%;color: rgb(4, 117, 117)">
                                                <a href="{{url('air_report_problemsub/'.$item->air_repaire_ploblem_id)}}" class="ladda-button btn-pill btn card_prs_4" style="background-color: rgb(181, 203, 236);width: 70%;">
                                                    <span class="ladda-label"> <i class="fa-solid fa-volume-high me-2" style="color: #0760c0"></i>{{$datacheck4}}</span>  
                                                </a> 
                                            </td>
                                            <td class="text-center" style="font-size:13px;width: 20%;color: rgb(50, 3, 68)">
                                                <a href="{{url('air_report_problem_detail/'.$item->air_repaire_ploblem_id)}}" class="ladda-button btn-pill btn card_prs_4" style="background-color: rgb(181, 203, 236);width: 50%;">
                                                    <span class="ladda-label"> <i class="fa-solid fa-volume-high me-2" style="color: #0760c0"></i>{{$datacheck7}}</span>  
                                                </a>
                                            </td>
                                        @elseif ($item->air_repaire_ploblem_id == '5')
                                            <td class="text-center" style="font-size:13px;width: 10%;color: rgb(4, 117, 117)">
                                                <a href="{{url('air_report_problemsub/'.$item->air_repaire_ploblem_id)}}" class="ladda-button btn-pill btn card_prs_4" style="background-color: rgb(209, 181, 236);width: 70%;">
                                                    <span class="ladda-label"> <i class="fa-solid fa-tenge-sign me-2" style="color: #8c07c0"></i>{{$datacheck5}}</span>  
                                                </a>
                                            </td> 
                                            <td class="text-center" style="font-size:13px;width: 20%;color: rgb(50, 3, 68)">
                                                <a href="{{url('air_report_problem_detail/'.$item->air_repaire_ploblem_id)}}" class="ladda-button btn-pill btn card_prs_4" style="background-color: rgb(209, 181, 236);width: 50%;">
                                                    <span class="ladda-label"> <i class="fa-solid fa-tenge-sign me-2" style="color: #8c07c0"></i>{{$datacheck7}}</span>  
                                                </a>
                                            </td>
                                        @else
                                            <td class="text-center" style="font-size:13px;width: 10%;color: rgb(4, 117, 117)">
                                                <a href="{{url('air_report_problemsub/'.$item->air_repaire_ploblem_id)}}" class="ladda-button btn-pill btn card_prs_4" style="background-color: rgb(185, 253, 250);width: 70%;">
                                                    <span class="ladda-label"> <i class="fa-solid fa-circle-exclamation me-2" style="color: #037381"></i>{{$datacheck6}}</span>  
                                                </a> 
                                            </td>
                                            <td class="text-center" style="font-size:13px;width: 20%;color: rgb(50, 3, 68)">
                                                <a href="{{url('air_report_problem_detail/'.$item->air_repaire_ploblem_id)}}" class="ladda-button btn-pill btn card_prs_4" style="background-color: rgb(185, 253, 250);width: 50%;">
                                                    <span class="ladda-label"> <i class="fa-solid fa-circle-exclamation me-2" style="color: #037381"></i>{{$datacheck7}}</span>  
                                                </a> 
                                            </td>
                                        @endif 

                                        
                                        {{-- <td class="text-center" style="font-size:13px;width: 10%;color: rgb(228, 15, 86)">0</td> --}}
                                        {{-- <td class="text-center" style="font-size:13px;width: 20%;color: rgb(50, 3, 68)">{{$datacheck7}}</td> --}}
                                         
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
