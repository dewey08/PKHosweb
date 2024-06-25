@extends('layouts.medicalslide')
@section('title', 'PK-OFFICER || เครื่องมือแพทย์')
 
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
        function addmedical(input) {
            var fileInput = document.getElementById('img');
            var url = input.value;
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#add_upload_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                fileInput.value = '';
                return false;
            }
        }
        function med_condestroy(medical_typecat_id) {
            
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
                            url: "{{ url('med_condestroy') }}" + '/' + medical_typecat_id,
                            type: 'DELETE',
                            data: {
                                _token: $("input[name=_token]").val()
                            },
                            success: function(data) {
                                if (data.status == 200 ) {
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
                                            $("#sid" + medical_typecat_id).remove();
                                            window.location.reload(); 
                                            // window.location = "{{ url('article/article_index') }}";
                                        }
                                    })
                                } else {
                                   
                                }
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
                   border: 5px #ddd solid;
                   border-top: 10px #12c6fd solid;
                   border-radius: 50%;
                   animation: sp-anime 0.8s infinite linear;
                   }
                   @keyframes sp-anime {
                   100% { 
                       transform: rotate(360deg); 
                   }
                   }
                   .is-hide{
                   display:none;
                   }
        </style>
       <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    
                </div>
            </div>
        </div>
          
                 
        <form class="custom-validation" action="{{ route('med.med_con_update') }}" method="POST"
        id="update_type" enctype="multipart/form-data">
        @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4 class="card-title">Detail Medical</h4>
                                    <p class="card-title-desc">รายละเอียดเครื่องมือแพทย์</p>
                                </div>
                                <div class="col"></div>
                                <div class="col-md-2 text-end">
                                    {{-- <button class="btn btn-secondary" id="Changbillitems"><i class="fa-solid fa-wand-magic-sparkles me-3"></i>ปรับ bilitems</button>  --}}     
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center shadow-lg"> 
                            <div class="row "> 
                                <div class="col-md-4">
                                    <div class="row "> 
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {{-- <img src="{{ asset('assets/images/default-image.jpg') }}" id="add_upload_preview"
                                                    alt="Image" class="img-thumbnail" width="450px" height="350px"> --}}
                                                    @if ( $dataedits->img == Null )
                                                    <img src="{{asset('assets/images/default-image.jpg')}}" height="450px" width="350px" alt="Image" class="img-thumbnail" id="add_upload_preview">
                                                    @else
                                                    <img src="{{asset('storage/article/'.$dataedits->img)}}" height="450px" width="350px" alt="Image" class="img-thumbnail" id="add_upload_preview">                                 
                                                    @endif 
                                                <br>
                                                <div class="input-group mb-3">
                                                    <label class="input-group-text" for="img">Upload</label>
                                                    <input type="file" class="form-control" id="img" name="img"
                                                        onchange="addmedical(this)">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                </div>
                                            </div>
                                        </div>
                                        <input id="medical_typecat_id" type="hidden" class="form-control form-control-sm" name="medical_typecat_id" value="{{$dataedits->medical_typecat_id}}">
                                        
                                        <div class="col-md-5 text-end">
                                            <label for="medical_typecatname">คลัง </label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <input id="medical_typecatname" type="text" class="form-control form-control-sm" name="medical_typecatname" value="{{$dataedits->medical_typecatname}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3"> 
                                        <div class="col-md-12 text-end">
                                            <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                                แก้ไขข้อมูล
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    {{-- <div class="row mt-3">                                        
                                    </div> --}}
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>ลำดับ</th>
                                                    <th>รูปภาพ</th>
                                                    <th>ประเภทเครื่องมือ</th>
                                                    <th>จัดการ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($medical_typecat as $item) 
                                                    <tr style="font-size: 12px;" id="sid{{$item->medical_typecat_id }}">  
                                                    <td width="5%">{{ $i++ }}</td>
                                                    <td>
                                                        @if ( $item->img == Null )
                                                        <img src="{{asset('assets/images/default-image.jpg')}}" height="50px" width="50px" alt="Image" class="img-thumbnail">
                                                        @else
                                                        <img src="{{asset('storage/article/'.$item->img)}}" height="50px" width="50px" alt="Image" class="img-thumbnail">                                 
                                                        @endif 
                                                    </td>
                                                    <td class="text-start">{{ $item->medical_typecatname }}</td>
                                                    <td width="10%">
                                                        <div class="btn-group">
                                                            <button type="button"
                                                                class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                ทำรายการ 
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item text-warning"
                                                                    href="{{ url('medical/med_con_edit/'.$item->medical_typecat_id)}}"
                                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                                    data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                                    <i class="fa-solid fa-pen-to-square me-2"></i>
                                                                    <label for=""
                                                                        style="color: rgb(252, 185, 0);font-size:13px">แก้ไข</label>
                                                                </a>
        
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                                    onclick="med_condestroy({{ $item->medical_typecat_id }})"
                                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                                    data-bs-custom-class="custom-tooltip" title="ลบ">
                                                                    <i class="fa-solid fa-trash-can me-2 mb-1"></i>
                                                                    <label for=""
                                                                        style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
                                                                </a>
                                                            </div>
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
                        <div class="card-footer">
                            <div class="col-md-12 text-end">
                               
                            </div>
                        </div>
                       
                    </div>
               
        </form>    
                
            </div>
        </div>
        
