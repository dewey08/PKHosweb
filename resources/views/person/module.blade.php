@extends('layouts.backend_admin')    
    <link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('select2/select2.min.css') }}" rel="stylesheet" />
<style>
        body {
        font-family: 'Kanit', sans-serif;
        font-size: 14px;
        
        }
        .form-control {
        font-family: 'Kanit', sans-serif;
        font-size: 14px;
        }
        .center {
        margin: auto;
        width: 100%;
        padding: 10px;
        }
</style>
     
@section('content')


        <div class="bg-body-light">
                    <div class="content content-full">
                        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">                            
                            <h1 style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.5rem;font-weight:normal;"> เพิ่มข้อมูล Module</h1>
                            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <form  method="post" action="{{ route('mo.module_save') }}"  enctype="multipart/form-data"  class="needs-validation" novalidate>
            
                        @csrf
                        <div class="content">
                <div class="block block-rounded block-bordered">
               
                <div class="block-header block-header-default ">
                                <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>Module</B></h3>
                    </div>
                <div class="block-content"> 
                <div class="row push">
                        <div class="col-lg-6">
                                <div class="form-group">
                                        <label style=" font-family: 'Kanit', sans-serif;">Picture Module</label>                                  
                                        <img id="image_upload_preview" src="{{asset('image/pers.png')}}" alt="กรุณาเพิ่มรูปภาพ" height="200px" width="200px"/>
                                </div>
                                <div class="form-group">
                                        <input style="font-family: 'Kanit', sans-serif;" type="file" name="picture" id="picture" class="form-control">
                                </div>  
                        </div>
                        <div class="col-lg-6"> 
                                <div class="form-group">
                                        <div class="col-lg-3"> 
                                                <label >Name </label>
                                        </div>
                                        <div class="col-lg-9">
                                                <input  name = "name"  id="name" class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;">
                                                
                                        </div>
                                </div>    
                        </div>                             
                </div>           
                <div align="right">       
                        <button type="submit"  class="btn btn-hero-sm btn-hero-info" ><i class="fas fa-save"></i> &nbsp; บันทึกข้อมูล</button>
                        &nbsp;&nbsp;<a href="{{ url('person/all')}}"  class="btn btn-hero-sm btn-hero-warning" > <i class="fas fa-window-close"></i> &nbsp;ยกเลิก</a><br><br>   
                </div>
        </form>
</div>   
                                                    
</div>  
@endsection


@section('footer')

<script src="{{ asset('select2/select2.min.js') }}"></script>

<script src="{{ asset('datepicker/bootstrap-3.3.7-dist/js/bootstrap.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker-custom.js') }}"></script>
<script src="{{ asset('datepicker/dist/locales/bootstrap-datepicker.th.min.js') }}" charset="UTF-8"></script>

<script>
                        
function readURL(input) {
        var fileInput = document.getElementById('picture');
        var url = input.value;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase(); 
                if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                var reader = new FileReader();            
                reader.onload = function (e) {
                        $('#image_upload_preview').attr('src', e.target.result);
                }            
                reader.readAsDataURL(input.files[0]);
                }else{        
                alert('กรุณาอัปโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                fileInput.value = '';
                return false;       
                }
        }            
        $("#picture").change(function () {
                readURL(this);
        });
</script>
