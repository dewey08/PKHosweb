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
                {{-- <div class="col-md-2 text-end">
                    <select name="dabyear" id="dabyear" class="form-control" style="width: 100%">
                        @foreach ($dabyears as $item)
                        @if ($dabyear == '')
                            @if ($y == $item->leave_year_id)
                                <option value="{{ $item->leave_year_id }}" selected>{{ $item->leave_year_id }}</option>
                            @else
                                <option value="{{ $item->leave_year_id }}">{{ $item->leave_year_id }}</option>
                            @endif
                        @else
                            @if ($dabyear == $item->leave_year_id)
                                <option value="{{ $item->leave_year_id }}" selected>{{ $item->leave_year_id }}</option>
                            @else
                                <option value="{{ $item->leave_year_id }}">{{ $item->leave_year_id }}</option>
                            @endif
                        @endif
                            
                        @endforeach

                    </select>
                 
                </div>
                <div class="col-md-1 text-start">
                    <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                        ค้นหา
                    </button>
                </div> --}}
            </div>
        </form>
       

        <div class="row mt-2">
            <div class="col-md-12">
                <div class="main-card card p-2">
                   
                        <table id="example" class="table table-borderless table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">an</th>
                                    <th class="text-center">hn</th>
                                    <th class="text-center">ptname</th>
                                    <th class="text-center">regdate</th>
                                    <th class="text-center">dchdate</th>
                                    <th class="text-center">admdate</th>
                                    <th class="text-center">age</th>
                                    <th class="text-center">height</th>
                                    <th class="text-center">bw</th>
                                    <th class="text-center">total_diag</th>
                                    <th class="text-center">sum_adjrw</th>
                                    <th class="text-center">total_cmi</th>
                                    <th class="text-center">total_noadjre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0;
                                $total1 = 0; ?>
                                @foreach ($data_anc as $item)
                                    <?php $number++; ?> 
                                    <tr id="#sid{{ $item->an }}">
                                            <td class="text-center text-muted">{{ $number }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->an }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->hn }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->ptname }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->regdate }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->dchdate }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->admdate }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->age }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->height }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->bw }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->total_diag }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->sum_adjrw }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->total_cmi }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->total_noadjre }}</td> 
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
