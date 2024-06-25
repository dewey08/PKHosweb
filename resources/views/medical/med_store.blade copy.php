@extends('layouts.medicalslide')
@section('title', 'PK-OFFICER || เครื่องมือแพทย์')
 
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
            {{-- <div class="row ">   
                @foreach ($medical_typecat as $item)                   
                        <div class="col-6 col-md-4 col-xl-4 mt-3">  
                            <a href="{{url('med_store_add/'.$item->medical_typecat_id)}}">
                                <div class="card shadow-lg ">
                                    <div class="card-body text-center shadow-lg"> 
                                        <i class="fa-solid fa-3x fa-warehouse text-info"></i> 
                                        <br>
                                        <label for="" class="mt-2">{{$item->medical_typecatname}}</label>
                                        <br>
                                            <a href="" class="btn btn-outline-info btn-sm position-relative me-4 ms-4 mt-3">
                                                ยืม
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    99+
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                            </a>
                                            <a href="" class="btn btn-outline-info btn-sm position-relative me-4 ms-4 mt-3">
                                                คืน
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    99+
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                            </a>
                                            <a href="" class="btn btn-outline-info btn-sm position-relative me-4 ms-4 mt-3">
                                                คลัง
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    99+
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                            </a>
                                    </div>
                                </div>
                            </a>
                        </div>                 
                @endforeach    
            </div> --}}
            <div class="row">
                @foreach ($medical_typecat as $item)
                    
                    <div class="col-6 col-md-6 col-xl-6 mt-3 mb-3"> 
                        <button class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500 shadow-lg">
                                                              
                                   <div class="row">
                                        <div class="col-md-6">
                                            @if ( $item->img == Null )
                                            <img src="{{asset('assets/images/default-image.jpg')}}" height="400px" width="auto;" alt="Image" class="img-thumbnail">
                                            @else
                                            <img src="{{asset('storage/article/'.$item->img)}}" height="400px" alt="Image" class="img-thumbnai">                                 
                                            @endif 

                                            <label for="" class="mt-2" style="font-size: 20px;color:red">{{$item->medical_typecatname}}</label>
                                        </div>
                                        <div class="col-md-6">
                                            <a class="btn btn-outline-info btn-sm position-relative me-4 mt-3" href="{{url('medical_store_borrow')}}">
                                                ยืม
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    99+
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                            </a> 
                                            <br>
                                            <a class="btn btn-outline-info btn-sm position-relative me-4 mt-3" href="{{url('medical_store_night')}}">
                                                คืน
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" >
                                                    99+
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                            </a> 
                                            <br>
                                            <a class="btn btn-outline-info btn-sm position-relative me-4 mt-3 Store_borrow" href="{{url('medical_stock/'.$item->medical_typecat_id)}}">
                                                คลัง
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    99+
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                            </a>
                                        </div>
                                   </div>
                                    
                                </button>
                                   
                    </div>

                @endforeach
                                
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
         
    });
    
</script>

@endsection
