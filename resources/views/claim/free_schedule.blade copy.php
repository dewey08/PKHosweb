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
        
                    <form action="{{ route('claim.ssop_data') }}" method="POST">
                    @csrf
                    <div class="row"> 
                        <div class="col"></div>
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
                        <div class="col-md-1">
                            <a href="{{url('ssop_send')}}" class="btn btn-success"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ส่งออก</a>                            
                        </div>
                        <div class="col-md-1">
                            <a href="{{url('ssop_zip')}}" class="btn btn-danger"><i class="fa-solid fa-file-zipper me-2"></i>ZipFile</a>                            
                        </div>
                        <div class="col"></div>
                    </div> 
                </form>
                {{-- <div class="col-md-1"> --}}
                    {{-- <form action="{{ route('claim.ssop_save16') }}" method="POST">
                        @csrf
                        @foreach ($ssop_data as $item)
                            <input type="hidden" name="Invno[]" id="Invno" value="{{$item->Invno}}">
                            <input type="hidden" name="HN[]" id="HN" value="{{ $item->HN }}">
                        @endforeach
                    </form> --}}
                {{-- </div> --}}
                {{-- <div class="col-md-2">
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
                </div>    --}}
         
       

        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Detail SSOP</h4>
                        <p class="card-title-desc">รายละเอียดประกันสังคม</p>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#BillTran" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">BillTran</span>    
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#BillItems" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">BillItems</span>    
                                </a>
                            </li>
                          
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="BillTran" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th> 
                                                    <th class="text-center" width="5%">Station</th> 
                                                    <th class="text-center">DTtran</th>
                                                    <th class="text-center" >Hcode</th>
                                                    <th class="text-center" >Invno</th>
                                                    <th class="text-center">VerCode</th>
                                                    <th class="text-center">HN</th> 
                                                    <th class="text-center">Tflag</th>
                                                    <th class="text-center" width="7%">HMain</th>
                                                    <th class="text-center">Pid</th>
                                                    <th class="text-center">ชื่อ-สกุล </th>
                                                    <th class="text-center" width="8%">Amount</th>
                                                    <th class="text-center" width="8%">Paid</th> 
                                                    <th class="text-center" width="10%">ClaimAmt</th> 
                                                    <th class="text-center">PayPlan</th>
                                                    <th class="text-center">OtherPay</th>
                                                    <th class="text-center">pttype</th>
                                                    <th class="text-center">Diag</th>
                                                </tr>
                                            </thead>
                                            {{-- <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($ssop_billtran as $item) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>   
                                                        <td class="text-center" width="5%">{{ $item->Station }}</td> 
                                                        <td class="text-center">{{ $item->DTtran }}</td> 
                                                        <td class="text-center">{{ $item->Hcode }}</td>  
                                                        <td class="text-center">{{ $item->Invno }}</td>  
                                                        <td class="text-center">{{ $item->VerCode }}</td> 
                                                        <td class="text-center">{{ $item->HN }}</td>  
                                                        <td class="text-center">{{ $item->Tflag }}</td> 
                                                        <td class="text-center">{{ $item->HMain }}</td> 
                                                        <td class="text-center">{{ $item->Pid }}</td> 
                                                        <td class="p-2">{{ $item->Name }}</td> 
                                                        <td class="text-center">{{ number_format($item->Amount, 2) }}</td> 
                                                        <td class="text-center">{{ number_format($item->Paid, 2) }}</td>  
                                                        <td class="text-center">{{ number_format($item->ClaimAmt, 2) }}</td>  
                                                        <td class="text-center">{{ number_format($item->PayPlan, 2) }}</td> 
                                                        <td class="text-center">{{ number_format($item->OtherPay, 2) }}</td> 
                                                        <td class="text-center">{{ $item->pttype }}</td> 
                                                        <td class="text-center">{{ $item->Diag }}</td> 
                                                    </tr>
                                                @endforeach
                                            </tbody> --}}
                                        </table>
                                    </div>
                                </p>
                            </div>
                            
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
