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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>รายการวินิจฉัย ใน</h5>
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
                                        <th class="text-center">HN</th>
                                        <th class="text-center">AN</th>
                                        <th class="text-center">วัน Admit</th>
                                        <th class="text-center">วันที่จำหน่าย</th>
                                        <th class="text-center">รหัสโรค</th>
                                        <th class="text-center">รายการ Lab</th>
                                        <th class="text-center">รายการยา</th>
                                        <th class="text-center">ให้เลือด</th>
                                        <th class="text-center" width="7%">หัตถการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($thalassemia_opdsubdrug_hn as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td class="text-center">{{ $item->hn }}</td>
                                            <td class="text-center">{{ $item->an }}</td>
                                            <td class="text-center">{{ $item->regdate }}</td>
                                            <td class="text-center">{{ $item->dchdate }}</td>
                                            <td class="text-center">
                                                <a href="{{url('thalassemia_opdsub_drugdiag_hn/'.$item->an)}}" target="_blank">{{ $item->icd10 }}</a>  
                                            </td>
                                            <td class="p-2">
                                                <a href="{{url('thalassemia_opdsub_drugdiag_lab/'.$item->an)}}" target="_blank">{{ $item->listlab }}</a>  
                                            </td>
                                            <td class="text-center"> {{ $item->nname }} </td>
                                            <td class="text-center">{{ $item->blood }}</td>
                                            <td class="text-center" width="7%">{{ $item->iptoprt }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>รายการวินิจฉัย นอก</h5>
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
                                        <th class="text-center">HN</th>
                                        <th class="text-center">AN</th>
                                        <th class="text-center">วัน Admit</th> 
                                        <th class="text-center">รหัสโรค</th>
                                        <th class="text-center">รายการ Lab</th>
                                        <th class="text-center">รายการยา</th>
                                        <th class="text-center">ให้เลือด</th>
                                        <th class="text-center" width="7%">หัตถการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow_opd as $item2)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td class="text-center">{{ $item2->hn }}</td>
                                            <td class="text-center">{{ $item2->vn }}</td>
                                            <td class="text-center">{{ $item2->vstdate }}</td> 
                                            <td class="text-center">{{ $item2->pdx }}</td>
                                            <td class="p-2">{{ $item2->nname }}</td>
                                            <td class="p-2"> {{ $item2->listlab }} </td>
                                            <td class="text-center">{{ $item2->blood }}</td>
                                            <td class="text-center" width="7%">{{ $item2->iptoprt }}</td>
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

        });
    </script>


@endsection
