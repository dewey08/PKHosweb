@extends('layouts.userhn')
@section('title','ZOffice || หัวหน้า')

<style>
  .btn{
     font-size:15px;
   }
   .xl{
    font-size:15px;
   }
   .bgc{
    background-color: #264886;
   }
   .bga{
    background-color: #FCFF9A;
   }
   .bgon{
    background-color: #FFF48F;
   }
   .boxpdf{
    /* height: 1150px; */
    height: auto;
   }
   /* .page{
        width: 90%;
        margin: 5px;
        box-shadow: 0px 0px 5px #000;
        animation: pageIn 1s ease;
        transition: all 1s ease, width 0.2s ease;
    } */
    @keyframes pageIn{
    0%{
        transform: translateX(-300px);
        opacity: 0;
    }
    100%{
        transform: translateX(0px);
        opacity: 1;
    }
    }
    #zoom-in{
        
    }
    #zoom-percent{
        display: inline-block;
    }
    #zoom-percent::after{
        content: "%";
    }
    #zoom-out{
        
    }
    .fpdf{
        width:auto;
        height:860px;
        /* height:auto; */
        margin:0;
        
        overflow:scroll;
        background-color: #FFFFFF;
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
  use App\Http\Controllers\BookController;
    $refnumber = BookController::refnumber();
  ?>
  <style>
    .btn{
       font-size:15px;
     }
     .bgc{
    background-color: #264886;
   }
   .bga{
    background-color: #fbff7d;
   }
   .boxpdf{
    /* height: 1150px; */
    height: auto;
   }
   /* .page{
        width: 90%;
        margin: 10px;
        box-shadow: 0px 0px 5px #000;
        animation: pageIn 1s ease;
        transition: all 1s ease, width 0.2s ease;
    } */
    @keyframes pageIn{
    0%{
        transform: translateX(-300px);
        opacity: 0;
    }
    100%{
        transform: translateX(0px);
        opacity: 1;
    }
    }
    #zoom-in{
        
    }
    #zoom-percent{
        display: inline-block;
    }
    #zoom-percent::after{
        content: "%";
    }
    #zoom-out{
        
    }
    .fpdf{
        width:auto;
        height:850px;
        /* height: auto; */
        margin:0;
        
        overflow:scroll;
        background-color: #FFFFFF;
    }
  </style>
