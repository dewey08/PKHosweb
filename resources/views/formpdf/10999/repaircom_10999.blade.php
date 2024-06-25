<html>
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
                @page {
                        margin: 0cm 0cm;
                            }
                body {
                    font-family: 'THSarabunNew', sans-serif;
                        font-size: 12px;
                    line-height: 0.9;  
                    margin-top:    0.2cm;
                    margin-bottom: 0.2cm;
                    margin-left:   1cm;
                    margin-right:  1cm; 
                }
                #watermark {     
                    position: fixed;
                            bottom:   0px;
                            left:     0px;                   
                            width:    29.5cm;
                            height:   21cm;
                            z-index:  -1000;
                }
                table,td {
                    /* border: 1px solid rgb(255, 255, 255); */
                    }   
                    .text-pedding{
                    /* padding-left:10px;
                    padding-right:10px; */
                    }                     
                    table{
                        border-collapse: collapse;  //กรอบด้านในหายไป
                    }
                    table.one{
                    border: 0.2px solid rgb(5, 5, 5);
                    /* height: 800px; */
                    /* padding: 15px; */
                    }
                    td {
                        margin: .2rem;
                    /* height: 3px; */
                    /* padding: 5px; */
                    /* text-align: left; */
                    }
                    td.o{
                        border: 0.2px solid rgb(5, 5, 5); 
                    }
                    td.b{
                        border: 0.2px solid rgb(255, 255, 255); 
                    }
                    td.d{
                        border: 0.2px solid rgb(5, 5, 5); 
                        height: 170px;
                    }
                    td.e{
                        border: 0.2px solid rgb(255, 255, 255);
                        
                    }
                    td.h{
                        border: 0.2px solid rgb(5, 5, 5); 
                        height: 10px;
                    }
                    .page-break {
                        page-break-after: always;
                    } 
                    
                    input {
                        margin: .3rem;
                    }
            } 
                         
        </style> 
        
        <?php    
            function DateThaimount($strDate)
            {
            $strYear = date("Y",strtotime($strDate))+543;
            $strMonth= date("n",strtotime($strDate));
            $strDay= date("j",strtotime($strDate));
    
            $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤษจิกายน","ธันวาคม");
            $strMonthThai=$strMonthCut[$strMonth];
            return thainumDigit($strMonthThai);
            }            
            function DateThaifrom($strDate)
            {
            $strYear = date("Y",strtotime($strDate))+543;
            $strMonth= date("n",strtotime($strDate));
            $strDay= date("j",strtotime($strDate));
    
            $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
            $strMonthThai=$strMonthCut[$strMonth];
            return thainumDigit($strDay.' '.$strMonthThai.'  พ.ศ. '.$strYear);
            }    
            $date = date('Y-m-d');    
            function timefor($strtime)
              {
              $H = substr($strtime,10,6);
              return $H;
              }
        ?>    
    </head>
<body> 
    <br>
    <table width="100%">        
        <tr>
          <td rowspan="2" width = "15%">
               <img src="{{ asset('image/Garuda.png') }}" width="50" height="50"> 
          </td>
          <td colspan="5" width = "70%">
              <label for="" style="font-size: 19px"><b>บันทึกแจ้งซ่อม</b></label>              
        </td>
          <td colspan="2" rowspan="2" width = "15%">
            <img src="{{ asset('image/salasontech.png') }}" width="60" height="60"> 
          </td>
        </tr>
        <tr>
          <td colspan="5" > <label for="" style="font-size: 14px">ส่วนราชการ {{$info_orgs->ORG_NAME}} อำเภอ {{$info_orgs->DISTRICT}} จังหวัด {{$info_orgs->PROVINCE}}</label>  </td><br>        
        </tr> 
        <tr>
          <td ><label for="" style="font-size: 12px">หน่วยงานผู้แจ้งซ่อม :</label> </td>
          <td colspan="7" ><label for="" style="font-size: 13px">{{$informcomrepair->HR_DEPARTMENT_SUB_SUB_NAME}} เบอร์โทร :&nbsp;{{$informcomrepair->HR_PHONE}}</label> </td>
        </tr>            
      </table>
      <hr> 
 <table  width="100%">
    <tr>          
        <td width="15%" >
           <b>ส่วนที่ 1 ผู้แจ้ง</b>
        </td>
        <td width="20%" >
            เลขที่ :&nbsp;{{$informcomrepair->REPAIR_ID}}
        </td>
        <td width="20%" >
            วันที่ :&nbsp;{{DateThai($informcomrepair->DATE_SAVE)}}
        </td>
        <td width="20%" >
            เวลา :&nbsp;{{timefor($informcomrepair->DATE_TIME_REQUEST)}} น.
        </td>
        <td width="25%" >            
        </td>
    </tr>           
