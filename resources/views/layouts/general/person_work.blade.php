@extends('layouts.backend')
@section('css_before')
    @yield('css_before_infowork')
@endsection
@section('css_after')
    <link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('asset/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
    @yield('css_after_infowork')
@endsection
@section('content')
<?php
    $person_id = Auth()->user()->PERSON_ID;
    $inforpersonuser = DB::table('hrd_person')->leftJoin('hrd_prefix','hrd_prefix.HR_PREFIX_ID','hrd_person.HR_PREFIX_ID')->where('ID',$person_id)->first();
    $permission_estimate_kpi = DB::table('infowork_job_person_permission')->where('IWJOB_PERMIS_PERSON_ID',$person_id)->first();
?>
<!-- Advanced Tables -->
<div class="bg-body-light">
    <div class="content">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.3rem;font-weight:normal;">
                {{ $inforpersonuser->HR_PREFIX_NAME }} {{$inforpersonuser->HR_FNAME }}
                {{ $inforpersonuser->HR_LNAME }}</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <div class="row">
                        <div>
                            <a href="{{ url('person_work/personworkjobdescription/'.$person_id)}}"
                                class="btn fw-4 <?=request()->is('person_work/personworkjobdescription/*')?'btn-primary':'btn-noneactive'?> mr-1">
                                Job description
                            </a>
                        </div>
                        <div>
                            <a href="{{ url('person_work/personworkcorecompetency_detail/'.$person_id)}}"
                                class="btn fw-4 <?=request()->is('person_work/personworkcorecompetency*')?'btn-primary':'btn-noneactive'?> mr-1">Core competency</a>
                        </div>
                        <div>
                            <a href="{{ url('person_work/personworkfuntionalcompetency_detail/'.$person_id)}}"
                                class="btn fw-4 <?=request()->is('person_work/personworkfuntionalcompetency*')?'btn-primary':'btn-noneactive'?> mr-1">Funtional competency
                            </a>
                        </div>
                        <div>
                            <a href="" class="btn fw-4 <?=request()->is('')?'btn-primary':'btn-noneactive'?> mr-1">KPI</a>
                            <!-- <a href="{{ route('pwork.kpi',$person_id)}}" class="btn fw-4 <?=request()->is('person_work/personworkkpi*')?'btn-primary':'btn-noneactive'?> mr-1">KPI</a> -->
                        </div>
                        @if(!empty($permission_estimate_kpi))
                        <div>
                            <a href="{{route('person.infowork.jobdes_estimate',$person_id)}}"
                                class="btn fw-4 <?=(request()->is('person_work/personwork_estimate_jobdescription*') || 
                                                    request()->is('person_work/personwork_estimate_kpi_person*')
                                                    )?'btn-success':'btn-noneactive'?> mr-1">
                                ประเมิน KPIs
                            </a>
                        </div>
                        @endif
                        <div>
                            <a href="" class="btn fw-4 <?=request()->is('person_work/personworkLeanning*')?'btn-primary':'btn-noneactive'?>">E-Leanning</a>
                        </div>
                        <div class="mr-3"></div>
                </ol>
            </nav>
        </div>
    </div>
</div>
@yield('content_infowork')
@endsection
@section('footer')
    <script src="{{ asset('datepicker/bootstrap-3.3.7-dist/js/bootstrap.js') }}"></script>
    <script src="{{ asset('datepicker/dist/js/bootstrap-datepicker-custom.js') }}"></script>
    <script src="{{ asset('datepicker/dist/locales/bootstrap-datepicker.th.min.js') }}" charset="UTF-8"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('asset/js/plugins/easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Page JS Code -->
    <script src="{{ asset('asset/js/pages/be_comp_charts.min.js') }}"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('asset/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/datatables/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/datatables/buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/datatables/buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/datatables/buttons/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('asset/js/plugins/datatables/buttons/buttons.colVis.min.js') }}"></script>
    <!-- Page JS Code -->
    <script src="{{ asset('asset/js/pages/be_tables_datatables.min.js') }}"></script>
    @yield('footer_infowork')
@endsection
