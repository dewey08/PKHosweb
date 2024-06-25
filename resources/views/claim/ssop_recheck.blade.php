@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || SSOP-REPORT')
 
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
  <style>
    #button{
           display:block;
           margin:20px auto;
           padding:30px 30px;
           background-color:#eee;
           border:solid #ccc 1px;
           cursor: pointer;
           }
           #overlay{	
           position: fixed;
           top: 0;
           z-index: 100;
           width: 100%;
           height:100%;
           display: none;
           background: rgba(0,0,0,0.6);
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
           .is-hide{
           display:none;
           }
</style>
    <div class="tabs-animation">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    
                </div>
            </div>
        </div>

        <form action="{{ route('claim.ssop_recheck_search') }}" method="POST">
            @csrf

            <div class="row">  
                <div class="col-md-2 text-end">วันที่</div>
                <div class="col-md-9 text-center">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1'
                         data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{ $start }}"/>
                        <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1'
                        data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{ $end }}"/>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            ค้นหาข้อมูล 
                        </button>
                        <a href="{{url('ssop_pull_new/'.$start.'/'.$end)}}" class="btn btn-info"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ดึงข้อมูลใหม่</a>
                        <a href="{{url('ssop_send')}}" class="btn btn-success"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ส่งออก</a>    
                        <a href="{{url('ssop_zip')}}" class="btn btn-danger"><i class="fa-solid fa-file-zipper me-2"></i>ZipFile</a>  
                        {{-- <a href="{{url('aipn_send_pull_new')}}" class="btn btn-success"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ส่งออก</a>  
                        <a href="{{url('aipn_zip_pull_new')}}" class="btn btn-info"><i class="fa-solid fa-file-zipper me-2"></i>ZipFile</a> --}}
                        {{-- <a href="{{url('ssop_pull_delete')}}" class="btn btn-danger"><i class="fa-solid fa-trash-can me-2"></i>Delete Data</a>     --}}
                    </div>
                </div>    
                <div class="col"></div>
            </div> 
        </form>
        
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="card-title">Detail SSOP RECHECK</h4>
                                <p class="card-title-desc">รายละเอียดประกันสังคมผู้ป่วยนอกที่ยังไม่เคลม</p>
                            </div>
                            <div class="col"></div>
                            <div class="col-md-2 text-end">
                                {{-- <button class="btn btn-secondary" id="Changbillitems"><i class="fa-solid fa-wand-magic-sparkles me-3"></i>ปรับ bilitems</button>  --}}  
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>  
                                        <th class="text-center" width="10%">VSTDATE</th>
                                        {{-- <th class="text-center" width="10%">AN</th>  --}}
                                        <th class="text-center" width="10%">HN</th>
                                        <th class="text-center" width="10%">VN</th>
                                        <th class="text-center" width="10%">PID</th>
                                        <th class="text-center">FULLNAME</th> 
                                        <th class="text-center" width="10%">ClaimAmt</th>
                                        <th class="text-center" width="10%">total_back_stm</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($ssop_recheck as $item) 
                                        <tr style="font-size: 12px;">   
                                            <td class="text-center">{{ $i++ }}</td>   
                                            <td class="text-center" width="10%">{{ $item->VSTDATE }}</td> 
                                            {{-- <td class="text-center" width="10%">{{ $item->AN }}</td>  --}}
                                            <td class="text-center" width="10%">{{ $item->HN }}</td>  
                                            <td class="text-center" width="10%">{{ $item->VN }}</td>  
                                            <td class="text-center" width="10%">{{ $item->PID }}</td> 
                                            <td class="text-start">{{ $item->FULLNAME }}</td>  
                                            <td class="text-center" width="10%">{{ $item->ClaimAmt }}</td> 
                                            <td class="text-center" width="10%">{{ $item->total_back_stm }}</td>  
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
