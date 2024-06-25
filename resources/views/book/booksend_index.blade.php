@extends('layouts.staff_book')
@section('title', 'ZOFFice || Book-Staff')

@section('menu')
<style>
  .btn{
     font-size:15px;
   }
   .btnco{
    background-color: #E9E5E5;
   }
</style>
<div class="px-3 py-2 border-bottom">
  <div class="container d-flex flex-wrap justify-content-center"> 
  {{-- <a href="{{url("book/book_dashboard")}}" class="btn btn-secondary btn-rounded btn-sm text-white shadow me-2">Dashboard</a> --}}
  <a href="{{url("book/bookmake_index")}}" class="btn btn-light btn-sm text-dark me-2">หนังสือรับ</a>  
  {{-- <a href="{{url("book/bookrep_index")}}" class="btn btn-secondary btn-rounded text-white shadow-lg me-2">สร้างงานใหม่</a>    --}}
  {{-- <a href="{{url("book/bookrep_index_add")}}" class="btn btn-secondary btn-sm text-white shadow me-2 " >สร้างงานใหม่</a>   --}}
  <a href="{{url("book/booksend_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-primary btn-sm text-white me-2">หนังสือเวียน</a>  
  <div class="text-end"> 
    {{-- <a href="{{url("book/booksend_index_add")}}" class="btn btn-success btn-rounded btn-sm">ออกเลขหนังสือส่ง</a> --}}
    <a href="{{url("book/booksend_index")}}" class="btn btn-light btn-sm text-dark me-2">ออกเลขหนังสือเวียน</a> 
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
<div class="container-fluid " style="width: 97%">
    <div class="row">
        <div class="col-md-12">  
            <div class="card">
                <div class="card-body shadow-lg">    
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example">
                      {{-- <table class="table table-hover table-bordered border-primary" style="width: 100%;" id="table_id"> เส้นสีฟ้า--}}
                      <thead>
                        <tr >
                           <th width="5%" class="text-center">ลำดับ</th>
                           <th class="text-center">ชื่อ-นามสกุล</th>
                           <th class="text-center">ตำแหน่ง</th>
                           <th class="text-center">หน่วยงาน</th>
                           <th class="text-center">username</th>
                           <th width="5%" class="text-center">สถานะ</th>
                           <th width="10%" class="text-center">Manage</th>
                        </tr>  
                      </thead>
                      <tbody>
                        <?php $i = 1; 
   
                         $date =  date('Y');
                        
                        ?>      
                         @foreach ( $users as $mem ) 
                          <tr id="sid{{$mem->id}}">
                                <td class="text-center">{{$i++}}</td>  
                                <td class="p-2">{{$mem->fname}} {{$mem->lname}}</td>                          
                                <td class="font-weight-bold">{{$mem->position_name}}</td>
                                <td class="p-2">{{$mem->dep_subsubname}}</td>
                                <td class="p-2">{{$mem->username}}</td>
                                
                                @if ($mem->type == 'ADMIN')
                                  <td class="font-weight-medium text-center"><div class="badge bg-danger">{{$mem->type}}</div></td>
                                @elseif ($mem->type == 'STAFF')
                                  <td class="font-weight-medium text-center"><div class="badge bg-success">{{$mem->type}}</div></td>
                                  @elseif ($mem->type == 'CUSTOMER')
                                  <td class="font-weight-medium text-center"><div class="badge bg-info">{{$mem->type}}</div></td>
                                @else
                                  <td class="font-weight-medium text-center"><div class="badge bg-warning">{{$mem->type}}</div></td>
                                @endif
                                <td class="text-center" width="10%"> 
                                      <a href="{{url('person/person_index_edit/'.$mem->id)}}" class="text-warning me-3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="แก้ไข" >
                                        <i class="fa-solid fa-pen-to-square"></i>
                                      </a> 
                                                                
                                      <a class="text-danger" href="javascript:void(0)" onclick="person_destroy({{$mem->id}})" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="ลบ">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>                                                          
                                </td>
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
</div>
   

@endsection
