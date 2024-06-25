@extends('layouts.pkclaim')
@section('title','PK-OFFICER || Report')
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
     <?php
     use App\Http\Controllers\karnController;
     use Illuminate\Support\Facades\DB; 
 ?>
  <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12">
                            <form action="{{ route('prb.prb_opd') }}" method="POST" >
                                @csrf
                            <div class="row">                   
                                    <div class="col"><h5 class="mb-sm-0">accident OPD รายวัน(ชำระเงิน) </h5></div>
                                    <div class="col-md-1 text-end">วันที่</div>
                                    <div class="col-md-2 text-center">
                                        <input id="startdate" name="startdate" class="form-control form-control-sm" type="date" value="{{$startdate}}">
                                                
                                    </div>
                                    <div class="col-md-1 text-center">ถึงวันที่</div>
                                    <div class="col-md-2 text-center">
                                        <input id="enddate" name="enddate" class="form-control form-control-sm" type="date" value="{{$enddate}}">                             
                                    </div>
                                    <div class="col-md-2"> 
                                        <button type="submit" class="btn btn-primary btn-sm">
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
                                    <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                    id="example"> 
                                        {{-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" >    --}}
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center">เดือน</th>
                                                <th class="text-center">ผู้ป่วย(คน)</th>
                                                <th class="text-center">ผู้ป่วย(ครั้ง)</th>
                                                <th class="text-center">ได้อออกใบเสร็จ</th>
                                                <th class="text-center">ไม่ได้อออกใบเสร็จ</th>
                                                <th class="text-center">สังคมสงเคราะห์</th>
                                                <th class="text-center">ชำระเงินเอง</th>
                                                <th class="text-center">จำนวนเงินที่ออกใบเสร็จ</th>
                                                <th class="text-center">ค่ารักษาทั้งหมด</th>
                                                <th class="text-center">ที่หายไป</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($data_prb as $item)
                                            
                                                <tr>
                                                    <td>{{$i++ }}</td> 

                                                    @if ($item->months == '1')
                                                        <td width="15%" class="text-center">มกราคม</td>
                                                        @elseif ($item->months == '2')
                                                            <td width="15%" class="text-center">กุมภาพันธ์</td>
                                                        @elseif ($item->months == '3')
                                                            <td width="15%" class="text-center">มีนาคม</td>
                                                        @elseif ($item->months == '4')
                                                            <td width="15%" class="text-center">เมษายน</td>
                                                        @elseif ($item->months == '5')
                                                            <td width="15%" class="text-center">พฤษภาคม</td>
                                                        @elseif ($item->months == '6')
                                                            <td width="15%" class="text-center">มิถุนายน</td>
                                                        @elseif ($item->months == '7')
                                                            <td width="15%" class="text-center">กรกฎาคม</td>
                                                        @elseif ($item->months == '8')
                                                            <td width="15%" class="text-center">สิงหาคม</td>
                                                        @elseif ($item->months == '9')
                                                            <td width="15%" class="text-center">กันยายน</td>
                                                        @elseif ($item->months == '10')
                                                            <td width="15%" class="text-center">ตุลาคม</td>
                                                        @elseif ($item->months == '11')
                                                            <td width="15%" class="text-center">พฤษจิกายน</td>
                                                        @else
                                                        <td width="15%" class="text-center">ธันวาคม</td>
                                                    @endif

                                                    <td>{{$item->hn }}</td>
                                                    <td>
                                                        <a href="{{url('prb_opd_sub/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->vn }}</a>                                                      
                                                    </td> 
                                                    <td>{{ $item->norcpno }} </td>                                            
                                                    <td class="text-center" >{{ $item->rcpno }}</td>  
                                                    <td class="text-center">{{ $item->social_aid }}</td>                                                       
                                                    <td>{{ $item->paid_money }} </td>  
                                                    <td>{{ $item->bill_amount }} </td>  
                                                    <td>{{ $item->income }} </td>  
                                                    <td>{{ $item->total }} </td>    
                                                </tr>

                                                {{-- <td>   
                                                    <a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target=".detail{{ $item->HN }}" style="color: rgb(230, 76, 5)"> 
                                                    <i class="fa-solid fa-pen-to-square" style="color: rgb(230, 76, 5)" style="font-size:13px"></i>  
                                                    </a>
                                                </td>   --}}
 
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
                $('#example').DataTable();
                $('#example2').DataTable();
                $('#example3').DataTable();

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
