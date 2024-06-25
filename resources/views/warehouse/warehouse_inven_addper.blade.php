@extends('layouts.warehouse_new')
@section('title', 'PK-OFFICER || คลังวัสดุ')
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
    function warehouse_inven_addper_destroy(warehouse_inven_person_id)
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
          url:"{{url('warehouse/warehouse_inven_addper_destroy')}}" +'/'+ warehouse_inven_person_id, 
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
                  $("#sid"+warehouse_inven_person_id).remove();     
                  window.location.reload(); 
                //   window.location = "{{url('supplies/supplies_index')}}"; //     
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

@section('content')
<style>
    #button{
           display:block;
           margin:20px auto;
           padding:30px 30px;
           background-color:#eee;
           border:solid #ccc 1px;
           cursor: pointer;
           }
           #overlay{	
           position: fixed;
           top: 0;
           z-index: 100;
           width: 100%;
           height:100%;
           display: none;
           background: rgba(0,0,0,0.6);
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
           border-top: 10px #1fdab1 solid;
           border-radius: 50%;
           animation: sp-anime 0.8s infinite linear;
           }
           @keyframes sp-anime {
           100% { 
               transform: rotate(390deg); 
           }
           }
           .is-hide{
           display:none;
           }
</style>

<div class="tabs-animation">
        <div class="row text-center">  
            <div id="overlay">
                <div class="cv-spinner">
                  <span class="spinner"></span>
                </div>
              </div>
              
        </div> 
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        ผู้ดูแลคลังวัสดุ
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group">

                                <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info"
                                    data-bs-toggle="modal" data-bs-target="#invenModal">
                                    <i class="pe-7s-shuffle btn-icon-wrapper"></i>เพิ่มผู้ดูแลคลังวัสดุ
                                </button>
                            </div>
                        </div>
                    </div>
                     

                    <div class="card-body shadow-lg">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered myTable" style="width: 100%;"
                                id="example">
                                <thead>
                                    <tr height="10px">
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">ชื่อผู้ดูแลคลังวัสดุ</th>
                                        <th width="10%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($warehouse_inven_person as $key => $item)
                                        <tr id="sid{{ $item->warehouse_inven_person_id }}">
                                            <td class="text-center" width="5%">{{ $key + 1 }}</td>
                                            <td class="p-2">{{ $item->warehouse_inven_person_username }}</td>
                                            </td>
                                            <td class="text-center" width="10%">
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-info dropdown-toggle menu btn-sm"
                                                        type="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">ทำรายการ</button>
                                                    <ul class="dropdown-menu">
                                                        <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="warehouse_inven_addper_destroy({{ $item->warehouse_inven_person_id }})">
                                                            <i class="fa-solid fa-trash-can me-2 mb-1"></i>
                                                            <label for="" style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
                                                        </a>
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
    <!--  Modal content for the above example -->
    {{-- <div class="modal fade inven" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true"> --}}
        <div class="modal fade" id="invenModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invenModalLabel">เพิ่มผู้ดูแลคลัง</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input id="warehouse_inven_id" type="hidden" class="form-control" name="warehouse_inven_id" value="{{$id}}">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">ผู้ดูแลคลัง</label>
                            <div class="form-group">
                                <select id="warehouse_inven_person_userid" name="warehouse_inven_person_userid"
                                        class="form-control " style="width: 100%">
                                        <option value="">--เลือก--</option>
                                        @foreach ($user as $ue)
                                            <option value="{{ $ue->id }}">
                                                {{ $ue->fname }}  {{ $ue->lname }}
                                            </option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="button" id="saveBtn" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                บันทึกข้อมูล
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                                    class="fa-solid fa-xmark me-2"></i>Close</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  

@endsection
@section('footer')
    <script>
        $(document).ready(function() {

            // $('select').select2();
            $('#warehouse_inven_person_userid').select2({
                dropdownParent: $('#invenModal')
            });
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#saveBtn').click(function() {

                var warehouse_inven_id = $('#warehouse_inven_id').val();
                var warehouse_inven_person_userid = $('#warehouse_inven_person_userid').val();
                // alert(warehouse_inven_name);
                $.ajax({
                    url: "{{ route('ware.warehouse_inven_addpersave') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        warehouse_inven_person_userid,
                        warehouse_inven_id
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            // alert('gggggg');
                            Swal.fire({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);

                                    window.location
                                        .reload();
                                }
                            })
                        } else {

                        }

                    },
                });
            });

        });

        $(document).on('click', '.add_user', function() {
            var warehouse_inven_id = $(this).val();
            alert(warehouse_inven_id);
            $('#inven_adduser').modal('show');
            // $.ajax({
            // type: "GET",
            // url:"{{ url('warehouse/warehouse_inven_edit') }}" +'/'+ warehouse_inven_id,  
            // success: function(data) {
            //     console.log(data.inven.warehouse_inven_person_userid);
            //     $('#warehouse_inven_person_userid').val(data.inven.warehouse_inven_person_userid)   
            //     $('#warehouse_inven_id').val(data.inven.warehouse_inven_id)                
            // },      
        });

      
    </script>
@endsection