</table> 
<table  width="100%">
    <tr>          
        <td width="50%" >
           แจ้งซ่อม :&nbsp;{{$informcomrepair->REPAIR_NAME}}
        </td>
        <td width="50%" >
            ยี่ห้อ/รุ่น :&nbsp;{{$informcomrepair->BRAND_NAME}}&nbsp; รุ่น&nbsp;{{$informcomrepair->MODEL_NAME}}
        </td>
    </tr> 
    <tr>          
        <td width="50%" >
           หมายเลขครุภัณฑ์ :&nbsp;{{$informcomrepair->ARTICLE_NUM}}
        </td>        
    </tr>  
    <tr>          
        <td width="50%" >
           อาการ :&nbsp;{{$informcomrepair->SYMPTOM}}
        </td>        
    </tr>          
</table> 
<br>
<table  width="100%">
    <tr>          
        <td width="15%" >          
        </td>
        <td width="40%" >
           ....................................ผู้แจ้งซ่อม 
        </td>
        <td width="45%" >
            ...................................หัวหน้าหน่วยงาน 
         </td>
    </tr> 
    <tr>          
        <td width="15%" >
         
        </td> 
        <td width="40%" >
            (&nbsp;{{$informcomrepair->USRE_REQUEST_NAME}}&nbsp; ) 
         </td> 
         <td width="45%" >
            (&nbsp;{{$headdeps->HR_FNAME}}&nbsp;&nbsp;{{$headdeps->HR_LNAME}}&nbsp; ) 
         </td>        
    </tr>  
             
</table>  
<hr>
<table  width="100%">
    <tr>          
        <td width="15%" >
           <b>ส่วนที่ 2 ช่าง</b>
        </td>
        <td width="30%" >
            เลขที่ใบแจ้งซ่อม :&nbsp;{{$informcomrepair->REPAIR_ID}}
        </td>
        <td width="20%" >
            วันที่ :&nbsp;{{DateThai($informcomrepair->DATE_SAVE)}}
        </td>
        <td width="20%" >
            เวลา :&nbsp;{{timefor($informcomrepair->DATE_TIME_REQUEST)}} น.
        </td>
        <td width="15%" >            
        </td>
    </tr>           
</table> 
<table  width="100%">
    <tr>          
        <td width="15%" >  </td>
        <td width="10%" > ความเร่งด่วน   </td>
        <td width="5%" > </td>
        <td width="10%">
        @if ($informcomrepair->PRIORITY_ID == '4')
            <input type="checkbox" id="scales" name="scales" checked>
            <label for="scales">ด่วนที่สุด</label>
        @else
            <input type="checkbox" id="scales" name="scales">
            <label for="scales">ด่วนที่สุด</label>
        @endif 
        </td>
        <td width="5%" > </td>
        <td width="10%">
            @if ($informcomrepair->PRIORITY_ID == '3')
            <input type="checkbox" id="scales" name="scales" checked>
            <label for="scales">ด่วนมาก</label>
        @else
            <input type="checkbox" id="scales" name="scales">
            <label for="scales">ด่วนมาก</label>
        @endif 
        </td>
        <td width="5%" >  </td>
        <td width="10%" >
            @if ($informcomrepair->PRIORITY_ID == '2')
                <input type="checkbox" id="scales" name="scales" checked>
                <label for="scales">ด่วน</label>
            @else
                <input type="checkbox" id="scales" name="scales">
                <label for="scales">ด่วน</label>
            @endif  
        </td>
        <td width="5%" > </td>
        <td width="10%" >  
            @if ($informcomrepair->PRIORITY_ID == '1')
                <input type="checkbox" id="scales" name="scales" checked>
                <label for="scales">ปกติ</label>
            @else
                <input type="checkbox" id="scales" name="scales">
                <label for="scales">ปกติ</label>
            @endif         
            
        </td>      
        <td width="15%" >            
        </td>
    </tr>           
