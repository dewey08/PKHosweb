

<center>

  
<div class="block-content block-content-full">
<div class="row">
   <div class="col-md-7" style="text-align: left">
 
   <div style="text-align:center">

   @if($infomation->bookrep_file == '' || $infomation->bookrep_file == null)
         ไม่มีข้อมูลไฟล์อัปโหลด 
   @else

    <iframe src="{{ asset('storage/bookrep_pdf/'.$infomation->bookrep_file) }}" height="100%" width="100%"></iframe>

   @endif

  
</div>

 



</body>
     
