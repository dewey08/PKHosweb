@extends('layouts.anc')
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
                                <h5>จำนวนผู้ป่วย Thalassemia OPD ให้เลือด</h5>
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
                                    <th class="text-center">เดือน</th> 
                                    <th class="text-center">จำนวนผู้ป่วย(ครั้ง)</th> 
                                    <th class="text-center">จำนวนผู้ป่วย(ครั้ง)ได้ยา</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow_opd as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td> 
                                      
                                        @if ($item->months == '1')
                                            <td width="20%" class="text-center">มกราคม</td>
                                            @elseif ($item->months == '2')
                                                <td width="20%" class="text-center">กุมภาพันธ์</td>
                                            @elseif ($item->months == '3')
                                                <td width="20%" class="text-center">มีนาคม</td>
                                            @elseif ($item->months == '4')
                                                <td width="20%" class="text-center">เมษายน</td>
                                            @elseif ($item->months == '5')
                                                <td width="20%" class="text-center">พฤษภาคม</td>
                                            @elseif ($item->months == '6')
                                                <td width="20%" class="text-center">มิถุนายน</td>
                                            @elseif ($item->months == '7')
                                                <td width="20%" class="text-center">กรกฎาคม</td>
                                            @elseif ($item->months == '8')
                                                <td width="20%" class="text-center">สิงหาคม</td>
                                            @elseif ($item->months == '9')
                                                <td width="20%" class="text-center">กันยายน</td>
                                            @elseif ($item->months == '10')
                                                <td width="20%" class="text-center">ตุลาคม</td>
                                            @elseif ($item->months == '11')
                                                <td width="20%" class="text-center">พฤษจิกายน</td>
                                            @else
                                            <td width="20%" class="text-center">ธันวาคม</td>
                                        @endif
                                       
                                        <td class="text-center">
                                            <a href="{{url('thalassemia_opdsub/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->VN }}</a>  
                                        </td>
                                        <td class="text-center">
                                            <a href="{{url('thalassemia_opdsubdrug/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->OVN }}</a>  
                                        </td>  
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
