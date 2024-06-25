<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
    <style>
        @font-face {
                    font-family: 'THSarabunNew';
            src: url('fonts/thsarabunnew-webfont.eot');
            src: url('fonts/thsarabunnew-webfont.eot?#iefix') format('embedded-opentype'),
                url('fonts/thsarabunnew-webfont.woff') format('woff'),
                url('fonts/thsarabunnew-webfont.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }        
        @font-face {
            font-family: 'THSarabunNew';
            src: url('fonts/thsarabunnew_bolditalic-webfont.eot');
            src: url('fonts/thsarabunnew_bolditalic-webfont.eot?#iefix') format('embedded-opentype'),
                url('fonts/thsarabunnew_bolditalic-webfont.woff') format('woff'),
                url('fonts/thsarabunnew_bolditalic-webfont.ttf') format('truetype');
            font-weight: bold;
            font-style: italic;
        }
        @font-face {
            font-family: 'THSarabunNew';
            src: url('fonts/thsarabunnew_italic-webfont.eot');
            src: url('fonts/thsarabunnew_italic-webfont.eot?#iefix') format('embedded-opentype'),
                url('fonts/thsarabunnew_italic-webfont.woff') format('woff'),
                url('fonts/thsarabunnew_italic-webfont.ttf') format('truetype');
            font-weight: normal;
            font-style: italic;
        }
        @font-face {
            font-family: 'THSarabunNew';
            src: url('fonts/thsarabunnew_bold-webfont.eot');
            src: url('fonts/thsarabunnew_bold-webfont.eot?#iefix') format('embedded-opentype'),
                url('fonts/thsarabunnew_bold-webfont.woff') format('woff'),
                url('fonts/thsarabunnew_bold-webfont.ttf') format('truetype');
            font-weight: bold;
            font-style: normal;
        }
        body {
            font-family: "THSarabunNew";
            font-size: 12px;
            line-height: 0.8;  
            padding: 10.00pt 7.1732pt 7.1732pt 40.00pt;             
        }
        
        .font-content{
            font-family: "THSarabunNew";
            font-size: 13px;
        }
    </style>

<body>  

<div class="container">
    <div class="col-md-12">
        <div class="row">
            <div for="" style="margin-top:3px; text-align:center; font-size:20px;">
                <b>ใบแจ้งซ่อม</b>
            </div>
            <div for=""style="font-size:18px; margin-top:3px; text-align: center;">
                {{ $org_name }}
            </div>
        </div>
    </div>
    <div class="col-md-12" style="margin-top:3px;">
        <span>หน่วยงานผู้แจ้งซ่อม : </span>
        <span style="margin-left:50px;"><b>{{$informrepair_index->HR_DEPARTMENT_SUB_SUB_NAME}}</b></span>
        <span style="margin-left:50px;">เบอร์โทร : </span>
        <span><b>....................................................</b></span>
    </div>
    <div class="col-md-12">
        <div class="row">
            <span><hr width="100%" size="3"></span>
        </div>
    </div>
    <div class="col-md-12 font-content">
        <span><b>ส่่วนที่ 1 ผู้แจ้ง</b></span>
        <span style="margin-left: 30px;">เลขที่ออก :</span>
        <span><b>{{$informrepair_index->REPAIR_ID}}</b></span>
        <span style="margin-left: 30px;">วันที่ :</span>
        <span><b>{{DateThai($informrepair_index->DATE_TIME_REQUEST)}}</b></span>
        <span style="margin-left: 30px;">เวลา :</span>
        <span><b>{{date("H:i น.",strtotime($informrepair_index->DATE_TIME_REQUEST))}}</b></span>
    </div>
    <div class="col-md-12 font-content">
        <span>แจ้งซ่อม : </span>
        <span style="margin-left: 50px;"><b>{{$informrepair_index->REPAIR_NAME}}</b></span>
        <span style="margin-left: 50px;">ยี่ห้อ/รุ่น : </span>
        <span>.......................</span>
    </div>
    <div class="col-md-12 font-content">
        <span>หมายเลขครุภัณฑ์ : </span>
        <span style="margin-left:50px;">{{$informrepair_index->ARTICLE_NUM}}</span>
    </div>
    <div class="col-md-12 font-content">
        <span>อาการ :</span>
        <span><b>{{$informrepair_index->SYMPTOM}}</b></span>
    </div>
    <br><br>
    <div class="col-md-12 font-content">
        <span style="margin-left: 190px; margin-top:50px;">ผู้แจ้งซ่อม</span>
        <span style="margin-left: 200px; margin-top:50px;">หัวหน้าหน่วยงาน</span>
    </div>
    <div class="col-md-12">
        <span style="margin-left: 80px;">({{$informrepair_index->USRE_REQUEST_NAME}})</span>
        <span style="margin-left: 140px;">({{$headdep->HR_FNAME}} {{$headdep->HR_LNAME}})</span>
    </div><br>
    <div class="col-md-12">
        <span><hr width="100%" size="3"></span>
    </div>
    <div class="col-md-12">
        <span><b>ส่วนที่ 2 ช่าง</b></span>
        <span style="margin-left: 50px;">เลชที่ใบแจ้งซ่อม ....................</span>
        <span style="margin-left: 50px;">วันที่ .................</span>
        <span style="margin-left: 50px;">เวลา .................</span>
    </div>
    <div class="col-md-12">
        <span style="margin-left: 130px;">ความเร่งด่วน</span>
        <span style="margin-left: 50px;">[      ] ฉุกเฉิน</span>
        <span style="margin-left: 50px;">[      ] เร่งด่วน</span>
        <span style="margin-left: 50px;">[      ] ปกติ</span>
    </div><br>
    <div class="col-md-12">
        <span>รายละเอียดการตรวจซ่อมที่พบ/ความเห็นของช่าง</span><br>
        <span>{{$informrepair_index->REPAIR_COMMENT}}</span><br>
        <span>รายการวัสดุอุปกรณ์ที่ใช้</span><br>
        <span>
            @foreach ($infoservices as $infoservice) 
              - {{ $infoservice->REPAIR_SERVICE_NAME}} <br>
            @endforeach 
        </span>
    </div>
    <div class="col-md-12">
        <span>ผลการตรวจซ่อม</span>
        <span style="margin-left: 20px;">1.[     ]</span>
        <span style="margin-left: 20px;"><b>ซ่อมได้</b></span>
        <span>พร้อมส่งคืนหน่วยงาน</span>
        <span style="margin-left: 10px;">วันที่ ....................</span>
        <span style="margin-left: 10px;">ผู้รับของ .................</span>
    </div>
    <div class="col-md-12">
        <span style="margin-left: 110px;">2.[      ]</span>
        <span style="margin-left: 20px;"><b>ส่งซ่อมภายนอก</b></span>
        <span style="margin-left: 5px;">ชื่อร้าน/บริษัท ..............................</span> <br>
        <span style="margin-left: 110px;">รายการอุปกรณ์ที่ส่ง</span><br>
        <span style="margin-left: 110px;">วันที่.....................</span>
        <span style="margin-left: 20px;">ผู้รับ ....................</span>
    </div>
    <div class="col-md-12">
        <span style="margin-left: 110px;">3.[      ]</span>
        <span><b>รออะไหล่</b></span>
        <span>.....................</span><br>
        <span style="margin-left: 110px;">4.[      ]</span>
        <span><b>รอจำหน่ายเนื่องจาก</b></span>
        <span>....................</span><br>
        <span style="margin-left: 110px;">ช่างแจ้งหน่วยงานที่แจ้ง</span>
        <span style="margin-left: 10px;">วันที่ .......................</span>
        <span style="margin-left: 10px;">ผู้รับเรื่อง .......................</span>
    </div>

    <div class="col-md-12">
        <span style="margin-left: 50px;">ช่าง</span>
        <span style="margin-left: 200px;">ความคิดเห็น</span>
        <span style="margin-left: 200px;">ผู้อนุมัติ</span>
    </div>
    <br><br>
    <div class="col-md-12" >
        <span style="margin-left: 20px;">..........................</span>
        <span style="margin-left: 150px;">..........................</span>
        <span style="margin-left: 150px;">
        <span>[  ] อนุมัติ</span>
        <span>[  ] ไม่อนุมัติ</span>
        </span>
    </div>
    <div class="col-md-12">
        <span style="margin-left: 10px;">ผู้ช่วยทำการตรวจสอบ</span>
        <span style="margin-left: 100px;">(นายสถาพร ป้อมสุวรรณ)</span>
        <span style="margin-left: 140px;">(นายสุภาพ สำราญวงษ์)</span>
    </div><br>
    <div class="col-md-12">
        <span><hr width="100%" size="3"></span>
    </div>
    <div class="col-md-12">
        <div class="row">
            <span><b>ส่วนที่ 3 </b></span>
            <span>ส่วนสั่งพัสดุเพิ่ม กรณี</span>
            <span><b>ส่งซ่อมภายนอกผลการตรวจประเมินส่งภายนอก</b></span>
        </div>
        <div class="row" style="margin-left: 30px;">
            <span>ผลการตรวจประเมินของช่าง</span>
            <span>บริษัท</span><br>
            <span>[     ]</span>
            <span>รายการอุปกรณ์ใหม่ๆ เพิ่มเติม</span>
            <span>.........................................................</span><br>
            <span>[   ] รวมราคาประเมิน ............</span>
            <span>รายการ</span>
            <span>ราคา .................. บาท</span>
            <span style="margin-left: 30px;">[     ] อนุมัติ</span>
            <span>[     ] ไม่อนุมัติ</span>
            <span>.............................</span><br>
            <div style="text-align: right; margin-right:50px;">(นายสถาพร ป้อมสุวรรณ)</div>
        </div>
    </div>
    <div class="col-md-12">
        <span><hr width="100%" size="3"></span>
    </div>
    <div class="col-md-12" style="margin-top:2px;">
        <div class="row">
            <span><b>ส่วนที่ 4 </b></span>
            <span>ส่วนส่งมอบงาน กรณี</span>
            <span><b>ส่งซ่อมภายใน(2)</b></span>
            <span><b>และรออะไหล่(3)</b></span>
        </div>
        <div class="row" style="margin-left: 30px;">
            <span>ช่างได้รับเครื่อง/อุปกรณ์/อะไหล่ พร้อมทำการตรวรซ่อมและส่งคืนหน่วยงาน .........................</span><br>
            <span>วันที่ ...............</span>
            <span>ผู้รับเครื่องอุปกรณ์คืน ....................</span>
        </div>
        <div class="row">
            <span><b>หมายเหตุ</b></span>
            <span>เครื่อง/อุปกรณ์/อะไหล่  ที่</span>
            <span><b>รอจำหน่าย (4)</b></span>
            <span>ได้ส่งมอบให้งานพัสดุแล้ว</span>
        </div>
        <div class="row" style="margin-left: 30px;">
            <span>วันที่ ...........................</span>
            <span>ผู้รับ ...........................</span>
            <span><b>ทราบ</b></span>
        </div>
        <br><br>
        <div class="row" style="margin-top: 2px;">
                <span class="text-center" style="margin-left: 100px;">.............................</span>
                <span class="text-center" style="margin-left: 190px;">(.................................)</span>
                <br>
                <span class="text-center" style="margin-left: 100px;">ช่างผู้ทำการตรวจสอบ</span>
                <span class="text-center" style="margin-left: 170px;">(นายสถาพร ป้อมสุวรรณ)</span>
            </span>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</body>
</html>
