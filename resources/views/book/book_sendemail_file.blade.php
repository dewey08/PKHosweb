

<div class="row">
      <div class="col-md-12">
            {{-- @if($dataedit->bookrep_file == '' || $dataedit->bookrep_file == null)
                  ไม่มีข้อมูลไฟล์อัปโหลด 
            @else
            <iframe src="{{ asset('storage/bookrep_pdf/'.$dataedit->bookrep_file) }}" height="900px" width="100%"></iframe>
            @endif   --}}
            <iframe src="{{ asset('storage/bookrep_pdf' .$dataedit->bookrep_file ) }}" height="900px" width="100%"></iframe>
      </div>
</div> 

