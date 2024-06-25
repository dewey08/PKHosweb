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
            <div class="col"></div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>รายการ icd10 ผู้ป่วยนอก</h5>
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
                                @foreach ($thalassemia_opdsub_diag_vn as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>                                       
                                        <td class="text-center">{{ $item->icd10 }}</td>
                                        <td class="p-2">{{ $item->iname }}</td>
                                        <td width="15%" class="text-center">{{ $item->diagtype }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
 
                        </div>
                    </div>
                </div>
            </div>         
            <div class="col"></div>
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
