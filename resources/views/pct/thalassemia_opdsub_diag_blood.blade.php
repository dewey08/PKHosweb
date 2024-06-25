@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || PCT')

     <?php
     use App\Http\Controllers\StaticController;
     use Illuminate\Support\Facades\DB;   
     $count_meettingroom = StaticController::count_meettingroom();
 ?>


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
    ?>

    <div class="container-fluid">
      
        <div class="row mt-3">
            {{-- <div class="col"></div> --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>รายการยาเบิก</h5>
                            </div>
                            <div class="col"></div> 
                            <div class="col-md-2 text-end">
                           
                            </div>
    
                        </div>
                    </div>
                    <div class="card-body shadow-lg">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">ชื่อ</th> 
                                    <th class="text-center">จำนวน</th> 
                                    <th class="text-center">ราคา</th> 
                                    <th class="text-center">วันที่</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($thalassemia_opdsub_diag_blood as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>                                       
                                        <td class="p-2">{{ $item->nname }}</td>
                                        <td width="10%" class="text-center">{{ $item->qty }}</td>
                                        <td width="10%" class="text-center">{{ $item->sum_price }}</td>
                                        <td width="10%" class="text-center">{{ $item->vstdate }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
 
                        </div>
                    </div>
                </div>
            </div>   
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>รายการยา LAB</h5>
                            </div>
                            <div class="col"></div> 
                            <div class="col-md-2 text-end">
                           
                            </div>
    
                        </div>
                    </div>
                    <div class="card-body shadow-lg">
                        <div class="table-responsive">
                            <table id="example2" class="table table-striped table-bordered dt-responsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th> 
                                    <th class="text-center">ชื่อ</th> 
                                    <th class="text-center">ผล</th> 
                                    <th class="text-center">วันที่</th>  
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($thalassemia_opdsub_diag_blood2 as $item2)
                                    <tr>
                                        <td>{{ $i++ }}</td>    
                                        <td class="p-2">{{ $item2->lab_items_name }}</td>
                                        <td width="15%" class="text-center">{{ $item2->lab_order_result }}</td>
                                        <td width="15%" class="text-center">{{ $item2->order_date }}</td> 
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
    </div>
 

    @endsection
    @section('footer')
        <script>
            
            $(document).ready(function() {
                $('#example').DataTable();
                $('#example2').DataTable();
                $('#example3').DataTable();
     
            });
        </script>
    
    
    @endsection