</table> 
<table  width="100%">
    <tr>          
        <td width="100%" >
           รายละเอียดการตรวจซ่อมที่พบ/ความเห็นของช่าง : {{$informcomrepair->REPAIR_COMMENT}}
        </td> 
    </tr> 
    <tr>          
        <td width="100%" >
           รายการวัสดุอุปกรณ์ที่ใช้ :.....................................................................................................................................................................................................
        </td> 
    </tr>  
</table> 
<table width="100%">
    <tr>          
        <td width="15%" >
           ผลการตรวจสอบ
        </td> 
        <td width="50%" >
            1. <input type="checkbox" id="scales" name="scales" >
            <label for="scales">ซ่อมได้พร้อมส่งคืนหน่วยงาน  วันที่ :.......................................</label>
         </td> 
         <td width="35%" >
            ผู้รับของ :......................................................
         </td> 
         
    </tr> 
   
</table>
<table width="100%">
    <tr>          
        <td width="15%" ></td> 
        <td width="85%" >
            2. <input type="checkbox" id="scales" name="scales" >
            @if ($informcomrepair->OUTSIDE_ACTIVE == 'true')
            <label for="scales">ส่งซ่อมภายนอก  ชื่อร้าน/บริษัท : {{$informcomrepair->OUTSIDE_SHOP}}</label>
            @else
            <label for="scales">ส่งซ่อมภายนอก  ชื่อร้าน/บริษัท :..........................................................................................................................</label>
            @endif
         </td>         
    </tr> 
</table>
<table width="100%">
    <tr>          
        <td width="15%" ></td> 
        <td width="85%" >
            <label for="scales">รายการอุปกาณ์ที่ต้องส่ง</label>
         </td>         
    </tr> 
</table>
<table width="100%">
    <tr>          
        <td width="15%" >
           
        </td> 
        <td width="50%" >          
            <label for="scales">วันที่ :&nbsp;{{DateThai($informcomrepair->REPAIR_DATE)}}</label>
         </td> 
         <td width="35%" >
            ผู้รับ : {{$informcomrepair->OUTSIDE_EMP}}
         </td>
    </tr>    
</table>
<table width="100%">
    <tr>          
        <td width="15%" ></td> 
        <td width="85%" >
            3. <input type="checkbox" id="scales" name="scales" >
            <label for="scales">รออะไหล่ :.............................................................................................................................................................</label>
         </td>         
    </tr> 
</table>
<table width="100%">
    <tr>          
        <td width="15%" ></td> 
        <td width="85%" >
            4. <input type="checkbox" id="scales" name="scales" >
            <label for="scales">รอจำหน่ายเนื่องจาก :...........................................................................................................................................</label><br>
            <label for="scales">แจ้งหน่วยงานที่แจ้ง :............................................................................................ ผู้รับเรื่อง :.............................................</label>
         </td>         
    </tr> 
</table>
<table  width="100%">
    <tr>          
        <td width="15%" >  </td>
        <td width="10%" > ช่าง   </td>
        <td width="20%"></td>       
        <td width="10%" >
            <label for="scales">เจ้าที่พัสดุ</label>  
        </td>
        <td width="14%" ></td>      
        <td width="31%" >   
            <label for="scales">ผู้อนุมัติ</label>         
        </td>
    </tr>           
