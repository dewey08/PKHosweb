@extends('layouts.appmail')
@section('title', 'ZOFFice || Book-Staff')
@section('content')
<form action="{{url('send_mailnewbook')}}" method="POST">
      @csrf
<div class="container">
     
            <div class="row">             
           
                <input type="hidden" id="bookrep_id" name="bookrep_id" value="{{$dataedit->bookrep_id}}">
                <input type="hidden" id="bookrep_file" name="bookrep_file" value="{{$dataedit->bookrep_file}}">
                <br>
                  <div class="col-md-3"> 
                    <input type="text" name="email" id="email" class="form-control" placeholder="To email">
                  </div> 
                <br>
                  <div class="col-md-3"> 
                    <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                  </div>
                <br>
                  <div class="col-md-5"> 
                    <input type="text" name="content" id="content" class="form-control" placeholder="Content">
                  </div>
                <br>
                  <div class="col-md-1">
                  <button type="submit" class="btn btn-primary">
                        ส่ง 
                  </button> 
                  </div> 
            </div> 
   
</div>
</div>
 
 

<div class="row">
      <div class="col-md-12">
            @if($dataedit->bookrep_file == '' || $dataedit->bookrep_file == null)
                  ไม่มีข้อมูลไฟล์อัปโหลด 
            @else
            <iframe src="{{ asset('storage/bookrep_pdf/'.$dataedit->bookrep_file) }}" height="900px" width="100%"></iframe>
            @endif  
      </div>
</div> 
</form> 
@endsection
