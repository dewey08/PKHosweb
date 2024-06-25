@extends('layouts.admin_setting')
@section('title', 'PK-OFFICER || Line Token')
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

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">   
              <div class="card">
                  {{-- <div class="card-header">{{ __('ตั้งค่ากลุ่มงาน') }}</div> --}}
                    <div class="card-body shadow-lg">
                      @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif                    

                    <div class="table-responsive"> 
                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                          {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example"> --}}
                          <thead>
                              <tr height="10px">
                                  <th width="5%" class="text-center">ลำดับ</th> 
                                  <th class="text-center" width="20%">ชื่อกลุ่ม</th>
                                  
                                  <th class="text-center">Line Token</th> 
                                  <th width="10%" class="text-center">Manage</th>
                              </tr>
                          </thead>
                          <tbody> 
                            @foreach ($line_token as $key=>$item)
                
                                <tr >
                                    <td class="text-center">{{ $key+1 }}</td>
                                    <td class="p-2" width="20%">{{ $item->line_token_name }}</td>
                                    <td class="p-2">{{ $item->line_token_code }}</td>        
                                    <td class="text-center" width="10%">
                                        {{-- <button type="button" class="btn btn-warning btn-sm edit_line" value="{{ $item->line_token_id }}" 
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                            title="แก้ไข" >
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button> --}}
                                        <div class="dropdown">
                                            <button class="btn btn-outline-info dropdown-toggle menu" type="button" data-bs-toggle="dropdown" aria-expanded="false">ทำรายการ</button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    {{-- <a href="" class="dropdown-item menu edit_line"  data-bs-toggle="tooltip" data-bs-placement="left" title="แก้ไข" >
                                                     <i class="fa-solid fa-pen-to-square mt-2 ms-2 mb-2 me-2 text-warning"></i>
                                                     <label for="" style="color: rgb(33, 187, 248)">แก้ไข</label> 
                                                   </a> --}}
                                                 </li>    
                                                 <button type="button"class="dropdown-item menu edit_line"  value="{{ $item->line_token_id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="รายละเอียด">
                                                    <i class="fa-solid fa-pen-to-square mt-2 ms-2 mb-2 me-2 text-warning"></i>
                                                    <label for="" style="color: rgb(243, 168, 7)">แก้ไข</label> 
                                                  </button>
                                            </ul>
                                          </div>
                                      
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
<div class="modal fade" id="linetokenModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <form action="{{ route('setting.line_token_update') }}" id="insert_lineForm" method="POST">
              @csrf
              @method('PUT')
              
              <input type="hidden" id="userid" name="userid" value="{{ Auth::user()->id }}"> 
              <input type="hidden" id="line_token_id" name="line_token_id"> 

          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">ตั้งค่า Line Token</h5>
         
          </div>
          <div class="modal-body">            
                <div class="row">
                    <div class="col-md-2 text-end">
                        <label for="line_token_name">ชื่อกลุ่ม :</label>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input id="line_token_name" type="text" class="form-control" name="line_token_name" readonly>                           
                        </div>
                    </div>     
                    <div class="col-md-2 text-end">
                      <label for="line_token_code">Line Token :</label>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                          <input id="line_token_code" type="text" class="form-control" name="line_token_code">                        
                      </div>
                  </div>                                                 
                </div> 

          </div>
        
          <div class="modal-footer"> 
              <button type="submit" id="saveBtn" class="btn btn-primary">แก้ไขข้อมูล</button> 
          </div>
        </form> 
      </div>
  </div>
</div>


@endsection
