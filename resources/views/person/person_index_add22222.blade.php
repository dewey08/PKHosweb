@extends('layouts.person')

@section('title','ZOFFice || บุคลากร')
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
<div class="container-fluid" >
    <div class="row ">
        <div class="col-md-7">
            <div class="card">
               
                 <div class="px-3 py-2 border-bottom">
                  <div class="container d-flex flex-wrap justify-content-center">                                        
                      <a type="button" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light text-dark me-2">   {{ __('ข้อมูลบุคลากร') }}</a>  
      
                      <div class="text-end">                    
                      <a href="{{url('person/person_index_add')}}" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i></a>
                    </div>
                  </div>
                </div>
          
                <div class="card-body shadow">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                  
                        <div class="table-responsive">
                          <table class="table table-striped table-borderless" style="width: 100%;">
                            <thead>
                              <tr>
                                 <th width="7%">No</th>
                                 <th>Name-Lastname</th>
                                 <th>Phone</th>
                                 <th>username</th>
                                 <th width="10%">Status</th>
                                 <th width="18%">Manage</th>
                              </tr>  
                            </thead>
                            <tbody>
                              <?php $i = 1; 
         
                               $date =  date('Y');
                              
                              ?>      
                               @foreach ( $users as $mem ) 
                               <tr id="sid{{$mem->id}}">
                                   <td>{{$i++}}</td>  
                                   <td>  {{$mem->fname}} {{$mem->lname}}</td>                          
                                   <td class="font-weight-bold">{{$mem->tel}}</td>
                                   <td>{{$mem->username}}</td>
                                   
                                   @if ($mem->type == 'ADMIN')
                                     <td class="font-weight-medium"><div class="badge bg-danger">{{$mem->type}}</div></td>
                                   @elseif ($mem->type == 'STAFF')
                                     <td class="font-weight-medium"><div class="badge bg-success">{{$mem->type}}</div></td>
                                     @elseif ($mem->type == 'CUSTOMER')
                                     <td class="font-weight-medium"><div class="badge bg-info">{{$mem->type}}</div></td>
                                   @else
                                     <td class="font-weight-medium"><div class="badge bg-warning">{{$mem->type}}</div></td>
                                   @endif
                                   <td>   
                                
                                     <a class="btn btn-warning" value="{{$mem->id}}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                     </a>                                 
                                      <a class="btn btn-danger" >
                                        <i class="fa-solid fa-trash-can"></i>
                                     </a>

                                     <a href="{{url('person/person_index_addsub/'.$mem->id)}}" class="btn btn-primary" >
                                        <i class="fa-solid fa-person-circle-plus"></i>
                                     </a>
         
                                   </td>
                                 </tr> 
                                                                  
                                @endforeach
                                                
                            </tbody>
                          </table>

                          <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                              <li class="page-item disabled">
                                <a class="page-link">Previous</a>
                              </li>
                              <li class="page-item"><a class="page-link" href="#">1</a></li>
                              <li class="page-item"><a class="page-link" href="#">2</a></li>
                              <li class="page-item"><a class="page-link" href="#">3</a></li>
                              <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                              </li>
                            </ul>
                          </nav>


                        </div>         
                  
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="px-3 py-2 border-bottom">
                    <div class="container d-flex flex-wrap justify-content-center">                                        
                        <a type="button" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light text-dark me-2">   {{ __('เพิ่มข้อมูลบุคลากร') }}</a>  
        
                        <div class="text-end">                    
                       
                      </div>
                    </div>
                  </div>

                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" required autocomplete="name" autofocus placeholder="ชื่อ">

                            @error('fname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}" required autocomplete="name" autofocus placeholder="นามสกุล">

                            @error('lname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div> 
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="อีเมล์">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input id="tel" type="text" class="form-control @error('tel') is-invalid @enderror" name="tel" value="{{ old('tel') }}" required autocomplete="tel" autofocus placeholder="เบอร์โทร">
                        </div>
                    </div>
                </div> 
                <div class="row mt-3">
                    <div class="form-group">
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Username">

                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                        </div>
                    </div>
                </div>      
                    <div class="form-group mt-3">             
                        <button type="submit" class="btn btn-primary " >
                            <i class="fa-solid fa-floppy-disk me-3"></i>บันทึกข้อมูล
                        </button>                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