@endsection
@section('footer')
<script>
    $(document).ready(function() {
        $('#example').DataTable();
        $('#example2').DataTable();
        $('#p4p_work_month').select2({
            placeholder:"--เลือก--",
            allowClear:true
        });
        $('#update_type').on('submit',function(e){
                  e.preventDefault();
              
                  var form = this;
                    //   alert('OJJJJOL');
                  $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){
                      $(form).find('span.error-text').text('');
                    },
                    success:function(data){
                      if (data.status == 0 ) {
                        
                      } else {          
                        Swal.fire({
                          title: 'แก้ไขข้อมูลสำเร็จ',
                          text: "You Update data success",
                          icon: 'success',
                          showCancelButton: false,
                          confirmButtonColor: '#06D177',
                          // cancelButtonColor: '#d33',
                          confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                          if (result.isConfirmed) {         
                            // window.location.reload(); 
                            // medical/med_index
                            window.location="{{url('medical/med_con')}}"; 
                          }
                        })      
                      }
                    }
                  });
            });

            // $('#Savebtn').click(function() {
            //         var medical_typecatname = $('#medical_typecatname').val();  
            //         $.ajax({
            //             url: "{{ route('med.med_consave') }}",
            //             type: "POST",
            //             dataType: 'json',
            //             data: {
            //                 medical_typecatname 
            //             },
            //             success: function(data) {
            //                 if (data.status == 200) {
            //                     Swal.fire({
            //                         title: 'บันทึกข้อมูลสำเร็จ',
            //                         text: "You Insert data success",
            //                         icon: 'success',
            //                         showCancelButton: false,
            //                         confirmButtonColor: '#06D177',
            //                         confirmButtonText: 'เรียบร้อย'
            //                     }).then((result) => {
            //                         if (result
            //                             .isConfirmed) {
            //                             console.log(
            //                                 data);
            //                             window.location.reload();
            //                             // window.location="{{url('warehouse/warehouse_index')}}";
            //                         }
            //                     })
            //                 } else {
            //                     Swal.fire({
            //                         title: 'ข้อมูลมีแล้ว',
            //                         text: "You Have data ",
            //                         icon: 'success',
            //                         showCancelButton: false,
            //                         confirmButtonColor: '#06D177',
            //                         confirmButtonText: 'เรียบร้อย'
            //                     }).then((result) => {
            //                         if (result
            //                             .isConfirmed) {
            //                             console.log(
            //                                 data);
            //                             window.location.reload();
            //                             // window.location="{{url('warehouse/warehouse_index')}}";
            //                         }
            //                     })

            //                 }

            //             },
            //         });
            // });
    });
    
</script>

@endsection