<div class="container-fluid mt-3" style="width: 98%">
    <div class="card"> 
        <div class="card-header">           
            
            <div class="row align-items-start">
                <div class="col">
                    {{ __('ทะเบียนหนังสือ') }}
                </div>
                <div class="col-md-9">
            
                </div>
                <div class="col">
                    <button type="button" href="{{url("book/booksend_index_add")}}" class="btn btn-success btn-sm comment" value="{{ $dataedits->bookrep_id }}">บันทึกความเห็น</button>
                    {{-- <a href="{{url("book/booksend_index_add")}}" class="btn btn-success btn-sm bookModal" data-bs-toggle="modal" data-bs-target="#bookModal">บันทึกความเห็น</a> --}}
                </div>
              </div>
              
        </div>
        {{-- <div class="text-end">
            <a href="{{url("book/booksend_index_add")}}" class="btn btn-success btn-rounded btn-sm">ออกเลขหนังสือส่ง</a>
        </div> --}}
        
        <div class="row">
            <div class="col-md-7">  
                <div class="row">
                    <div class="col-md-12"> 
                        <div class="card-body fpdf">
                            {{-- <div class="card-body shadow-lg ">   --}}
                                
                                <div class="fpdf mt-2 text-center" id="pages">
                                        @if($dataedits->bookrep_file == '' || $dataedits->bookrep_file == null)
                                            ไม่มีข้อมูลไฟล์อัปโหลด 
                                        @else
                                            <?php list($a,$b,$c,$d) = explode('/',$url); ?>
                                                <iframe src="{{ asset('storage/bookrep_pdf/'.$dataedits->bookrep_file) }}" height="100%" width="100%"></iframe>
                                        @endif  
                                </div>                                     
                            {{-- </div> --}}
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-md-5">  
                {{-- <div class="card-body"> --}}
                    <div class="card-body shadow-lg ">  

                        <!-- Pills navs -->
                            <ul class="nav nav-pills mb-3" id="ex1" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{$message}}" id="ex1-tab-1" data-mdb-toggle="pill" href="#ex1-pills-1"
                                        role="tab" aria-controls="ex1-pills-1" aria-selected="true"><label class="xl">รายละเอียด</label>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{$message1}}" id="ex1-tab-2" data-mdb-toggle="pill" href="#ex1-pills-2"
                                        role="tab" aria-controls="ex1-pills-2" aria-selected="false"><label class="xl">ส่งกลุ่มงาน</label>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{$message2}}" id="ex1-tab-3" data-mdb-toggle="pill" href="#ex1-pills-3"
                                        role="tab" aria-controls="ex1-pills-3" aria-selected="false" ><label class="xl">ส่งฝ่าย/แผนก</label>
                                    </a >
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{$message3}}" id="ex1-tab-4" data-mdb-toggle="pill" href="#ex1-pills-4"
                                        role="tab" aria-controls="ex1-pills-4" aria-selected="false" ><label class="xl">ส่งบุคคลากร</label>
                                    </a >
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{$message4}}" id="ex1-tab-5" data-mdb-toggle="pill" href="#ex1-pills-5"
                                        role="tab" aria-controls="ex1-pills-5" aria-selected="false" ><label class="xl">ส่งทีมนำองค์กร</label>
                                    </a >
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{$message5}}" id="ex1-tab-6" data-mdb-toggle="pill" href="#ex1-pills-6"
                                        role="tab" aria-controls="ex1-pills-6" aria-selected="false" >&nbsp;ไ<label class="xl">ฟล์แนบ</label>&nbsp;&nbsp;
                                    </a >
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{$message6}}" id="ex1-tab-7" data-mdb-toggle="pill" href="#ex1-pills-7"
                                        role="tab" aria-controls="ex1-pills-7" aria-selected="false" >&nbsp;<label class="xl">การเปิดอ่าน</label>&nbsp;&nbsp;
                                    </a >
                                </li>
                            </ul>
                        <!-- Pills navs -->
    
                        <!-- Pills content -->
                        <div class="tab-content" id="ex1-content">
                            <div class="tab-pane fade show active" id="ex1-pills-1" role="tabpanel" aria-labelledby="ex1-tab-1" >
                                <div class="row">
                                    <div class="col-md-3 text-center mt-4"> 
                                        <img src="/assets/img/crut.png" class="img-fluid hover-shadow" alt="Los Angeles Skyscrapers" width="130px" height="130px"/>
                                    </div>
                        
                                    <input type="hidden" id="bookrep_repnum" name="bookrep_repnum" class="form-control" value="{{$refnumber}}" readonly/>
                                    <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                                    <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                                    
                                    <div class="col-md-9">  
                                        <div class="row">
                                            <div class="col-md-6"> 
                                                <div class="form-outline bgon">
                                                    <input type="text" id="bookrep_recievenum" name="bookrep_recievenum" class="form-control" value="{{$dataedits->bookrep_recievenum}}"/>
                                                    <label class="form-label" for="bookrep_repnum">เลขที่รับ</label>
                                                </div> 
                                            </div> 
                                            <div class="col-md-6"> 
                                                <div class="form-outline bgon">
                                                    <input type="text" id="bookrep_repbooknum" name="bookrep_repbooknum" class="form-control" value="{{$dataedits->bookrep_repbooknum}}"/>
                                                    <label class="form-label" for="bookrep_repbooknum">เลขที่หนังสือ</label>
                                                </div> 
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-6"> 
                                                <div class="form-outline bgon">
                                                    <input id="bookrep_type_name" name="bookrep_type_name" type="text" class="form-control" value="{{$dataedits->bookrep_type_name}}">
                                                    <label class="form-label" for="bookrep_type_name">ประเภทหนังสือ</label>
                                                </div> 
                                            </div> 
                                            <div class="col-md-6"> 
                                                <div class="form-outline bgon">
                                                    <input id="import_fam_name" name="import_fam_name" type="text" class="form-control" value="{{$dataedits->import_fam_name}}">
                                                    <label class="form-label" for="import_fam_name">นำเข้าไว้ในแฟ้ม</label>
                                                </div>                                   
                                            </div>                                                  
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-4"> 
                                                <div class="form-outline bgon">
                                                    <input id="bookrep_save_date" name="bookrep_save_date" type="text" class="form-control" value="{{DateThai($dataedits->bookrep_save_date)}}" >
                                                    <label class="form-label" for="bookrep_save_date">ลงสมุดบันทึก วันที่</label>
                                                </div> 
                                            </div>
                                            <div class="col-md-4"> 
                                                <div class="form-outline bgon">
                                                    <input id="bookrep_save_time" name="bookrep_save_time" type="text" class="form-control" value="{{$dataedits->bookrep_save_time}}">
                                                    <label class="form-label" for="bookrep_save_date">เวลา</label>
                                                </div> 
                                            </div>  
                                            <div class="col-md-4"> 
                                                <div class="form-outline bgon">
                                                    <input id="bookrep_secret_class_name" name="bookrep_secret_class_name" type="text" class="form-control" value="{{$dataedits->bookrep_secret_class_name}}">
                                                    <label class="form-label" for="bookrep_secret_class_name">ชั้นความลับ</label>
                                                </div>                                    
                                            </div>                            
                                        </div>
                                        <div class="row mt-2">  
                                            <div class="col-md-4"> 
                                                <div class="form-outline bgon"> 
                                                    <input id="bookrep_follow_date" type="text" class="form-control" name="start_date" value="{{ DatetimeThai($dataedits->start_date)}}">
                                                    <label class="form-label" for="bookrep_follow_date">ติดตาม ณ วันที่</label>
                                                </div> 
                                            </div>
                                            <div class="col-md-4"> 
                                                <div class="form-outline bgon">
                                                    <input id="bookrep_save_time" name="bookrep_save_time" type="text" class="form-control" value="{{$dataedits->bookrep_save_time}}">
                                                    <label class="form-label" for="bookrep_save_time">เวลา</label>
                                                </div> 
                                            </div>
                                            <div class="col-md-4">  
                                                <div class="form-outline bgon">
                                                    <input id="bookrep_speed_class_name" name="bookrep_speed_class_name" type="text" class="form-control" value="{{$dataedits->bookrep_speed_class_name}}">
                                                    <label class="form-label" for="bookrep_speed_class_name">ชั้นความเร็ว</label>
                                                </div> 
                                            </div> 
                                        </div>
                                            
                                    </div>                       
                                </div>                
                                <div class="row mt-1">
                                    <div class="col-md-3 text-end bgc text-white"> 
                                        ชื่อเรื่อง
                                    </div>
                                    <div class="col-md-9 mt-1"> 
                                        <div class="form-outline bgon">
                                            <input type="text" id="bookrep_name" name="bookrep_name" class="form-control" value="{{$dataedits->bookrep_name}}"/>
                                            <label class="form-label" for="bookrep_name">ชื่อเรื่อง</label>
                                        </div> 
                                    </div>
                                </div>                
                                <div class="row mt-1">
                                    <div class="col-md-3 text-end bgc text-white"> 
                                        เนื้อเรื่อง
                                    </div>
                                    <div class="col-md-9 mt-1"> 
                                        <div class="form-outline bgon">
                                            <textarea class="form-control" id="bookrep_story" name="bookrep_story" rows="2">{{$dataedits->bookrep_story}}</textarea>
                                            <label class="form-label" for="bookrep_story">เนื้อเรื่อง</label>
                                        </div>
                                    </div>
                                </div>                
                                <div class="row mt-1">
                                    <div class="col-md-3 text-end bgc text-white"> 
                                        ข้อเสนอประกอบ
                                    </div>
                                    <div class="col-md-9 mt-1">
                                        <div class="form-outline bgon">
                                            <textarea class="form-control" id="bookrep_assembly" name="bookrep_assembly" rows="2">{{$dataedits->bookrep_assembly}}</textarea>
                                            <label class="form-label" for="bookrep_assembly">
                                                เรื่องเดิม .. , สรุปเรื่อง .. , ข้อมูล กฎระเบียบที่เกี่ยวข้อง .. , ข้อเสนอเพื่อพิจารณา ..
                                            </label> 
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-1">
                                    <div class="col-md-3 text-end bgc text-white"> 
                                        ความเห็นที่ 1
                                    </div>
                                    <div class="col-md-9 mt-1"> 
                                        <div class="form-outline bgon">
                                            <textarea class="form-control" id="bookrep_comment1" name="bookrep_comment1" rows="3">{{$dataedits->bookrep_comment1}}</textarea>
                                            <label class="form-label" for="bookrep_name">ความเห็นที่ 1 &nbsp;&nbsp;&nbsp;&nbsp;ผู้เสนอ :</label>
                                        </div> 
                                    </div>
                                </div> 
                                <div class="row mt-1">
                                    <div class="col-md-3 text-end bgc text-white"> 
                                        ความเห็นที่ 2
                                    </div>
                                    <div class="col-md-9 mt-1"> 
                                        <div class="form-outline bgon">
                                            <textarea class="form-control" id="bookrep_comment2" name="bookrep_comment2" rows="3">{{$dataedits->bookrep_comment2}}</textarea>
                                            <label class="form-label" for="bookrep_name">ความเห็นที่ 2 &nbsp;&nbsp;&nbsp;&nbsp;ผู้เสนอ :</label>
                                        </div> 
                                    </div>
                                </div> 
                            
                                <div class="row mt-1">
                                    <div class="col-md-3 text-end bgc text-white"> 
                                        ความเห็น ผอ.
                                    </div>
                                    <div class="col-md-9 mt-1"> 
                                        <div class="form-outline bgon">
                                            <textarea class="form-control" id="bookrep_comment3" name="bookrep_comment3" rows="3">{{$dataedits->bookrep_comment3}}</textarea>
                                            <label class="form-label" for="bookrep_name">ความเห็น ผอ. &nbsp;&nbsp;&nbsp;&nbsp;ผู้เสนอ :</label>
                                        </div> 
                                    </div>
                                </div> 
                            </div>

                            <!-- ************ ส่งกลุ่มงาน ********************** -->
                            <div class="tab-pane fade" id="ex1-pills-2" role="tabpanel" aria-labelledby="ex1-tab-2">
                                    <form action="{{route('book.bookmake_index_senddep')}}" method="POST">
                                        @csrf                             
                                        <div class="row text-center">
                                        
                                                <input type="hidden" name="bookrep_id" id="bookrep_id" value=" {{ $dataedits->bookrep_id }}">
                                                <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <select id="dep" name="DEPARTMENT_ID" class="form-control" style="width: 100%" required>                      
                                                        <option value=""></option>
                                                        @foreach ($department as $depart )
                                                            <option value="{{ $depart->DEPARTMENT_ID}}">{{ $depart->DEPARTMENT_NAME}}</option>
                                                        @endforeach                             
                                                    </select>   
                                                </div>
                                            </div> 
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <select id="book_objective" name="book_objective" class="form-control" style="width: 100%" required>                      
                                                        <option value=""></option>
                                                        @foreach ($book_objective as $book )
                                                            <option value="{{ $book->objective_id}}">{{ $book->objective_name}}</option>
                                                        @endforeach                             
                                                    </select>   
                                                </div>
                                            </div> 
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        ส่ง 
                                                    </button> 
                                                    
                                                </div>
                                            </div>                                                                  
                                        </div> 
                                    </form> 
                                    <div class="row">
                                            <div class="col-md-12 ">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example2">
                                                    <thead>
                                                        <tr height="10px">
                                                            <th width="5%" class="text-center">ลำดับ</th> 
                                                            <th class="text-center">ชื่อกลุ่มงาน</th> 
                                                            <th width="10%" class="text-center">Manage</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $num = 1; $date =  date('Y'); ?>      
                                                        @foreach ($book_senddep as $item2)
                                                
                                                            <tr id="sid{{ $item2->senddep_id }}">
                                                                <td class="text-center" width="5%">{{ $num++ }}</td>
                                                                <td class="p-2">{{ $item2->senddep_dep_name }}</td>               
                                                                <td class="text-center" width="10%"> 
                                                                
                                                                    <a class="text-danger" href="javascript:void(0)"
                                                                        onclick="bookdep_destroy({{ $item2->senddep_id }})"
                                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                        data-bs-custom-class="custom-tooltip" title="ลบ">
                                                                        <i class="fa-solid fa-trash-can"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                    
                                                        @endforeach
                                                                        
                                                    </tbody>
                                                    </table>      
                                                </div> 
                                            </div> 
                                    </div>  
                            </div>
                            <!-- ************ ส่งฝ่าย/แผนก ********************** -->
                            <div class="tab-pane fade" id="ex1-pills-3" role="tabpanel" aria-labelledby="ex1-tab-3">
                                    <form action="{{route('book.bookmake_index_senddepsub')}}" method="POST">
                                        @csrf                             
                                        <div class="row text-center">                                    
                                                <input type="hidden" name="bookrep_id" id="bookrep_id" value=" {{ $dataedits->bookrep_id }}">
                                                <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <select id="DEPARTMENT_SUB_ID" name="DEPARTMENT_SUB_ID" class="form-control" style="width: 100%" required>                      
                                                        <option value=""></option>
                                                        @foreach ($department_sub as $depart_sub )
                                                            <option value="{{ $depart_sub->DEPARTMENT_SUB_ID}}">{{ $depart_sub->DEPARTMENT_SUB_NAME}}</option>
                                                        @endforeach                             
                                                    </select>   
                                                </div>
                                            </div> 
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <select id="book_objective2" name="book_objective2" class="form-control" style="width: 100%" required>                      
                                                        <option value=""></option>
                                                        @foreach ($book_objective as $book )
                                                            <option value="{{ $book->objective_id}}">{{ $book->objective_name}}</option>
                                                        @endforeach                             
                                                    </select>   
                                                </div>
                                            </div> 
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        ส่ง 
                                                    </button> 
                                                    
                                                </div>
                                            </div>                                                                  
                                        </div> 
                                    </form> 

                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example3">
                                                    <thead>
                                                        <tr height="10px">
                                                            <th width="5%" class="text-center">ลำดับ</th> 
                                                            <th class="text-center">ชื่อฝ่าย/แผนก</th> 
                                                            <th width="10%" class="text-center">Manage</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $num = 1; $date =  date('Y'); ?>      
                                                        @foreach ($book_senddep_sub as $item3)
                                                
                                                            <tr id="sid{{ $item3->senddepsub_id }}">
                                                                <td class="text-center" width="5%">{{ $num++ }}</td>
                                                                <td class="p-2">{{ $item3->senddep_depsub_name }}</td>               
                                                                <td class="text-center" width="10%"> 
                                                                
                                                                    <a class="text-danger" href="javascript:void(0)"
                                                                        onclick="bookdepsub_destroy({{ $item3->senddepsub_id }})"
                                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                        data-bs-custom-class="custom-tooltip" title="ลบ">
                                                                        <i class="fa-solid fa-trash-can"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                    
                                                        @endforeach
                                                                        
                                                    </tbody>
                                                </table>      
                                            </div> 
                                        </div> 
                                    </div> 
                            </div>
                            <!-- ************ ส่งบุคคลากร ********************** -->
                            <div class="tab-pane fade" id="ex1-pills-4" role="tabpanel" aria-labelledby="ex1-tab-4">
                                <form action="{{route('book.bookmake_index_sendperson')}}" method="POST">
                                    @csrf                             
                                    <div class="row text-center">                                    
                                            <input type="hidden" name="bookrep_id" id="bookrep_id" value=" {{ $dataedits->bookrep_id }}">
                                            <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                                        <div class="col-md-5 ">
                                            <div class="form-group">
                                                <select id="sendperson_user_id" name="sendperson_user_id" class="form-control" style="width: 100%" required>                      
                                                    <option value=""></option>
                                                    @foreach ($users as $user )
                                                        <option value="{{ $user->id}}">{{ $user->fname}} {{ $user->lname}}</option>
                                                    @endforeach                             
                                                </select>   
                                            </div>
                                        </div> 
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <select id="book_objective3" name="book_objective3" class="form-control" style="width: 100%" required>                      
                                                    <option value=""></option>
                                                    @foreach ($book_objective as $book )
                                                        <option value="{{ $book->objective_id}}">{{ $book->objective_name}}</option>
                                                    @endforeach                             
                                                </select>   
                                            </div>
                                        </div> 
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    ส่ง 
                                                </button> 
                                                
                                            </div>
                                        </div>                                                                  
                                    </div> 
                                </form> 

                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example3">
                                                <thead>
                                                    <tr height="10px">
                                                        <th width="5%" class="text-center">ลำดับ</th> 
                                                        <th class="text-center">ชื่อ-นามสกุล</th> 
                                                        <th width="10%" class="text-center">Manage</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $num = 1; $date =  date('Y'); ?>      
                                                    @foreach ($book_send_person as $item4)
                                            
                                                        <tr id="sid{{ $item4->sendperson_id }}">
                                                            <td class="text-center" width="5%">{{ $num++ }}</td>
                                                            <td class="p-2">{{ $item4->sendperson_user_name }}</td>               
                                                            <td class="text-center" width="10%"> 
                                                            
                                                                <a class="text-danger" href="javascript:void(0)"
                                                                    onclick="bookperson_destroy({{ $item4->sendperson_id }})"
                                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                    data-bs-custom-class="custom-tooltip" title="ลบ">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                
                                                    @endforeach
                                                                    
                                                </tbody>
                                            </table>      
                                        </div> 
                                    </div> 
                                </div>  
                            </div>
                            <!-- ************ ส่งทีมนำองค์กร ********************** -->
                            <div class="tab-pane fade" id="ex1-pills-5" role="tabpanel" aria-labelledby="ex1-tab-5">
                                <form action="{{route('book.bookmake_index_sendteam')}}" method="POST">
                                    @csrf                             
                                    <div class="row">                                    
                                            <input type="hidden" name="bookrep_id" id="bookrep_id" value=" {{ $dataedits->bookrep_id }}">
                                            <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                                        <div class="col-md-5 text-center">
                                            <div class="form-group">
                                                <select id="org_team_id" name="org_team_id" class="form-control" style="width: 100%" required>                      
                                                    <option value=""></option>
                                                    @foreach ($org_team as $team )
                                                        <option value="{{ $team->org_team_id}}">{{ $team->org_team_detail}}</option>
                                                    @endforeach                             
                                                </select>   
                                            </div>
                                        </div> 
                                        <div class="col-md-5 text-center">
                                            <div class="form-group">
                                                <select id="book_objective5" name="book_objective5" class="form-control" style="width: 100%" required>                      
                                                    <option value=""></option>
                                                    @foreach ($book_objective as $book )
                                                        <option value="{{ $book->objective_id}}">{{ $book->objective_name}}</option>
                                                    @endforeach                             
                                                </select>   
                                            </div>
                                        </div> 
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    ส่ง 
                                                </button> 
                                                
                                            </div>
                                        </div>                                                                  
                                    </div> 
                                </form> 

                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example4">
                                                <thead>
                                                    <tr height="10px">
                                                        <th width="5%" class="text-center">ลำดับ</th> 
                                                        <th class="text-center">ทีมนำองค์กร</th> 
                                                        <th width="10%" class="text-center">Manage</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $num = 1; $date =  date('Y'); ?>      
                                                    @foreach ($book_sendteam as $item5)
                                            
                                                        <tr id="sid{{ $item5->sendteam_id }}">
                                                            <td class="text-center" width="5%">{{ $num++ }}</td>
                                                            <td class="p-2">{{ $item5->sendteam_team_name }}</td>               
                                                            <td class="text-center" width="10%"> 
                                                            
                                                                <a class="text-danger" href="javascript:void(0)"
                                                                    onclick="booksendteam_destroy({{ $item5->sendteam_id.'/'.$dataedits->bookrep_id}})"
                                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                    data-bs-custom-class="custom-tooltip" title="ลบ">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                
                                                    @endforeach
                                                                    
                                                </tbody>
                                            </table>      
                                        </div> 
                                    </div> 
                                </div> 
                            </div>

                            <!-- ************ ไฟล์แนบ ********************** -->
                            <div class="tab-pane fade" id="ex1-pills-6" role="tabpanel" aria-labelledby="ex1-tab-6">
                                <div class="row mt-1">
                                    <div class="col-md-3 text-end bgc text-white "> 
                                        ไฟล์ประกอบ 1
                                    </div>
                                    <div class="col-md-9 mt-1">
                                        <div class="input-group bgon p-2 me-2">                                    
                                            <label class="form-label me-4" for="bookrep_file1">ไฟล์ประกอบ 1</label>
                                            @if ($dataedits->bookrep_file1 != '')
                                                <a href="{{asset('storage/bookrep_pdf/'.$dataedits->bookrep_file1)}}" target="_blank"><i class="fa-solid fa-2x fa-file-pdf text-danger "></i> </a>                                 
                                            @endif
                                        </div>                          
                                    </div>
                                </div> 
                                <div class="row mt-1">
                                    <div class="col-md-3 text-end bgc text-white"> 
                                        ไฟล์ประกอบ 2
                                    </div>
                                    <div class="col-md-9 mt-1"> 
                                        <div class="input-group bgon p-2 me-2">                                    
                                            <label class="form-label me-4" for="bookrep_file2">ไฟล์ประกอบ 2</label>
                                            @if ($dataedits->bookrep_file1 != '')
                                                <a href="{{asset('storage/bookrep_pdf/'.$dataedits->bookrep_file2)}}" target="_blank"><i class="fa-solid fa-2x fa-file-pdf text-danger "></i> </a>                                 
                                            @endif
                                        </div>  
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-md-3 text-end bgc text-white"> 
                                        ไฟล์ประกอบ 3
                                    </div>
                                    <div class="col-md-9 mt-1">
                                        <div class="input-group bgon p-2 me-2">                                    
                                            <label class="form-label me-4" for="bookrep_file3">ไฟล์ประกอบ 3</label>
                                            @if ($dataedits->bookrep_file1 != '')
                                                <a href="{{asset('storage/bookrep_pdf/'.$dataedits->bookrep_file3)}}" target="_blank"><i class="fa-solid fa-2x fa-file-pdf text-danger "></i> </a>                                 
                                            @endif
                                        </div>      
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-md-3 text-end bgc text-white"> 
                                        ไฟล์ประกอบ 4
                                    </div>
                                    <div class="col-md-9 mt-1"> 
                                        <div class="input-group bgon p-2 me-2">                                    
                                            <label class="form-label me-4" for="bookrep_file4">ไฟล์ประกอบ 4</label>
                                            @if ($dataedits->bookrep_file1 != '')
                                                <a href="{{asset('storage/bookrep_pdf/'.$dataedits->bookrep_file4)}}" target="_blank"><i class="fa-solid fa-2x fa-file-pdf text-danger "></i> </a>                                 
                                            @endif
                                        </div> 
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-md-3 text-end bgc text-white"> 
                                        ไฟล์ประกอบ 5
                                    </div>
                                    <div class="col-md-9 mt-1"> 
                                        <div class="input-group bgon p-2 me-2">                                    
                                            <label class="form-label me-4" for="bookrep_file5">ไฟล์ประกอบ 5</label>
                                            @if ($dataedits->bookrep_file1 != '')
                                                <a href="{{asset('storage/bookrep_pdf/'.$dataedits->bookrep_file5)}} " target="_blank"><i class="fa-solid fa-2x fa-file-pdf text-danger "></i> </a>                                 
                                            @endif
                                        </div> 
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="ex1-pills-7" role="tabpanel" aria-labelledby="ex1-tab-7">
                            </div>


                        </div>
                        <!-- Pills content -->
                    
                    </div>
                {{-- </div> --}}
            </div> 
        </div> 
    </div>
