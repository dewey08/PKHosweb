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
                            <form action="{{ route('claim.acc_checksit_spsch') }}" method="POST">
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
                            
                                        {{-- @foreach ($data_sit as $item)                                                
                                            <input type="hidden" id="vn"  name="vn[]">{{ $item->vn }}</input>  
                                            <input type="hidden" id="cid"  name="cid[]">{{ $item->cid }}</input>  
                                            <input type="hidden" id="vstdate"  name="vstdate[]">{{ $item->vstdate }}</input>                                       
                                        @endforeach --}}

                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        ค้นหา 
                                    </button>
                                </div>                                
                        </form>
                        <div class="col"></div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body py-0 px-2 mt-2">
                                <div class="table-responsive">
                                    {{-- <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                    <table id="key-datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                        id="example">  --}}
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th> 
                                                <th class="text-center" width="10%">vn</th>  
                                                <th class="text-center" >check_sit_date</th>
                                                <th class="text-center">check_sit_maininscl</th>
                                                <th class="text-center">check_sit_subinscl</th> 
                                                <th class="text-center">check_sit_startdate</th> 
                                                <th class="text-center">check_sit_status</th> 
                                                <th class="text-center">check_sit_user_person_id</th>      
                                                <th class="text-center">check_sit_hmain</th>  
                                                <th class="text-center">check_sit_vstdate</th>  
                                                <th class="text-center">check_sit_cid</th>                     
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($data_sit as $item) 
                                            <tr>   
                                                <td class="text-center">{{ $i++ }}</td>   
                                                <td class="text-center" width="10%">{{ $item->check_sit_vn }}</td>  
                                                <td class="text-center">{{ $item->check_sit_date }}</td>  
                                                <td class="text-center">{{ $item->check_sit_maininscl }}</td> 
                                                <td class="text-center">{{ $item->check_sit_subinscl }}</td>  
                                                <td class="text-center">{{ $item->check_sit_startdate }}</td>  
                                                <td class="text-center">{{ $item->check_sit_status }}</td>  
                                                <td class="text-center">{{ $item->check_sit_user_person_id }}</td> 
                                                <td class="text-center">{{ $item->check_sit_hmain }}</td>  
                                                <td class="text-center">{{ $item->check_sit_vstdate }}</td>  
                                                <td class="text-center">{{ $item->check_sit_cid }}</td>   
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
