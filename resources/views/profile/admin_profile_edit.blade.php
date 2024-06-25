@extends('layouts.admindashboard')

@section('title', 'PK-OFFICER || Profile')


@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function addpre() {
            var prenew = document.getElementById("PRE_INSERT").value;
            // alert(prenew);
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ url('person/addpre') }}",
                method: "GET",
                data: {
                    prenew: prenew,
                    _token: _token
                },
                success: function(result) {
                    $('.show_pre').html(result);
                }
            })
        }

        function editpic(input) {
        var fileInput = document.getElementById('img');
        var url = input.value;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#edit_upload_preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
            fileInput.value = '';
            return false;
        }
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
<br>
    <div class="container mt-3">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        {{-- <div class="d-flex">
                            <div class=""> --}}
                        <label for="">แก้ไขข้อมูลบุคลากร</label>
                        {{-- </div> --}}
                        {{-- <div class="ms-auto">

                            </div> --}}
                        {{-- </div> --}}
                    </div>
                    <div class="card-body">
                       
                        <div id="progrss-wizard" class="twitter-bs-wizard">
                            <ul class="twitter-bs-wizard-nav nav-justified">
                                <li class="nav-item">
                                    <a href="#progress-seller-details" class="nav-link" data-toggle="tab">
                                        <span class="step-number">01</span>
                                        <span class="step-title ">ข้อมูลส่วนตัว</span>
                                    </a>
                                </li>
                              

                                <li class="nav-item">
                                    <a href="#progress-bank-detail" class="nav-link" data-toggle="tab">
                                        <span class="step-number">03</span>
                                        <span class="step-title">รูปภาพ</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#progress-confirm-detail" class="nav-link" data-toggle="tab">
                                        <span class="step-number">04</span>
                                        <span class="step-title">Confirm Detail</span>
                                    </a>
                                </li>

                            </ul>

                            <div id="bar" class="progress mt-4">
                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"></div>
                            </div>
                            <div class="tab-content twitter-bs-wizard-tab-content">
                                <div class="tab-pane" id="progress-seller-details">

                                    <form action="{{ route('user.profile_update') }}" method="POST" id="update_profileForm"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input id="id" type="hidden" class="form-control" name="id"
                                        value="{{ $dataedits->id }}">

                                        <div class="row">
                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <label class="form-label" for="pname">คำนำหน้า :</label>
                                                    <select id="pname" name="pname"
                                                        class="form-control select2 show_pre" style="width: 100%">
                                                        <option value=""></option>
                                                        @foreach ($users_prefix as $pre)
                                                        @if ($dataedits->pname == $pre->prefix_id)
                                                            <option value="{{ $pre->prefix_id }}" selected>
                                                                {{ $pre->prefix_name }} </option>
                                                        @else
                                                            <option value="{{ $pre->prefix_id }}">{{ $pre->prefix_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="fname" style="color: red">ชื่อ :</label>
                                                    <input type="text" class="form-control form-control-sm" id="fullname" name="fullname" value="{{$dataedits->fname }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="lname" style="color: red">นามสกุล :</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="lname" name="lname" value="{{ $dataedits->lname }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="cid" >บัตรประชาชน</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="cid" name="cid" value="{{ $dataedits->cid }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="username"  style="color: red">ชื่อผู้ใช้งาน</label>
                                                    <input type="text" class="form-control form-control-sm" id="username" name="username" value="{{ $dataedits->username }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="password"  style="color: red">Password</label>
                                                    <input type="password" class="form-control form-control-sm" id="password" name="password" required>
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="line_token">Line Token</label>
                                                    <textarea id="line_token" name="line_token" class="form-control" rows="2">{{ $dataedits->line_token }}</textarea>
                                                </div>
                                            </div>
                                        </div>


                                </div>
                                
                                <div class="tab-pane" id="progress-bank-detail">
                                    <div>

                                        @if ($dataedits->img == null)
                                            <img src="{{ asset('assets/images/default-image.jpg') }}"
                                                id="edit_upload_preview" height="300px" width="300px" alt="Image"
                                                class="img-thumbnail">
                                        @else
                                            <img src="{{ asset('storage/person/' . $dataedits->img) }}"
                                                id="edit_upload_preview" height="300px" width="300px" alt="Image"
                                                class="img-thumbnail">
                                        @endif
                                        <br>
                                        <div class="input-group mb-3 mt-3">

                                            <input type="file" class="form-control" id="img" name="img"
                                            onchange="editpic(this)">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </div>


                                    </div>
                                </div>
                                <div class="tab-pane" id="progress-confirm-detail">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-6">
                                            <div class="text-center">
                                                <div class="mb-4">
                                                    <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                                                </div>
                                                <div>
                                                    <h5>Confirm Detail</h5> 
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        <i class="fa-solid fa-floppy-disk me-2"></i>
                                                        แก้ไขข้อมูล
                                                    </button>
                                                    <a href="{{ url('person/person_index') }}"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="fa-solid fa-xmark me-2"></i>
                                                        ยกเลิก
                                                    </a>
                                                    <p class="text-muted">ยืนยันการแก้ไขข้อมูลบุคลากร</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <ul class="pager wizard twitter-bs-wizard-pager-link">
                                <li class="previous"><a href="javascript: void(0);">Previous</a></li>
                                <li class="next"><a href="javascript: void(0);">Next</a></li>
                            </ul>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>



@endsection
@section('footer')
    <script>
        $(document).ready(function() {
            
            $('#pname').select2({
                placeholder:"--เลือก--",
                allowClear:true
            });
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            

        });

        $(document).ready(function(){
              $('#update_profileForm').on('submit',function(e){
                    e.preventDefault();
                      //   alert('Person');
                    var form = this;
                  
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
                      Swal.fire({
                        icon: 'error',
                        title: 'Username...!!',
                        text: 'Username นี้ได้ถูกใช้ไปแล้ว!',
                      }).then((result) => {
                        if (result.isConfirmed) {                  
                        
                        }
                      })   
                    } else {                         
                      Swal.fire({
                        title: 'แก้ไขข้อมูลสำเร็จ',
                        text: "You Edit data success",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#06D177', 
                        confirmButtonText: 'เรียบร้อย'
                      }).then((result) => {
                        if (result.isConfirmed) {                  
                        //   window.location="{{route('person.person_index')}}"; //
                          window.location
                                            .reload();
                        }
                      })      
                    }
                      }
                    });
              }); 
        });
    </script>

@endsection