</div> 

 <!-- Modal -->
 <div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">หนังสือเลขที่ {{$dataedits->bookrep_recievenum}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('hn.hn_bookindex_comment_update') }}" id="insert_commentForm" method="POST">
                            @csrf
                            @method('PUT')

                        <div class="row ">
                            <div class="col-md-8 "> 

                                <div class="row mt-1">
                                    <div class="col-md-3 text-end bgc text-white"> 
                                        ชื่อเรื่อง
                                    </div>
                                    <div class="col-md-9 mt-1"> 
                                        <div class="form-outline bgon">
                                            <input type="text" id="bookrep_name" name="bookrep_name" class="form-control" value="{{$dataedits->bookrep_name}}"/>
                                            <label class="form-label" for="bookrep_name">ชื่อเรื่อง</label>
                                        </div> 
                                    </div>
                                </div> 
                                <div class="row mt-1">
                                    <div class="col-md-3 text-end bgc text-white"> 
                                        เนื้อเรื่อง
                                    </div>
                                    <div class="col-md-9 mt-1"> 
                                        <div class="form-outline bgon">
                                            <textarea class="form-control" id="bookrep_story" name="bookrep_story" rows="2">{{$dataedits->bookrep_story}}</textarea>
                                            <label class="form-label" for="bookrep_story">เนื้อเรื่อง</label>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row mt-1">
                                    <div class="col-md-3 text-end bgc text-white"> 
                                        ความเห็นที่ 1
                                    </div>
                                    <div class="col-md-9 mt-1"> 
                                        <div class="form-outline bgon">
                                            {{-- <textarea class="form-control" id="bookrep_comment1" name="bookrep_comment1" rows="3" >{{$dataedits->bookrep_comment1}}</textarea> --}}
                                            <input class="form-control" id="bookrep_comment1" name="bookrep_comment1" >
                                            <label class="form-label" for="bookrep_name">ความเห็นที่ 1 &nbsp;&nbsp;&nbsp;&nbsp;ผู้เสนอ :</label>
                                        </div> 
                                    </div>
                                </div> 
                                <div class="row mt-1">
                                    <div class="col-md-3 text-end bgc text-white"> 
                                        ความเห็นที่ 2
                                    </div>
                                    <div class="col-md-9 mt-1"> 
                                        <div class="form-outline bgon">
                                            <textarea class="form-control" id="bookrep_comment2" name="bookrep_comment2" rows="3">{{$dataedits->bookrep_comment2}}</textarea>
                                            <label class="form-label" for="bookrep_name">ความเห็นที่ 2 &nbsp;&nbsp;&nbsp;&nbsp;ผู้เสนอ :</label>
                                        </div> 
                                    </div>
                                </div>         
                                <div class="row mt-1">
                                    <div class="col-md-3 text-end bgc text-white"> 
                                        ความเห็น ผอ.
                                    </div>
                                    <div class="col-md-9 mt-1"> 
                                        <div class="form-outline bgon">
                                            <textarea class="form-control" id="bookrep_comment3" name="bookrep_comment3" rows="3">{{$dataedits->bookrep_comment3}}</textarea>
                                            <label class="form-label" for="bookrep_name">ความเห็น ผอ. &nbsp;&nbsp;&nbsp;&nbsp;ผู้เสนอ :</label>
                                        </div> 
                                    </div>
                                </div> 
                                <input type="hidden" id="id" name="id" value="{{$dataedits->bookrep_id}}">
                                <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                                <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}"> 
                                <div class="row mt-3">
                                    <div class="col-md-12 text-center"> 
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">ปิด</button>
                                        <button type="sumit" class="btn btn-primary btn-sm">บันทึกความเห็น</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                            <div class="col-md-4 "> 

                                <h2 class="text-center">Digital Signature</h2>
                                    <form class="custom-validation" action="{{ route('book.signature_save') }}" method="POST" id="signature_saveForm" enctype="multipart/form-data">
                                        @csrf
                                        <div id="signature-pad">
                                            <div style="border:solid 1px teal; width:360px;height:110px;padding:3px;position:relative;">
                                                <div id="note" onmouseover="my_function();" class="text-center">The signature should be inside box</div>
                                                <canvas id="the_canvas" width="350px" height="100px" ></canvas>
                                            </div> 
                                            <div class="mt-2 text-center">
                                            
                                                        <input type="hidden" id="signature" name="signature">
                                                        <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                                                        <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">

                                                        <button type="button" id="clear_btn" class="btn btn-danger btn-sm" data-action="clear"><span class="glyphicon glyphicon-remove"></span> Clear</button>
                                                        <button type="button" id="save_btn" class="btn btn-primary btn-sm" data-action="save-png" onclick="create()"><span class="glyphicon glyphicon-ok"></span> Create</button>
                                                        <button type="submit" class="btn btn-primary btn-sm" data-action="save-png"><span class="glyphicon glyphicon-ok"></span> Save  </button>
                                            </div>
                                        </div>
                                    <form> 
                                        <div class="mt-5">
                                               
                                                <div class="row">
                                                    @foreach ($book_signature as $bo)
                                                        <div class="col-md-4 mt-2">
                                                            <div style="border:solid 1px rgb(237, 240, 240); width:110px;height:50px;padding:3px;position:relative;">
                                                                <img src="{{$bo->signature_name_text}}" height="30px" width="100px" class="mt-1"> <br> 
                                                            </div> 
                                                        </div> 
                                                    @endforeach
                                                </div> 
                                                    
                                               
                                        </div>

                            </div>

                        </div>
                    </div>
                    <!--<div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" id="saveBtn" class="btn btn-primary btn-sm">บันทึกข้อมูล</button>
                    </div>-->
            </div>
        </div>
  </div>
