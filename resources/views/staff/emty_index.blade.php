@extends('layouts.staff')
@section('title', 'ZOFFice || Dashboard-Staff')

@section('menu')
    <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center"> 
        {{-- <a href="{{url("setting/setting_index")}}" class="btn btn-secondary text-white shadow-lg me-2">กลุ่มงาน</a> --}}
        {{-- <a href="{{url("setting/setting_permiss")}}" class="btn btn-secondary text-white shadow-lg me-2">กำหนดสิทธิ์การเห็นชอบ</a>   --}}
        {{-- <a href="{{url("land/land_index")}}" class="btn btn-danger text-white shadow-lg me-2">ข้อมูลที่ดิน</a>
        <a href="{{url("building/building_index")}}" class="btn btn-danger text-white shadow-lg me-2">ข้อมูลอาคาร</a>    
        <a href="{{url("serve/serve_index")}}" class="btn btn-danger text-white shadow-lg me-2">ข้อมูลบริการ</a>        
        <a href="{{url("supplies/supplies_index")}}" class="btn btn-danger text-white shadow-lg me-2">ข้อมูลวัสดุ</a>
        <a href="{{url("article/article_index")}}" class="btn btn-danger text-white shadow-lg me-2">ข้อมูลครุภัณฑ์</a>                
        <a href="{{url("supplies/supplies_index")}}" class="btn btn-danger text-white shadow-lg me-2">ข้อมูลค่าเสื่อม</a>
        <a href="{{url("supplies/supplies_index")}}" class="btn btn-danger text-white shadow-lg me-2">ขายทอดตลาด</a>   --}}
        <a href="{{url("setting/setting_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-secondary text-white me-2">Dashboard</a>  
        <div class="text-end">
            {{-- <a type="button" class="btn btn-light text-dark me-2">Login</a> --}}
            <a href="{{url("setting/setting_index")}}" class="btn btn-danger">ตั้งค่าข้อมูล</a>
        </div>
        </div>
    </div>
@endsection
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
  <div class="container ">
      


  </div>
@endsection
