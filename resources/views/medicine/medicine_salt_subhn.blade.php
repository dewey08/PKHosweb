@extends('layouts.medicine')
@section('title', 'PK-OFFICER || แพทย์แผนไทย')

     <?php
     use App\Http\Controllers\StaticController;
     use Illuminate\Support\Facades\DB;   
     $count_meettingroom = StaticController::count_meettingroom();
 ?>


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
                   border: 10px #ddd solid;
                   border-top: 10px #20a886 solid;
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
                   .inputmedsalt{
                        border-radius: 4em 4em 4em 4em;
                        box-shadow: 0 0 10px rgb(189, 187, 187);
                    }
                    .cardmedsalt{
                        border-radius: 4em 4em 4em 4em;
                        box-shadow: 0 0 10px rgb(122, 121, 121);
                        /* box-shadow: 0 0 10px rgb(232, 187, 243); */
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
            <div id="preloader">
                <div id="status">
                    <div class="spinner"> 
                    </div>
                </div>
            </div>
         
                    
            <div class="row">
                <div class="col-md-6"> 
                    <h4 class="card-title" style="color:rgb(10, 151, 85)">Thai traditional medical procedures</h4>
                    <p class="card-title-desc"> หัตถการแพทย์แผนไทย  </p>
                </div>
                <div class="col"></div>
                
            </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col"></div>
            <div class="col-md-10">
                <div class="card cardshadow">
                  
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>                                           
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">วันที่</th>
                                        <th class="text-center">หัตถการ</th>                                                    
                                    </tr>                                            
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow as $item)
                                        <tr>
                                            <td class="text-center">{{$i++}}</td> 
                                            <td class="text-center">{{DateThai($item->service_date)}}</td> 
                                            <td class="text-center">{{$item->icd10tm}} </td>  
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>
    </div>
  

@endsection
 