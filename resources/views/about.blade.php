@extends('layouts.admin')

    <script src="{{ asset('datepicker/jquery-2.1.3.min.js') }}"></script>

    <link href="{{ asset('datepicker/bootstrap-3.3.7-dist/css/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('datepicker/bootstrap-3.3.7-dist/css/bootstrap-theme.css') }}" rel="stylesheet" />
    <script src="{{ asset('datepicker/bootstrap-3.3.7-dist/js/bootstrap.js') }}"></script>

    <link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
    <script src="{{ asset('datepicker/dist/js/bootstrap-datepicker-custom.js') }}"></script>
    <script src="{{ asset('datepicker/dist/locales/bootstrap-datepicker.th.min.js') }}" charset="UTF-8"></script>
   
   
    @section('content')

    <label for="inputdatepicker" class="col-md-2 control-label">datepicker</label>
    <div class="col-md-10">
         
        <input id="inputdatepicker" class="datepicker" data-date-format="mm/dd/yyyy">
    </div>
    @endsection
    
<script>
    $(document).ready(function () {
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true              //Set เป็นปี พ.ศ.
        }).datepicker("setDate", "0");  //กำหนดเป็นวันปัจุบัน
    });
</script>