@extends('layouts.user')
@section('title','ZOffice || ทำงานต่างประเทศ')
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
    <div class="px-0 py-0 border-bottom mb-2">
      <div class="d-flex flex-wrap justify-content-center">  
        <a href="{{url('user/gleave_data_add')}}" class="btn btn-light col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto text-dark me-2">
          <i class="fa-solid fa-angles-left text-danger">    </i>
          ย้อนกลับ
        </a>
      
        <div class="text-end">   
          <a type="button" class="btn btn-primary"> ทำงานต่างประเทศ</a>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('ทำงานต่างประเทศ') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are ทำงานต่างประเทศ  ') }}

                  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
