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
                                <h5>รายการ icd10 ผู้ป่วยใน</h5>
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
                                    <th class="text-center">ICD10&ICD9</th> 
                                    <th class="text-center">ชื่อ</th> 
                                    <th class="text-center">diag type</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($thalassemia_opdsub_drugdiag_hn as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>                                       
                                        <td width="10%" class="text-center">{{ $item->icd10 }}</td>
                                        <td class="p-2">{{ $item->iname }}</td>
                                        <td width="10%" class="text-center">{{ $item->diagtype }}</td>
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
                                <h5>รายการ icd9 ผู้ป่วยใน</h5>
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
                                    <th class="text-center">ICD10&ICD9</th> 
                                    <th class="text-center">ชื่อ</th> 
                                    <th class="text-center">diag type</th> 
                                    <th class="text-center">วันที่เข้า</th> 
                                    <th class="text-center">เวลาเข้า</th> 
                                    <th class="text-center">วันที่ออก</th> 
                                    <th class="text-center">เวลาออก</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($thalassemia_opdsub_drugdiag_lab as $item2)
                                    <tr>
                                        <td>{{ $i++ }}</td>                                       
                                        <td width="10%" class="text-center">{{ $item2->icd9 }}</td>
                                        <td class="p-2">{{ $item2->iname }}</td>
                                        <td width="10%" class="text-center">{{ $item2->priority }}</td>
                                        <td width="14%" class="text-center">{{ $item2->opdate }}</td>
                                        <td width="10%" class="text-center">{{ $item2->optime }}</td>
                                        <td width="14%" class="text-center">{{ $item2->enddate }}</td>
                                        <td width="10%" class="text-center">{{ $item2->endtime }}</td>
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
