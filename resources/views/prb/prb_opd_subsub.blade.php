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
                <div class="row">                   
                     
                    <div class="col"><h5 class="mb-sm-0">accident OPD รายวัน(ชำระเงิน) </h5></div> 
                    <div class="col-md-4 text-center"></div>
                    <div class="col-md-4 text-center"></div>
                    <div class="col">
                        {{-- <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-file-excel me-2 text-white"></i> Emport Excel
                        </button> --}}
                    </div>
                   
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">                     
                    <div class="card-body py-0 px-2 mt-2"> 
                        <div class="table-responsive">
                            {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example">  --}}
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>                                           
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">วันที่</th>
                                        <th class="text-center">เวลา</th>   
                                        <th class="text-center">HN</th> 
                                        <th class="text-center">เลขบัตร</th> 
                                        <th class="text-center">AN</th> 
                                        <th class="text-center">ชื่อ - สกุล</th> 
                                        <th class="text-center">ตึก</th> 
                                        <th class="text-center">สิทธิ</th> 
                                        <th class="text-center">เลขที่ใบเสร็จ</th> 
                                        <th class="text-center">ค่ารักษา</th> 
                                        <th class="text-center">refer นอก</th> 
                                        <th class="text-center">refer ใน</th> 
                                        <th class="text-center">Note งานประกัน</th>                                                  
                                    </tr>                                            
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($data_prb as $item)
                                        <tr>
                                            <td class="text-center">{{$i++}}</td> 
                                            <td class="text-center">{{DateThai($item->vstdate)}}</td> 
                                            <td class="text-center">{{$item->vsttime}}</td>  
                                            <td class="text-center">{{$item->hn}}</td> 
                                            <td class="text-center">{{$item->cid}}</td> 
                                            <td class="text-center">{{$item->an}}</td> 
                                            <td class="text-center">{{$item->fullname}}</td> 
                                            <td class="text-center">{{$item->name}}</td> 
                                            <td class="text-center">{{$item->pttype}}</td> 
                                            <td class="text-center">{{$item->rcpno}}</td> 
                                            <td class="text-center">{{$item->income}}</td> 
                                            <td class="text-center">{{$item->refer_hospcode}}</td> 
                                            <td class="text-center">{{$item->hospcode}}</td> 
                                            <td class="text-center">{{$item->note}}</td> 
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
