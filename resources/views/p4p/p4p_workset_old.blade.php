@extends('layouts.p4pnew')
@section('title', 'PK-OFFICER || P4P')

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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-4">
                                <h5>เพิ่มรายการภาระงาน P4P </h5>
                            </div>
                            <div class="col"></div> 
                            <div class="col-md-2 text-end">
                           
                            </div>
    
                        </div>
                    </div>
                    <div class="card-body shadow-lg">
                        <div class="row mt-3">
                            <div class="col-md-2 text-end">
                                <label for="article_num">เลขครุภัณฑ์ </label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input id="article_num" type="text" class="form-control form-control-sm"
                                        name="article_num">
                                </div>
                            </div>
                            <div class="col-md-2 text-end">
                                <label for="article_name">ชื่อครุภัณฑ์ </label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input id="article_name" type="text" class="form-control form-control-sm"
                                        name="article_name">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
  

@endsection
