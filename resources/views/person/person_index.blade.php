@extends('layouts.person')
@section('title', 'PK-OFFICER || บุคลากร')
@section('content') 
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

<style>
    #button {
        display: block;
        margin: 20px auto;
        padding: 30px 30px;
        background-color: #eee;
        border: solid #ccc 1px;
        cursor: pointer;
    }

    #overlay {
        position: fixed;
        top: 0;
        z-index: 100;
        width: 100%;
        height: 100%;
        display: none;
        background: rgba(0, 0, 0, 0.6);
    }

    .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .spinner {
        width: 250px;
        height: 250px;
        border: 10px #ddd solid;
        border-top: 10px #d22cf3 solid;
        border-radius: 50%;
        animation: sp-anime 0.8s infinite linear;
    }

    @keyframes sp-anime {
        100% {
            transform: rotate(390deg);
        }
    }

    .is-hide {
        display: none;
    }
</style>

<style>
    /* @media (min-width: 950px) {
        .modal {
            --bs-modal-width: 950px;
        }
    }

    @media (min-width: 1500px) {
        .modal-xls {
            --bs-modal-width: 1500px;
        }
    }

    @media (min-width: 1500px) {
        .container-fluids {
            width: 1500px;
            margin-left: auto;
            margin-right: auto;
            margin-top: auto;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right
        }

        .dataTables_wrapper .dataTables_length {
            float: left
        }

        .dataTables_info {
            float: left;
        }

        .dataTables_paginate {
            float: right
        }

        .custom-tooltip {
            --bs-tooltip-bg: var(--bs-primary);
        }

        .table thead tr th {
            font-size: 14px;
        }

        .table tbody tr td {
            font-size: 13px;
        }

        .menu {
            font-size: 13px;
        }
    }

    .hrow {
        height: 2px;
        margin-bottom: 9px;
    } */
</style>
<div class="tabs-animation">
    <div id="preloader">
        <div id="status">
            <div class="spinner">
            </div>
        </div>
    </div>
        <div class="row ">
            <div class="col-md-12">
                <div class="card shadow"> 
                    <div class="card-header ">
                        <label for="">ข้อมูลบุคลากร</label> 
                        <div class="btn-actions-pane-right">
                            <a href="{{ url('person/person_index_add') }}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info"  >
                                <i class="fa-solid fa-folder-plus text-info me-2"></i>
                                เพิ่มข้อมูลบุคลากร
                                </a> 
                        </div>
                        {{-- <div class="d-flex">
                            <div class="">
                                <label for="">ข้อมูลบุคลากร</label> 
                             </div> 
                                <div class="ms-auto">
                                    <a href="{{ url('person/person_index_add') }}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary"  >
                                    <i class="fa-solid fa-folder-plus text-white me-2"></i>
                                    เพิ่มข้อมูลบุคลากร
                                    </a> 
                                    
                                </div>
                        </div>           --}}
                </div>
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                id="example">  --}}
                                <table id="example" class="table table-striped table-bordered dt-responsive nowrap table-sm"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                            <td class="p-2" width="13%">{{ $mem->prefix_name }}{{ $mem->fname }} {{ $mem->lname }}</td>
                                            <td class="p-2" width="15%">{{ $mem->POSITION_NAME }}</td>
                                            <td class="p-2" width="20%">{{$mem->DEPARTMENT_NAME}}</td>
                                            <td class="p-2">{{$mem->DEPARTMENT_SUB_NAME}}</td>
                                            <td class="p-2">{{$mem->DEPARTMENT_SUB_SUB_NAME}}</td>  

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
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        ทำรายการ
                                                       
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item text-warning" href="{{ url('person/person_index_edit/' .$mem->id) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square me-2"></i>
                                                            <label for="" style="color: rgb(252, 185, 0);font-size:13px">แก้ไข</label>
                                                        </a>

                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="person_destroy({{ $mem->id }})" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="custom-tooltip" title="ลบ">
                                                            <i class="fa-solid fa-trash-can me-2 mb-1"></i>
                                                            <label for="" style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- Header -->
                                                {{-- <div class="btn-group"> 
                                                    <button type="button" class="btn btn-info waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="mdi mdi-chevron-left"></i> ทำรายการ
                                                    </button>
                                                    <div class="dropdown-menu">  
                                                        <a class="dropdown-item" href="{{ url('person/person_index_edit/' .$mem->id) }}">
                                                            <i class="fa-solid fa-pen-to-square me-2 mt-2 ms-2 text-warning"></i>
                                                            <label for="" class="text-warning">แก้ไข</label>
                                                        </a>
                                                        
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="person_destroy({{ $mem->id }})">
                                                            <i class="fa-solid fa-trash-can me-2 mt-2 ms-2 mb-2 text-danger"></i>
                                                            <label for="" class="text-danger">ลบ</label>
                                                        </a>
                                                    </div>
                                                </div> --}}


                                                {{-- <div class="dropdown">
                                                    <button class="dropdown-toggle btn btn-sm text-secondary" href="#" id="dropdownMenuLink" data-mdb-toggle="dropdown" aria-expanded="false" >
                                                      ทำรายการ
                                                    </button>                                      
                                                        <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
                                                          
                                                              <li>
                                                                <a href="{{ url('person/person_index_edit/' .$mem->id) }}" class="text-warning me-3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="แก้ไข" >
                                                                  <i class="fa-solid fa-pen-to-square me-2 mt-3 ms-4"></i>
                                                                  <label for="" style="color: black">แก้ไข</label>
                                                                </a>  
                                                              </li>
                                                              <li>
                                                                <a class="text-danger" href="javascript:void(0)" onclick="person_destroy({{ $mem->id }})">
                                                                  <i class="fa-solid fa-trash-can me-2 mt-3 ms-4 mb-4"></i>
                                                                  <label for="" style="color: black">ลบ</label>
                                                                </a> 
                                                              </li>
                                                        </ul>
                                                </div> --}}
                                                <!--    <a href="{{ url('person/person_index_edit/' . $mem->id) }}"
                                                    class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    data-bs-custom-class="custom-tooltip" title="แก้ไข" >
                                                    <i class="fa-solid fa-pen-to-square me-2"></i>
                                                </a>
                                              <button type="button" class="btn rounded-pill text-info edit_type" 
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                data-bs-custom-class="custom-tooltip" 
                                                title="กำหนดสิทธิ์การเข้าถึง"                                  
                                                value="{{$mem->id}}">
                                                  <i class="fa-solid fa-layer-group"></i>
                                                </button> 
                                                <a class="text-danger" href="javascript:void(0)"
                                                    onclick="person_destroy({{ $mem->id }})" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                    title="ลบ">
                                                    <i class="fa-solid fa-trash-can me-2"></i>
                                                </a>-->
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
