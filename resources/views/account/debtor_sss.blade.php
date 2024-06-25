@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || Account')
@section('content')
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
    
</script>
    <style>
        .table th {
            font-family: sans-serif;
            font-size: 12px;
        }

        .table td {
            font-family: sans-serif;
            font-size: 12px;
        }
    </style>
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
    ?>
    <div class="container-fluid">
    
    <div class="row">
        <div class="col-xl-12">
            <form action="{{ route('acc.checksit_admit') }}" method="POST" >
                @csrf
            <div class="row">                   
                    <div class="col"></div>
                    <div class="col-md-1 text-end">วันที่</div>
                    <div class="col-md-2 text-center">
                        {{-- <input id="startdate" name="startdate" class="form-control form-control-sm" type="date" value="{{$startdate}}"> --}}
                        <div class="input-group" id="datepicker1">
                            <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="startdate" id="startdate"
                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" value="{{$startdate}}">

                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                        </div>  
                    </div>
                    <div class="col-md-1 text-center">ถึงวันที่</div>
                    <div class="col-md-2 text-center">
                        {{-- <input id="enddate" name="enddate" class="form-control form-control-sm" type="date" value="{{$enddate}}"> --}}
                        <div class="input-group" id="datepicker1">
                            <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="enddate" id="enddate"
                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" value="{{$enddate}}">

                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                        </div> 
                    </div>
                    <div class="col-md-2"> 
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-magnifying-glass me-2"></i>
                            ค้นหา
                        </button>
                    </div>
                    <div class="col"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive">
                        {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                            id="example"> --}}
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">Stamp</th>
                                    <th class="text-center">AN</th>
                                    <th class="text-center">HN</th>
                                    <th class="text-center">AdmitDischarge</th>
                                    <th class="text-center">cid</th>
                                    <th class="text-center">pttype</th>
                                    <th class="text-center">spsc</th>
                                    <th class="text-center">pang_stamp_nhso</th>
                                    <th class="text-center">pdx</th>
                                    <th class="text-center">income</th>
                                    <th class="text-center">uc_money</th>
                                    <th class="text-center">paid_money</th>
                                    <th class="text-center">pang_stamp_id</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                {{-- @foreach ($datashow as $item)                                            
                                        <tr>
                                            <td>{{$i++ }}</td>
                                            <td>{{$item->Stamp}}</td>
                                            <td>{{$item->AN }}</td>
                                            <td>{{$item->HN }}</td> 
                                            <td>{{ $item->AN }} </td>                                            
                                            <td class="text-center" >{{ $item->AdmitDischarge }}</td>  
                                            <td class="text-center">{{ $item->cid }}</td>                                                       
                                            <td>{{ $item->pttype }} </td>  
                                            <td>{{ $item->spsc }} </td>  
                                            <td>{{ $item->pang_stamp_nhso }} </td>  
                                            <td>{{ $item->pdx }} </td>  
                                            <td>{{ $item->income }} </td> 
                                            <td> {{ $item->uc_money }}  </td>  
                                            <td>{{ $item->paid_money }} </td>  
                                            <td>{{ $item->pang_stamp_id }} </td>  
                                        </tr>
                                @endforeach --}}
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
            $('#example').DataTable();
            $('#example2').DataTable();

            $('select').select2();
            $('#ECLAIM_STATUS').select2({
                dropdownParent: $('#detailclaim')
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });
    </script>

@endsection
