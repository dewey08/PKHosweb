@extends('layouts.anc')
@section('title', 'PK-OFFICER || ANC')
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
        $tel_ = Auth::user()->tel;
        $debsubsub = Auth::user()->dep_subsubtrueid;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    
    $datenow = date('Y-m-d');
    $y = date('Y') + 544;
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\SoteController;
    $refnumber = SoteController::refnumber();
    ?>
    <style>
        body {
            font-family: sans-serif;
            font: normal;
            font-style: normal;
        }

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
    <div class="tabs-animation">
        <div id="preloader">
            <div id="status">
                <div class="spinner">

                </div>
            </div>
        </div>
        <form action="{{ url('prenatal_care') }}" method="GET">
            @csrf
            <div class="row ">
                <div class="col-md-3">
                    <h4 class="card-title">รายละเอียดข้อมูล </h4>
                    {{-- <p class="card-title-desc">รายละเอียดข้อมูล </p> --}}
                </div>
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
             
            </div>
        </form>
       

        <div class="row mt-2">
            <div class="col-md-12">
                <div class="main-card card p-2">
                   
                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">principal_diagnosis</th>
                                    <th class="text-center">pre_admission_comorbidity</th>
                                    <th class="text-center">TRACHEOSTOMY</th>
                                    <th class="text-center">MECHANICAL_VENTILATION</th>
                                    <th class="text-center">มากกว่า 96hr</th>
                                    <th class="text-center">น้อยกว่า 96hr</th>
                                    <th class="text-center">PACKED_RED_CELLS</th>
                                    <th class="text-center">FRESH_FROZEN_PLASMA</th>
                                    <th class="text-center">PLATELETS</th>
                                    <th class="text-center">CRYOPRECIPITATE</th>
                                    <th class="text-center">whole_blood</th>
                                    <th class="text-center">Computer_Tomography</th>
                                    <th class="text-center">computer_tomography_text</th>
                                    <th class="text-center">CHEMOTHERAPY</th>
                                    <th class="text-center">MRI</th>
                                    <th class="text-center">Hemodialysis</th>
                                    <th class="text-center">outers</th>
                                    <th class="text-center">non_or_other_text</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0;
                                $total1 = 0; ?>
                                @foreach ($data_anc as $item)
                                    <?php $number++; ?> 
                                    <tr id="#sid{{ $item->principal_diagnosis }}">
                                            <td class="text-center text-muted">{{ $number }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->principal_diagnosis }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->pre_admission_comorbidity }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->TRACHEOSTOMY }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->MECHANICAL_VENTILATION }} </td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->a96hra }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->b96hrb }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->PACKED_RED_CELLS }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->FRESH_FROZEN_PLASMA }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->PLATELETS }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->CRYOPRECIPITATE }}</td>
                                            <td class="text-start" style="font-size: 13px">  {{ $item->whole_blood }} </td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->Computer_Tomography }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->computer_tomography_text }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->CHEMOTHERAPY }}</td> 
                                            <td class="text-start" style="font-size: 13px">{{ $item->MRI }}</td> 
                                            <td class="text-start" style="font-size: 13px">{{ $item->Hemodialysis }}</td> 
                                            <td class="text-start" style="font-size: 13px">{{ $item->outers }}</td> 
                                            <td class="text-start" style="font-size: 13px">{{ $item->non_or_other_text }}</td> 
                                    </tr>

                                @endforeach
                                

                            </tbody>
                        </table>
                        {{-- {{$dabyear}} --}}
                </div>
            </div>
        </div>


    </div>

@endsection
@section('footer')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('select').select2();
            // dabyear

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

          
            var ctx = document.getElementById("Mychart").getContext("2d");

            fetch("{{ route('anc.prenatal_care_bar') }}")
                .then(response => response.json())
                .then(json => {
                    const Mychart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: json.labels,
                            datasets: json.datasets,

                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        },
                        plugins: [ChartDataLabels],
                    })
                });



        });
    </script>

@endsection
