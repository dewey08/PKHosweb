@extends('layouts.backend')
@section('css_before')
    @yield('css_before_cpay')
@endsection
@section('css_after')   
    <link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('asset/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css')}}">
    @yield('css_after_cpay')
@endsection
@section('content')
@php($PERSON_ID = Auth()->user()->PERSON_ID)
<div class="bg-body-light">
    <div class="block-header block-header-default">
        <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>งานจ่ายกลาง</B></h3>
        <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <div class="row">
                    <!-- <a href="{{route('gencpay.dashboard',$PERSON_ID)}}" class="mr-2 btn {{request()->is('general_cpay/dashboard*')?'btn-primary':'btn-noneactive'}}">Dashboard</a> -->
                    <a href="{{route('gencpay.quota_equpment',$PERSON_ID)}}" class="mr-4 btn {{request()->is('general_cpay/quota_equpment*')?'btn-primary':'btn-noneactive'}}" >ชุดอุปกรณ์คงเหลือ <span class="badge badge-danger"></span></a>
            </ol>
        </nav>
    </div>
</div>
@yield('content_cpay')
@endsection
@section('footer')
    <script src="{{ asset('datepicker/bootstrap-3.3.7-dist/js/bootstrap.js') }}"></script>
    <script src="{{ asset('datepicker/bootstrap-3.3.7-dist/js/bootstrap.js') }}"></script>
    <script src="{{ asset('google/Charts.js') }}"></script>
    @yield('footer_cpay')
@endsection