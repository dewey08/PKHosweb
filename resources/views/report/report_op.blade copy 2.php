@extends('layouts.pkclaim')

@section('content')
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
  <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">รายงานผู้ป่วยนอกแยกสิทธิ์การรักษา</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                            <li class="breadcrumb-item active">รายงานผู้ป่วยนอกแยกสิทธิ์การรักษา</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    {{-- <div class="card-body pb-0"> 
                        <div class="row">
                            <div class="col"></div>
                            <div class="col-md-2">
                                <input type="date" name="startdate" id="startdate" class="form-control"> 
                            </div>
                            <div class="col-md-1 text-center"> 
                                <label for=""> ถึง </label> 
                            </div>
                            <div class="col-md-2"> 
                                <input type="date" name="enddate" id="enddate" class="form-control"> 
                            </div>
                            <div class="col-md-2"> 
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-magnifying-glass me-2"></i>
                                    ค้นหา
                                </button>
                            </div>
                            <div class="col"></div>
                        </div>
                    </div>
                    <br> --}}
                        <div class="card-body py-0 px-2 mt-2"> 
                                <div class="table-responsive">
                                    {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example"> --}}
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">   
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center">ปี</th>
                                                <th class="text-center">จำนวนผู้ป่วยทั้งหมด(ครั้ง)</th>
                                                <th class="text-center">บัตรทอง UC</th>
                                                <th class="text-center">ข้าราชการ OFC</th>
                                                <th class="text-center">ข้าราชการ LGO</th>
                                                <th class="text-center">ประกันสังคม SSS</th>
                                                <th class="text-center">ต่างด้าว NRD</th>
                                                <th class="text-center">สถานะสิทธฺ์ STP</th>
                                                <th class="text-center">ครูเอกชน PVT</th>
                                                <th class="text-center">คนไทยในต่างประเทศFRG</th>
                                                <th class="text-center">ผู้ประกันตนคนพิการDIS</th>
                                                <th class="text-center">ชำระเงิน/สงเคราะห์</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($datashow as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->datesave }}</td>
                                                <td>{{ $item->totol }}</td>
                                                <td>{{ $item->ucs }}</td>
                                                <td>{{ $item->ofc }}</td>
                                                <td>{{ $item->lgo }}</td>
                                                <td>{{ $item->sss }}</td>
                                                <td>{{ $item->nrd }}</td>
                                                <td>{{ $item->stp }}</td>
                                                <td>{{ $item->pvt }}</td>
                                                <td>{{ $item->frg }}</td>
                                                <td>{{ $item->dis }}</td>
                                                <td>{{ $item->other }}</td>
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

        <div class="row">
            <div class="col-xl-12">
                <h6 class="mb-0 text-uppercase">Line Chart </h6>
                <hr />
                <div class="card shadow">
                    <div class="card-body">
                        <div class="chart-container-fluid">
                            <canvas id="myChart" width="800" height="1000"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> 
    @endsection
    @section('footer')
        
    @endsection
