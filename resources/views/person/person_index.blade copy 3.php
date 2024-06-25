@extends('layouts.person')

@section('title', 'ZOFFice || บุคลากร')
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }

    function person_destroy(id)
    {
      Swal.fire({
      title: 'ต้องการลบใช่ไหม?',
      text: "ข้อมูลนี้จะถูกลบไปเลย !!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
      cancelButtonText: 'ไม่, ยกเลิก'
      }).then((result) => {
      if (result.isConfirmed) {
          $.ajax({
          url:"{{url('person/person_destroy')}}" +'/'+ id,  
          type:'DELETE',
          data:{
              _token : $("input[name=_token]").val()
          },
          success:function(response)
          {          
              Swal.fire({
                title: 'ลบข้อมูล!',
                text: "You Delet data success",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#06D177',
                // cancelButtonColor: '#d33',
                confirmButtonText: 'เรียบร้อย'
              }).then((result) => {
                if (result.isConfirmed) {                  
                  $("#sid"+id).remove();     
                  window.location.reload(); 
                //   window.location = "/person/person_index"; //     
                }
              }) 
          }
          })        
        }
        })
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
                                        <th class="text-center" width="13%">ชื่อ-นามสกุล</th>
                                        <th class="text-center" width="15%">ตำแหน่ง</th>
                                        <th class="text-center" width="20%">กลุ่มงาน</th>
                                        <th class="text-center">ฝ่าย/แผนก</th>
                                        <th class="text-center">หน่วยงาน</th>
                                        <th width="7%" class="text-center">Manage</th>
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
                                            <td class="p-2" width="15%">{{ $mem->position_name }}</td>
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
                                            <td class="text-center" width="7%">

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
