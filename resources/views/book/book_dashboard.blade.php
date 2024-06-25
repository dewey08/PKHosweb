@extends('layouts.staff_book')
@section('title', 'ZOFFice || Book-Staff')

@section('menu')
<style>
  .btn{
     font-size:15px;
   }
</style>
<div class="px-3 py-2 border-bottom">
    <div class="container d-flex flex-wrap justify-content-center"> 
        {{-- <a href="{{url("book/book_dashboard")}}" class="btn btn-primary btn-rounded btn-sm text-white shadow me-2">Dashboard</a> --}}
        <a href="{{url("book/bookmake_index")}}" class="btn btn-light btn-sm text-white me-2">หนังสือรับ</a>  
        {{-- <a href="{{url("book/bookrep_index")}}" class="btn btn-secondary btn-rounded text-white shadow me-2">สร้างงานใหม่</a>    --}}
        <a href="{{url("book/bookrep_index_add")}}" class="btn btn-light btn-sm text-white me-2">สร้างงานใหม่</a>  
        <a href="{{url("book/booksend_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light btn-sm text-white me-2">หนังสือเวียน</a>  
        <div class="text-end"> 
            {{-- <a href="{{url("book/bookrep_index_add")}}" class="btn btn-primary btn-rounded">หนังสือรับ</a> --}}
            {{-- <label for="" class="text-danger" style="font-size: 16px">หนังสือรับ</label> --}}
            {{-- <h4>หนังสือรับ</h4> --}}
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
<div class="container-fluid ">
    <div class="row">
        <div class="col-md-12">  
            <div class="card">
                <div class="card-body shadow-lg">    
                  
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
   

@endsection
