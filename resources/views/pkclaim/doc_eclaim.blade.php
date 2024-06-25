@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || FS EClaim')
 
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
    $ynow = date('Y')+543;
    $yb =  date('Y')+542;
    ?>
     
     <style>
        #button {
            display: block;
            margin: 20px auto;
            padding: 30px 30px;
            background-color: #eee;
            border: solid #ccc 1px;
            cursor: pointer;
        }

        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
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

        .is-hide {
            display: none;
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
          height:815px;
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

    }
        .modal-dialog {
            max-width: 60%;
        }
        .modal-dialog-slideout {
            min-height: 100%;
            margin: 0 0 0 ;
            background: #fff;
        }
        /* .modal.fade .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(100%, 0)scale(1);
            transform: translate(100%, 0)scale(1);
        } */
        .modal.fade .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(100%, 0)scale(30);
            transform: translate(100%, 0)scale(5);
        }

        .modal.fade.show .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(0, 0);
            transform: translate(0, 0);
            display: flex;
            align-items: stretch;
            -webkit-box-align: stretch;
            height: 100%;
        }

        .modal.fade.show .modal-dialog.modal-dialog-slideout .modal-body {
            overflow-y: auto;
            overflow-x: hidden;
        }

        .modal-dialog-slideout .modal-content {
            border: 0;
        }

        .modal-dialog-slideout .modal-header,
        .modal-dialog-slideout .modal-footer {
            height: 4rem;
            display: block;
        }
        .datepicker {
            z-index: 2051 !important;
        }
    </style>

    <?php
        $ynow = date('Y')+543;
        $yb =  date('Y')+542;
    ?>

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
        <div class="col-md-3">
            <h4 class="card-title" style="color:rgb(252, 161, 119)">Detail Claim</h4>
            <p class="card-title-desc">รายละเอียดข้อมูล การเคลม</p>
        </div> 
        <div class="col"></div> 
    </div>
        

        <div class="row ">    
            <div class="col-xl-12 col-md-12">
                <div class="card cardclaim">   
                        <div class="table-responsive mt-3 ms-2 me-2 mb-3">
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                               <thead>
                                    <tr> 
                                        <th class="text-center" width="5%">รหัส</th> 
                                        <th class="text-center">รายการ</th>
                                        <th class="text-center" width="5%">ประเภท</th> 
                                        <th class="text-center" width="10%">โปรแกรม</th> 
                                        <th class="text-center" width="7%">ผู้รับผิดชอบ</th> 
                                        <th class="text-center" width="7%">เอกสาร</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ii = 1; ?>
                                    @foreach ($datashow as $item2) 
                                    <tr id="tr_{{$item2->icode}}">   
                                        <td class="text-center" width="5%">{{ $item2->icode }}</td> 
                                        <td class="text-start">{{ $item2->detail }}</td> 
                                        <td class="text-center">{{ $item2->type }}</td> 
                                        <td class="text-center" width="10%">{{ $item2->program }}</td> 
                                        <td class="text-center" width="7%">{{ $item2->pm }}</td> 
                                        <td class="text-center text-danger" width="7%">
                                            <a  data-bs-toggle="modal" data-bs-target="#exampleModal{{$item2->icode}}">
                                                <i class="fa-regular fa-hand-point-up"></i>
                                                {{ $item2->doc }}
                                            </a> 
                                            {{-- class="btn-icon btn-shadow btn-dashed btn btn-outline-danger"  --}}
                                        </td>    
                                    </tr>

                                    <div class="modal fade" id="exampleModal{{$item2->icode}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-slideout">
                                            <div class="modal-content"> 
                                                <div class="modal-header"> 
                                                    
                                                </div>  
                                                <div class="modal-body"> 
                                                    {{-- <img src="{{ asset('doc_claim/'.$item2->icode.'.PNG') }}" height="auto" width="auto" >  --}}
                                                    {{-- <input type="file" class="form-control" id="pdfupload" name="pdfupload" accept="application/pdf" />  --}}
                                                    {{-- <div id="zoom-percent" style="text-align: right;background-color: #E6E6FA;">90</div> --}}
   
                                                        {{-- <a id="zoom-in" class="btn btn-primary btn-sm text-white" ><i class="fa fa-search-plus"></i></a> --}}
                                                        {{-- <a id="zoom-out" class="btn btn-primary btn-sm text-white" ><i class="fa fa-search-minus"></i></a> --}}
                                                        {{-- <a id="zoom-reset" class="btn btn-primary btn-sm text-white" ><i class="fa fa-search-minus"></i></a>      --}}
                                                        <div class="fpdf mt-2" id="pages">
                        
                                                        
                                                                <iframe src="{{ asset('doc_claim/'.$item2->icode.'.pdf') }}" height="100%" width="100%"></iframe>
                                                        
                                                
                                                    
                                                        </div>   
                                                    {{-- </div>        --}}
                                                </div>         
                                            </div>
                                        </div>
                                    </div>

                                    @endforeach
                                </tbody>
                            </table>
                        </div> 
                </div>
            </div> 
        </div>

    </div>


   

@endsection
@section('footer')
  
    <script src="{{ asset('pdfupload/pdf_up.js') }}"></script> 
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="{{ asset('js/gcpdfviewer.js') }}"></script> 
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#p4p_work_month').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            }); 
            
        });
    </script>
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
