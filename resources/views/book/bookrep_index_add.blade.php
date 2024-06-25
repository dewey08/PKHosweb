@extends('layouts.book')
@section('title', 'PK-OFFICER || งานสารบรรณ')
<script src="{{ asset('js/signature.js') }}"></script>

@section('content')
<script>
  function TypeAdmin() {
      window.location.href = '{{ route('index') }}';
  }
</script>
<script>
    function addtype() {
              var bookrep_type = document.getElementById("BOOK_TYPE_INSERT").value;
            
              var _token = $('input[name="_token"]').val();
              $.ajax({
                  url: "{{route('book.addtype')}}",
                  method: "GET",
                  data: {
                    bookrep_type: bookrep_type,
                      _token: _token
                  },
                  success: function (result) {
                      $('.show_type').html(result);
                  }
              })
          }

    function addfam() {
        var book_fam = document.getElementById("BOOK_FAM_INSERT").value;
    
        var _token = $('input[name="_token"]').val();
        $.ajax({ 
            url: "{{route('book.addfam')}}",
            method: "GET",
            data: {
                book_fam: book_fam,
                _token: _token
            },
            success: function (result) {
                $('.show_fam').html(result);
            }
        })
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
  use App\Http\Controllers\StaticController;
  use App\Models\Orginfo;

    $refnumber = BookController::refnumber(); 
    date_default_timezone_set("Asia/Bangkok");
    $datenow = date('Y-m-d H:i:s');

    $org =  Orginfo::where('orginfo_id','=',1)->first();  
 
  ?>

  <style>
    body{
        font-size:13px;
    }
    .btn{
       font-size:14px;
     }
     .imput {
       font-size:13px;
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
     .page{
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
          /* width:1024px; */
          height:755px;
          width:1024px;
          /* height:auto; */
          margin:0;
          
          overflow:scroll;
          background-color: #DAD8D8;
      }
      @media (min-width: 950px) {
        .modal {
            --bs-modal-width: 950px;
        }
    }

    @media (min-width: 1500px) {
        .modal-xls {
            --bs-modal-width: 1500px;
        }
    }

    @media (min-width: 1500px) {
        .container-fluids {
            width: 1500px;
            margin-left: auto;
            margin-right: auto;
            margin-top: auto;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right
        }

        .dataTables_wrapper .dataTables_length {
            float: left
        }

        .dataTables_info {
            float: left;
        }

        .dataTables_paginate {
            float: right
        }

        .custom-tooltip {
            --bs-tooltip-bg: var(--bs-primary);
        }

        .table thead tr th {
            font-size: 14px;
        }

        .table tbody tr td {
            font-size: 13px;
        }

        .menu {
            font-size: 13px;
        }
    }

    .hrow {
        height: 2px;
        margin-bottom: 9px;
    }
  
  </style>

 
<div class="container-fluid" >
    <div class="row">      
        <div class="col-md-6">  
            <div class="card" >
                <form class="custom-validation" action="{{ route('book.bookrep_index_save') }}" method="POST" id="book_saveForm" enctype="multipart/form-data">
                    @csrf    
                <div class="card-body shadow-lg boxpdf" >   
                    <div class="row"> 
                        <div class="col-md-12">
                            <div class="input-group text-center"> 
                                <input type="file" class="form-control" id="pdfupload" name="pdfupload" accept="application/pdf" />
                           
                                <div id="zoom-percent" style="text-align: right;background-color: #E6E6FA;">90</div>
   
                                <a id="zoom-in" class="btn btn-primary btn-sm text-white" ><i class="fa fa-search-plus mt-2"></i></a>
                                <a id="zoom-out" class="btn btn-primary btn-sm text-white" ><i class="fa fa-search-minus mt-2"></i></a>
                                <a id="zoom-reset" class="btn btn-primary btn-sm text-white" ><i class="fa fa-search-minus mt-2"></i></a>                        
                           
                                <div class="fpdf mt-2" id="pages"></div>

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
                        <div class="col-md-3 text-center mt-5"> 
                            <img src="{{ asset('assets/img/crut.png') }}" class="img-fluid hover-shadow" alt="Los Angeles Skyscrapers" width="110px" height="110px"/>
                        </div>
              
                        <input type="hidden" id="bookrep_repnum" name="bookrep_repnum" class="form-control" value="{{$refnumber}}" readonly/>
                        <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                        <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                        
                        <div class="col-md-9">  
                            <div class="row mt-3">
                                <div class="col-md-4 mt-3"> 
                                    <div class="form-outline ">
                                        <label class="form-label" for="bookrep_repnum">เลขที่รับ</label>
                                        <input type="text" id="bookrep_recievenum" name="bookrep_recievenum" class="form-control form-control-sm" placeholder="เลขที่รับ"/>                                        
                                    </div> 
                                </div> 
                                <div class="col-md-4 mt-3"> 
                                    <div class="form-outline ">
                                        <label class="form-label" for="bookrep_repbooknum">เลขที่หนังสือ</label>
                                        <input type="text" id="bookrep_repbooknum" name="bookrep_repbooknum" class="form-control form-control-sm" placeholder="เลขที่หนังสือ"/>                                       
                                    </div> 
                                </div>
                                <div class="col-md-4 mt-3"> 
                                    <div class="form-outline">
                                        <label class="form-label" for="bookrep_save_date">ลงสมุดบันทึก วันที่</label>
                                        <input id="bookrep_save_date" name="bookrep_save_date" type="date" class="form-control form-control-sm datepicker" name="start_date" placeholder="ลงสมุดบันทึก วันที่">                                        
                                    </div>                                   
                                </div> 
                            </div>

                            <div class="row ">
                                <div class="col-md-4 mt-3"> 
                                    <label class="form-label" for="bookrep_repbooknum">ชั้นความลับ</label>
                                        <select id="bookrep_secret_class_id" name="bookrep_secret_class_id" class="form-control" style="width: 100%">                      
                                            <option value=""></option>
                                                @foreach ($secret_class as $sec )
                                                    <option value="{{ $sec->secret_class_id}}">{{ $sec->secret_class_name}}</option>
                                                @endforeach 
                                        </select> 
                                </div>
                                <div class="col-md-4 mt-3">  
                                    <div class="form-group">
                                        <label class="form-label" for="bookrep_repbooknum">ชั้นความเร็ว</label>
                                        <select id="bookrep_speed_class_id" name="bookrep_speed_class_id" class="form-control" style="width: 100%">                      
                                          <option value=""></option>
                                            @foreach ($speed_class as $items )
                                              <option value="{{ $items->speed_class_id}}">{{ $items->speed_class_name}}</option>
                                            @endforeach 
                                        </select> 
                                    </div>
                                </div>                              
                                <div class="col-md-4 mt-3"> 
                                    <div class="form-outline"> 
                                        <label class="form-label" for="bookrep_follow_date">ติดตาม ณ วันที่</label>
                                        <input id="bookrep_follow_date" type="date" class="form-control form-control-sm datepicker" name="start_date">                                       
                                    </div> 
                                </div> 
                            </div>                          

                            <div class="row ">
                                <div class="col-md-6 mt-3"> 
                                    <div class="form-group">
                                        <select id="bookrep_type_id" name="bookrep_type_id" class="form-control show_type" style="width: 100%">                      
                                          <option value=""></option>
                                            @foreach ($book_type as $type )
                                              <option value="{{ $type->booktype_id}}">{{ $type->booktype_name}}</option>
                                            @endforeach 
                                        </select> 
                                    </div>
                                </div> 
                                <div class="col-md-4 mt-3"> 
                                    <div class="form-outline bga">
                                        {{-- <label class="form-label" for="BOOK_TYPE_INSERT">เพิ่มประเภทหนังสือ</label> --}}
                                        <input type="text" id="BOOK_TYPE_INSERT" name="BOOK_TYPE_INSERT" class="form-control form-control-sm shadow"/>
                                        
                                    </div> 
                                </div>
                                <div class="col-md-1 mt-3"> 
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="addtype();">
                                            เพิ่ม
                                        </button> 
                                    </div>
                                </div>                      
                            </div>
                            <div class="row ">
                                <div class="col-md-6 mt-3"> 
                                    <div class="form-group">
                                        <select id="bookrep_import_fam" name="bookrep_import_fam" class="form-control show_fam" style="width: 100%">                      
                                            <option value=""></option>
                                              @foreach ($book_import_fam as $import )
                                                <option value="{{ $import->import_fam_id}}">{{ $import->import_fam_name}}</option>
                                              @endforeach 
                                          </select> 
                                    </div>
                                </div> 
                                <div class="col-md-4 mt-3"> 
                                    <div class="form-outline bga">
                                        <input type="text" id="BOOK_FAM_INSERT" name="BOOK_FAM_INSERT" class="form-control form-control-sm shadow" />
                                        {{-- <label class="form-label" for="bookrep_recievenum">เพิ่มเข้าไว้ในแฟ้ม</label> --}}
                                    </div> 
                                </div>
                                <div class="col-md-1 mt-3"> 
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="addfam();">
                                            เพิ่ม
                                        </button> 
                                    </div>
                                </div>                      
                            </div>


                        </div>                       
                    </div>

                    <div class="row  ">
                        <div class="col-md-3 text-end bgc text-white mt-3"> 
                            ชื่อเรื่อง
                        </div>
                        <div class="col-md-9 mt-3"> 
                            <div class="form-outline ">
                                <input type="text" id="bookrep_name" name="bookrep_name" class="form-control form-control-sm" />
                                {{-- <label class="form-label" for="bookrep_name">ชื่อเรื่อง</label> --}}
                            </div> 
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-md-3 text-end bgc text-white mt-3"> 
                            เนื้อเรื่อง
                        </div>
                        <div class="col-md-9 mt-3"> 
                            <div class="form-outline">
                                <textarea class="form-control" id="bookrep_story" name="bookrep_story" rows="2"></textarea>
                                {{-- <label class="form-label" for="bookrep_story">เนื้อเรื่อง</label> --}}
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-md-3 text-end bgc text-white mt-3"> 
                            ข้อเสนอประกอบ
                        </div>
                        <div class="col-md-9 mt-3">
                            <div class="form-outline">
                                <textarea class="form-control" id="bookrep_assembly" name="bookrep_assembly" rows="2"></textarea>
                                {{-- <label class="form-label" for="bookrep_assembly">
                                    เรื่องเดิม .. , สรุปเรื่อง .. , ข้อมูล กฎระเบียบที่เกี่ยวข้อง .. , ข้อเสนอเพื่อพิจารณา ..
                                </label>  --}}
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-md-3 text-end bgc text-white mt-3"> 
                            ไฟล์ประกอบ 1
                        </div>
                        <div class="col-md-9 mt-3">
                            <div class="input-group"> 
                                <input type="file" class="form-control" id="bookrep_file1" name="bookrep_file1"/>
                              </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-md-3 text-end bgc text-white mt-3"> 
                            ไฟล์ประกอบ 2
                        </div>
                        <div class="col-md-9 mt-3">
                            <div class="input-group"> 
                                <input type="file" class="form-control" id="bookrep_file2" name="bookrep_file2"/>
                              </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-md-3 text-end bgc text-white mt-3"> 
                            ไฟล์ประกอบ 3
                        </div>
                        <div class="col-md-9 mt-3">
                            <div class="input-group"> 
                                <input type="file" class="form-control" id="bookrep_file3" name="bookrep_file3"/>
                              </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-md-3 text-end bgc text-white mt-3"> 
                            ไฟล์ประกอบ 4
                        </div>
                        <div class="col-md-9 mt-3">
                            <div class="input-group"> 
                                <input type="file" class="form-control" id="bookrep_file4" name="bookrep_file4"/>
                              </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-md-3 text-end bgc text-white mt-3"> 
                            ไฟล์ประกอบ 5
                        </div>
                        <div class="col-md-9 mt-3">
                            <div class="input-group"> 
                                <input type="file" class="form-control" id="bookrep_file5" name="bookrep_file5"/>
                              </div>
                        </div>
                    </div>
                    <hr> 

                    <div class="col-md-12 mt-3 text-end"> 
                        <div class="form-group">                            
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                บันทึกข้อมูล
                            </button> 
                            <a href="{{url('book/bookmake_index')}}" class="btn btn-danger btn-sm">
                                <i class="fa-solid fa-xmark me-2"></i>
                                ยกเลิก</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>

@endsection
@section('footer') 


<script src="{{ asset('pdfupload/pdf_up.js') }}"></script> 
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script src="{{ asset('js/gcpdfviewer.js') }}"></script> 


<script>
    
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




