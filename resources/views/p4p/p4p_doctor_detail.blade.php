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
   
            <div class="row ">
                <div class="col-md-4">
                    <h4 class="card-title" style="color:rgb(252, 161, 119)">Detail P4P Doctor</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล</p>
                </div>

                <div class="col"></div>
             
            </div>
   


        <div class="row">
            <div class="col-xl-12">
                <div class="card cardp4p">

                    <div class="table-responsive p-4">
                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">an</th>
                                    <th class="text-center">hn</th>
                                    <th class="text-center">order_date</th> 
                                    <th class="text-center">order_time</th>
                                    <th class="text-center">dname</th> 
                                    <th class="text-center">order_item_detail</th> 
                                    <th class="text-center">order_doctor</th> 
                                    <th class="text-center">p4p</th> 
                                    <th class="text-center">order_type</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0;
                                    $total1 = 0; ?>
                                    @foreach ($datashow as $item)
                                        <?php $number++; ?>
                                        <tr id="#sid{{ $item->order_doctor }}">
                                            <td class="text-center" width="5%">{{ $number }}</td>
                                            <td class="text-center" width="5%">{{ $item->an }} </td>
                                            <td class="text-center" width="5%">{{ $item->hn }} </td>
                                            <td class="text-center" width="5%">{{ $item->order_date }} </td> 
                                            <td class="text-center" width="5%">order_time </td>
                                            <td class="text-start" width="10%">{{ $item->dname }} </td> 
                                            <td class="text-start">{{ $item->order_item_detail }} </td> 
                                            <td class="text-start" width="5%">{{ $item->order_doctor }} </td> 
                                            <td class="text-start" width="5%">{{ $item->p4p }} </td> 
                                            <td class="text-start" width="5%">{{ $item->order_type }} </td> 
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
