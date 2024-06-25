@extends('layouts.p4pnew')
@section('title', 'PK-OFFICER || P4P')
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
        <form action="{{ url('p4p_doctor') }}" method="GET">
            @csrf
            <div class="row ">
                <div class="col-md-4">
                    <h4 class="card-title" style="color:rgb(252, 161, 119)">Detail P4P Doctor</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล</p>
                </div>

                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
                <div class="col-md-5 text-end">

                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                        data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control cardp4p" name="startdate" id="datepicker"
                            placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker"
                            data-date-autoclose="true" autocomplete="off" data-date-language="th-th"
                            value="{{ $startdate }}" required />
                        <input type="text" class="form-control cardp4p" name="enddate" placeholder="End Date"
                            id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker"
                            data-date-autoclose="true" autocomplete="off" data-date-language="th-th"
                            value="{{ $enddate }}" required />
                        <button type="submit" class="ladda-button me-2 btn-pill btn btn-primary cardp4p"
                            data-style="expand-left">
                            <span class="ladda-label"> <i
                                    class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                            <span class="ladda-spinner"></span>
                        </button>
 
                    </div>
                </div>
            </div>
        </form>


        <div class="row">
            <div class="col-xl-12">
                <div class="card cardp4p">

                    <div class="table-responsive p-4">
                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">Doctor</th> 
                                    <th class="text-center">order_doctor</th>
                                    <th class="text-center">total_order</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0;
                                    $total1 = 0; ?>
                                    @foreach ($datashow as $item)
                                        <?php $number++; ?>
                                        <tr id="#sid{{ $item->order_doctor }}">
                                            <td class="text-center" width="5%">{{ $number }}</td>
                                            <td class="text-start">{{ $item->dname }} </td> 
                                            <td class="text-center" width="10%">
                                                <a href="{{url('p4p_doctor_detail/'.$item->order_doctor.'/'.$startdate.'/'.$enddate)}}" style="width: 100%" class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="right" title="รายละเอียด">  
                                                    <i class="fa-regular fa-heart me-2" style="color: rgb(12, 161, 124)"></i>
                                                    {{ $item->order_doctor }}
                                                </a>  
                                            </td>
                                            <td class="text-center" width="10%">{{ $item->total_order }} </td> 
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
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
            $('#example3').DataTable();
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
            // dabyear

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


        });
    </script>

@endsection