</div>
@endsection
@section('footer') 

<script src="{{ asset('pdfupload/pdf_up.js') }}"></script>
<script src="{{ asset('js/globalFunction.js') }}"></script>
 
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script src="{{ asset('js/gcpdfviewer.js') }}"></script> 
   
<script src="{{ asset('js/book.js') }}"></script>  
<script> 
    var wrapper = document.getElementById("signature-pad");
    var clearButton = wrapper.querySelector("[data-action=clear]");
    var savePNGButton = wrapper.querySelector("[data-action=save-png]");
    var canvas = wrapper.querySelector("canvas");
    var el_note = document.getElementById("note");
    var signaturePad;
    signaturePad = new SignaturePad(canvas);
    clearButton.addEventListener("click", function (event) {
    document.getElementById("note").innerHTML="The signature should be inside box";
    signaturePad.clear();
    });
    savePNGButton.addEventListener("click", function (event){
    if (signaturePad.isEmpty()){
        alert("Please provide signature first.");
        event.preventDefault();
    }else{
        var canvas  = document.getElementById("the_canvas");
        var dataUrl = canvas.toDataURL();
        document.getElementById("signature").value = dataUrl;

        // ข้อความแจ้ง
            Swal.fire({
                title: 'สร้างสำเร็จ',
                text: "You create success",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#06D177',               
                confirmButtonText: 'เรียบร้อย'
            }).then((result) => {
                if (result.isConfirmed) {}
            })  
    }
    });
    function my_function(){
    document.getElementById("note").innerHTML="";
    } 
