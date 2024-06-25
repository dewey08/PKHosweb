@extends('layouts.clinictb')
@section('title', 'PK-OFFICER || CLINIC-TB')

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
    $ynow = date('Y') + 543;
    $yb = date('Y') + 542;
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
            border-top: 10px #fd6812 solid;
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
        #tb_count{
                    width: 40px;
                    height: 40px;
                    background-color: rgb(248, 209, 163);
                    border-radius: 100%;
                    margin: 0% auto;
                    -webkit-animation: pulse 3s infinite ease-in-out;
                    -o-animation: pulse 3s infinite ease-in-out;
                    -ms-animation: pulse 3s infinite ease-in-out;
                    -moz-animation: pulse 3s infinite ease-in-out;
                    animation: pulse 3s infinite ease-in-out;
            }
            .cardtbss{
                /* border-radius: 7em 7em 7em 7em; */
                border: none;
                /* box-shadow: 0 0 10px rgba(93, 199, 241); */
                /* box-shadow: 0 0 10px rgb(247, 198, 176); */
                /* border:solid 1px #80acfd; */
            }
        
        
    </style>
    <?php
    use App\Http\Controllers\StaticController;
    use Illuminate\Support\Facades\DB;
    $count_meettingroom = StaticController::count_meettingroom();
    ?>

        <div class="tabs-animation">
            <div id="preloader">
                <div id="status">
                    <div class="spinner">
    
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div id="overlay">
                    <div class="cv-spinner">
                        <span class="spinner"></span>
                    </div>
                </div>
            </div>



        <form action="{{ url('tb_main') }}" method="GET">
            @csrf
                
                        <div class="row"> 
                            <div class="col-md-3">
                                <h5 class="card-title" style="color:rgba(93, 199, 241)">Clinic TB</h5>
                                <p class="card-title-desc">บริการคัดกรองและค้นหาวัณโรคในกลุ่มเสี่ยง</p>
                            </div>
                            <div class="col"></div>
                            <div class="col-md-1 text-end mt-2">วันที่</div>
                            <div class="col-md-5 text-end ">
                                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                    <input type="text" class="form-control cardtb" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                        data-date-language="th-th" value="{{ $startdate }}" required/>
                                    <input type="text" class="form-control cardtb" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                        data-date-language="th-th" value="{{ $enddate }}"/>                     
                                    <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary cardtb"> 
                                        <i class="fa-solid fa-magnifying-glass text-primary me-2"></i>ค้นหา
                                    </button>  
                                    <button type="button" class="ladda-button me-2 btn-pill btn btn-primary cardacc" data-style="expand-left" id="Pulldata">
                                        <span class="ladda-label"> <i class="fa-solid fa-file-circle-plus text-white me-2"></i>ประมวลผล</span>
                                        <span class="ladda-spinner"></span>
                                    </button>   
                                </div>  
                            </div>
                        </div>
                  
               
        </form>
        <div class="row mb-4">
            @foreach ($d_tb_main as $item)
                    @if ($item->group_code == '02')
                        <div class="col-xl-4 mt-4">    
                                <a href="{{url('tb_main_detail/'.$item->group_code)}}" class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">                                                         
                                    <img  src="{{ asset('images/pir.png') }}" height="120px" width="100px" class="rounded-circle me-4 mt-3 mb-3"> <br>
                                    <h2 class="card-title" style="color:rgb(9, 134, 184)">{{$item->group_screen}}</h2>
                                    <span class="tb_count"><h1 style="color:rgb(247, 102, 182)">{{$item->Cvn}} / {{$item->CXR}} คน</h1></span>
                                </a> 
                        </div>
                    @elseif ($item->group_code == '05')
                        <div class="col-xl-4 mt-4">    
                                <a href="{{url('tb_main_detail/'.$item->group_code)}}" class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">                                                         
                                    <img  src="{{ asset('images/patients.png') }}" height="100px" width="120px" class="rounded-circle me-4 mt-3 mb-3"> <br>
                                    <h2 class="card-title" style="color:rgb(9, 134, 184)">{{$item->group_screen}}</h2>
                                    <span class="tb_count"><h1 style="color:rgb(247, 102, 182)">{{$item->Cvn}} / {{$item->CXR}} คน</h1></span>
                                </a> 
                        </div>
                    @elseif ($item->group_code == '06')
                        <div class="col-xl-4 mt-4">    
                                <a href="{{url('tb_main_detail/'.$item->group_code)}}" class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">                                                         
                                    <img  src="{{ asset('images/narcotics.png') }}" height="100px" width="100px" class="rounded-circle me-4 mt-3 mb-3"> <br>
                                    <h2 class="card-title" style="color:rgb(9, 134, 184)">{{$item->group_screen}}</h2>
                                    <span class="tb_count"><h1 style="color:rgb(247, 102, 182)">{{$item->Cvn}} / {{$item->CXR}} คน</h1></span>
                                </a> 
                        </div>
                    @elseif ($item->group_code == '07')
                        <div class="col-xl-4 mt-4">    
                                <a href="{{url('tb_main_detail/'.$item->group_code)}}" class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">                                                         
                                    <img  src="{{ asset('images/sasuk.png') }}" height="120px" width="100px" class="rounded-circle me-4 mt-3 mb-3"> <br>
                                    <h2 class="card-title" style="color:rgb(9, 134, 184)">{{$item->group_screen}}</h2>
                                    <span class="tb_count"><h1 style="color:rgb(247, 102, 182)">{{$item->Cvn}} / {{$item->CXR}} คน</h1></span>
                                </a> 
                        </div>
                    @else
                        <div class="col-xl-4 mt-4">    
                                <a href="{{url('tb_main_detail/'.$item->group_code)}}" class="btn-icon btn-shadow btn-dashed btn btn-outline-info avatar-title bg-white text-primary rounded-pill">                                                         
                                    <img  src="{{ asset('images/protective.png') }}" height="100px" width="100px" class="rounded-circle me-4 mt-3 mb-3"> <br>
                                    <h2 class="card-title" style="color:rgb(9, 134, 184)">{{$item->group_screen}}</h2>
                                    <span class="tb_count"><h1 style="color:rgb(247, 102, 182)">{{$item->Cvn}} / {{$item->CXR}} คน</h1></span>
                                </a> 
                        </div>
                    @endif
               
                   
               
            @endforeach 
        </div>
    </div>

@endsection
@section('footer')
 
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
            $('#example4').DataTable();
            $('#example5').DataTable();
            
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#Pulldata').click(function() {
                var startdate = $('#datepicker').val(); 
                var enddate = $('#datepicker2').val(); 
                Swal.fire({
                        title: 'ต้องการประมวลผลใช่ไหม ?',
                        text: "You Warn Process Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Process it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('re.tb_main_pull') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        startdate,
                                        enddate                        
                                    },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'ประมวลผลสำเร็จ',
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
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                }
                                            })
                                        } else {
                                            
                                        }
                                    },
                                });
                                
                            }
                })
            });
 

        });
    </script>
@endsection