</table> 
<table  width="100%">
    <tr>          
        <td width="5%" >  </td>
        <td width="12%" > ....................................................   </td>
        <td width="10%"></td>       
        <td width="20%" >
            <label for="scales">....................................................</label>  
        </td>
        <td width="5%" ></td>      
        <td width="10%" >   
            <input type="checkbox" id="scales" name="scales" >
            <label for="scales">อนุมัติ</label>         
        </td>
        <td width="20%" >   
            <input type="checkbox" id="scales" name="scales" >
            <label for="scales">ไม่อนุมัติ</label>         
        </td>
    </tr>           
</table> 
<table  width="100%">
    <tr>          
        <td width="5%" >  </td>
        <td width="20%" > (&nbsp; {{$informcomrepair->TECH_REPAIR_NAME}} &nbsp;)</td>
        <td width="10%"></td>       
        <td width="20%" > (...............................................................)</td>
        <td width="10%" ></td>      
        <td width="30%" >   
            (....................................................)        
        </td>
    </tr>           
</table> 
<hr>
<table  width="100%">
    <tr>          
        <td width="70%" >
           <b>ส่วนที่ 3 ส่วนสั่งพัสดุเพิ่ม กรณี ส่งซ่อมภายนอกผลการตรวจประเมินส่งภายนอก</b>
        </td>   
        <td width="30%" ></td>       
    </tr>  
    <tr>          
        <td width="70%" >
           ผลการตรวจประเมินของช่าง บริษัท<br>
           <input type="checkbox" id="scales" name="scales" >
           <label for="scales">รายการอุปกรณ์ใหม่ฯเพิ่มเติม..............................................................................</label>  
        </td>   
        <td width="30%" ></td>       
    </tr>  
</table> 
<table  width="100%">    
    <tr>          
        <td width="60%" >
           <input type="checkbox" id="scales" name="scales" >
           <label for="scales">รวมราคาประเมิน.................................รายการ ราคา...............................บาท</label>  
        </td>   
        <td width="10%" >
            <input type="checkbox" id="scales" name="scales" >
            <label for="scales">อนุมัติ</label> 
        </td>   
        <td width="30%" >
            <input type="checkbox" id="scales" name="scales" >
            <label for="scales">ไม่อนุมัติ .............................................</label> 
        </td>      
    </tr>    
    <tr>          
        <td width="60%" ></td>   
        <td width="10%" ></td>   
        <td width="30%" >
            <label for="scales">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( .............................................)</label> 
        </td>      
    </tr>         
</table> 
<hr>
<table  width="100%">
    <tr>          
        <td width="100%" >
           <b>ส่วนที่ 4 ส่วนส่งมอบงาน กรณีส่งซ่อมภายใน(2) และรออะไหล่(3)</b>
        </td>        
    </tr>    
</table> 
<table  width="100%">
    <tr>   
        <td width="10%" ></td>    
        <td width="90%" >
            ช่างได้รับเครื่อง/อุปกรณ์/อะไหล่ พร้อมทำการตรวจซ่อมและส่งคืนหน่วยงาน.............................................................................................
        </td>        
    </tr> 
    <tr>   
        <td width="10%" ></td>         
        <td width="90%" >
           วันที่ ...........................................ผู้รับเครื่องอุปกรณ์คืน................................................................................................................................
        </td>     
    </tr>            
</table> 

<table  width="100%">
    <tr>          
        <td width="100%" >
           <b>หมายเหตุ</b> เครื่อง/อุปกรณ์/อะไหล่ ที่รอจำหน่าย(4) ได้ส่งมอบให้งานพัสดุแล้ว<br>
           วันที่ ...........................................ผู้รับ................................................................ทราบ
        </td>        
    </tr>    
</table> 
<br>
<table  width="100%">
    <tr>   
        <td width="15%" ></td>    
        <td width="30%" >
            ..............................................................
        </td>  
        <td width="15%" ></td>    
        <td width="40%" >
                (.........................................................)
        </td>         
    </tr>     
</table> 
<table  width="100%">
    <tr>   
        <td width="20%" ></td>    
        <td width="25%" >
            ช่างผู้ทำการตรวจสอบ
        </td>  
        <td width="15%" ></td>    
        <td width="40%" >
            (..............................................................)
        </td>      
    </tr>            
</table> 
</body>
</html>