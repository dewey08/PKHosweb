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
                                        {{-- <th class="text-center">เวลา</th>    --}}
                                        <th class="text-center">VN</th> 
                                        <th class="text-center">ชื่อ - สกุล</th> 
                                        <th class="text-center">สิทธิ</th> 
                                        <th class="text-center">ชำระเงินเอง</th> 
                                        <th class="text-center">ค่ารักษา</th> 
                                        <th class="text-center">เลขที่ใบเสร็จ</th> 
                                        <th class="text-center">ลงค้างชำระใน HOSxP</th> 
                                        <th class="text-center">สถานะการชำระ</th> 
                                        <th class="text-center">เซนต์ใบสภาพหนี้</th> 
                                        <th class="text-center">ออกหนังสือทวง</th> 
                                        <th class="text-center">Note งานประกัน</th>  
                                        <th class="text-center">WARD</th>                                                 
                                    </tr>                                            
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($data_prb as $item)
                                        <tr>
                                            <td class="text-center">{{$i++}}</td> 
                                            <td class="text-center">{{DateThai($item->regdate)}}</td> 
                                            {{-- <td class="text-center">{{$item->vsttime}}</td>   --}}
                                      
                                            <td class="text-center">{{$item->vn}}</td> 
                                            <td class="text-center">{{$item->fullname}}</td> 
                                            <td class="text-center">{{$item->pttype}}</td>  
                                            <td class="text-center">{{$item->paid_money}}</td> 
                                            <td class="text-center">{{$item->income}}</td>
                                            <td class="text-center">{{$item->bill_amount}}</td> 

                                            <td class="text-center">{{$item->hos}}</td> 
                                            <td class="text-center">{{$item->paid}}</td> 

                                            <td class="text-center">{{$item->nee}}</td> 
                                            <td class="text-center">{{$item->book}}</td> 
                                            <td class="text-center">{{$item->note}}</td> 
                                            <td class="text-center">{{$item->wardname}}</td> 
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
