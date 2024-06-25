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
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\SoteController;
    $refnumber = SoteController::refnumber();
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

        .modal-dis {
            width: 1350px;
            margin: auto;
        }

        @media (min-width: 1200px) {
            .modal-xlg {
                width: 90%;
            }
        }
    </style>
    <div class="tabs-animation">

        <div id="preloader">
            <div id="status">
                <div class="spinner">
    
                </div>
            </div>
        </div>
        


        <div class="row">
            <div class="col-md-12">
                <div class="main-card card p2">
                    <div class="card-header">
                        รายละเอียด
                       
                    </div>
                    <div class="table-responsive p-3">
                        <table id="example" class="align-middle mb-0 table table-borderless table-striped table-hover ">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">ตึก</th>
                                    <th class="text-center">Doctor</th>
                                    <th class="text-center">จำนวนผู้ป่วย</th>
                                    <th class="text-center">adjrw</th>
                                    <th class="text-center">cmi</th>
                                    <th class="text-center">total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0; $total1 = 0; ?>
                                @foreach ($data_anc as $item)
                                    <?php $number++; ?> 
                                    <tr id="#sid{{ $item->ward }}">
                                            <td class="text-center text-muted">{{ $number }}</td>
                                            <td>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                     n                                     <div class="widget-content-left me-3">
                                                            <div class="widget-content-left">
                                                                <img width="40" class="rounded-circle"
                                                                    src="images/avatars/4.jpg" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-left flex2">
                                                          
                                                                <div class="widget-heading">{{ $item->wardname }}</div> 
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->doctor }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->total_an }}</td>
                                            <td class="text-start" style="font-size: 13px">
                                                <div>{{ $item->sum_adjrw }}</div>
                                            </td>
                                            <td class="text-start" style="font-size: 13px">
                                                <div class="pie-sparkline">{{ $item->total_cmi }}</div>
                                            </td>
                                            <td class="text-start" style="font-size: 13px">
                                                <div >{{ $item->total_noadjre }}</div>
                                                {{-- <div class="badge bg-warning">{{ $item->total_noadjre }}</div> --}}
                                            </td>
                                    </tr>

                                @endforeach
                                

                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="d-block text-center card-footer">
                        
                        <button class="btn-wide btn btn-success">Save</button>
                    </div> --}}
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
  

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '#printBtn', function() {
                var month_id = $(this).val();
                alert(month_id);

            });
            $("#spinner-div").hide(); //Request is complete so hide spinner

           
        });
    </script>

@endsection
