@extends('layouts.usergroup')
@section('title','ZOffice || หัวหน้ากลุ่ม')
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
  use App\Http\Controllers\UsersuppliesController;
        use App\Http\Controllers\StaticController;
        use App\Models\Products_request_sub;
    
        $refnumber = UsersuppliesController::refnumber();    
        $checkhn = StaticController::checkhn($iduser);
        $checkhnshow = StaticController::checkhnshow($iduser);
        $count_suprephn = StaticController::count_suprephn($iduser);
        $count_bookrep_rong = StaticController::count_bookrep_rong();
  ?>
@section('menu')
<style>
  body{
      font-size:14px;
  }
  .btn{
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
   .fpdf{
        width:auto;
        height:695px;
        /* height: auto; */
        margin:0;
        
        overflow:scroll;
        background-color: #FFFFFF;
    }
   
</style>
    <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">  
        <a href="{{url('po/po_bookindex/'.Auth::user()->id)}}" class="btn btn-primary btn-sm text-white me-2 mt-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หนังสือราชการ<span class="badge bg-danger ms-2">{{$count_bookrep_rong}}</span>&nbsp;&nbsp;&nbsp;</a>   
        <a href="{{url('po/po_leaveindex/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;การลา<span class="badge bg-danger ms-2">0</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a> 
        <a href="{{url('po/po_trainindex/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2">ประชุม/อบรม/ดูงาน<span class="badge bg-danger ms-2">0</span></a> 
        <a href="{{url('po/po_purchaseindex/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2">&nbsp;จัดซื้อจัดจ้าง<span class="badge bg-danger ms-2">{{$count_suprephn}}</span>&nbsp;</a> 
        <a href="{{url('po/po_storeindex/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2">&nbsp;&nbsp;คลังวัสดุ<span class="badge bg-danger ms-2">0</span>&nbsp;&nbsp;</a> 
        <div class="text-end"> 
        </div>
        </div>
    </div>
@endsection

<div class="container-fluid " style="width: 97%">
  <div class="row">
    <div class="col-md-12">  
        <div class="card">
          <div class="card-header"> 
                <div class="container-fluid d-flex flex-wrap">  
                {{-- <a href="" class="btn btn-primary btn-sm text-white me-2 mt-2">หนังสือราชการ</a>     --}}
                {{-- <a href="{{url("book/bookmake_index")}}" class="col-4 col-lg-auto mb-lg-0 me-lg-auto btn btn-primary btn-sm text-white me-2 mt-2">หนังสือรับ</a>   --}}
                <button href="" class="col-6 col-lg-auto mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark">หนังสือราชการ</button> 
                <div class="text-end"> 
                    <a href="{{url("po/po_bookindex_retire/".$dataedits->bookrep_id)}}" class="btn btn-primary btn-sm text-white">เกษียณหนังสือ</a>          
                </div>
                </div>
  
                 
          </div>
            <div class="card-body shadow-lg">    
              <div class="row">  

                <div class="col-md-6">  
                        <div class="card-body shadow-lg boxpdf" >   
                            <div class="row">                               
                                <div class="col-md-12">                                            
                                        <div class="fpdf mt-2 text-center" id="pages">
                            
                                                @if($dataedits->bookrep_file == '' || $dataedits->bookrep_file == null)
                                                        ไม่มีข้อมูลไฟล์อัปโหลด 
                                                @else                                                       
                                                    <iframe src="{{ asset('storage/bookrep_pdf/'.$dataedits->bookrep_file) }}" height="100%" width="100%"></iframe>
                                                      
                                                @endif 
                                           
                                            </div>
                                       
                                </div>  
                                
                            </div> 
                                                  
                        </div>
                               
                 
                </div>
                <div class="col-md-6">  
                    <div class="card">
                        <div class="card-body shadow-lg">   
                          
                            <div class="row">
                                <div class="col-md-3 text-center mt-4"> 
                                    <img src="{{ asset('assets/img/crut.png') }}" class="img-fluid hover-shadow" alt="Los Angeles Skyscrapers" width="130px" height="130px"/>
                                   <!-- <img src="http://dekbanbanproject.com/zoffice/public/assets/img/crut.png" class="img-fluid hover-shadow" alt="Los Angeles Skyscrapers" width="130px" height="130px"/> -->
                                </div>
                      
                                <input type="hidden" id="bookrep_repnum" name="bookrep_repnum" class="form-control" value="" readonly/>
                                <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                                <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                                <input type="hidden" id="bookrep_id" name="bookrep_id" value="{{$dataedits->bookrep_id}}"/>
                                
                                <div class="col-md-9">  
                                    <div class="row">
                                        <div class="col-md-6 mt-3"> 
                                            <div class="form-outline bgon">
                                                <input type="text" id="bookrep_recievenum" name="bookrep_recievenum" class="form-control" value="{{$dataedits->bookrep_recievenum}}"/>
                                                <label class="form-label" for="bookrep_repnum">เลขที่รับ</label>
                                            </div> 
                                        </div> 
                                        <div class="col-md-6 mt-3"> 
                                            <div class="form-outline bgon">
                                                <input type="text" id="bookrep_repbooknum" name="bookrep_repbooknum" class="form-control" value="{{$dataedits->bookrep_repbooknum}}"/>
                                                <label class="form-label" for="bookrep_repbooknum">เลขที่หนังสือ</label>
                                            </div> 
                                        </div>
                                       
                                    </div>
        
                                    <div class="row ">
                                        <div class="col-md-6 mt-3"> 
                                            <div class="form-outline bgon">
                                                <input id="bookrep_secret_class_name" name="bookrep_secret_class_name" type="text" class="form-control" value="{{$dataedits->bookrep_secret_class_name}}">
                                                <label class="form-label" for="bookrep_secret_class_name">ชั้นความลับ</label>
                                            </div> 
                                        </div>
                                        <div class="col-md-6 mt-3">   
                                                <div class="form-outline bgon">
                                                    <input id="bookrep_speed_class_name" name="bookrep_speed_class_name" type="text" class="form-control" value="{{$dataedits->bookrep_speed_class_name}}">
                                                    <label class="form-label" for="bookrep_speed_class_name">ชั้นความเร็ว</label>
                                                </div>                                             
                                        </div>                              
                                       
                                    </div>
        
                                    <div class="row ">
                                      <div class="col-md-6 mt-3"> 
                                        <div class="form-outline bgon">
                                          <input id="bookrep_save_date" name="bookrep_save_date" type="date" class="form-control datepicker" value="{{$dataedits->bookrep_save_date}}">
                                          <label class="form-label" for="bookrep_save_date">ลงสมุดบันทึก วันที่</label>
                                      </div> 
                                      </div> 
                                      <div class="col-md-6 mt-3"> 
                                        <div class="form-outline bgon"> 
                                          <input id="bookrep_follow_date" type="date" class="form-control datepicker" name="bookrep_follow_date" value="{{$dataedits->bookrep_follow_date}}">
                                          <label class="form-label" for="bookrep_follow_date">ติดตาม ณ วันที่</label>
                                      </div> 
                                      </div>
                                                        
                                  </div>
        
                                    <div class="row ">
                                        <div class="col-md-6 mt-3"> 
                                            <div class="form-outline bgon">
                                                <input id="bookrep_type_name" name="bookrep_type_name" type="text" class="form-control" value="{{$dataedits->bookrep_type_name}}">
                                                <label class="form-label" for="bookrep_type_name">ประเภทหนังสือ</label>
                                            </div> 
                                        </div> 
                                        <div class="col-md-6 mt-3"> 
                                            <div class="form-outline bgon">
                                                <input id="import_fam_name" name="import_fam_name" type="text" class="form-control" value="{{$dataedits->import_fam_name}}">
                                                <label class="form-label" for="import_fam_name">นำเข้าไว้ในแฟ้ม</label>
                                            </div>  
                                        </div>
                                                       
                                    </div>
                                   
        
        
                                </div>                       
                            </div>
        
                            <div class="row ">
                                <div class="col-md-3 text-end bgc text-white mt-3"> 
                                    ชื่อเรื่อง
                                </div>
                                <div class="col-md-9 mt-3"> 
                                    <div class="form-outline bgon">
                                        <input type="text" id="bookrep_name" name="bookrep_name" class="form-control" value="{{$dataedits->bookrep_name}}"/>
                                        <label class="form-label" for="bookrep_name">ชื่อเรื่อง</label>
                                    </div> 
                                </div>
                            </div>
        
                            <div class="row ">
                                <div class="col-md-3 text-end bgc text-white mt-3"> 
                                    เนื้อเรื่อง
                                </div>
                                <div class="col-md-9 mt-3"> 
                                    <div class="form-outline bgon">
                                        <textarea class="form-control" id="bookrep_story" name="bookrep_story" rows="3">{{$dataedits->bookrep_story}}</textarea>
                                        <label class="form-label" for="bookrep_story">เนื้อเรื่อง</label>
                                    </div>
                                </div>
                            </div>
        
                            <div class="row ">
                                <div class="col-md-3 text-end bgc text-white mt-3"> 
                                    ข้อเสนอประกอบ
                                </div>
                                <div class="col-md-9 mt-3">
                                    <div class="form-outline bgon">
                                        <textarea class="form-control" id="bookrep_assembly" name="bookrep_assembly" rows="3">{{$dataedits->bookrep_assembly}}</textarea>
                                        <label class="form-label" for="bookrep_assembly">
                                            เรื่องเดิม .. , สรุปเรื่อง .. , ข้อมูล กฎระเบียบที่เกี่ยวข้อง .. , ข้อเสนอเพื่อพิจารณา ..
                                        </label> 
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-3 text-end bgc text-white mt-3"> 
                                    ไฟล์ประกอบ 1
                                </div>
                                <div class="col-md-1 ">
                                </div>
                                <div class="col-md-8 mt-3">
                                    <div class="input-group">              
                                            @if ($dataedits->bookrep_file1 != '')
                                                <a href="{{asset('storage/bookrep_pdf/'.$dataedits->bookrep_file1)}}" target="_blank">
                                                    <i class="fa-solid fa-2x fa-file-pdf text-danger me-3"></i> 
                                                </a>                                                                     
                                            @endif
                                      </div>
                                </div>
                               
                            </div>
                            <div class="row ">
                                <div class="col-md-3 text-end bgc text-white mt-3"> 
                                    ไฟล์ประกอบ 2
                                </div>
                                <div class="col-md-1 ">
                                </div>
                                <div class="col-md-8 mt-3">
                                    <div class="input-group">              
                                            @if ($dataedits->bookrep_file2 != '')
                                            <a href="{{asset('storage/bookrep_pdf/'.$dataedits->bookrep_file2)}}" target="_blank"><i class="fa-solid fa-2x fa-file-pdf text-danger "></i> </a>                                 
                                        @endif
                                      </div>
                                </div>
                              
                        </div>
                            <div class="row ">
                                <div class="col-md-3 text-end bgc text-white mt-3"> 
                                    ไฟล์ประกอบ 3
                                </div>
                                <div class="col-md-1 ">
                                </div>
                                <div class="col-md-8 mt-3">
                                    <div class="input-group">               
                                            @if ($dataedits->bookrep_file3 != '')
                                            <a href="{{asset('storage/bookrep_pdf/'.$dataedits->bookrep_file3)}}" target="_blank"><i class="fa-solid fa-2x fa-file-pdf text-danger "></i> </a>                                 
                                            @endif
                                      </div>
                                </div>
                               
                        </div>
                            <div class="row ">
                                <div class="col-md-3 text-end bgc text-white mt-3"> 
                                    ไฟล์ประกอบ 4
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-8 mt-3">
                                    <div class="input-group">              
                                            @if ($dataedits->bookrep_file4 != '')
                                            <a href="{{asset('storage/bookrep_pdf/'.$dataedits->bookrep_file4)}}" target="_blank"><i class="fa-solid fa-2x fa-file-pdf text-danger "></i> </a>                                 
                                        @endif
                                      </div>
                                </div>
                              
                        </div>
                            <div class="row ">
                                <div class="col-md-3 text-end bgc text-white mt-3"> 
                                    ไฟล์ประกอบ 5
                                </div>
                                <div class="col-md-1 ">
                                </div>
                                <div class="col-md-8 mt-3">
                                    <div class="input-group">              
                                            @if ($dataedits->bookrep_file5 != '')
                                            <a href="{{asset('storage/bookrep_pdf/'.$dataedits->bookrep_file5)}}" target="_blank"><i class="fa-solid fa-2x fa-file-pdf text-danger "></i> </a>                                 
                                        @endif
                                      </div>
                                </div>
                               
                        </div>
                            <br> <br> <br> <br>
                            <!-- <div class="col-md-12 mt-3 text-end"> 
                                <div class="form-group"> 
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        บันทึกข้อมูล
                                    </button> 
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
          
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