</script>


<script>
//     function getImgFromUrl(logo_url, callback) {
//     var img = new Image();
//     img.src = logo_url;
//     img.onload = function () {
//         callback(img);
//     };
// }
// function generatePDF(img){
//     var options = {orientation: 'p', unit: 'mm', format: custom};
//     var doc = new jsPDF(options);
//     doc.addImage(img, 'JPEG', 0, 0, 100, 50);}




pdfjsLib.GlobalWorkerOptions.workerSrc = "{{ asset('pdfupload/pdf_upwork.js') }}";
document.querySelector("#pdfupload").addEventListener("change", function(e){
document.querySelector("#pages").innerHTML = "";

    var file = e.target.files[0]
    if(file.type != "application/pdf"){
        alert(file.name + " is not a pdf file.")
        return
    }
    
var fileReader = new FileReader();  

fileReader.onload = function() {
    var typedarray = new Uint8Array(this.result);

    pdfjsLib.getDocument(typedarray).promise.then(function(pdf) {


        // you can now use *pdf* here
        console.log("the pdf has", pdf.numPages, "page(s).");
        
  for (var i = 0; i < pdf.numPages; i++) {
    (function(pageNum){
            pdf.getPage(i+1).then(function(page) {
            // you can now use *page* here
            var viewport = page.getViewport(2.0);
            var pageNumDiv = document.createElement("div");
            pageNumDiv.className = "pageNumber";
            pageNumDiv.innerHTML = "Page " + pageNum;
            var canvas = document.createElement("canvas");
            canvas.className = "page";
            canvas.title = "Page " + pageNum;
            document.querySelector("#pages").appendChild(pageNumDiv);
            document.querySelector("#pages").appendChild(canvas);
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            page.render({
                canvasContext: canvas.getContext('2d'),
                viewport: viewport
            }).promise.then(function(){
                console.log('Page rendered');
            });
            page.getTextContent().then(function(text){
                console.log(text);
            });
            });
            })(i+1);
        }
    });
};

 fileReader.readAsArrayBuffer(file);
});

var curWidth = 90;
function zoomIn(){
    if (curWidth < 150) {
        curWidth += 10;
        document.querySelector("#zoom-percent").innerHTML = curWidth;
        document.querySelectorAll(".page").forEach(function(page){

            page.style.width = curWidth + "%";
        });
    }
}
function zoomOut(){
    if (curWidth > 20) {
        curWidth -= 10;
        document.querySelector("#zoom-percent").innerHTML = curWidth;
        document.querySelectorAll(".page").forEach(function(page){

            page.style.width = curWidth + "%";
        });
    }
}
function zoomReset(){

    curWidth = 90;
    document.querySelector("#zoom-percent").innerHTML = curWidth;

    document.querySelectorAll(".page").forEach(function(page){
    page.style.width = curWidth + "%";
        });
    }
    document.querySelector("#zoom-in").onclick = zoomIn;
    document.querySelector("#zoom-out").onclick = zoomOut;
    document.querySelector("#zoom-reset").onclick = zoomReset;
    window.onkeypress = function(e){
        if (e.code == "Equal") {
            zoomIn();
        }
        if (e.code == "Minus") {
            zoomOut();
        }
};

  
</script>
@endsection
