@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || SSOP')
 
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
    use App\Http\Controllers\StaticController;
    use Illuminate\Support\Facades\DB;   
    $count_meettingroom = StaticController::count_meettingroom();
    ?>    
 
    <div class="tabs-animation">
         
                <div class="row">
                    <div class="col-xl-12">
                        {{-- <form action="{{ route('claim.ssop_search') }}" method="POST"> --}}
                            <form action="{{ route('claim.ssop_data') }}" method="POST">
                            @csrf
                            <div class="row"> 
                                <div class="col-md-1 text-end">วันที่</div>
                                <div class="col-md-2 text-center">
                                    <div class="input-group" id="datepicker1">
                                        <input type="text" class="form-control" name="startdate" id="datepicker"  data-date-container='#datepicker1'
                                            data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                            value="{{ $start }}">

                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-1 text-center">ถึงวันที่</div>
                                <div class="col-md-2 text-center">
                                    <div class="input-group" id="datepicker1">
                                        <input type="text" class="form-control" name="enddate" id="datepicker2" data-date-container='#datepicker1'
                                            data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                            value="{{ $end }}">

                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                                 
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        ค้นหา 
                                    </button>
                                </div>
                                
                        </form>
                        <div class="col-md-1">

                            <form action="{{ route('claim.ssop_save16') }}" method="POST">
                                @csrf
                                @foreach ($ssop_data as $item)
                                    <input type="hidden" name="Invno[]" id="Invno" value="{{$item->Invno}}">
                                    <input type="hidden" name="HN[]" id="HN" value="{{ $item->HN }}">
                                  
                                @endforeach

                               
                            </form>
                        </div>
                        <div class="col-md-2">

                            <form action="{{ route('claim.ssop_save16') }}" method="POST">
                                @csrf
                                @foreach ($ssop_data as $item)
                                    <input type="hidden" name="Invno[]" id="Invno" value="{{$item->Invno}}">
                                    <input type="hidden" name="HN[]" id="HN" value="{{ $item->HN }}">
                                   
                                    
                                @endforeach

                                <input type="hidden" name="startdate" id="startdate" value="{{ $start }}">
                                <input type="hidden" name="enddate" id="enddate" value="{{ $end }}">

                                <button type="submit" class="btn btn-warning">
                                    <i class="fa-solid fa-hand-holding-dollar me-2"></i>
                                    Export 16 แฟ้ม
                                </button>
                            </form>
                        </div>
                        <div class="col-md-1">
                            <a href="{{url('ssop_detail')}}" class="btn btn-info">Detail</a>
                        </div>   
                    </div>
                </div>
          
                <div class="row mt-3">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body py-0 px-2 mt-2">
                                <div class="table-responsive">
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    {{-- <table id="key-datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                    {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                        id="example"> 
                                        <thead> --}}
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th> 
                                                <th class="text-center" width="5%">Station</th>
                                                {{-- <th class="text-center" >Authencode</th> --}}
                                                <th class="text-center">DTtran</th>
                                                <th class="text-center" >Hcode</th>
                                                <th class="text-center" >Invno</th>
                                                <th class="text-center">Billno</th>
                                                <th class="text-center">HN</th>
                                                {{-- <th class="text-center">MemberNo</th> --}}
                                              
                                                {{-- <th class="text-center">VerCode</th> --}}
                                                <th class="text-center">Tflag</th>
                                                <th class="text-center" width="7%">HMain</th>
                                                <th class="text-center">Pid</th>
                                                <th class="text-center">ชื่อ-สกุล </th>
                                                <th class="text-center" width="8%">Amount</th>
                                                <th class="text-center" width="8%">Paid</th>
                                                {{-- <th class="text-center">PayPlan</th>  --}}
                                                <th class="text-center" width="10%">ClaimAmt</th>
                                                {{-- <th class="text-center">OtherPayplan</th> --}}
                                                <th class="text-center">OtherPay</th>
                                                <th class="text-center">pttype</th>
                                                <th class="text-center">Diag</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($ssop_data as $item) 
                                                <tr id="sid{{ $item->Invno }}">   
                                                    <td class="text-center">{{ $i++ }}</td>   
                                                    <td class="text-center" width="5%">{{ $item->Station }}</td>
                                                    {{-- <td class="text-center">{{ $item->Authencode }} </td> --}}
                                                    <td class="text-center">{{ $item->DTtran }}</td> 
                                                    <td class="text-center">{{ $item->Hcode }}</td>  
                                                    <td class="text-center">{{ $item->Invno }}</td>  
                                                    <td class="text-center">{{ $item->Billno }}</td> 
                                                    <td class="text-center">{{ $item->HN }}</td> 
                                                    {{-- <td class="text-center">{{ $item->MemberNo }}</td>  --}}
                                                  
                                                    {{-- <td class="text-center">{{ $item->VerCode }}</td>  --}}
                                                    <td class="text-center">{{ $item->Tflag }}</td> 
                                                    <td class="text-center">{{ $item->HMain }}</td> 
                                                    <td class="text-center">{{ $item->Pid }}</td> 
                                                    <td class="p-2">{{ $item->Name }}</td> 
                                                    <td class="text-center">{{ $item->Amount }}</td> 
                                                    <td class="text-center">{{ $item->Paid }}</td> 
                                                    {{-- <td class="text-center">{{ $item->PayPlan }}</td>  --}}
                                                    <td class="text-center">{{ $item->ClaimAmt }}</td> 
                                                    {{-- <td class="text-center">{{ $item->OtherPayplan }}</td>  --}}
                                                    <td class="text-center">{{ $item->OtherPay }}</td> 
                                                    <td class="text-center">{{ $item->pttype }}</td> 
                                                    <td class="text-center">{{ $item->Diag }}</td> 
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });
    });
</script>
@endsection
