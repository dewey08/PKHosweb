@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || Document')
   

@section('content')
   
    <?php  
        $ynow = date('Y')+543;
        $yb =  date('Y')+542;
        $mo =  date('m');
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
               border: 10px #ddd solid;
               border-top: 10px rgb(212, 106, 124) solid;
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
    <?php
        use App\Http\Controllers\StaticController;
        use Illuminate\Support\Facades\DB;   
        $count_meettingroom = StaticController::count_meettingroom();
    ?>
    <script>
        function document_destroy(document_id) {
            Swal.fire({
                position: "top-end",
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
                        url: "{{ url('document_destroy') }}" + '/' + document_id,
                        type: 'POST',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            if (response.status == 200 ) {
                                Swal.fire({
                                    position: "top-end",
                                    title: 'ลบข้อมูล!',
                                    text: "You Delet data success",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#06D177',
                                    // cancelButtonColor: '#d33',
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $("#sid" + document_id).remove();
                                        window.location.reload();
                                        // window.location = "{{ url('air_main') }}";
                                    }
                                })
                            } else {  
                            }
                        }
                    })
                }
            })
        }
        function addimg(input) {
            var fileInput = document.getElementById('img');
            var url = input.value;
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg" || ext == "pdf")) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#add_upload_preview').attr('src', e.target.result);  
                }
                reader.readAsDataURL(input.files[0]);  
            } else {
                alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif/.pdf .');
                fileInput.value = '';
                return false;
            }
        }
    </script>
  
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title app-page-title-simple">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div>
                                    <div class="page-title-head center-elem">
                                        <span class="d-inline-block pe-2">
                                            <i class="fa-solid fa-book-open-reader opacity-4" style="color:rgb(228, 8, 129)"></i> 
                                        </span>
                                        <span class="d-inline-block">Register Document</span>
                                    </div>
                                    <div class="page-title-subheading opacity-10">
                                        <nav class="" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item">
                                                    <a>
                                                        <i aria-hidden="true" class="fa fa-home opacity-4" style="color:rgb(252, 52, 162)"></i>
                                                    </a>
                                                </li>
                                                <li class="breadcrumb-item">
                                                    <a>ทะเบียน</a>
                                                </li>
                                                <li class="active breadcrumb-item" aria-current="page">
                                                    เอกสารต่างๆ
                                                </li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <div class="page-title-actions">  
                                <button type="button" class="ladda-button btn-pill btn btn-primary" data-bs-toggle="modal" target="_blank" data-bs-target="#exampleModal">
                                    <i class="fa-solid fa-circle-check text-white me-2"></i>
                                    เก็บเอกสาร
                                </button>
                            </div>
                        </div>
                    </div>
        
            <div class="row"> 
                <div class="col-xl-4">
                    <div class="card cardclaim p-2">   
                        <div class="table-responsive me-2 ms-2 mb-2"> 
                            <table id="example" class="table table-hover table-sm dt-responsive nowrap" style=" border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr style="font-size: 13px"> 
                                        <th width="5%" class="text-center">ลำดับ</th>  
                                        <th class="text-start">ชื่อ</th> 
                                        <th class="text-center" width="10%">กองทุน</th> 
                                        <th class="text-center" width="10%">แก้ไข</th>
                                        {{-- <th class="text-center" width="10%">ลบ</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow as $item) 
                                        <tr style="font-size: 13px" id="sid{{$item->document_id}}">                                                   
                                            <td class="text-center" width="5%">{{ $i++ }}</td>   
                                            <td class="p-2">
                                                <a href="{{url('documentsub/'.$item->document_id)}}"> {{ $item->document_name }}</a> 
                                            </td> 
                                            <td class="text-center" width="10%">{{ $item->hip_code }}</td>  
                                            <td class="text-center" width="10%"> 
                                                <button type="button" class="ladda-button btn-pill btn btn-white" data-bs-toggle="modal" target="_blank" data-bs-target="#editModal{{$item->document_id}}"> 
                                                    <i class="fa-solid fa-pen-to-square me-2 text-warning" style="font-size:13px"></i> 
                                                </button>
                                            </td>
                                            {{-- <td class="text-center" width="10%">
                                                <a class="text-danger" href="javascript:void(0)" onclick="document_destroy({{ $item->document_id }})"
                                                    data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" title="ลบ">
                                                    <i class="fa-solid fa-trash-can"></i> 
                                                </a>
                                            </td>  --}}
                                        </tr>

                                        <div class="modal fade" id="editModal{{$item->document_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
                                            <div class="modal-dialog">
                                                <div class="modal-content"> 
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{ route('d.document_update') }}" id="update_Form" enctype="multipart/form-data">
                                                                @csrf
                                                                <br>
                                                                <input type="hidden" name="document_id" id="document_id" value="{{$item->document_id}}">
                                                                    <div class="container"> 
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group"> 
                                                                                    @if ( $item->img == Null )
                                                                                    <img src="{{asset('assets/images/defailt_img.jpg')}}" id="add_upload_preview" width="450px" height="380px" alt="Image" class="img-thumbnail"> 
                                                                                    @else
                                                                                            @if ($item->img_file == 'pdf')
                                                                                                <iframe src="{{ asset('storage/instrument/PTTinst_sss_todtan.pdf' ) }}" height="200px" width="100%"></iframe>
                                                                                            @else
                                                                                                <img src="{{asset('storage/document/'.$item->img)}}" id="add_upload_preview" width="450px" height="380px" alt="Image" class="img-thumbnail"> 
                                                                                            @endif
                                                                                                                   
                                                                                    @endif
                                                                                    <br>
                                                                                    <div class="input-group mt-3"> 
                                                                                        <input type="file" class="form-control" id="img" name="img" onchange="addimg(this)">
                                                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mt-4">
                                                                            <div class="col"></div>
                                                                            <div class="col-md-2 text-end">ชื่อ</div>
                                                                            <div class="col-md-9"> 
                                                                                <input type="text" class="form-control" name="document_name" id="document_name" value="{{$item->document_name}}">   
                                                                            </div> 
                                                                            <div class="col"></div>
                                                                        </div>
                                                                        <div class="row mt-3">
                                                                            <div class="col"></div>
                                                                            <div class="col-md-2 text-end">กองทุน</div>
                                                                            <div class="col-md-9"> 
                                                                                <input type="text" class="form-control" name="hip_code" id="hip_code" value="{{$item->hip_code}}">   
                                                                            </div> 
                                                                            <div class="col"></div>
                                                                        </div>
                                                                        <div class="row mt-3">
                                                                            <div class="col"></div> 
                                                                            <div class="col-md-3 text-end"></div>
                                                                            <div class="col-md-6"> 
                                                                                    <button type="submit" class="ladda-button btn-pill btn btn-info">
                                                                                        <i class="fa-solid fa-floppy-disk me-2"></i>
                                                                                        แก้ไขข้อมูล
                                                                                    </button> 
                                                                            </div> 
                                                                            <div class="col"></div>
                                                                        </div> 
                                                                    </div>   
                                                                    <br>  
                                                                
                                                                    </form>    
                                    
                                                        </div>         
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> 
                       
                    </div> 
                </div>  
                <div class="col-xl-8">
                    <div class="card cardclaim p-4">  
                            <iframe src="{{ asset('storage/document/'.$data_file) }}" height="700px" width="100%"></iframe> 
                    </div> 
                </div>   
            </div>
 
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
            <div class="modal-dialog">
            <div class="modal-content"> 
                    <div class="modal-body">
                        <form method="POST" action="{{ route('d.document_save') }}" id="insert_Form" enctype="multipart/form-data">
                            @csrf
                            <br>
                            
                                <div class="container"> 
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <img src="{{ asset('assets/images/default-image.jpg') }}" id="add_upload_preview"
                                                    alt="Image" class="img-thumbnail" width="450px" height="380px">
                                                <br>
                                                <div class="input-group mt-3"> 
                                                    <input type="file" class="form-control" id="img" name="img" onchange="addimg(this)">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col"></div>
                                        <div class="col-md-2 text-end">ชื่อ</div>
                                        <div class="col-md-6"> 
                                            <input type="text" class="form-control" name="document_name" id="document_name" required>   
                                        </div> 
                                        <div class="col"></div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col"></div>
                                        <div class="col-md-2 text-end">กองทุน</div>
                                        <div class="col-md-6"> 
                                            <input type="text" class="form-control" name="hip_code" id="hip_code">   
                                        </div> 
                                        <div class="col"></div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col"></div> 
                                        <div class="col-md-3 text-end"></div>
                                        <div class="col-md-6"> 
                                                <button type="submit" class="ladda-button btn-pill btn btn-info">
                                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                                    บันทึกข้อมูล
                                                </button> 
                                        </div> 
                                        <div class="col"></div>
                                    </div> 
                                </div>   
                                <br>  
                             
                                </form>    

                    </div>         
            </div>
        </div>
    </div>
  

    @endsection
    @section('footer')
    
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#insert_Form').on('submit',function(e){
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
                          position: "top-end",
                          title: 'บันทึกข้อมูลสำเร็จ',
                          text: "You Insert data success",
                          icon: 'success',
                          showCancelButton: false,
                          confirmButtonColor: '#06D177',
                          // cancelButtonColor: '#d33',
                          confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                          if (result.isConfirmed) {         
                            window.location.reload();  
                            // window.location="{{url('air_main')}}"; 
                          }
                        })      
                      }
                    }
                  });
            });

            $('#update_Form').on('submit',function(e){
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
                          position: "top-end",
                          title: 'แก้ไขข้อมูลสำเร็จ',
                          text: "You Update data success",
                          icon: 'success',
                          showCancelButton: false,
                          confirmButtonColor: '#06D177',
                          // cancelButtonColor: '#d33',
                          confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                          if (result.isConfirmed) {         
                            window.location.reload();  
                            // window.location="{{url('air_main')}}"; 
                          }
                        })      
                      }
                    }
                  });
            });
 
              
        });
    </script>
    @endsection
