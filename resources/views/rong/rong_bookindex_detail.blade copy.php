@extends('layouts.userrong')
@section('title','ZOffice || หัวหน้าบริหาร')
@section('content')
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
    }
    @keyframes pageIn{
    0%{
        transform: translateX(-300px);
        opacity: 0;
    }
    100%{
        transform: translateX(0px);
        opacity: 1;
    }
    } */
    
    .fpdf{
        width:auto;
        height:695px;
        /* height: auto; */
        margin:0;
        
        overflow:scroll;
        background-color: #FFFFFF;
    }
 

</style>
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
          <div class="card-header">
            <div class="row">
              <div class="col-md-2">
                {{ __('หนังสือราชการ') }}
              </div>
              <div class="col-md-8">
                
              </div>
              <div class="col-md-2">
                <a href="{{url("rong/rong_bookindex_retire/".$dataedits->bookrep_id)}}" class="btn btn-primary btn-sm text-white me-2">เกษียณหนังสือ</a> 
              </div>
            </div>
                    
         
          </div>
            <div class="card-body shadow-lg">    
              <div class="row">  

                <div class="col-md-6">  
                    <div class="card boxpdf" >
        
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
                                        <div class="col-md-6"> 
                                            <div class="form-outline ">
                                                <input type="text" id="bookrep_recievenum" name="bookrep_recievenum" class="form-control" value="{{$dataedits->bookrep_recievenum}}"/>
                                                <label class="form-label" for="bookrep_repnum">เลขที่รับ</label>
                                            </div> 
                                        </div> 
                                        <div class="col-md-6"> 
                                            <div class="form-outline ">
                                                <input type="text" id="bookrep_repbooknum" name="bookrep_repbooknum" class="form-control" value="{{$dataedits->bookrep_repbooknum}}"/>
                                                <label class="form-label" for="bookrep_repbooknum">เลขที่หนังสือ</label>
                                            </div> 
                                        </div>
                                       
                                    </div>
        
                                    <div class="row mt-3">
                                        <div class="col-md-6"> 
                                            <select id="bookrep_secret_class_id" name="bookrep_secret_class_id" class="form-control" style="width: 100%">                      
                                                <option value=""></option>
                                                  @foreach ($secret_class as $sec )
                                                  @if ($dataedits->bookrep_secret_class_id == $sec->secret_class_id)
                                                  <option value="{{ $sec->secret_class_id}}" selected>{{ $sec->secret_class_name}}</option>
                                                  @else
                                                  <option value="{{ $sec->secret_class_id}}">{{ $sec->secret_class_name}}</option>
                                                  @endif
                                                   
                                                  @endforeach 
                                              </select> 
                                        </div>
                                        <div class="col-md-6">  
                                            <div class="form-group">
                                                <select id="bookrep_speed_class_id" name="bookrep_speed_class_id" class="form-control" style="width: 100%">                      
                                                  <option value=""></option>
                                                    @foreach ($speed_class as $items )
                                                    @if ($dataedits->bookrep_speed_class_id == $items->speed_class_id)
                                                    <option value="{{ $items->speed_class_id}}" selected>{{ $items->speed_class_name}}</option>
                                                    @else
                                                    <option value="{{ $items->speed_class_id}}">{{ $items->speed_class_name}}</option>
                                                    @endif
                                                      
                                                    @endforeach 
                                                </select> 
                                            </div>
                                        </div>                              
                                       
                                    </div>
        
                                    <div class="row mt-3">
                                      <div class="col-md-6"> 
                                        <div class="form-outline">
                                          <input id="bookrep_save_date" name="bookrep_save_date" type="date" class="form-control datepicker" value="{{$dataedits->bookrep_save_date}}">
                                          <label class="form-label" for="bookrep_save_date">ลงสมุดบันทึก วันที่</label>
                                      </div> 
                                      </div> 
                                      <div class="col-md-6"> 
                                        <div class="form-outline"> 
                                          <input id="bookrep_follow_date" type="date" class="form-control datepicker" name="bookrep_follow_date" value="{{$dataedits->bookrep_follow_date}}">
                                          <label class="form-label" for="bookrep_follow_date">ติดตาม ณ วันที่</label>
                                      </div> 
                                      </div>
                                                        
                                  </div>
        
                                    <div class="row mt-3">
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <select id="bookrep_type_id" name="bookrep_type_id" class="form-control show_type" style="width: 100%">                      
                                                  <option value=""></option>
                                                    @foreach ($book_type as $type )
                                                    @if ($dataedits->bookrep_type_id == $type->booktype_id)
                                                    <option value="{{ $type->booktype_id}}" selected>{{ $type->booktype_name}}</option>
                                                    @else
                                                    <option value="{{ $type->booktype_id}}">{{ $type->booktype_name}}</option>
                                                    @endif
                                                      
                                                    @endforeach 
                                                </select> 
                                            </div>
                                        </div> 
                                        <div class="col-md-6"> 
                                          <div class="form-group">
                                            <select id="bookrep_import_fam" name="bookrep_import_fam" class="form-control show_fam" style="width: 100%">                      
                                                <option value=""></option>
                                                  @foreach ($book_import_fam as $import )
                                                  @if ($dataedits->bookrep_import_fam == $import->import_fam_id)
                                                  <option value="{{ $import->import_fam_id}}" selected>{{ $import->import_fam_name}}</option>
                                                  @else
                                                  <option value="{{ $import->import_fam_id}}">{{ $import->import_fam_name}}</option>
                                                  @endif
                                                   
                                                  @endforeach 
                                              </select> 
                                        </div>
                                        </div>
                                                       
                                    </div>
                                   
        
        
                                </div>                       
                            </div>
        
                            <div class="row mt-2">
                                <div class="col-md-3 text-end bgc text-white"> 
                                    ชื่อเรื่อง
                                </div>
                                <div class="col-md-9 mt-1"> 
                                    <div class="form-outline ">
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
                                    <div class="form-outline">
                                        <textarea class="form-control" id="bookrep_story" name="bookrep_story" rows="3">{{$dataedits->bookrep_story}}</textarea>
                                        <label class="form-label" for="bookrep_story">เนื้อเรื่อง</label>
                                    </div>
                                </div>
                            </div>
        
                            <div class="row mt-1">
                                <div class="col-md-3 text-end bgc text-white"> 
                                    ข้อเสนอประกอบ
                                </div>
                                <div class="col-md-9 mt-1">
                                    <div class="form-outline">
                                        <textarea class="form-control" id="bookrep_assembly" name="bookrep_assembly" rows="3">{{$dataedits->bookrep_assembly}}</textarea>
                                        <label class="form-label" for="bookrep_assembly">
                                            เรื่องเดิม .. , สรุปเรื่อง .. , ข้อมูล กฎระเบียบที่เกี่ยวข้อง .. , ข้อเสนอเพื่อพิจารณา ..
                                        </label> 
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-3 text-end bgc text-white"> 
                                    ไฟล์ประกอบ 1
                                </div>
                                <div class="col-md-1 mt-1">
                                </div>
                                <div class="col-md-8 mt-1">
                                    <div class="input-group">              
                                            @if ($dataedits->bookrep_file1 != '')
                                                <a href="{{asset('storage/bookrep_pdf/'.$dataedits->bookrep_file1)}}" target="_blank">
                                                    <i class="fa-solid fa-2x fa-file-pdf text-danger me-3"></i> 
                                                </a>                                                                     
                                            @endif
                                      </div>
                                </div>
                               
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-3 text-end bgc text-white"> 
                                    ไฟล์ประกอบ 2
                                </div>
                                <div class="col-md-1 mt-1">
                                </div>
                                <div class="col-md-8 mt-1">
                                    <div class="input-group">              
                                            @if ($dataedits->bookrep_file2 != '')
                                            <a href="{{asset('storage/bookrep_pdf/'.$dataedits->bookrep_file2)}}" target="_blank"><i class="fa-solid fa-2x fa-file-pdf text-danger "></i> </a>                                 
                                        @endif
                                      </div>
                                </div>
                              
                        </div>
                            <div class="row mt-1">
                                <div class="col-md-3 text-end bgc text-white"> 
                                    ไฟล์ประกอบ 3
                                </div>
                                <div class="col-md-1 mt-1">
                                </div>
                                <div class="col-md-8 mt-1">
                                    <div class="input-group">               
                                            @if ($dataedits->bookrep_file3 != '')
                                            <a href="{{asset('storage/bookrep_pdf/'.$dataedits->bookrep_file3)}}" target="_blank"><i class="fa-solid fa-2x fa-file-pdf text-danger "></i> </a>                                 
                                            @endif
                                      </div>
                                </div>
                               
                        </div>
                            <div class="row mt-1">
                                <div class="col-md-3 text-end bgc text-white"> 
                                    ไฟล์ประกอบ 4
                                </div>
                                <div class="col-md-1 mt-1">
                                </div>
                                <div class="col-md-8 mt-1">
                                    <div class="input-group">              
                                            @if ($dataedits->bookrep_file4 != '')
                                            <a href="{{asset('storage/bookrep_pdf/'.$dataedits->bookrep_file4)}}" target="_blank"><i class="fa-solid fa-2x fa-file-pdf text-danger "></i> </a>                                 
                                        @endif
                                      </div>
                                </div>
                              
                        </div>
                            <div class="row mt-1">
                                <div class="col-md-3 text-end bgc text-white"> 
                                    ไฟล์ประกอบ 5
                                </div>
                                <div class="col-md-1 mt-1">
                                </div>
                                <div class="col-md-8 mt-1">
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
