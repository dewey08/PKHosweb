@extends('layouts.user')
@section('title','ZOffice || เพิ่มข้อมูลการลา')


<style>
      @charset "UTF-8";
    *,
    *::before,
    *::after {
      box-sizing: border-box;
    }
      .block-content {
      transition: opacity 0.25s ease-out;
      width: 100%;
      margin: 0 auto;
      padding: 1.25rem 1.25rem 1px;
      overflow-x: visible;
    }
    .d-flex {
      display: flex !important;
    }
    .align-items-center {
      align-items: center !important;
    }
    .justify-content-center {
      justify-content: center !important;
    }

</style>
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
      <style>
        .btn{
           font-size:15px;
         }
      </style>
<div class="container-fluid">
  <div class="px-0 py-0 border-bottom mb-2">
    <div class="d-flex flex-wrap justify-content-center">  
      <a class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto text-white me-2"></a>
    
      <div class="text-end">
        <a href="{{url('user/gleave_data_dashboard/'.Auth::user()->id)}}" class="btn btn-light text-dark me-2">dashboard</a>
        <a href="{{url('user/gleave_data_add/'.Auth::user()->id)}}" class="btn btn-info text-white me-2">เพิ่มข้อมูลการลา</a>
        <a href="{{url('user/gleave_data/'.Auth::user()->id)}}" class="btn btn-light text-dark me-2">ข้อมูลการลา</a>
      </div>
    </div>
  </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">  
                <div class="card-body ">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <div class="row">
                          <div class="col-6 col-md-4 col-xl-2">
                            <a class="block block-link-shadow text-center" href="{{url('user/gleave_data_sick')}}">
                                <div class="block-content d-flex justify-content-center align-items-center bg-light">
                                    <div>
                                        <i class="far fa-3x fa-solid fa-bed-pulse text-info"></i>
                                        <div class="font-w600 mt-3">ลาป่วย</div>
                                        <br>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-xl-2">
                          <a class="block block-link-shadow text-center" href="{{url('user/gleave_data_leave')}}">
                              <div class="block-content d-flex justify-content-center align-items-center bg-light">
                                  <div>
                                      <i class="far fa-3x fa-solid fa-person-half-dress"></i>
                                      <div class="font-w600 mt-3 text-uppercase">ลากิจ</div>
                                      <br>
                                  </div>
                              </div>
                          </a>
                      </div>
                   
                      <div class="col-6 col-md-4 col-xl-2">
                          <a class="block block-link-shadow text-center" href="{{url('user/gleave_data_vacation')}}">
                              <div class="block-content d-flex justify-content-center align-items-center bg-light">
                                  <div>
                                    <i class="far fa-3x fa-solid fa-person-pregnant text-success"></i>
                                      <div class="font-w600 mt-3 text-uppercase">ลาพักผ่อน</div>
                                      <br>
                                      {{-- <div class="font-w600 mt-3 text-uppercase" style=" color: red;">*กรุณาตั้งค่าวันลา</div> --}}
                                  </div>
                              </div>
                          </a>
                      </div>
                              
                      <div class="col-6 col-md-4 col-xl-2">
                          <a class="block block-link-shadow text-center" href="{{url('user/gleave_data_study')}}">
                              <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center bg-light">
                                  <div>
                                      <i class="far fa-3x fa-solid fa-person-chalkboard text-warning"></i>
                                      <div class="font-w600 mt-3 text-uppercase">ลาศึกษา ฝึกอบรม</div>
                                      <br>
                                  </div>
                              </div>
                          </a>
                      </div>

                 
                      <div class="col-6 col-md-4 col-xl-2">
                          <a class="block block-link-shadow text-center" href="{{url('user/gleave_data_work')}}">
                              <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center bg-light">
                                  <div>
                                    <i class="far fa-3x fa-solid fa-person-walking-luggage text-danger"></i>
                                      <div class="font-w600 mt-3 text-uppercase">ลาทำงานต่างประเทศ</div>
                                      <br>
                                  </div>
                              </div>
                          </a>
                      </div>
                      <div class="col-6 col-md-4 col-xl-2">
                          <a class="block block-link-shadow text-center" href="{{url('user/gleave_data_occupation')}}">
                              <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center bg-light">
                                  <div>
                                    <i class="far fa-3x fa-solid fa-people-pulling text-dark"></i>
                                      <div class="font-w600 mt-3 text-uppercase">ลาฟื้นฟูอาชีพ</div>
                                      <br>
                                  </div>
                              </div>
                          </a>
                      </div>
                    </div>
                    <br>
                    <div class="row">
               
                      <div class="col-6 col-md-4 col-xl-2">
                          <a class="block block-link-shadow text-center" href="{{url('user/gleave_data_soldier')}}">
                              <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center bg-light">
                                  <div>
                                   
                                    <i class="far fa-3x fa-solid fa-person-rifle text-primary"></i>
                                      <div class="font-w600 mt-3 text-uppercase">ลาเกณฑ์ทหาร</div>
                                      <br>
                                  </div>
                              </div>
                          </a>
                      </div>
                     
                      <div class="col-6 col-md-4 col-xl-2">
                          <a class="block block-link-shadow text-center" href="{{url('user/gleave_data_helpmaternity')}}">
                              <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center bg-light">
                                  <div>
                                      <i class="far fa-3x fa-solid fa-person-dots-from-line text-success"></i>
                                      <div class="font-w600 mt-3 text-uppercase">ลาช่วยภริยาคลอด</div>
                                      <br>
                                  </div>
                              </div>
                          </a>
                      </div>
               
                  
                      <div class="col-6 col-md-4 col-xl-2">
                          <a class="block block-link-shadow text-center" href="{{url('user/gleave_data_maternity')}}">
                              <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center bg-light">
                                  <div>                                     
                                      <i class="far fa-3x fa-solid fa-person-breastfeeding text-danger"></i>
                                      <div class="font-w600 mt-3 text-uppercase">ลาคลอดบุตร</div>
                                      <br>
                                  </div>
                              </div>
                          </a>
                      </div>
                   
                      <div class="col-6 col-md-4 col-xl-2">
                          <a class="block block-link-shadow text-center" href="{{url('user/gleave_data_spouse')}}">
                              <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center bg-light">
                                  <div>
                                      <i class="far fa-3x fa-solid fa-hospital-user text-dark"></i>
                                      <div class="font-w600 mt-3 text-uppercase">ลาติดตามคู่สมรส</div>
                                      <br>
                                  </div>
                              </div>
                          </a>
                      </div>


                      <div class="col-6 col-md-4 col-xl-2">
                          <a class="block block-link-shadow text-center" href="{{url('user/gleave_data_out')}}">
                              <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center bg-light">
                                  <div> 
                                      <i class="far fa-3x fa-solid fa-arrow-right-from-bracket text-info"></i>
                                      <div class="font-w600 mt-3 text-uppercase">ลาออก</div>
                                      <br>
                                  </div>
                              </div>
                          </a>
                      </div>

                      <div class="col-6 col-md-4 col-xl-2">
                          <a class="block block-link-shadow text-center" href="{{url('user/gleave_data_law')}}">
                              <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center bg-light">
                                  <div>
                                    <i class="far fa-3x fa-solid fa-person-hiking"></i>
                                      <div class="font-w600 mt-3 text-uppercase">ลาป่วย<br>ตามกฎหมายฯ</div>
                                      <br>
                                  </div>
                              </div>
                          </a>
                      </div>
                    </div> 
                     
                    <div class="row">
                      <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-shadow text-center" href="{{url('user/gleave_data_ordination')}}">
                            <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center bg-light">
                                <div>
                                    <i class="far fa-3x fa-solid fa-user-injured text-warning"></i>
                                    <div class="font-w600 mt-3 text-uppercase">ลาอุปสมบท<br>ประกอบพิธีฮัจญ์</div>
                                    <br>
                                </div>
                            </div>
                        </a>
                    </div>  
                  </div>            
                </div>






                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
