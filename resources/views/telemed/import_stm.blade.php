@extends('layouts.upstm')
@section('title', 'PK-OFFICER || Stm')
 
@section('content')

 <br> <br> <br> <br> <br>
    <div class="container mt-5">
      <div class="row">
        <div class="col-lg-12">
         

            {{-- <div class="col-lg-6 align-self-center">
              <div class="owl-carousel owl-banner">
                <div class="item header-text">
                  <h6>Welcome to TeleMedicine</h6>
                  <h2>บริการ <em>พบแพทย์</em> <span>ออนไลน์</span></h2> 
                  <div class="down-buttons">
                    <div class="main-blue-button-hover">
                      <a href="#register">ลงทะเบียน</a>
                    </div>
                    <div class="call-button">
                      <a href="#"><i class="fa fa-phone"></i> 044-861-700</a>
                    </div>
                  </div>
                </div>                
              </div>
            </div> --}}
          <form action="{{ route('s.import_stm_save') }}" method="POST" enctype="multipart/form-data">
            @csrf
              <div class="col-lg-6 align-self-center">
                <div class="mb-3">
                  <label for="formFileLg" class="form-label">Import STM</label>
                  <input class="form-control form-control-lg" id="formFileLg" name="file_" type="file" required>
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
                {{-- <div class="mb-3">  --}}
                  {{-- <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-floppy-disk me-2"></i>
                    บันทึกข้อมูล
                </button> --}}
                    <button type="submit" class="btn btn-info"><i class="fa-solid fa-file-import"></i></button>
                
                {{-- </div> --}}
              </div>
          </form>

    
        </div>
      </div>
    </div>
 

 
 
     
 
@endsection
@section('footer')

<script>
    $(document).ready(function() {
       
    });
</script>
@endsection
