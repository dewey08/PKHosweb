@extends('layouts.userhn')
@section('title','ZOffice || หัวหน้า')
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
  {{-- <div class="px-0 py-0 border-bottom mb-2">
    <div class="d-flex flex-wrap justify-content-center">
        <a class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto text-white me-2"></a>

        <div class="text-end">
          <a href="{{url('hn/hn_dashboard')}}" class="btn btn-warning text-white shadow-lg me-2">dashboard</a>
          <a href="{{url('hn/hn_bookindex')}}" class="btn btn-light text-dark shadow-lg me-2">หนังสือราชการ<span class="badge bg-danger ms-2">9</span></a>
          <a href="{{url('hn/hn_leaveindex')}}" class="btn btn-light text-dark shadow-lg me-2">เห็นชอบการลา<span class="badge bg-danger ms-2">9</span></a>
          <a href="{{url('hn/hn_trainindex')}}" class="btn btn-light text-dark shadow-lg me-2">เห็นชอบประชุม/อบรม/ดูงาน<span class="badge bg-danger ms-2">9</span></a>
          <a href="{{url('hn/hn_purchaseindex')}}" class="btn btn-light text-dark shadow-lg me-2">เห็นชอบจัดซื้อจัดจ้าง<span class="badge bg-danger ms-2">9</span></a>
          <a href="{{url('hn/hn_storeindex')}}" class="btn btn-light text-dark shadow-lg me-2">เห็นชอบคลังวัสดุ<span class="badge bg-danger ms-2">9</span></a>
           
        </div>
    </div>
</div> --}}
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!  USER_INDEX') }}

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#saexampleModal">
                        Launch demo modal PAGE DASHBOARD
                      </button>
                      
                      <!-- Modal -->
                      <div class="modal fade" id="saexampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              ...
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
