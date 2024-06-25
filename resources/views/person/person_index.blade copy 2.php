@extends('layouts.person')

@section('title', 'ZOFFice || บุคลากร')
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

@section('menu')
<style>
    .btn{
       font-size:15px;
     }
  </style>
      <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center"> 
            <a href="{{url("person/person_index")}}" class="btn btn-info btn-sm text-white me-2">ข้อมูลบุคลากร</a>
            <a href="{{url("person/depsub_index")}}" class="btn btn-light btn-sm text-dark me-2">ประชุมภายนอก</a>
            <a href="{{url("person/depsubsub_index")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-2">ประชุมภายใน</a>          
      
          <div class="text-end">
            <a href="{{ url('person/person_index_add') }}" class="btn btn-light btn-sm text-dark me-2">เพิ่มข้อมูลบุคลากร </a>
        </div>
        </div>
      </div>
@endsection
@section('content')  
    <div class="container-fluid" style="width: 97%">
        <div class="row ">
            <div class="col-md-12">
                <div class="card shadow"> 

                    <div class="card-body shadow">
                        
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                id="example"> 
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">ชื่อ-นามสกุล</th>
                                        <th class="text-center">ตำแหน่ง</th>
                                        <th class="text-center">กลุ่มงาน</th>
                                        <th class="text-center">ฝ่าย/แผนก</th>
                                        <th class="text-center">หน่วยงาน</th>
                                        <th width="16%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    
                                    $date = date('Y');
                                    
                                    ?>
                                    @foreach ($users as $mem)
                                        <tr id="sid{{ $mem->id }}">
                                            <td class="text-center" width="5%">{{ $i++ }}</td>
                                            <td class="p-2" width="13%">{{ $mem->fname }} {{ $mem->lname }}</td>
                                            <td class="p-2" width="17%">{{ $mem->position_name }}</td>
                                            <td class="p-2" width="20%">{{$mem->dep_name}}</td>
                                            <td class="p-2">{{$mem->dep_subname}}</td>
                                            <td class="p-2">{{$mem->dep_subsubname}}</td>  

                                            <!--  @if ($mem->type == 'ADMIN')
                                                <td class="font-weight-medium text-center">
                                                    <div class="badge bg-danger">{{ $mem->type }}</div>
                                                </td>
                                            @elseif ($mem->type == 'STAFF')
                                                <td class="font-weight-medium text-center">
                                                    <div class="badge bg-success">{{ $mem->type }}</div>
                                                </td>
                                            @elseif ($mem->type == 'CUSTOMER')
                                                <td class="font-weight-medium text-center">
                                                    <div class="badge bg-info">{{ $mem->type }}</div>
                                                </td>
                                            @else
                                                <td class="font-weight-medium text-center">
                                                    <div class="badge bg-warning">{{ $mem->type }}</div>
                                                </td>
                                            @endif
                                            -->
                                            <td class="text-center" width="10%">

                                                <a href="{{ url('person/person_index_edit/' . $mem->id) }}"
                                                    class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip" title="แก้ไข" >
                                                    <i class="fa-solid fa-pen-to-square me-2"></i>
                                                </a>
                                              <!-- <button type="button" class="btn rounded-pill text-info edit_type" 
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                data-bs-custom-class="custom-tooltip" 
                                                title="กำหนดสิทธิ์การเข้าถึง"                                  
                                                value="{{$mem->id}}">
                                                  <i class="fa-solid fa-layer-group"></i>
                                                </button> -->
                                                <a class="text-danger" href="javascript:void(0)"
                                                    onclick="person_destroy({{ $mem->id }})" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                    title="ลบ">
                                                    <i class="fa-solid fa-trash-can me-2"></i>
                                                </a>
                                            <!--
                                                <a href="{{ url('person/person_index_addsub/' . $mem->id) }}"
                                                    class="text-primary" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                    title="เพิ่มข้อมูลรายละเอียดส่วนบุคคล">
                                                    <i class="fa-solid fa-person-circle-plus"></i>
                                                </a>
                                            -->
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-2">
                <div class="card"> 
                    <div class="card-header shadow-lg text-center">
                        เพิ่มข้อมูลบุคลากร
                    </div>

                    <div class="card-body shadow">
                        <form action="{{ route('person.person_save') }}" method="POST" id="insert_personForm"
                            enctype="multipart/form-data">
                       
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input id="fname" type="text"
                                            class="form-control @error('fname') is-invalid @enderror" name="fname"
                                            value="{{ old('fname') }}" required autocomplete="name" autofocus
                                            placeholder="ชื่อ">

                                        @error('fname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>                               
                            </div>
                            <div class="row mt-3">                        
                              <div class="col-md-12">
                                  <div class="form-group">
                                      <input id="lname" type="text"
                                          class="form-control @error('lname') is-invalid @enderror" name="lname"
                                          value="{{ old('lname') }}" required autocomplete="name" autofocus
                                          placeholder="นามสกุล">

                                      @error('lname')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                  </div>
                              </div>                                
                          </div>


                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input id="username" type="text"
                                            class="form-control @error('username') is-invalid @enderror" name="username"
                                            value="{{ old('username') }}" required autocomplete="username" autofocus
                                            placeholder="ชื่อผู้ใช้งาน">

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                               
                            </div>

                            <div class="row mt-3"> 
                              <div class="col-md-12">
                                  <div class="form-group">
                                      <input id="password" type="password"
                                          class="form-control @error('password') is-invalid @enderror" name="password"
                                          required autocomplete="new-password" placeholder="รหัสผ่าน">

                                      @error('password')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                  </div>
                              </div>
                          </div>


                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select id="dep" name="dep_id"
                                            class="form-control form-control-lg department" style="width: 100%">
                                            <option value=""></option>
                                            @foreach ($department as $depart)
                                                <option value="{{ $depart->DEPARTMENT_ID }}">
                                                    {{ $depart->DEPARTMENT_NAME }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select id="depsub" name="dep_subid"
                                            class="form-control form-control-lg department_sub" style="width: 100%">
                                            <option value=""></option>
                                            @foreach ($department_sub as $departsub)
                                                <option value="{{ $departsub->DEPARTMENT_SUB_ID }}">
                                                    {{ $departsub->DEPARTMENT_SUB_NAME }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select id="depsubsub" name="dep_subsubid"
                                            class="form-control form-control-lg department_sub_sub" style="width: 100%">
                                            <option value=""></option>
                                            @foreach ($department_sub_sub as $departsubsub)
                                                <option value="{{ $departsubsub->DEPARTMENT_SUB_SUB_ID }}">
                                                    {{ $departsubsub->DEPARTMENT_SUB_SUB_NAME }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select id="depsubsubtrue" name="dep_subsubtrueid"
                                            class="form-control form-control-lg" style="width: 100%">
                                            <option value=""></option>
                                            @foreach ($department_sub_sub as $departsubsubtrue)
                                                <option value="{{ $departsubsubtrue->DEPARTMENT_SUB_SUB_ID }}">
                                                    {{ $departsubsubtrue->DEPARTMENT_SUB_SUB_NAME }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select id="position" name="position_id" style="width: 100%">
                                            <option value=""></option>
                                            @foreach ($position as $item)
                                                <option value="{{ $item->POSITION_ID }}">{{ $item->POSITION_NAME }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input id="start_date" type="date" class="form-control datepicker"
                                            name="start_date" placeholder="วันที่เริ่มงาน">

                                        @error('start_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    

                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select id="status" name="status" style="width: 100%">
                                            <option value=""></option>
                                            @foreach ($status as $st)
                                                <option value="{{ $st->STATUS_ID }}">{{ $st->STATUS_NAME }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary ">
                                    <i class="fa-solid fa-floppy-disk me-3"></i>บันทึกข้อมูล
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

    <!--Edit  Modal update_type -->
    <div class="modal fade" id="editexampleModal" tabindex="-1" aria-labelledby="editexampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editexampleModalLabel">กำหนดการสิทธิ์เข้าถึง</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="update_type">
                        @csrf
                        @method('PUT')
                        <input type="hidden" class="form-control" id="edittype_id" name="edittype_id" />


                        <div class="col-md-12">
                            <div class="form-group">
                                {{-- <input type="text" class="form-control" id="edittype_name" name="type" placeholder=""> --}}
                                <select class="form-control" id="edittype_name" name="type" style="width: 100%">
                                    {{-- <option value=""></option> --}}
                                    <option value="STAFF">STAFF</option>
                                    <option value="ADMIN">ADMIN</option>
                                    <option value="CUSTOMER">CUSTOMER</option>
                                    <option value="MANAGE">MANAGE</option>
                                    <option value="USER">USER</option>
                                    <option value="NOTUSER">NOTUSER</option>
                                </select>
                            </div>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-success rounded-pill">
                        <i class="ri-save-3-fill me-1"></i>
                        Save
                    </button>
                    <button type="button" class="btn btn-outline-danger rounded-pill" data-bs-dismiss="modal">
                        <i class="ri-shut-down-line me-1"></i>
                        Cancel
                    </button>

                </div>
                </form>
            </div>
        </div>
    </div>






@endsection
