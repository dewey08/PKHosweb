@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || Rep-stm-0')
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
    body{
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
        <form action="{{ url('report_zero') }}" method="GET">
            @csrf
            <div class="row "> 
                <div class="col-md-3">
                    <h4 class="card-title">Detail </h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล </p>
                </div>
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
                <div class="col-md-4 text-end"> 
                    
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $startdate }}" required/>
                        <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $enddate }}" required/>  
                    </div> 
                </div>
                <div class="col-md-2 text-start">
                    <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                        ค้นหา
                    </button> 
                </div>
            </div>
        </form>  


        <div class="row">
            <div class="col-md-12">
                <div class="main-card card">
                  
                    <div class="table-responsive p-2">
                        {{-- <table id="example" class="align-middle mb-0 table table-borderless table-striped table-hover "> --}}
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th> 
                                    <th class="text-center">rep</th>
                                    <th class="text-center">repno</th>
                                    <th class="text-center">trainid</th>
                                    <th class="text-center">hn</th>
                                    <th class="text-center">cid</th>
                                    <th class="text-center">fullname</th>
                                    <th class="text-center">vstdate</th>
                                    <th class="text-center">maininscl</th>
                                    <th class="text-center">projectcode</th>
                                    <th class="text-center">debit</th>
                                    <th class="text-center">ip_paytrue</th>
                                    <th class="text-center">pp</th>
                                    <th class="text-center">ชดเชย</th>
                                    <th class="text-center">va</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0; $total1 = 0; ?>
                                @foreach ($report as $item)
                                    <?php $number++; ?> 
                                    <tr id="#sid{{ $item->rep }}">
                                            <td class="text-center text-muted">{{ $number }}</td>
                                            
                                            <td class="text-start" style="font-size: 13px">{{ $item->rep }}</td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->repno }} </td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->tranid }} </td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->hn }} </td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->cid }} </td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->fullname }} </td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->vstdate }} </td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->maininscl }} </td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->projectcode }} </td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->debit }} </td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->ip_paytrue }} </td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->pp }} </td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->total_approve }} </td>
                                            <td class="text-start" style="font-size: 13px">{{ $item->va }} </td>
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
            // dabyear

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
 
           
        });
    </script>

@endsection
